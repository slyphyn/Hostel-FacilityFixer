@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>User Dashboard</h2>

        <h4>Your Complaints</h4>
        @if(auth()->user()->complaints)
            @forelse(auth()->user()->complaints as $complaint)
                <p>{{ $complaint->block_number }} - {{ $complaint->status }}</p>
            @empty
                <p>No complaints yet.</p>
            @endforelse
        @else
            <p>No complaints yet.</p>
        @endif

        <!-- Add more sections as needed -->

    </div>
@endsection