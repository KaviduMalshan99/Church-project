@extends ('AdminDashboard.master')

@section('content')

<div class="content-header">
    <div>
        <h2 class="content-title card-title">Areas</h2>
    </div>
    <div>
        <button type="button" class="btn btn-primary btn-sm rounded" data-bs-toggle="modal" data-bs-target="#addoccupationModal">Add</button>
    </div>
</div>

<div class="card mb-4">
    <header class="card-header"></header>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Area</th>
                                <th>Leader</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($areas->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">No areas found.</td>
                                </tr>
                            @else
                                @foreach($areas as $area)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $area->area }}</td>
                                        <td>{{ $area->leader }}</td>
                                        <td class="text-end">
                                            <div>
                                                <a href="javascript:void(0);" 
                                                    class="btn btn-warning btn-sm me-2" 
                                                    onclick="editArea('{{ $area->id }}', '{{ $area->area }}', '{{ $area->leader }}')">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form id="delete-form-{{ $area->id }}" action="{{ route('areas.destroy', $area->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-form-{{ $area->id }}', 'Are you sure you want to delete this area?');">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addoccupationModal" tabindex="-1" aria-labelledby="addoccupationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addoccupationModalLabel">Add New Area</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('areas.store') }}" method="POST" onsubmit="return combineArea();" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="main_area" class="form-label">Main Area</label>
                                <input type="text" class="form-control" id="main_area" placeholder="Main Area" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sub_area" class="form-label">Sub Area</label>
                                <input type="text" class="form-control" id="sub_area" placeholder="Sub Area" required>
                            </div>
                        </div>
                        <input type="hidden" name="area" id="combined_area">
                    </div>
                    <div class="mb-3">
                        <label for="leader" class="form-label">Leader</label>
                        <input type="text" class="form-control" id="leader" name="leader" placeholder="Leader" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editAreaModal" tabindex="-1" aria-labelledby="editAreaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAreaModalLabel">Edit Area</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAreaForm" action="" method="POST" onsubmit="return combineEditArea();" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_main_area" class="form-label">Main Area</label>
                                <input type="text" class="form-control" id="edit_main_area" placeholder="Main Area" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_sub_area" class="form-label">Sub Area</label>
                                <input type="text" class="form-control" id="edit_sub_area" placeholder="Sub Area" required>
                            </div>
                        </div>
                        <input type="hidden" name="area" id="edit_combined_area">
                    </div>
                    <div class="mb-3">
                        <label for="edit_leader" class="form-label">Leader</label>
                        <input type="text" class="form-control" id="edit_leader" name="leader" placeholder="Leader" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function combineArea() {
        const main = document.getElementById('main_area').value.trim();
        const sub = document.getElementById('sub_area').value.trim();
        if (!main || !sub) {
            alert("Please enter both Main Area and Sub Area.");
            return false;
        }
        document.getElementById('combined_area').value = `${main}-${sub}`;
        return true;
    }

    function combineEditArea() {
        const main = document.getElementById('edit_main_area').value.trim();
        const sub = document.getElementById('edit_sub_area').value.trim();
        if (!main || !sub) {
            alert("Please enter both Main Area and Sub Area.");
            return false;
        }
        document.getElementById('edit_combined_area').value = `${main}-${sub}`;
        return true;
    }

    function editArea(id, area, leader) {
        const form = document.getElementById('editAreaForm');
        form.action = `/settings/areas/${id}`;

        const parts = area.split("-");
        document.getElementById('edit_main_area').value = parts[0] ?? '';
        document.getElementById('edit_sub_area').value = parts[1] ?? '';

        document.getElementById('edit_leader').value = leader;

        const editModal = new bootstrap.Modal(document.getElementById('editAreaModal'));
        editModal.show();
    }
</script>

@endsection
