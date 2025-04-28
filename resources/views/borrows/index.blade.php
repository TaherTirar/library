@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>{{ Auth::user()->role === 'admin' ? 'All Borrows' : 'My Borrows' }}</h4>
            <a href="{{ route('borrows.create') }}" class="btn btn-primary">Borrow a Book</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped borrow-table">
                    <thead>
                        <tr>
                            @if(Auth::user()->role === 'admin')
                                <th><i class="fas fa-user"></i> User</th>
                            @endif
                            <th colspan="2"><i class="fas fa-book"></i> Book Details</th>
                            <th><i class="far fa-calendar"></i> Borrow Date</th>
                            <th><i class="far fa-calendar-check"></i> Expected Return</th>
                            <th><i class="far fa-calendar-times"></i> Actual Return</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                            <th><i class="fas fa-tasks"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borrows as $borrow)
                            <tr class="borrow-row {{ !$borrow->actual_return_date && $borrow->expected_return_date < now() ? 'overdue' : '' }} {{ $borrow->actual_return_date ? 'returned' : '' }}">
                                @if(Auth::user()->role === 'admin')
                                    <td>{{ $borrow->user->name }}</td>
                                @endif
                                <td colspan="2">
                                    <div class="book-title-cell">
                                        <span>{{ $borrow->book->title }}</span>
                                        <span class="author">by {{ $borrow->book->author }}</span>
                                    </div>
                                </td>
                                <td class="date-cell">
                                    <i class="far fa-calendar-alt text-muted"></i>
                                    {{ $borrow->borrow_date->format('Y-m-d') }}
                                </td>
                                <td class="date-cell">
                                    <i class="far fa-calendar-check {{ !$borrow->actual_return_date && $borrow->expected_return_date < now() ? 'text-danger' : 'text-muted' }}"></i>
                                    {{ $borrow->expected_return_date->format('Y-m-d') }}
                                    @if(!$borrow->actual_return_date)
                                        @php
                                            $daysLeft = now()->diffInDays($borrow->expected_return_date, false);
                                        @endphp
                                        <div class="time-indicator {{ $daysLeft < 0 ? 'urgent' : ($daysLeft <= 3 ? 'warning' : '') }}">
                                            @if($daysLeft < 0)
                                                <i class="fas fa-exclamation-circle"></i>
                                                {{ abs($daysLeft) }} days overdue
                                            @elseif($daysLeft === 0)
                                                <i class="fas fa-clock"></i>
                                                Due today
                                            @else
                                                <i class="fas fa-hourglass-half"></i>
                                                {{ $daysLeft }} days left
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="date-cell">
                                    <i class="far fa-calendar-times {{ $borrow->actual_return_date ? 'text-success' : 'text-muted' }}"></i>
                                    {{ $borrow->actual_return_date ? $borrow->actual_return_date->format('Y-m-d') : '-' }}
                                </td>
                                <td>
                                    @if($borrow->actual_return_date)
                                        <span class="borrow-status returned">Returned</span>
                                    @elseif($borrow->expected_return_date < now())
                                        <span class="borrow-status overdue">Overdue</span>
                                    @else
                                        <span class="borrow-status borrowed">Borrowed</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$borrow->actual_return_date && (Auth::user()->role === 'admin' || $borrow->user_id === Auth::id()))
                                        <form action="{{ route('borrows.return', $borrow) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="return-button">
                                                <span>Return Book</span>
                                                <span>📚</span>
                                            </button>
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
