@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User Profile') }}</div>
                @if(isset($success))
                    <div class="alert alert-success">
                        {{ $success }}
                    </div>
                @endif
                
                <div class="card-body">
                    <p>Name: {{ $user->name }}</p>
                    <p>Email: {{ $user->email }}</p>
                    <p>Phone: {{ $user->phone }}</p>
                    
                    @if($user->role == 1)
                    <p>Status: Student</p>
                    <p>Course: {{ $user->userDetail->course ?? 'N/A' }}</p>
                    <p>Matric Number: {{ $user->userDetail->matric_number ?? 'N/A' }}</p>
                    <p>Year of Study: {{ $user->userDetail->year_of_study ?? 'N/A' }}</p>
                    <p>Hostel Name: {{ $user->userDetail->hostel_name ?? 'N/A' }}</p>
                    <p>Room Number: {{ $user->userDetail->room_number ?? 'N/A' }}</p>
                    <p>Emergency Contact: {{ $user->userDetail->emergency_contact ?? 'N/A' }}</p>
                    <p>Gender: {{ $user->userDetail->gender ?? 'N/A' }}</p>
                    <p>Date of Birth: {{ $user->userDetail->date_of_birth ?? 'N/A' }}</p>
                @elseif($user->role == 2)
                    <p>Status: Staff</p>
                    <p>Position: {{ $user->userDetail->position ?? 'N/A' }}</p>
                @endif
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                    <a href="{{ route('profile.showChangePasswordForm') }}" class="btn btn-primary">Change Password</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="customAlertModal" tabindex="-1" role="dialog" aria-labelledby="customAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0.5rem;">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="customAlertMessage"></div>
            <div class="modal-footer" style="padding: 0.5rem;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var urlParams = new URLSearchParams(window.location.search);
        var successMessage = urlParams.get('success');

        if (successMessage) {
            // Display the custom alert modal
            $('#customAlertMessage').html(successMessage);
            $('#customAlertModal').modal('show');
        }
    });
</script>
@endsection

