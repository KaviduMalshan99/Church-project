@extends ('AdminDashboard.master')

@section('content')

<div class="content-header">
    <div>
        <h2 class="content-title card-title">Held Office in Council</h2>
    </div>
    <div>
        <button type="button" class="btn btn-primary btn-sm rounded" data-bs-toggle="modal" data-bs-target="#addheldincouncilModal">Add</button>
    </div>
</div>

<div class="card mb-4">
    <header class="card-header">
        <div class="row align-items-center">
        </div>
    </header>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($heldincouncil->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">No data found.</td>
                                </tr>
                            @else
                                @foreach($heldincouncil as $heldincouncil)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $heldincouncil->name }}</td>
                                        <td class="text-end">
                                            <div>
                                            <a href="javascript:void(0);" 
                                                class="btn btn-warning btn-sm me-2" 
                                                onclick="editreligion('{{ $heldincouncil->id }}', '{{ $heldincouncil->name }}')">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form id="delete-form-{{ $heldincouncil->id }}" action="{{ route('held_in_council.destroy', $heldincouncil->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-form-{{ $heldincouncil->id }}', 'Are you sure you want to delete this?');">
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

<div class="pagination-area mt-30 mb-50">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-start">
        </ul>
    </nav>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addheldincouncilModal" tabindex="-1" aria-labelledby="addheldincouncilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addheldincouncilModalLabel">Add New</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('held_in_council.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="name" required>
                            </div>
                        </div>
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
<div class="modal fade" id="editreligionModal" tabindex="-1" aria-labelledby="editreligionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editreligionModalLabel">Edit Religion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editreligionForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="edit_name" name="name" placeholder="Name" required>
                            </div>
                        </div>
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
    function editreligion(id, name) {
        // Set the form action dynamically
        const form = document.getElementById('editreligionForm');
        form.action = `/settings/held_in_council/${id}`; 

        // Set the input value
        document.getElementById('edit_name').value = name; 

        // Initialize and show the modal
        const editModal = new bootstrap.Modal(document.getElementById('editreligionModal'));
        editModal.show();
    }
</script>



@endsection
