@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('List of User') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? 'N/A' }}</td>
                                    <td>
                                        {{-- {{ $user->role === 'user' ? 'User' : ($user->role === 'staff' ? 'Staff' : 'Admin') }} --}}
                                        <!-- Add a dropdown to change roles -->
                                        <form action="{{ route('admin.update', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>User</option>
                                                <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Staff</option>
                                                <option value="3" {{ $user->role == 3 ? 'selected' : '' }}>Admin</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-sm btn-primary">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
