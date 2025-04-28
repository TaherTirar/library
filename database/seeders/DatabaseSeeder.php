<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create default regular user
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Generate categories
        $categories = Category::factory(10)->create();

        // Generate books
        $books = Book::factory(50)->recycle($categories)->create();

        // Generate users
        $users = User::factory(20)->create();

        // Generate borrows for books that are borrowed
        $borrowedBooks = Book::where('status', 'borrowed')->get();

        foreach ($borrowedBooks as $book) {
            $user = $users->random();
            $borrowDate = now()->subDays(rand(1, 30));

            Borrow::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'borrow_date' => $borrowDate,
                'expected_return_date' => $borrowDate->copy()->addDays(14),
                'actual_return_date' => null,
            ]);
        }

        // Add some returned books
        foreach (range(1, 30) as $i) {
            $user = $users->random();
            $book = $books->where('status', 'available')->random();

            $borrowDate = now()->subDays(rand(15, 60));
            $returnDate = $borrowDate->copy()->addDays(rand(1, 14));

            Borrow::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'borrow_date' => $borrowDate,
                'expected_return_date' => $borrowDate->copy()->addDays(14),
                'actual_return_date' => $returnDate,
            ]);
        }
    }
}
