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
                        <th>Family Name</th>
                        <th>Main Member</th>
                        <th>Family Member Name</th>
                        <th>Relationship to Main Person</th>
                        <th>Gender</th>
                        <th>Cotact NO</th>
                        <th>Created At</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($family_members as $family_member)
                    <tr>
                        @php
                        $main_person = App\Models\Member::find($family_member->main_member_id);
                        @endphp
                        <td>{{ $family_member->family ? $family_member->family->family_name : 'N/A' }}</td>
                        <td>{{ $main_person ? $main_person->member_name : 'N/A' }}</td>
                        <td>{{$family_member -> member_name}}</td>
                        <td>{{$family_member -> relationship_to_main_person	}}</td>
                        <td>{{$family_member -> gender}}</td>
                        <td>{{$family_member -> contact_info}}</td>
                        <td>{{$family_member->created_at->format('d/m/Y') }}</td>
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
                                    return confirm("Are you sure you want to delete this family?");
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
