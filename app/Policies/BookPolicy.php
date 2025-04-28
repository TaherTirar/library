<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true; // Anyone can view the list of books
    }

    public function view(User $user, Book $book)
    {
        return true; // Anyone can view a book
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Book $book)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Book $book)
    {
        return $user->role === 'admin';
    }
}
