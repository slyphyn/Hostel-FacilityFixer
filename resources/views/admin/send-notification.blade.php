@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Send Notification') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('send.notification') }}">
                            @csrf
                            <label for="message">Notification Message:</label>
                            <textarea name="message" id="message" required></textarea>
                            <button type="submit">Send Notification</button>
                        </form>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
