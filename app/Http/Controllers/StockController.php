<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Pharmachy;
use App\Models\Medicine;
use App\Models\Sale;

class StockController extends Controller
{
   public function index()
    {
        $stocks = Stock::all();

        // Calculate remaining quantities for the main branch
        foreach ($stocks as $stock) {
            $stock->remaining_quantity = $this->calculateRemainingQuantity($stock->medicine_id);
        }
 

        // Get the summed quantities for each combination of pharmacy_id and medicine_id
        $summedStocks = Stock::select('pharmacy_id', 'medicine_id')
        ->selectRaw('SUM(quantity) as total_quantity')
        ->groupBy('pharmacy_id', 'medicine_id')
        ->get();

    // Calculate the total sales quantity for each stock
    $summedSales = Sale::select('stock_id')
        ->selectRaw('SUM(quantity) as total_quantity')
        ->groupBy('stock_id')
        ->get();

    // Create a dictionary for easy lookup
    $summedQuantities = $summedStocks->keyBy(function ($item) {
        return $item->pharmacy_id . '-' . $item->medicine_id;
    });

    $summedSalesQuantities = $summedSales->keyBy('stock_id');

    // Attach the summed quantity to each stock
    foreach ($stocks as $stock) {
        $stockKey = $stock->pharmacy_id . '-' . $stock->medicine_id;
        $salesKey = $stock->id;

        // Calculate the remaining stock quantity after sales
        $stock->total_quantity = $summedQuantities[$stockKey]->total_quantity ?? 0;
        $stock->total_quantity -= $summedSalesQuantities[$salesKey]->total_quantity ?? 0;
    }

        return view('admin.stock.index', compact('stocks'));
    }

    public function create()
    {
        $pharmacies = Pharmachy::all();
        $medicines = Medicine::all();
        return view('admin.stock.create', compact('pharmacies', 'medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pharmacy_id' => 'required|exists:pharmachies,id',
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer',
            'unit_price' => 'required|integer',
            'type' => 'required|in:received,supplied',
        ]);

        $pharmacy_id = $request->pharmacy_id;
        $medicine_id = $request->medicine_id;
        $quantity = $request->quantity;
        $type = $request->type;

        if ($type == 'received' && $pharmacy_id != 1) {
            return redirect()->back()->withErrors(['pharmacy_id' => 'Only the main branch can receive stock.']);
        }

        if ($type == 'supplied' && $pharmacy_id == 1) {
            return redirect()->back()->withErrors(['pharmacy_id' => 'Main branch cannot supply stock.']);
        }

        if ($type == 'supplied') {
            $remainingQuantity = $this->calculateRemainingQuantity($medicine_id);

            if ($quantity > $remainingQuantity) {
                return redirect()->back()->withErrors(['quantity' => 'Supplied quantity cannot exceed remaining received quantity.']);
            }
        }

        Stock::create($request->all());
        return redirect()->route('stocks.index');
    }

    public function show(Stock $stock)
    {
        return view('admin.stock.show', compact('stock'));
    }

    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        $pharmacies = Pharmachy::all();
        $medicines = Medicine::all();
        return view('admin.stock.edit', compact('stock', 'pharmacies', 'medicines'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'pharmacy_id' => 'required|exists:pharmachies,id',
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer',
            'unit_price' => 'required|integer',
            'type' => 'required|in:received,supplied',
        ]);

        $pharmacy_id = $request->pharmacy_id;
        $medicine_id = $request->medicine_id;
        $quantity = $request->quantity;
        $type = $request->type;

        if ($type == 'received' && $pharmacy_id != 1) {
            return redirect()->back()->withErrors(['pharmacy_id' => 'Only the main branch can receive stock.']);
        }

        if ($type == 'supplied' && $pharmacy_id == 1) {
            return redirect()->back()->withErrors(['pharmacy_id' => 'Main branch cannot supply stock.']);
        }

        if ($type == 'supplied') {
            $remainingQuantity = $this->calculateRemainingQuantity($medicine_id) + $stock->quantity;

            if ($quantity > $remainingQuantity) {
                return redirect()->back()->withErrors(['quantity' => 'Supplied quantity cannot exceed remaining received quantity.']);
            }
        }

        $stock->update($request->all());
        return redirect()->route('stocks.index');
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();
        return redirect()->route('stocks.index');
    }

    private function calculateRemainingQuantity($medicine_id)
    {
        $received = Stock::where('medicine_id', $medicine_id)
                         ->where('pharmacy_id', 1)
                         ->where('type', 'received')
                         ->sum('quantity');

        $supplied = Stock::where('medicine_id', $medicine_id)
                         ->where('pharmacy_id', '!=', 1)
                         ->where('type', 'supplied')
                         ->sum('quantity');

        return $received - $supplied;
    }
}
