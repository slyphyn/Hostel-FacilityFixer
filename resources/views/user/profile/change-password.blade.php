@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Change Password') }}</div>              

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif                        
                        <form method="POST" action="{{ route('profile.change-password') }}" onsubmit="return validatePassword();">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="current_password">{{ __('Current Password') }}:</label>
                                <input type="password" name="current_password" id="current_password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="new_password">{{ __('New Password') }}:</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="new_password_confirmation">{{ __('Confirm New Password') }}:</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('Change Password') }}</button>
                        </form>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function validatePassword() {
        console.log('Function called');
        
        var newPassword = document.getElementById("new_password").value;
        var confirmPassword = document.getElementById("new_password_confirmation").value;
        
        console.log('New Password:', newPassword);
        console.log('Confirm Password:', confirmPassword);

        if (newPassword !== confirmPassword) {
            alert("Passwords do not match. Please enter matching passwords.");
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }
</script>
