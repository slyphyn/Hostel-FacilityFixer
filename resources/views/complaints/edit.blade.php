@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Complaint</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('complaints.update', $complaint->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="block_number">Block Number:</label>
                                <input type="text" name="block_number" id="block_number" class="form-control" value="{{ $complaint->block_number }}" required>
                            </div>

                            <div class="form-group">
                                <label for="location_type">Location Type:</label>
                                <select name="location_type" id="location_type" class="form-control" required>
                                    <option value="room" {{ $complaint->location_type === 'room' ? 'selected' : '' }}>Room</option>
                                    <option value="toilet" {{ $complaint->location_type === 'toilet' ? 'selected' : '' }}>Toilet</option>
                                </select>
                            </div>

                            <div class="form-group" id="roomNumberField" style="display:none;">
                                <label for="room_number">Room Number:</label>
                                <input type="text" name="room_number" id="room_number" class="form-control" value="{{ $complaint->room_number }}">
                            </div>

                            <div class="form-group" id="toiletLocationField" style="display:none;">
                                <label for="toilet_location">Toilet Location:</label>
                                <input type="text" name="toilet_location" id="toilet_location" class="form-control" value="{{ $complaint->toilet_location }}">
                            </div>

                            <div class="form-group">
                                <label for="category">Category:</label>
                                <select name="category" id="category" class="form-control" required>
                                    <option value="plumbing" {{ $complaint->category === 'plumbing' ? 'selected' : '' }}>Plumbing</option>
                                    <option value="electrical_it" {{ $complaint->category === 'electrical_it' ? 'selected' : '' }}>Electrical / IT</option>
                                    <option value="general_maintenance" {{ $complaint->category === 'general_maintenance' ? 'selected' : '' }}>General Maintenance</option>
                                    <option value="pest_control" {{ $complaint->category === 'pest_control' ? 'selected' : '' }}>Pest Control</option>
                                    <option value="safety_security" {{ $complaint->category === 'safety_security' ? 'selected' : '' }}>Safety and Security</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="damage_description">Description of Damage:</label>
                                <select name="damage_description" id="damage_description" class="form-control" required>
                                    @if($complaint->category == 'plumbing')
                                        <option value="Clogged" @if($complaint->damage_description == 'Clogged') selected @endif>Clogged</option>
                                        <option value="Leaking" @if($complaint->damage_description == 'Leaking') selected @endif>Leaking</option>
                                        <option value="Drainage" @if($complaint->damage_description == 'Drainage') selected @endif>Drainage</option>
                                    @elseif($complaint->category == 'electrical_it')
                                        <option value="Broken lamps/Fans" @if($complaint->damage_description == 'Broken lamps/Fans') selected @endif>Broken lamps/Fans</option>
                                        <option value="Wiring Issue" @if($complaint->damage_description == 'Wiring Issue') selected @endif>Wiring Issue</option>
                                        <option value="Internet connection" @if($complaint->damage_description == 'Internet connection') selected @endif>Internet connection</option>
                                    @elseif($complaint->category == 'general_maintenance')
                                        <option value="Broken furniture" @if($complaint->damage_description == 'Broken furniture') selected @endif>Broken furniture</option>
                                        <option value="Wall cracks" @if($complaint->damage_description == 'Wall cracks') selected @endif>Wall cracks</option>
                                        <option value="Loose tiles" @if($complaint->damage_description == 'Loose tiles') selected @endif>Loose tiles</option>
                                    @elseif($complaint->category == 'pest_control')
                                        <option value="Insect" @if($complaint->damage_description == 'Insect') selected @endif>Insect</option>
                                    @elseif($complaint->category == 'safety_security')
                                        <option value="Security-related issue" @if($complaint->damage_description == 'Security-related issue') selected @endif>Security-related issue</option>
                                    @endif
                                    <option value="Others" @if($complaint->damage_description == 'Others') selected @endif>Others</option>
                                </select>
                            </div>

                            <div class="form-group" id="otherDamageField" @if($complaint->damage_description != 'others') style="display: none;" @endif>
                                <label for="damage_description_other">Other Damage Description:</label>
                                <input type="text" name="damage_description_other" id="damage_description_other" class="form-control" value="{{ $complaint->damage_description_other }}">
                            </div>

                            <div class="form-group">
                                <label for="photo">Insert Photo:</label>
                                <input type="file" name="photo" id="photo" class="form-control-file" accept="image/*">
                            </div>

                            <div class="form-group">
                                <label for="consent">Consent:</label>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="allow_entry" name="consent" value="allow_entry">
                                    <label class="form-check-label" for="allow_entry">Allow UTM Staff or Contractor to enter my room when I'm not inside.</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="do_not_allow_entry" name="consent" value="do_not_allow_entry">
                                    <label class="form-check-label" for="do_not_allow_entry">Do Not Allow UTM Staff or Contractor to enter my room when I'm not inside.</label>
                                </div>
                            </div>

                            <button type="button" id="updateBtn" class="btn btn-primary">Update Complaint</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('location_type').addEventListener('change', function () {
            var roomNumberField = document.getElementById('roomNumberField');
            var toiletLocationField = document.getElementById('toiletLocationField');

            if (this.value === 'room') {
                roomNumberField.style.display = 'block';
                toiletLocationField.style.display = 'none';
            } else if (this.value === 'toilet') {
                roomNumberField.style.display = 'none';
                toiletLocationField.style.display = 'block';
            }
        });

        document.getElementById('damage_description').addEventListener('change', function () {
            var otherDamageField = document.getElementById('otherDamageField');

            if (this.value === 'others') {
                otherDamageField.style.display = 'block';
            } else {
                otherDamageField.style.display = 'none';
            } 
        });

        function validateConsent() {
            // Check if at least one consent checkbox is selected
            if (!document.getElementById('allow_entry').checked && !document.getElementById('do_not_allow_entry').checked) {
                alert('Please select at least one consent option.');
                return false;
            }
            return true;
        }
    </script>
@endsection
