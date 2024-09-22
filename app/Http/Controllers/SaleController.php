<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\Pharmachy;
use Illuminate\Support\Facades\Auth;


class SaleController extends Controller
{
    /**
     * Display a listing of the sales.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {$userId = Auth::id();

        // Create the base query with eager loading
        $query = Sale::with(['stock', 'stock.medicine', 'user']);

        // Check if the user is not the admin (user_id 1 is the admin)
        if ($userId != 1) {
            // Filter sales by the logged-in user's ID
            $query->where('user_id', $userId);
        }

        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('stock.medicine', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        // Get the filtered sales
        $sales = $query->get();

        return view('admin.sales.index', compact('sales'));
    }


    /**
     * Show the form for creating a new sale.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = Auth::id();

        // Get the pharmacy associated with the logged-in user
        $pharmacy = Pharmachy::where('user_id', $userId)->first();
    
        // Filter the stocks based on the pharmacy ID
        if ($pharmacy) {
            $stocks = Stock::with('medicine')
                ->where('pharmacy_id', $pharmacy->id)
                ->get();
        } else {
            $stocks = collect(); // Empty collection if no pharmacy is associated with the user
        }
    
        return view('admin.sales.create', compact('stocks'));
    }

    /**
     * Store a newly created sale in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

     public function addTempSale(Request $request)
{
    $request->validate([
        'stock_id' => 'required|exists:stocks,id',
        'quantity' => 'required|integer',
    ]);

    \DB::table('temp_sales')->insert([
        'stock_id' => $request->stock_id,
        'user_id' => Auth::id(),
        'quantity' => $request->quantity,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('sales.create')->with('status', 'Medicine added to cart!');
}

public function store(Request $request)
{
    $userId = Auth::id();
    $tempSales = \DB::table('temp_sales')->where('user_id', $userId)->get();
    $invoiceNumber = time(); // Or use another method to generate an invoice number

    foreach ($tempSales as $tempSale) {
        $stock = Stock::findOrFail($tempSale->stock_id);
        $unit_price = $stock->unit_price;
        $total_price = $unit_price * $tempSale->quantity;

        Sale::create([
            'stock_id' => $tempSale->stock_id,
            'user_id' => $userId,
            'quantity' => $tempSale->quantity,
            'unit_price' => $unit_price,
            'total_price' => $total_price,
            'invoice_number' => $invoiceNumber,
        ]);
    }

    \DB::table('temp_sales')->where('user_id', $userId)->delete(); // Clear the temporary table

    return redirect()->route('sales.index')->with('status', 'Sales recorded successfully!');
}


    /**
     * Display the specified sale.
     *
     * @param \App\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        return view('admin.sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified sale.
     *
     * @param \App\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $stocks = Stock::with('medicine')->get();
        return view('admin.sales.edit', compact('sale', 'stocks'));
    }

    /**
     * Update the specified sale in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'quantity' => 'required|integer',
        ]);

        $stock = Stock::findOrFail($request->stock_id);
        $unit_price = $stock->unit_price; // Get unit price from stock
        $total_price = $unit_price * $request->quantity;

        $sale->update([
            'stock_id' => $request->stock_id,
            'quantity' => $request->quantity,
            'unit_price' => $unit_price, // Save unit price
            'total_price' => $total_price,
        ]);

        return redirect()->route('sales.index')->with('status', 'Sale updated successfully!');
    }

    /**
     * Remove the specified sale from the database.
     *
     * @param \App\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('status', 'Sale deleted successfully!');
    }
}
