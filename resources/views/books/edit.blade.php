@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Edit Book</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if($book->image_path)
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div>
                            <img src="{{ asset('storage/' . $book->image_path) }}" alt="{{ $book->title }}" style="max-width: 200px; height: auto;" class="img-thumbnail">
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="image" class="form-label">Update Book Cover Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $book->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author', $book->author) }}" required>
                    @error('author')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="publication_year" class="form-label">Publication Year</label>
                    <input type="number" class="form-control @error('publication_year') is-invalid @enderror" id="publication_year" name="publication_year" value="{{ old('publication_year', $book->publication_year) }}" min="1000" max="{{ date('Y') }}" required>
                    @error('publication_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="available" {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="borrowed" {{ old('status', $book->status) == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update Book</button>
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
