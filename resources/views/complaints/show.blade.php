@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Complaint Details</div>

                    <div class="card-body">
                        <!-- for staff when change the status -->
                        @if(session('status_update_success'))
                            <div class="alert alert-success">
                                {{ session('status_update_success') }}
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <p><strong>ID:</strong> {{ $complaint->id }}</p>
                        <p><strong>Complaint Created:</strong> {{ $complaint->created_at->format('d/m/Y, g:i A') }}</p>
                        <p><strong>Block Number:</strong> {{ $complaint->block_number }}</p>
                        <p><strong>Location Type:</strong> {{ $complaint->location_type }}</p>
                        <p><strong>Room Number:</strong> {{ $complaint->room_number ?? 'N/A' }}</p>
                        <p><strong>Toilet Location:</strong> {{ $complaint->toilet_location ?? 'N/A' }}</p>
                        <p><strong>Category:</strong> {{ ucfirst(str_replace('_', '/', ucwords($complaint->category))) ?? 'N/A' }}</p>
                        <p><strong>Damage Description:</strong> {{ $complaint->damage_description }}</p>
                        <p><strong>Other Damage Description:</strong> {{ $complaint->damage_description_other ?? 'N/A' }}</p>
                        <p><strong>Consent:</strong> {{ $complaint->allow_entry ? 'Allow UTM Staff or Contractor enter my room when I am not inside' : 'Do Not Allow UTM Staff or Contractor enter my room when I am not inside.' }}</p> <!-- Display the consent field -->
                        <p><strong>Photo:</strong></p>
                        <img src="{{ asset('storage/' . $complaint->photo_path) }}" alt="Complaint Photo" class="img-fluid" style="max-width: 100%; max-height: 300px;">
                        {{-- <p><strong>Status:</strong> <span style="font-weight: 500; color: #333;">{{ $complaint->status }}</span></p> --}}
                        <p>
                            <strong>Status:</strong>
                            <span style="font-weight: 500; color: #333; background-color: 
                                @if($complaint->status === 'in_progress')
                                    #ffc107
                                @elseif($complaint->status === 'feedback submitted')
                                    #28a745
                                @elseif($complaint->status === 'resolved')
                                    #28a745
                                @elseif($complaint->status === 'pending')
                                    #67a4e7
                                @else
                                    #ffffff
                                @endif
                            ;">
                                {{ $complaint->status }}
                            </span>
                        </p>
                        @if(auth()->user()->role === 1 && $complaint->status == 'feedback submitted')
                        <p><a href="{{ route('feedback.userIndex') }}">View Feedback</a></p>
                        @endif
                        
                        @if(auth()->user()->role === 2) 
                            <div class="mb-3 p-3" style="background-color: #e0f8ff7a; border: 1px solid #dae0e5; border-radius: 5px;">
                                <h5>Update Status and Assigned Staff Details</h5>
                                    <form action="{{ route('complaints.update.statusAndStaff', $complaint->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                            
                                        <div class="form-group">
                                            <label for="status">New Status</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                            </select>
                                        </div>
                            
                                        <div class="form-group">
                                            <label for="assigned_staff_name">Assigned Staff Name:</label>
                                            <input type="text" name="assigned_staff_name" id="assigned_staff_name" class="form-control" value="{{ $complaint->assigned_staff_name }}">
                                        </div>
                            
                                        <div class="form-group">
                                            <label for="assigned_staff_contact">Assigned Staff Contact:</label>
                                            <input type="text" name="assigned_staff_contact" id="assigned_staff_contact" class="form-control" value="{{ $complaint->assigned_staff_contact }}">
                                        </div>
                            
                                        <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Update Changes</button>
                                    </form>
                                </div>
                        @endif

                        @if (auth()->user()->role === 1 && $complaint->status == 'resolved')
                            <a href="{{ route('complaints.feedback.create', $complaint->id) }}" class="btn btn-success">Give Feedback</a>
                        @endif
                    

                        @if(auth()->user()->role === 1) 
                            <a href="{{ route('complaints.edit', $complaint->id) }}" class="btn btn-primary">Edit</a>

                            {{-- <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this complaint?')">Delete</button>
                            </form> --}}
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal{{ $complaint->id }}">
                                Delete
                            </button>

                            <!-- Bootstrap Modal for Delete Confirmation -->
                            <div class="modal fade" id="confirmDeleteModal{{ $complaint->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmDeleteModalLabel">Delete Confirmation</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this complaint?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
