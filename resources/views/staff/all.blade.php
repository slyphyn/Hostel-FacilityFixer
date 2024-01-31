@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <form action="{{ route('staff.complaints.find') }}" method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <input type="text" class="form-control" name="name_or_block_number" value="{{ request('name_or_block_number') }}" placeholder="Search by Name or Block Number">
                        </div>
                
                        <div class="col-md-3 mb-3">
                            <select class="form-select" name="status">
                                <option value="" selected>Select Status</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="feedback submitted" {{ request('status') === 'feedback submitted' ? 'selected' : '' }}>Feedback Submitted</option>
                            </select>
                        </div>
                
                        <div class="col-md-4 mb-3">
                            <button type="submit" class="btn btn-primary form-control">Search</button>
                        </div>
                    </div>
                </form>
                
                
                <div class="card">
                    <div class="card-header">All Complaints</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Block Number</th>
                                    <th>Location Type</th>
                                    <th>Status</th>
                                    <th>Assign By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($complaints as $complaint)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $complaint->user->name }}</td>
                                        <td>{{ $complaint->block_number }}</td>
                                        <td>{{ $complaint->location_type }}</td>
                                        <td>
                                            @if($complaint->status === 'in_progress')
                                                In Progress
                                            @elseif($complaint->status === 'resolved')
                                                {{ ucwords($complaint->status) }}
                                            @elseif($complaint->status === 'pending')
                                                {{ ucwords($complaint->status) }}
                                            @else
                                                {{ $complaint->status }}
                                            @endif
                                        </td>                                       
                                        <td>
                                            <div class="grid-display">
                                                <div>{{ $complaint->assigned_staff_name ?? 'N/A' }}</div>
                                                <div>{{ $complaint->assigned_staff_contact ?? 'N/A' }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('complaints.show', $complaint->id) }}" class="btn btn-info">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        {{ $complaints->links('mypagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
