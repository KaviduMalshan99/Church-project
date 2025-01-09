@extends ('AdminDashboard.master')

@section('content')


<form method="POST" action="{{ route('member.store') }}" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-12">
        <div class="content-header">
            <h2 class="content-title">Add New Family Members</h2>
            <div>
                <button type="submit" class="btn btn-md rounded font-sm hover-up">Add Members</button>
            </div>
        </div>
    </div>

    <div class="card mb-4 ml-3">
    <div class="card-header">
        <h4>Main Person Name</h4>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <label for="main_person" class="form-label">Select Family Main Person</label>
            <select name="main_person" class="form-control" id="main_person">
                <option value="">Select family main person</option>
                @foreach($main_persons as $main_person)
                    <option value="{{ $main_person->id }}">
                        {{ $main_person->member_name }} ({{ $main_person->family_no }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>


    

    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-header">
                <br>
                <h4>Basic Details of Family Member</h4>
            </div>
            <div class="card-body">
                
                    <div class="mb-4">
                        <label for="member_name" class="form-label">Member Name <i class="text-danger">*</i></label>
                        <input type="text" name="member_name" placeholder="Type here" class="form-control" id="member_name" required />
                    </div>
                    <div class="mb-4">
                        <label for="member_name" class="form-label">NIC <i class="text-danger">*</i></label>
                        <input type="text" name="nic" placeholder="Type here" class="form-control" id="nic" required />
                    </div>
                    <div class="mb-4">
                        <label for="birth_date" class="form-label">Birth Date</label>
                        <input type="date" name="birth_date" class="form-control" id="birth_date" />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Gender <i class="text-danger">*</i></label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label me-3">Civil Status <i class="text-danger">*</i></label>
                        <div class="d-inline-flex">
                            <div class="form-check me-4">
                                <input class="form-check-input" type="radio" name="civil_status" id="single" value="Single">
                                <label class="form-check-label" for="single">
                                    Single
                                </label>
                            </div>
                            <div class="form-check me-4">
                                <input class="form-check-input" type="radio" name="civil_status" id="married" value="Married">
                                <label class="form-check-label" for="married">
                                    Married
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Relationship to Main Person <i class="text-danger">*</i></label>
                        <input list="relationshipOptions" name="relationship_to_main_person" placeholder="e.g., son, daughter" class="form-control" />
                        <datalist id="relationshipOptions">
                            <option value="Son"></option>
                            <option value="Daughter"></option>
                            <option value="Spouse"></option>
                            <option value="Parent"></option>
                            <option value="Sibling"></option>
                            <option value="Grandparent"></option>
                            <option value="Grandchild"></option>
                            <option value="Uncle"></option>
                            <option value="Aunt"></option>
                            <option value="Cousin"></option>
                        </datalist>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Occupation <i class="text-danger">*</i></label>
                        <input list="occupationOptions" name="occupation" placeholder="Select or type your occupation" class="form-control" required />
                        <datalist id="occupationOptions">
                            @foreach ($occupation as $item)
                                <option value="{{ $item->name }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Professional Qualifications</label>
                        <input type="text" name="professional_quali" class="form-control" />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Contact Info</label>
                        <input type="text" name="contact_info" placeholder="e.g., 0712345678" class="form-control" />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" placeholder="e.g., example@example.com" class="form-control" />
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Interest Activities</label>
                        <input type="text" name="interests" placeholder="e.g., Dance, Music, etc." class="form-control" />
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
                    <img src="{{ asset('backend/assets/imgs/theme/upload.svg') }}" alt="" />
                    <input name="image" id="media_upload" class="form-control" type="file" />
                </div>
                <div class="image-preview mt-4" id="image_preview_container" style="display: flex; gap: 5px; flex-wrap: wrap;">
                    <!-- Image previews will appear here -->
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
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="mb-4" id="otherReligionDiv" style="display: none;">
                        <label class="form-label">Specify Religion <i class="text-danger">*</i></label>
                        <input type="text" id="otherReligionInput" class="form-control" placeholder="Specify your religion">
                    </div>
                    <div class="mb-4">
                        <label class="form-check">
                            <input type="checkbox" name="baptized" class="form-check-input" />
                            <span class="form-check-label">Baptized</span>
                        </label>
                    </div>
                    <!--<div class="mb-4">
                        <label class="form-check">
                            <input type="checkbox" name="full_member" class="form-check-input" />
                            <span class="form-check-label">Full Member</span>
                        </label>
                    </div>
                    <div class="mb-4">
                        <label class="form-check">
                            <input type="checkbox" name="sabbath_member" class="form-check-input" />
                            <span class="form-check-label">Sabbath Member</span>
                        </label>
                    </div>-->
                    <div class="mb-4">
                        <label class="form-check">
                            <input type="checkbox" name="held_office_in_council" class="form-check-input" />
                            <span class="form-check-label">Held Office in Council</span>
                        </label>
                    </div>
                    <!-- Current Church Congregation Section -->
                    <div class="mb-4">
                            <label class="form-label">Current Church Congregation <i class="text-danger">*</i></label><br>
                            <label class="form-check">
                                <input type="radio" name="church_congregation" value="Moratumulla" class="form-check-input" />
                                <span class="form-check-label">Moratumulla</span>
                            </label>
                            <label class="form-check">
                                <input type="radio" name="church_congregation" value="Other" class="form-check-input" onchange="toggleOtherChurchInput()" />
                                <span class="form-check-label">Other</span>
                            </label>
                            <div class="mt-2" id="otherChurchDiv" style="display: none;">
                                <input type="text" name="other_church_congregation" class="form-control" placeholder="Specify the congregation" />
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
                            <textarea name="optional_notes" class="form-control" placeholder="Add any additional notes here..."></textarea>
                        </div>
                </div>
            </div>
        
        
    </div>
</div>
</form>
 

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#main_person').select2({
            placeholder: "Select family main person",
            allowClear: true
        });
    });
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
