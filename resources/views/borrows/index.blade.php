@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>{{ Auth::user()->role === 'admin' ? 'All Borrows' : 'My Borrows' }}</h4>
            <a href="{{ route('borrows.create') }}" class="btn btn-primary">Borrow a Book</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            @if(Auth::user()->role === 'admin')
                                <th>User</th>
                            @endif
                            <th>Book</th>
                            <th>Author</th>
                            <th>Borrow Date</th>
                            <th>Expected Return</th>
                            <th>Actual Return</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borrows as $borrow)
                            <tr>
                                @if(Auth::user()->role === 'admin')
                                    <td>{{ $borrow->user->name }}</td>
                                @endif
                                <td>{{ $borrow->book->title }}</td>
                                <td>{{ $borrow->book->author }}</td>
                                <td>{{ $borrow->borrow_date->format('Y-m-d') }}</td>
                                <td>{{ $borrow->expected_return_date->format('Y-m-d') }}</td>
                                <td>{{ $borrow->actual_return_date ? $borrow->actual_return_date->format('Y-m-d') : '-' }}</td>
                                <td>
                                    @if($borrow->actual_return_date)
                                        <span class="badge bg-success">Returned</span>
                                    @elseif($borrow->expected_return_date < now())
                                        <span class="badge bg-danger">Overdue</span>
                                    @else
                                        <span class="badge bg-primary">Borrowed</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$borrow->actual_return_date && (Auth::user()->role === 'admin' || $borrow->user_id === Auth::id()))
                                        <form action="{{ route('borrows.return', $borrow) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Return Book</button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role === 'admin' ? '8' : '7' }}" class="text-center">No borrows found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $borrows->links() }}
        </div>
    </div>
@endsection
