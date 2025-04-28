<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $data = [];

        if (Auth::user()->role === 'admin') {
            $data['totalBooks'] = Book::count();
            $data['availableBooks'] = Book::where('status', 'available')->count();
            $data['borrowedBooks'] = Book::where('status', 'borrowed')->count();
            $data['activeBorrows'] = Borrow::whereNull('actual_return_date')->count();
            $data['recentBorrows'] = Borrow::with(['user', 'book'])
                                    ->latest()
                                    ->take(5)
                                    ->get();
        } else {
            $data['userBooks'] = Borrow::where('user_id', Auth::id())
                                ->whereNull('actual_return_date')
                                ->with('book')
                                ->get();
            $data['borrowHistory'] = Borrow::where('user_id', Auth::id())
                                    ->whereNotNull('actual_return_date')
                                    ->with('book')
                                    ->latest()
                                    ->take(5)
                                    ->get();
        }

        return view('home', compact('data'));
    }
}
