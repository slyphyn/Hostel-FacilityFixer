
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">List of Complaints</div>

                    <div class="card-body">                    
                    
                        {{-- @php
                            dd(session()->all());
                        @endphp --}}
                        <table class="table">
                            <thead>
                                <tr>
                                    {{-- <th>ID</th> --}}
                                    <th>Block Number</th>
                                    <th>Location Type</th>
                                    <th>Status</th>
                                    <th>Assign By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($complaints)        
                                    @foreach($complaints as $complaint)
                                        <tr>
                                            {{-- <td>{{ $complaint->id }}</td> --}}
                                            <td>{{ $complaint->block_number }}</td>
                                            <td>{{ ucwords($complaint->location_type) }}</td>
                                            <td style="color: black;">{{ ucwords($complaint->status) }}</td>
                                            <td>
                                                <div class="grid-display">
                                                    <div>{{ $complaint->assigned_staff_name ?? 'Not Assign' }}</div>
                                                    <div>{{ $complaint->assigned_staff_contact ?? '' }}</div>
                                                </div>
                                            </td>                                      
                                            <td>
                                                <a href="{{ route('complaints.show', $complaint->id) }}" class="btn btn-info">View</a>
                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <p>No complaints yet.</p>
                                @endif
                            </tbody>
                        </table>
                        {{ $complaints->links('mypagination') }}

                    </div>
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
