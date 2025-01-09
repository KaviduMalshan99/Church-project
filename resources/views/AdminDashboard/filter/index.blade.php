@extends('AdminDashboard.master')

@section('content')
<style>
    .modal-title {
    font-size: 1.2rem;
}
.modal-body p {
    font-size: 1.0rem;
}

#modalMemberImage {
    max-width: 150px;
    border-radius: 8px;
}

</style>

<div class="col-12">
    <div class="content-header">
        <h2 class="content-title">Filter Members</h2>
    </div>
</div>

<div class="row mt-4">
    <!-- Filter Form -->
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-body">
            <form method="GET" action="{{ route('filter.index') }}">
                <div class="d-flex justify-content-between mb-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('filter.index') }}" class="btn btn-secondary">Reset</a>
                </div>

                <div class="mb-4">
                    <label for="member" class="form-label">Member Name / ID</label>
                    <select name="member" id="member" class="form-select">
                        <option value="">Select Member Name or ID</option>
                        @foreach($members as $member)
                            <option value="{{ $member->member_id }}" {{ request('member') == $member->member_id ? 'selected' : '' }}>
                                {{ $member->member_name }} ({{ $member->member_id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="family_no" class="form-label">Family Number</label>
                    <select name="family_no" id="family_no" class="form-select">
                        <option value="">Search or Select Family Number</option>
                        @foreach($familyNumbers as $familyNumber)
                            <option value="{{ $familyNumber }}" {{ request('family_no') == $familyNumber ? 'selected' : '' }}>
                                {{ $familyNumber }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select Gender</option>
                        <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Age Range</label>
                    <select name="age_range" class="form-select">
                        <option value="">Select Age Range</option>
                        <option value="0-18" {{ request('age_range') == '0-18' ? 'selected' : '' }}>0-18</option>
                        <option value="19-25" {{ request('age_range') == '19-25' ? 'selected' : '' }}>19-25</option>
                        <option value="26-35" {{ request('age_range') == '26-35' ? 'selected' : '' }}>26-35</option>
                        <option value="36-50" {{ request('age_range') == '36-50' ? 'selected' : '' }}>36-50</option>
                        <option value="51+" {{ request('age_range') == '51+' ? 'selected' : '' }}>51+</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Civil Status</label>
                    <select name="civil_status" class="form-select">
                        <option value="">Select Status</option>
                        <option value="Single" {{ request('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Married" {{ request('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="religion" class="form-label">Religion</label>
                    <select name="religion" class="form-select" id="religion">
                        <option value="">Select Religion</option>
                        @foreach($religions as $religion)
                            <option value="{{ $religion->name }}" {{ request('religion') == $religion->name ? 'selected' : '' }}>
                                {{ $religion->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="occupation" class="form-label">Occupation</label>
                    <select name="occupation" class="form-select" id="occupation">
                        <option value="">Select Occupation</option>
                        @foreach($occupations as $occupation)
                            <option value="{{ $occupation->name }}" {{ request('occupation') == $occupation->name ? 'selected' : '' }}>
                                {{ $occupation->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Baptized</label>
                    <select name="baptized" class="form-select">
                        <option value="">Select Option</option>
                        <option value="1" {{ request('baptized') == '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ request('baptized') == '0' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </form>

            </div>
        </div>
    </div>

    <!-- Members Table -->
    <div class="col-md-9">
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>NIC</th>
                                <th>Contact</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $member)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $member->member_id }}</td>
                                    <td>{{ $member->member_name }}</td>
                                    <td>{{ $member->nic }}</td>
                                    <td>{{ $member->contact_info }}</td>
                                    <td class="text-end">
                                        <button 
                                            class="btn btn-primary btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#memberDetailModal" 
                                            data-id="{{ $member->id }}" 
                                            data-name="{{ $member->member_name }}"
                                            data-member-id="{{ $member->member_id }}" 
                                            data-gender="{{ $member->gender }}" 
                                            data-birth-date="{{ $member->birth_date }}"
                                            data-occupation="{{ $member->occupation }}" 
                                            data-religion="{{ $member->religion }}" 
                                            data-civil-status="{{ $member->civil_status }}" 
                                            data-baptized="{{ $member->baptized }}"
                                            data-church-congregation="{{ $member->church_congregation }}"
                                            data-image="{{ $member->image }}">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No members found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $members->links() }}
            </div>
        </div>
    </div>
</div>

<!-- modal-->
<div class="modal fade" id="memberDetailModal" tabindex="-1" aria-labelledby="memberDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberDetailModalLabel">Member Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex">
                    <!-- Image Section -->
                    <div class="me-4">
                        <img id="modalMemberImage" src="" alt="Member Image" class="img-fluid" style="max-width: 150px; border-radius: 8px;">
                    </div>
                    <div>
                        <h4 id="modalMemberName"></h4>
                        <p>
                            <strong>Member ID:</strong> <span id="modalMemberId"></span><br>
                            <strong>Gender:</strong> <span id="modalGender"></span><br>
                            <strong>Age:</strong> <span id="modalAge"></span><br>
                            <strong>Occupation:</strong> <span id="modalOccupation"></span><br>
                            <strong>Religion:</strong> <span id="modalReligion"></span><br>
                            <strong>Civil Status:</strong> <span id="modalCivilStatus"></span><br>
                            <strong>Baptized:</strong> <span id="modalBaptized"></span><br>
                            <strong>Church Congregation:</strong> <span id="modalChurchCongregation"></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script>
    // Enable Select2 for searchable dropdowns
    $(document).ready(function () {
        $('#member').select2({
            placeholder: 'Select Member Name or ID',
            allowClear: true
        });

        $('#family_no').select2({
            placeholder: 'Search or Select Family Number',
            allowClear: true
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var memberDetailModal = document.getElementById('memberDetailModal');

        memberDetailModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget;

            // Extract info from data-* attributes
            var memberName = button.getAttribute('data-name');
            var memberId = button.getAttribute('data-member-id');
            var gender = button.getAttribute('data-gender');
            var birthDate = button.getAttribute('data-birth-date');
            var age = moment().diff(moment(birthDate, 'YYYY-MM-DD'), 'years'); 
            var occupation = button.getAttribute('data-occupation');
            var religion = button.getAttribute('data-religion');
            var civilStatus = button.getAttribute('data-civil-status');
            var baptized = button.getAttribute('data-baptized') === '1' ? 'Yes' : 'No';
            var churchCongregation = button.getAttribute('data-church-congregation');
            var image = button.getAttribute('data-image');

            // Update modal content
            document.getElementById('modalMemberName').textContent = memberName;
            document.getElementById('modalMemberId').textContent = memberId;
            document.getElementById('modalGender').textContent = gender;
            document.getElementById('modalAge').textContent = age + ' years';
            document.getElementById('modalOccupation').textContent = occupation;
            document.getElementById('modalReligion').textContent = religion;
            document.getElementById('modalCivilStatus').textContent = civilStatus;
            document.getElementById('modalBaptized').textContent = baptized;
            document.getElementById('modalChurchCongregation').textContent = churchCongregation;

            // Set image src
            document.getElementById('modalMemberImage').src = image ? '/storage/' + image : '/path/to/default/image.jpg'; // Use a default image if not set
        });
    });
</script>


@endsection
