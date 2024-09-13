<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    //
    public function index() {
        // View all sellers
        return User::role("seller")->get();

    }

    public function approve($id) {
        // Approve a seller
    }

    public function reject($id) {
        // Reject a seller
    }

    public function viewSales($id) {
        // View sales for a specific seller
        
    }
}
