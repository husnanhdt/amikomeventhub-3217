<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Nanti bisa ambil data event dari database
        return view('welcome');
    }
}