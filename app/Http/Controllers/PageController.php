<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class PageController extends Controller
{
    public function index(){
    	return view('index');
    }

    public function getALlProduct(){
    	$products = Products::all();

    	return response()->json([
    		'products' => $products
    	]); 
    }
}
