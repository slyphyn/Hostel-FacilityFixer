@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @auth
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                {{ __('You are logged in as User!') }}

                {{-- Redirect to the complaint.create page --}}
                <script>window.location = "{{ route('complaints.create') }}";</script>
            @endauth
        </div>
    </div>
</div>
@endsection
