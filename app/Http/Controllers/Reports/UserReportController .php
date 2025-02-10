<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Shop;
use App\Models\Representative;
use App\Models\User;
use Illuminate\Http\Request;

class UserReportController  extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }


        $users = $query->get();

        return view('reports.user', compact('users'));
    }
}
