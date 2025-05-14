@extends ('AdminDashboard.master')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
   
<div class="d-flex justify-content-end mb-4">
    <a class="btn btn-primary" href="{{ route('family.create') }}">Add Family</a>
</div>
<div class="card shadow-sm rounded-3 p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 text-primary">
            <i class="fas fa-users me-2"></i>Family Directory
        </h5>
        <span class="badge bg-primary rounded-pill fs-6">{{$totalFamilies}} Families</span>
    </div>
    
    <form method="GET" action="{{ route('family.list') }}" class="row g-3 align-items-end">
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
            <a href="{{ route('family.list') }}" class="btn btn-outline-secondary">
                <i class="fas fa-undo me-1"></i> Reset
            </a>
        </div>
    </form>
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
                        <th>Contact</th>
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
                        <td>{{ $family->mainPerson->contact_info }}</td>
                        <td>
                            @if ($family->mainPerson)
                                {{ $family->mainPerson->registered_date }}
                            @else
                                <span class="text-danger">Main person not set</span>
                            @endif
                        </td>

                        <td class="text-end">
                            <a href="{{ route('family.edit', $family->family_number ) }}" class="btn btn-sm btn-outline-primary custom-hover">Edit</a>
                           
                            <form id="delete-form-{{ $family->family_number }}" action="{{ route('family.destroy', $family->family_number ) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn  btn-outline-danger btn-sm" onclick="confirmDelete('delete-form-{{$family->family_number  }}', 'Are you sure you want to delete this family?');">
                                Delete
                                </button>
                            </form>
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