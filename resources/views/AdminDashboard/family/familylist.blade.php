@extends ('AdminDashboard.master')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
   
<div class="d-flex justify-content-end mb-4">
    <a class="btn btn-primary" href="{{ route('family.create') }}">Add Family</a>
</div>
<div class="card py-2 px-4 fs-5 fw-bold">
{{$totalFamilies}} Families
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="familyTable">
                <thead class="fs-6">
                    <tr>
                        <th>#</th>
                        <th>Family Number</th>
                        <th>Main Person</th>
                        <th>Registered Date</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($families as $family)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $family->family_number }}</td>
                        <td>
                            @if($family->mainPerson)
                                {{ $family->mainPerson->member_name }}
                            @else
                                N/A (Main person ID: {{ $family->main_person_id }})
                            @endif
                        </td>
                        <td>
                            @if ($family->mainPerson)
                                {{ $family->mainPerson->registered_date }}
                            @else
                                <span class="text-danger">Main person not set</span>
                            @endif
                        </td>

                        <td class="text-end">
                            <a href="{{ route('family.edit', $family->family_number ) }}" class="btn btn-sm btn-outline-primary custom-hover">Edit</a>
                            <form action="{{ route('family.destroy', $family->family_number ) }}" method="POST" style="display:inline-block;">
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





<script>
    $(document).ready(function() {
        $('#familyTable').DataTable({
            "paging": true,           
            "searching": true,      
            "ordering": true,       
            "info": true,            
            "lengthChange": true     
        });
    });
</script>

@endsection