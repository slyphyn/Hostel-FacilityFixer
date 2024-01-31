@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <h3>Welcome, {{ auth()->user()->name }}!</h3>
                        <!-- Add more content based on your requirements -->

                        <!-- Example: Display User's Complaints -->
                        @if(auth()->user()->feedback)
                        @forelse(auth()->user()->feedback as $feedbacks)
                            <p>{{ $feedbacks->feedback_id }} - {{ $feedbacks->feedback }}</p>
                        @empty
                            <p>No feedback yet..</p>
                        @endforelse
                        @else
                            <p>No feedback yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

