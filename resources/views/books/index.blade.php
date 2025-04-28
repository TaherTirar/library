@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Books</h4>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('books.create') }}" class="btn btn-primary">Add New Book</a>
            @endif
        </div>

        <div class="card-body">
            <form action="{{ route('books.index') }}" method="GET" class="mb-4">
                <div class="row">
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
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Year</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                            <tr>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->publication_year }}</td>
                                <td>{{ $book->category->name }}</td>
                                <td>
                                    @if($book->status === 'available')
                                        <span class="badge bg-success">Available</span>
                                    @else
                                        <span class="badge bg-danger">Borrowed</span>
                                    @endif
                                </td>
                                <td class="d-flex">
                                    <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-info me-2">View</a>

                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-warning me-2">Edit</a>

                                        <form action="{{ route('books.destroy', $book) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">Delete</button>
                                        </form>
                                    @elseif($book->status === 'available')
                                        <a href="{{ route('borrows.createWithBook', $book) }}" class="btn btn-sm btn-success">Borrow</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No books found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $books->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
