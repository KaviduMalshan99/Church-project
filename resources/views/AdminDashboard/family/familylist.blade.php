@extends ('AdminDashboard.master')

@section('content')
<div class="d-flex justify-content-end mb-4">
    <a class="btn btn-primary" href="{{ route('family.create') }}">Add Family</a>
</div>
<div class="card py-2 px-4 fs-5 fw-bold">
{{$totalFamilies}} Families
</div>
<div class="card">
    <div class="card-body">
        <!-- Table for listing sub-churches -->

        <div class="table-responsive">
            <table class="table table-hover" id="subChurchTable">
                <thead class="fs-6">
                    <tr>
                        <th>Family Number</th>
                        <th>Family Name</th>
                        <th>Main Person</th>
                        <th>Created At</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($families as $family)
                    <tr>
                        @php
                        $main_person = App\Models\Member::find($family->main_person_id);
                        @endphp
                        <td>{{ $family->family_number }}</td>
                        <td>{{ $family->family_name }}</td>
                        <td>{{ $main_person->member_name }}</td>
                        <td>{{ $family->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <!-- Edit and Delete Actions -->
                            <a href="{{ route('family.edit', $family->id) }}" class="btn btn-sm btn-outline-primary custom-hover">Edit</a>

                            <form action="{{ route('family.destroy', $family->id) }}" method="POST" style="display:inline-block;">
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
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $families->links('vendor.pagination.bootstrap-4') }}
            </div>


        </div>
    </div>
</div>

@endsection