<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produtos;
use App\Categories;
use App\Supplier;
use App\User;
use App\Historical_alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $itens = Produtos::all()->count('id');

      $user = User::all()->count('id');

      $suppliers = Supplier::all()->count('id');

      $categories = Categories::all()->count('id');

      $alerts_count = Historical_alert::all()->count('id');

      return view('home', compact('itens','user', 'suppliers', 'categories', 'alerts_count'));

    }

}
