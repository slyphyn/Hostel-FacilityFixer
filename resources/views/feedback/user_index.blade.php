@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Your Feedback') }}</div>

                    <div class="card-body">
                        @forelse($feedbacks as $feedback)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <p><strong>Complaint:</strong> {{ $feedback->complaint->block_number }}</p>
                                    <p><strong>Feedback:</strong> {{ $feedback->feedback }}</p>

                                    @if($feedback->response)
                                        <p><strong>Staff Response:</strong> {{ $feedback->response }}</p>
                                    @endif

                                    <a href="{{ route('complaints.show', $feedback->complaint->id) }}" class="btn btn-info">View</a>
                                </div>
                            </div>
                        @empty
                            <p>No feedback yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
