@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Update Response</h2>

        <form action="{{ route('feedback.saveUpdatedResponse', $feedback->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="response">Staff Response:</label>
                <textarea name="response" id="response" class="form-control" rows="4">{{ $feedback->response }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save Response</button>
        </form>
    </div>
@endsection