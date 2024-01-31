@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Submit Feedback</div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('complaints.feedback.store', $complaint->id) }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="feedback">Feedback:</label>
                                <textarea name="feedback" id="feedback" class="form-control" rows="4" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit Feedback</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
