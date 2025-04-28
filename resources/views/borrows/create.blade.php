@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Borrow a Book</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('borrows.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="book_id" class="form-label">Select Book</label>
                    <select class="form-control @error('book_id') is-invalid @enderror" id="book_id" name="book_id" required>
                        <option value="">Select a Book</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ request('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->title }} - {{ $book->author }}
                            </option>
                        @endforeach
                    </select>
                    @error('book_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <p>Standard loan period is 14 days.</p>
                    <p>Expected return date will be: <strong>{{ now()->addDays(14)->format('Y-m-d') }}</strong></p>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Borrow Book</button>
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
