<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        // Get most borrowed books (top 10)
        $mostBorrowedBooks = Book::withCount('borrows')
            ->orderBy('borrows_count', 'desc')
            ->take(10)
            ->get();

        // Get most active users (top 10)
        $mostActiveUsers = User::withCount('borrows')
            ->orderBy('borrows_count', 'desc')
            ->take(10)
            ->get();

        // Global stats
        $totalBooks = Book::count();
        $totalBorrows = Borrow::count();
        $currentBorrows = Borrow::whereNull('actual_return_date')->count();

        // Books status
        $availableBooks = Book::where('status', 'available')->count();
        $borrowedBooks = Book::where('status', 'borrowed')->count();

        // Overdue borrows
        $overdueBorrows = Borrow::whereNull('actual_return_date')
            ->where('expected_return_date', '<', now())
            ->count();

        return view('admin.reports', compact(
            'mostBorrowedBooks',
            'mostActiveUsers',
            'totalBooks',
            'totalBorrows',
            'currentBorrows',
            'availableBooks',
            'borrowedBooks',
            'overdueBorrows'
        ));
    }
}
