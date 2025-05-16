@extends('AdminDashboard.master')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

<div class="d-flex justify-content-end mb-4">
    <a class="btn btn-primary" href="{{ route('member.create') }}">Add Family Members</a>
</div>
<div class="card shadow-sm rounded-3 p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 text-primary">
            <i class="fas fa-user-friends me-2"></i>Member Directory
        </h5>
        <span class="badge bg-primary rounded-pill fs-6">{{ $memberCount }} Members</span>
    </div>

    <form method="GET" action="{{ route('member.list') }}" class="row g-3 align-items-end">
        <div class="col-md-6 col-lg-4">
            <label for="area" class="form-label">Filter by Area:</label>
            <select name="area" id="area" class="form-select">
                <option value="">-- All Areas --</option>
                @foreach($areas as $area)
                    <option value="{{ $area->area }}" {{ request('area') == $area->area ? 'selected' : '' }}>
                        {{ $area->area }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 col-lg-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter me-1"></i> Apply Filter
            </button>
            <a href="{{ route('member.list') }}" class="btn btn-outline-secondary">
                <i class="fas fa-undo me-1"></i> Reset
            </a>
        </div>
    </form>
</div>


<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="memberTable">
                <thead>
                    <tr>
                        <th>Family Number</th>
                        <th>Member id</th>
                        <th>Member Name</th>
                        <th>Main Member</th>
                        <th>Relationship to Main Member</th>
                        <th>Gender</th>
                        <th>Contact No</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($family_members as $family_member)
                        <tr>
                            <td>{{ $family_member->family_no }}</td>
                            <td>{{ $family_member->member_id }}</td>
                            <td>{{ $family_member->member_name }}</td>
                            <td>
                                @php
                                    // Fetch the main member (assumed to be the first member with the same family_no)
                                    $mainPerson = \App\Models\Member::where('family_no', $family_member->family_no)
                                                                    ->where('relationship_to_main_person', 'Main Member')
                                                                    ->first();
                                @endphp

                                @if ($mainPerson)
                                    {{ $mainPerson->member_name }}
                                @else
                                    N/A
                                @endif
                            </td>

                            <td>{{ $family_member->relationship_to_main_person }}</td>
                            <td>{{ $family_member->gender }}</td>
                            <td>{{ $family_member->contact_info }}</td>
                            <td class="text-end">
                                <!-- Edit and Delete Actions -->
                                <a href="{{ route('member.edit', $family_member->id) }}" class="btn btn-sm btn-outline-primary custom-hover">Edit</a>

                                <form id="delete-form-{{ $family_member->id }}" action="{{ route('member.destroy', $family_member->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn  btn-outline-danger btn-sm" onclick="confirmDelete('delete-form-{{ $family_member->id }}', 'Are you sure you want to delete this Member?');">
                                    Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination links -->


<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this member?");
    }
</script>
<script>
    $(document).ready(function() {
        $('#memberTable').DataTable({
            "paging": true,           
            "searching": true,      
            "ordering": true,       
            "info": true,            
            "lengthChange": true     
        });
    });
</script>
@endsection
