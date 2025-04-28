@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Books Collection</h4>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('books.create') }}" class="btn btn-primary btn-action">
                    <i class="fas fa-plus"></i> Add New Book
                </a>
            @endif
        </div>

        <div class="filters-container">
            <form action="{{ route('books.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search by title or author" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-control">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="book-grid">
            @forelse($books as $book)
                <div class="book-card card {{ $book->status === 'available' ? 'available' : 'borrowed' }}">
                    <div class="card-body">
                        <h5 class="book-title">{{ $book->title }}</h5>
                        <p class="book-author">by {{ $book->author }}</p>

                        <div class="book-meta">
                            <p class="mb-1"><i class="far fa-calendar-alt"></i> {{ $book->publication_year }}</p>
                            <p class="mb-2"><i class="fas fa-bookmark"></i> {{ $book->category->name }}</p>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        @if($book->status === 'available')
                            <span class="badge bg-success status-badge mb-2 d-block">Available</span>
                        @else
                            <span class="badge bg-danger status-badge mb-2 d-block">Borrowed</span>
                        @endif

                        <div class="mt-2">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-info btn-action">View</a>

                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('books.edit', $book) }}" class="btn btn-warning btn-action">Edit</a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-action" onclick="return confirm('Are you sure you want to delete this book?')">Delete</button>
                                </form>
                            @elseif($book->status === 'available')
                                <a href="{{ route('borrows.createWithBook', $book) }}" class="btn btn-success btn-action">Borrow</a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No books found.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $books->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
