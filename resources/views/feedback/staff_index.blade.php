@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('All Feedback') }}</div>

                <div class="card-body">
                    @if ($feedbacks->count() > 0)
                        @foreach ($feedbacks as $feedback)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <p class="card-text">User: {{ $feedback->user->name }}</p>
                                    <p class="card-text">Complaint: {{ $feedback->complaint->block_number }}</p>
                                    <p class="card-text">Feedback: {{ $feedback->feedback }}</p>

                                    <!-- Display staff response if available -->
                                    @if($feedback->response)
                                        <p class="card-text">Staff Response: {{ $feedback->response }}</p>
                                    @endif

                                    <!-- Add link to update response page -->
                                    <a href="{{ route('feedback.updateResponse', $feedback->id) }}" class="btn btn-sm btn-primary">Update Response</a>
                                </div>
                            </div>
                        @endforeach

                        {{ $feedbacks->links('mypagination') }}

                    @else
                        <p>No feedback available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
