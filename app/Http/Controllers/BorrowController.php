<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BorrowController extends Controller
{

    public function index(): View
    {
        // For regular users - show only their borrows
        if (Auth::user()->role === 'user') {
            $borrows = Borrow::with('book')
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10);
        } else {
            // For admins - show all borrows
            $borrows = Borrow::with(['book', 'user'])
                ->latest()
                ->paginate(10);
        }

        return view('borrows.index', compact('borrows'));
    }

    public function create(): View
    {
        $books = Book::where('status', 'available')->get();
        return view('borrows.create', compact('books'));
    }

    public function createWithBook(Book $book)
    {
        // Check if book is available
        if ($book->status !== 'available') {
            return redirect()->route('books.index')
                ->with('error', 'Sorry, this book is not available for borrowing.');
        }

        // Display the borrow form with the selected book
        $books = collect([$book]); // Create collection with only this book

        return view('borrows.create', compact('books', 'book'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->status !== 'available') {
            return back()->withErrors(['book_id' => 'This book is not available for borrowing.']);
        }

        $borrowDate = Carbon::now();
        $expectedReturnDate = Carbon::now()->addDays(14); // Default to 2 weeks

        // Create borrow record
        $borrow = Borrow::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrow_date' => $borrowDate,
            'expected_return_date' => $expectedReturnDate,
        ]);

        // Update book status
        $book->status = 'borrowed';
        $book->save();

        return redirect()->route('borrows.index')->with('success', 'Book borrowed successfully.');
    }

    public function returnBook(Borrow $borrow): RedirectResponse
    {
        if (Auth::user()->role !== 'admin' && $borrow->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You can only return books that you have borrowed.');
        }

        // Make sure the book isn't already returned
        if ($borrow->actual_return_date) {
            return back()->with('error', 'This book has already been returned.');
        }

        // Update the borrow record
        $borrow->actual_return_date = now();
        $borrow->save();

        // Update the book status
        $book = $borrow->book;
        $book->status = 'available';
        $book->save();

        return redirect()->route('borrows.index')->with('success', 'Book returned successfully.');
    }
}
