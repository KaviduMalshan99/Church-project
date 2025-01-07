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
                    <div class="mb-4">
                    <label class="form-label">Occupation <i class="text-danger">*</i></label>
                        <select name="occupation" class="form-select" required>
                            <option value="">Select Occupation</option>
                            @foreach ($occupation as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
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
                        <label class="form-label">Relationship to main person</label></label>
                        <input type="text" name="relationship_to_main_person" placeholder="e.g., son, daughter" class="form-control" />
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
                    <input name="images[]" id="media_upload" class="form-control" type="file" multiple />
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
                        <select name="religion_if_not_catholic" id="religionSelect" class="form-select" required onchange="handleReligionChange()">
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
    function handleReligionChange() {
        const select = document.getElementById('religionSelect');
        const otherReligionDiv = document.getElementById('otherReligionDiv');
        const otherReligionInput = document.getElementById('otherReligionInput');

        if (select.value === 'other') {
            otherReligionDiv.style.display = 'block';
            otherReligionInput.setAttribute('name', 'religion_if_not_catholic'); // Assign the same name
            otherReligionInput.setAttribute('required', 'required');
            select.removeAttribute('name'); // Remove name from dropdown
        } else {
            otherReligionDiv.style.display = 'none';
            otherReligionInput.removeAttribute('name'); // Remove name from input
            otherReligionInput.removeAttribute('required');
            select.setAttribute('name', 'religion_if_not_catholic'); // Assign the name back to dropdown
        }
    }
</script>
@endsection
