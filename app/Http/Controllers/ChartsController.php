<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;
use App\Models\Product;
use App\Models\Category;


class ChartsController extends Controller
{
    //
    public function multipleCharts()
{
    $taxes = Tax::withCount('products')->get();

    // Format data for the tax chart
    $taxChartData = [
        'labels' => $taxes->pluck('name'),
        'data' => $taxes->pluck('products_count'),
    ];

    $categories = Category::withCount('products')->get();

    // Format data for the category chart
    $categoryChartData = [
        'labels' => $categories->pluck('name'),
        'data' => $categories->pluck('products_count'),
    ];

    $products = Product::withCount('taxes')->get();

    // Format data for the product chart
    $productChartData = [
        'labels' => $products->pluck('name'),
        'data' => $products->pluck('taxes_count'), // Change 'id' to the appropriate field or logic for counting products
    ];

    return view('welcome', compact('taxChartData', 'categoryChartData', 'productChartData'));
}
}
