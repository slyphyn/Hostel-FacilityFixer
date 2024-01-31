@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('complaints.report') }}" method="GET">
            @csrf

            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" required>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select name="category" id="category" required>
                    <option value="room">Room</option>
                    <option value="toilet">Toilet</option>
                </select>
            </div>

            <button type="submit">Generate Report</button>
        </form>
    </div>
@endsection