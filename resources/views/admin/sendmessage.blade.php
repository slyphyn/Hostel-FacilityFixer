@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Send Message') }}</div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="post" action="{{ route('admin.sendCustomMessageForm') }}">
                            @csrf

                            <div class="form-group">
                                <label for="recipient">Recipient:</label>
                                <select name="recipient" id="recipient" class="form-control" required>
                                    <option value="1">User</option>
                                    <option value="2">Staff</option>
                                    <option value="3">All</option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="message">Message:</label>
                                <textarea name="message" id="message" class="form-control" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>                           
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
