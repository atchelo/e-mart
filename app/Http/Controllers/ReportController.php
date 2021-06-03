<?php

namespace App\Http\Controllers;

use App\AddSubVariant;
use App\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function stockreport(Request $request)
    {

        $products = AddSubVariant::with(['variantimages', 'products', 'products.store', 'products.vender'])->whereHas('products.store', function ($q) {
            return $q->where('status', '=', '1');
        })->whereHas('products.vender', function ($q) {
            return $q->where('status', '=', '1');
        });

        if ($request->ajax()) {
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('product_name', function ($row) {
                    return '<b>' . $row->products->name . '</b>';
                })
                ->addColumn('variant', 'admindesk.reports.variantinfo')
                ->addColumn('store_name', function ($row) {
                    return '<b>' . $row->products->store->name . '</b>';
                })
                ->addColumn('stock', function ($row) {
                    if ($row->stock < 5) {
                        return "<span class='text-red'><b>$row->stock</b></span>";
                    } else {
                        return "<b>$row->stock</b>";
                    }
                })
                ->rawColumns(['product_name', 'variant', 'store_name', 'stock'])
                ->make(true);
        }

        return view('admindesk.reports.stockreport');
    }

    public function salesreport(Request $request)
    {

        $salesdata = AddSubVariant::with(['order', 'variantimages', 'products', 'products.store', 'products.vender'])->whereHas('products')->whereHas('order', function ($q) {
            return $q->where('status', '=', 'delivered');
        })->whereHas('products.store', function ($q) {
            return $q->where('status', '=', '1');
        })->whereHas('products.vender', function ($q) {
            return $q->where('status', '=', '1');
        })->withCount('order')->groupBy('id');

        if ($request->ajax()) {
            return DataTables::of($salesdata)
                ->addIndexColumn()
                ->addColumn('product_name', function ($row) {
                    return '<b>' . $row->products->name . '</b>';
                })
                ->addColumn('variant', 'admindesk.reports.variantinfo')
                ->addColumn('store_name', function ($row) {
                    return '<b>' . $row->products->store->name . '</b>';
                })
                ->addColumn('sales', function ($row) {
                    return $row->order_count;
                })
                ->rawColumns(['product_name', 'variant', 'store_name', 'sales'])
                ->make(true);
        }

        return view('admindesk.reports.salesreport');
    }

    public function mostviewproducts(Request $request){

        $data = Product::orderByUniqueViews()->get();

        
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('product_name', function ($row) {
                    return '<b>' . $row->name . '</b>';
                })
                ->addColumn('views', function ($row) {
                    
                    return "<b>$row->unique_views_count</b>";
                    
                })
                ->rawColumns(['product_name', 'views'])
                ->make(true);
        }

        return view('admindesk.reports.viewreport');

    }
}
