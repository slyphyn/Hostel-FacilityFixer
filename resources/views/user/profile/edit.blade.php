@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Profile') }}</div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">{{ __('Name') }}:</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="email">{{ __('Email') }}:</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">{{ __('Phone') }}:</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
                            </div>

                            @if($user->role == 1)
                                <div class="form-group">
                                    <label for="course">{{ __('Course') }}:</label>
                                    <input type="text" name="course" id="course" class="form-control" value="{{ old('course', $user->userDetail->course ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label for="matric_number">{{ __('Matric Number') }}:</label>
                                    <input type="text" name="matric_number" id="matric_number" class="form-control" value="{{ old('matric_number', $user->userDetail->matric_number ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="year_of_study">{{ __('Year of Study') }}:</label>
                                    <input type="text" name="year_of_study" id="year_of_study" class="form-control" value="{{ old('year_of_study', $user->userDetail->year_of_study ?? '') }}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="hostel_name">{{ __('Hostel Block') }}:</label>
                                    <input type="text" name="hostel_name" id="hostel_name" class="form-control" value="{{ old('hostel_name', $user->userDetail->hostel_name ?? '') }}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="room_number">{{ __('Room Number') }}:</label>
                                    <input type="text" name="room_number" id="room_number" class="form-control" value="{{ old('room_number', $user->userDetail->room_number ?? '') }}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="emergency_contact">{{ __('Emergency Contact') }}:</label>
                                    <input type="text" name="emergency_contact" id="emergency_contact" class="form-control" value="{{ old('emergency_contact', $user->userDetail->emergency_contact ?? '') }}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="gender">{{ __('Gender') }}:</label>
                                    <input type="text" name="gender" id="gender" class="form-control" value="{{ old('gender', $user->userDetail->gender ?? '') }}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="date_of_birth">{{ __('Date of Birth') }}:</label>
                                    <input type="text" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth', $user->userDetail->date_of_birth ?? '') }}">
                                </div>

                            @elseif($user->role == 2)
                                <div class="form-group">
                                    <label for="position">{{ __('Position') }}:</label>
                                    <input type="text" name="position" id="position" class="form-control" value="{{ old('position', $user->userDetail->position ?? '') }}">
                                </div>

                            @endif

                            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">{{ __('Update Profile') }}</button>
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

