<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Generate Report') }}</div>

                <div class="card-body">
                    <form action="{{ route('staff.report.generate') }}" method="post" class="mb-3">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label">Start Date:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') ?? (isset($startDate) ? $startDate->toDateString() : '') }}">
                            </div>

                            <div class="col-md-4">
                                <label for="end_date" class="form-label">End Date:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') ?? (isset($endDate) ? $endDate->toDateString() : '') }}">
                            </div>

                            {{-- <div class="col-md-4">
                                <label for="category" class="form-label">Type:</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="room">Room</option>
                                    <option value="toilet">Toilet</option>
                                    <option value="plumbing">Plumbing</option>
                                    <option value="electrical_it">Electrical/IT</option>
                                    <option value="general_maintenance">General Maintenance</option>
                                    <option value="pest_control">Pest Control</option>
                                    <option value="safety_security">Safety Security</option>
                                </select>
                            </div> --}}
                            <div class="col-md-4">
                                <label for="category" class="form-label">Type:</label>
                                @if(isset($categories) && is_array($categories) && count($categories) > 0)
                                    <select name="category" id="category" class="form-control">
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat }}" {{ old('category', $category) === $cat ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $cat)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <select name="category" id="category" class="form-control">
                                        <option value="room">Room</option>
                                        <option value="toilet">Toilet</option>
                                        <option value="plumbing">Plumbing</option>
                                        <option value="electrical_it">Electrical/IT</option>
                                        <option value="general_maintenance">General Maintenance</option>
                                        <option value="pest_control">Pest Control</option>
                                        <option value="safety_security">Safety Security</option>
                                    </select>
                                @endif
                            </div>
                            
                            
                            
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Generate Report</button>
                    </form>

                    @if(isset($complaints) && $complaints->count() > 0)
                        <div>
                            <h2>Generated Report</h2>
                        </div>

                        <div>
                            <p>Total Complaints: {{ $totalComplaints }}</p>
                            <p>Resolved Complaints: {{ $resolvedComplaints }}</p>
                            <p>Pending Complaints: {{ $pendingComplaints }}</p>
                            <p>In Progress Complaints: {{ $inProgressComplaints }}</p>
                            <p>Feedback Submitted Complaints: {{ $feedbackSubmittedComplaints }}</p>
                        </div>

                        <div style="text-align: center;">
                            <canvas id="myPieChart" width="400" height="400" style="width: 400px; height: 400px;"></canvas>
                        </div>

                        <script>
                            var ctx = document.getElementById('myPieChart').getContext('2d');
                            var myPieChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: {!! json_encode($complaints->map(function($complaint) {
                                        return $complaint->location_type . '-' . $complaint->status;
                                    })->unique()) !!},
                                    datasets: [{
                                        data: {!! json_encode($complaints->countBy(function($complaint) {
                                            return $complaint->location_type . '-' . $complaint->status;
                                        })->values()) !!},
                                        backgroundColor: [
                                            'rgba(97, 245, 195, 0.8)',
                                            'rgba(255, 99, 132, 0.8)',
                                            'rgba(54, 162, 235, 0.8)',
                                            'rgba(255, 206, 86, 0.8)',
                                            'rgba(97, 245, 195, 0.8)',
                                            'rgba(255, 159, 99, 0.8)',
                                            'rgba(186, 161, 255, 0.8)',
                                        ],
                                    }],
                                },
                                options: {
                                    maintainAspectRatio: false,
                                    responsive: false,
                                    width: 400,
                                    height: 400,
                                }
                            });
                        </script>
                        
                    @else
                    <div>
                        <h2>Generated Report</h2>
                    </div>
                        <p>No record found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
