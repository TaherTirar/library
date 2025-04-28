@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Book Details</h4>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h2>{{ $book->title }}</h2>
                    <p class="lead">By {{ $book->author }}</p>

                    <div class="mb-3">
                        <strong>Publication Year:</strong> {{ $book->publication_year }}
                    </div>

                    <div class="mb-3">
                        <strong>Category:</strong> {{ $book->category->name }}
                    </div>

                    <div class="mb-3">
                        <strong>Status:</strong>
                        @if($book->status === 'available')
                            <span class="badge bg-success">Available</span>
                        @else
                            <span class="badge bg-danger">Borrowed</span>
                        @endif
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to Books</a>

                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">Edit</a>
                        @elseif($book->status === 'available')
                            <a href="{{ route('borrows.createWithBook', $book) }}" class="btn btn-success">Borrow this Book</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
