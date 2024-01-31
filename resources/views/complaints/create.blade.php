@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Submit Complaint</div>

                    <div class="card-body">

                        <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Block Information -->
                            <div class="mb-3">
                                <label for="block_number" class="form-label">Block Number:</label>
                                <select name="block_number" id="block_number" class="form-control" required>
                                    @for ($i = 1; $i <= 25; $i++)
                                        <option value="H{{ sprintf('%02d', $i) }}">H{{ sprintf('%02d', $i) }}</option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Location Type -->
                            <div class="mb-3">
                                <label for="location_type" class="form-label">Location Type:</label>
                                <select name="location_type" id="location_type" class="form-control" required>
                                    <option value="room">Room</option>
                                    <option value="toilet">Toilet</option>
                                </select>
                            </div>

                            <!-- Room Number (Conditional) -->
                            <div class="mb-3" id="roomNumberField" style="display: none;">
                                <label for="room_number" class="form-label">Room Number:</label>
                                <input type="text" name="room_number" id="room_number" class="form-control">
                            </div>

                            <!-- Toilet Location (Conditional) -->
                            <div class="mb-3" id="toiletLocationField" style="display: none;">
                                <label for="toilet_location" class="form-label">Toilet Location:</label>
                                <input type="text" name="toilet_location" id="toilet_location" class="form-control">
                            </div>

                            <!-- Category Description -->
                            <div class="mb-3">
                                <label for="category" class="form-label">Category:</label>
                                <select name="category" id="category" class="form-control" required>
                                    <option value="plumbing">Plumbing</option>
                                    <option value="electrical_it">Electrical / IT</option>
                                    <option value="general_maintenance">General Maintenance</option>
                                    <option value="pest_control">Pest Control</option>
                                    <option value="safety_security">Safety and Security</option>
                                </select>
                            </div>

                            <!-- Damage Description -->
                            <div class="mb-3">
                                <label for="damage_description" class="form-label">Description of Damage:</label>
                                <select name="damage_description" id="damage_description" class="form-control" required>
                                </select>
                            </div>

                            <!-- Other Damage Description (Conditional) -->
                            <div class="mb-3" id="otherDamageField" style="display: none;">
                                <label for="damage_description_other" class="form-label">Other Damage Description:</label>
                                <input type="text" name="damage_description_other" id="damage_description_other" class="form-control">
                            </div>

                            <!-- Photo -->
                            <div class="mb-3">
                                <label for="photo" class="form-label">Insert Photo:</label>
                                <input type="file" name="photo" id="photo" class="form-control-file" accept="image/*">
                            </div>

                            <!-- Consent Checkbox -->
                            <div class="mb-3">
                                <label for="consent" class="form-label" style="background-color: #ff9999; padding: 5px;">Consent:</label>
                                <p>
                                    I certify that the above statement are true and promise to comply with the Safety Instructions as above. I hereby:-
                                </p>
                            </div>

                            <!-- Consent Radio Buttons -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="allow_entry" name="consent" value="allow_entry" required>
                                    <label class="form-check-label" for="allow_entry">Allow UTM Staff or Contractor to enter my room when I'm not inside.</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="do_not_allow_entry" name="consent" value="do_not_allow_entry" required>
                                    <label class="form-check-label" for="do_not_allow_entry">Do Not Allow UTM Staff or Contractor to enter my room when I'm not inside.</label>
                                </div>
                            </div>
                            

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Submit Complaint</button>
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

        document.getElementById('category').addEventListener('change', function () {
        var damageDescription = document.getElementById('damage_description');
        var otherDamageField = document.getElementById('otherDamageField');

        // Reset damage description dropdown
        damageDescription.value = '';

        if (this.value === 'plumbing') {
            damageDescription.innerHTML = `
                <option value="Clogged">Clogged</option>
                <option value="Leaking">Leaking</option>
                <option value="Drainage">Drainage</option>
            `;
        } else if (this.value === 'electrical_it') {
            damageDescription.innerHTML = `
                <option value="Broken lamps/Fans">Broken lamps/Fans</option>
                <option value="Wiring Issue">Wiring Issue</option>
                <option value="Internet connection">Internet connection</option>
            `;
        } else if (this.value === 'general_maintenance') {
            damageDescription.innerHTML = `
                <option value="Broken furniture">Broken furniture</option>
                <option value="Wall cracks">Wall cracks</option>
                <option value="Loose tiles">Loose tiles</option>
            `;
        } else if (this.value === 'pest_control') {
            damageDescription.innerHTML = `
                <option value="Insect">Insect</option>
            `;
        } else if (this.value === 'safety_security') {
            damageDescription.innerHTML = `
                <option value="Security-related issue">Security-related issue</option>
            `;
        }

        damageDescription.innerHTML += `
            <option value="Others">Others</option>
        `;

        // Hide/show other damage field based on selected damage description
        if (damageDescription.value.toLowerCase() === 'others') {
            otherDamageField.style.display = 'block';
        } else {
            otherDamageField.style.display = 'none';
        }
    });


        document.getElementById('damage_description').addEventListener('change', function () {
            var otherDamageField = document.getElementById('otherDamageField');

            if (this.value.toLowerCase() === 'others') {
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
