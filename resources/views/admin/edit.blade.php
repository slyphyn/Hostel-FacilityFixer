@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit User') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.update', $user->id) }}">
                        @csrf
                        @method('PUT')
            
                        <!-- Display user details and role dropdown for editing -->
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
            
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
            
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}" required>
                        </div>
            
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select name="role" id="role" class="form-control">
                                <option value="1" {{ $user->role === 1 ? 'selected' : '' }}>User</option>
                                <option value="2" {{ $user->role === 2 ? 'selected' : '' }}>Staff</option>
                                <option value="3" {{ $user->role === 3 ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
            
                        <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Update User</button>
                        
                    </form>

                    <form action="{{ route('admin.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="margin-top: 10px;">Delete User</button>
                    </form>
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
