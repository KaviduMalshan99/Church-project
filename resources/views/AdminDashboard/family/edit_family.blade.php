@extends ('AdminDashboard.master')

@section('content')
<form method="POST" action="{{ route('family.update', $family->family_number) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12">
            <div class="content-header">
                <h2 class="content-title">Update Family</h2>
                <div>
                    <button type="submit" class="btn btn-md rounded font-sm hover-up">Update</button>
                </div>
            </div>
        </div>




        <div class="col-lg-7">
            <div class="card mb-4">
                <div class="card-header">
                    <br>
                    <h4>Basic Details of Main Member</h4>
                </div>
                <div class="card-body">

                    <div class="mb-4">
                        <label for="member_name" class="form-label">Member Name <i class="text-danger">*</i></label>
                        <input type="text" name="member_name" value="{{$member->member_name}}" placeholder="Type here" class="form-control" id="member_name" required />
                    </div>
                     <div class="mb-4">
                        <label for="member_name" class="form-label">NIC</label>
                        <input type="text" name="nic" value="{{$member->nic}}" placeholder="Type here" class="form-control" id="nic" required />
                    </div>
                    <div class="mb-4">
                        <label for="birth_date" class="form-label">Birth Date</label>
                        <input type="date" name="birth_date" value="{{$member->birth_date}}" class="form-control" id="birth_date" />
                    </div>
                    <div class="mb-4">
                        <label for="registered_date" class="form-label">Registered Date</label>
                        <input type="date" name="registered_date" value="{{$member->registered_date}}" class="form-control" id="registered_date" />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Gender <i class="text-danger">*</i></label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender', $member->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $member->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $member->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="mb-2">
                    <label class="form-label me-3">Civil Status <i class="text-danger">*</i></label>
                        <div class="d-inline-flex">
                            <div class="form-check me-4">
                                <input class="form-check-input" type="radio" name="civil_status" id="single" value="Single" {{ old('civil_status', $member->civil_status) == 'Single' ? 'checked' : '' }}>
                                <label class="form-check-label" for="single">
                                    Single
                                </label>
                            </div>
                            <div class="form-check me-4">
                                <input class="form-check-input" type="radio" name="civil_status" id="married" value="Married" {{ old('civil_status', $member->civil_status) == 'Married' ? 'checked' : '' }}>
                                <label class="form-check-label" for="married">
                                    Married
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Occupation <i class="text-danger">*</i></label>
                        <input 
                            list="occupationOptions" 
                            name="occupation" 
                            placeholder="Select or type your occupation" 
                            class="form-control" 
                            value="{{ old('occupation', $member->occupation) }}" 
                            required 
                        />
                        <datalist id="occupationOptions">
                            @foreach ($occupation as $item)
                                <option data-id="{{ $item->id }}" value="{{ $item->name }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Professional Qualifications</label>
                        <input type="text" name="professional_quali" value="{{$member->professional_quali}}" class="form-control" />
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Contact Info</label>
                        <input type="text" name="contact_info" value="{{$member->contact_info}}" placeholder="e.g., 0712345678" class="form-control" />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{$member->email}}" placeholder="e.g., example@example.com" class="form-control" />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Interest Activities</label>
                        <input type="text" name="interests"  value="{{$member->interests}}" placeholder="e.g., Dance, Music, etc." class="form-control" />
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Media</h4>
                </div>
                <div class="card-body">
                    <div class="input-upload">
                        <label for="media_upload">
                            <img src="{{ asset('backend/assets/imgs/theme/upload.svg') }}" alt="" />
                        </label>
                        <input name="image" id="media_upload" class="form-control" type="file" style="display: none;" onchange="previewImage(event)" />
                    </div>

                    <div class="image-preview mt-4" id="image_preview_container" style="display: flex; gap: 5px; flex-wrap: wrap;">
                        <!-- Existing Image Preview -->
                        @if($member->image)
                            <img 
                                id="existing_image" 
                                src="{{ asset('storage/' . $member->image) }}" 
                                alt="Existing Image" 
                                style="max-width: 150px; max-height: 150px; border: 1px solid #ddd; border-radius: 5px;" 
                            />
                        @endif
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Organization</h4>
                </div>
                <div class="card-body">
                    <div class="row gx-2">
                        <div class="mb-4">
                            <label class="form-label">Religion <i class="text-danger">*</i></label>
                            <select name="religion" id="religionSelect" class="form-select" required onchange="handleReligionChange()">
                                <option value="">Select Religion</option>
                                @foreach ($religion as $item)
                                    <option value="{{ $item->name }}" 
                                        {{ (old('religion') ?? $member->religion) === $item->name ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                                <option value="other" 
                                    {{ (old('religion') ?? $member->religion) === 'other' ? 'selected' : '' }}>
                                    Other
                                </option>
                            </select>
                        </div>  

                        <div class="mb-4" id="otherReligionDiv" 
                            style="display: {{ (old('religion') ?? $member->religion) === 'other' ? 'block' : 'none' }};">
                            <label class="form-label">Specify Religion <i class="text-danger">*</i></label>
                            <input type="text" name="religion" id="otherReligionInput" 
                                class="form-control" placeholder="Specify your religion" 
                                value="{{ (old('religion') === 'other') ? old('religion') : (($member->religion === 'other') ? $member->religion : '') }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-check">
                                <input type="checkbox" name="baptized" value="1"
                                    class="form-check-input"
                                    {{ old('baptized', $member->baptized) ? 'checked' : '' }} />
                                <span class="form-check-label">Baptized</span>
                            </label>
                        </div>


                        <div class="mb-4">
                            <label class="form-check">
                                <input type="checkbox" name="held_office_in_council" value="1"
                                    class="form-check-input"
                                    {{ old('held_office_in_council', $member->held_office_in_council) ? 'checked' : '' }} />
                                <span class="form-check-label">Held Office in Council</span>
                            </label>
                        </div>

                            <!-- Current Church Congregation Section -->
                            <div class="mb-4">
                                <label class="form-label">Current Church Congregation <i class="text-danger">*</i></label><br>
                                <label class="form-check">
                                    <input type="radio" name="church_congregation" value="Moratumulla" class="form-check-input"
                                        {{ old('church_congregation', $member->church_congregation) == 'Moratumulla' ? 'checked' : '' }} />
                                    <span class="form-check-label">Moratumulla</span>
                                </label>

                                <!-- Other Option -->
                                <label class="form-check">
                                    <input type="radio" name="church_congregation" value="Other" class="form-check-input"
                                        {{ old('church_congregation', $member->church_congregation) == 'Other' ? 'checked' : '' }}
                                        onchange="toggleOtherChurchInput()" />
                                    <span class="form-check-label">Other</span>
                                </label>
                                <div class="mt-2" id="otherChurchDiv" style="display: {{ old('church_congregation', $member->church_congregation) == 'Other' ? 'block' : 'none' }};">
                                    <input type="text" name="other_church_congregation" class="form-control" placeholder="Specify the congregation"
                                        value="{{ old('other_church_congregation', $member->other_church_congregation) }}" />
                                </div>
                            </div>

                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4>Other</h4>
                </div>
                <div class="card-body">
                    <!-- Optional Notes and Other Details -->
                    <div class="mb-4">
                        <label class="form-label">Optional Notes </label>
                        <textarea name="optional_notes" class="form-control" placeholder="Add any additional notes here...">{{ old('optional_notes', $member->optional_notes) }}</textarea>
                    </div>
                </div>

            </div>

        </div>
    </div>
</form>

<script>
    function previewImage(event) {
        const previewContainer = document.getElementById('image_preview_container');
        const existingImage = document.getElementById('existing_image');

        // Remove existing image if it exists
        if (existingImage) {
            existingImage.remove();
        }

        // Add new image preview
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '150px';
                img.style.maxHeight = '150px';
                img.style.border = '1px solid #ddd';
                img.style.borderRadius = '5px';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    }
</script>

<script>
    // Toggle the "Other" field for church congregation
    function toggleOtherChurchInput() {
        var otherChurchInput = document.querySelector('input[name="church_congregation"][value="Other"]');
        var otherChurchDiv = document.getElementById('otherChurchDiv');
        if (otherChurchInput.checked) {
            otherChurchDiv.style.display = 'block';
        } else {
            otherChurchDiv.style.display = 'none';
        }
    }
</script>
<script>
    function handleReligionChange() {
        const select = document.getElementById('religionSelect');
        const otherReligionDiv = document.getElementById('otherReligionDiv');
        const otherReligionInput = document.getElementById('otherReligionInput');

        if (select.value === 'other') {
            otherReligionDiv.style.display = 'block';
            otherReligionInput.setAttribute('name', 'religion');
            otherReligionInput.setAttribute('required', 'required');
            select.removeAttribute('name'); 
        } else {
            otherReligionDiv.style.display = 'none';
            otherReligionInput.removeAttribute('name'); 
            otherReligionInput.removeAttribute('required');
            select.setAttribute('name', 'religion'); 
        }
    }
</script>

@endsection