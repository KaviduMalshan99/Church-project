@extends('AdminDashboard.master')

@section('content')
<div class="d-flex justify-content-end mb-4">
    <a class="btn btn-primary" href="{{ route('member.create') }}">Add Family Members</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="familyTable">
                <thead>
                    <tr>
                        <th>Family Number</th>
                        <th>Main Member</th>
                        <th>Family Member Name</th>
                        <th>Relationship to Main Person</th>
                        <th>Gender</th>
                        <th>Contact No</th>
                        <th>Created At</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($family_members as $family_member)
                        <tr>
                            <td>{{ $family_member->family_no }}</td>

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

                            <td>{{ $family_member->member_name }}</td>
                            <td>{{ $family_member->relationship_to_main_person }}</td>
                            <td>{{ $family_member->gender }}</td>
                            <td>{{ $family_member->contact_info }}</td>
                            <td>{{ $family_member->created_at->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <!-- Edit and Delete Actions -->
                                <a href="{{ route('member.edit', $family_member->id) }}" class="btn btn-sm btn-outline-primary custom-hover">Edit</a>

                                <form action="{{ route('member.destroy', $family_member->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirmDelete()">Delete</button>
                                </form>

                                <script>
                                    function confirmDelete() {
                                        return confirm("Are you sure you want to delete this member?");
                                    }
                                </script>
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
        return confirm("Are you sure you want to delete this item?");
    }
</script>

@endsection
