{{-- for staff --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Feedback Details</h2>

        <div class="card mb-3">
            <div class="card-body">
                <p><strong>User:</strong> {{ $feedback->user->name }}</p>
                <p><strong>Complaint:</strong> {{ $feedback->complaint->block_number }}</p>
                <p><strong>Feedback:</strong> {{ $feedback->feedback }}</p>

                <!-- Add more details as needed -->

                <!-- Display staff response if available -->
                @if($feedback->response)
                    <p><strong>Staff Response:</strong> {{ $feedback->response }}</p>
                @endif

                <!-- Form for staff to respond -->
                <form action="{{ route('feedback.respond', $feedback->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="response">Staff Response:</label>
                        <textarea name="response" id="response" class="form-control" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Response</button>
                </form>
            </div>
        </div>
    </div>
@endsection