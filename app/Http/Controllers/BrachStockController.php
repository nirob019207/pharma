<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Sale;
use App\Models\Pharmachy;
use Illuminate\Support\Facades\Auth;

class BrachStockController extends Controller
{
    public function index(Request $request)
    {
        // Get the logged-in user's ID
        $userId = Auth::id();

        // Get the pharmacy associated with the logged-in user
        $pharmacy = Pharmachy::where('user_id', $userId)->first();

        // Start the query
        $query = Stock::query();

        // Filter by pharmacy
        if ($pharmacy) {
            $query->where('pharmacy_id', $pharmacy->id);
        }

        // Check if a search query is present
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('medicine', function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });
        }

        // Get the filtered stocks
        $stocks = $query->get();

        // Calculate the total quantity for each medicine in the pharmacy's stock
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

            // Calculate the total quantity for the given medicine in the given pharmacy
            $totalQuantity = $summedQuantities[$stockKey]->total_quantity ?? 0;

            // Subtract the sales quantity for the given stock
            $totalQuantity -= $summedSalesQuantities[$salesKey]->total_quantity ?? 0;

            // Update stock quantity
            $stock->total_quantity = $totalQuantity;
        }

        return view('admin.branchStock.index', compact('stocks'));
    }
}
