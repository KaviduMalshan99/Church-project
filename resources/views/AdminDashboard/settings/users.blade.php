@extends ('AdminDashboard.master')

@section('content')

<div class="content-header">
    <div>
        <h2 class="content-title card-title">Users</h2>
    </div>
    <div>
        <button type="button" class="btn btn-primary btn-sm rounded" data-bs-toggle="modal" data-bs-target="#addUserModal">Add</button>
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
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Role</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($users->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">No users found.</td>
                                </tr>
                            @else
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->contact }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td class="text-end">
                                            <div>
                                              <!-- Edit Button -->
                                              <a href="javascript:void(0);" 
                                                    class="btn btn-warning btn-sm me-2" 
                                                    onclick="editUser('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->contact }}', '{{ $user->role }}', '{{ $user->signature }}')">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-form-{{ $user->id }}', 'Are you sure you want to delete this user?');">
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
<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Name Input -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Full name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email Input -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="example@mail.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password Input -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirm Password Input -->
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Contact Input -->
                                <div class="mb-3">
                                    <label for="contact" class="form-label">Contact</label>
                                    <input type="tel" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" placeholder="phone number" required>
                                    @error('contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Role Dropdown -->
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="" disabled selected>Select Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="signature" class="form-label">Signature</label>
                                    <input type="file" class="form-control @error('signature') is-invalid @enderror" id="signature" name="signature" accept="image/*">
                                    @error('signature')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Save User</button>
                        </div>
                    </form>
                </div>``

        </div>
    </div>
</div>


<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Name Input -->
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="edit_name" name="name" placeholder="Name" required>
                            </div>

                            <!-- Email Input -->
                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit_email" name="email" placeholder="Email" required>
                            </div>

                            <!-- Contact Input -->
                            <div class="mb-3">
                                <label for="edit_contact" class="form-label">Contact</label>
                                <input type="tel" class="form-control" id="edit_contact" name="contact" placeholder="Contact" required>
                            </div>

                              <!-- Role Dropdown -->
                              <div class="mb-3">
                                <label for="edit_role" class="form-label">Role</label>
                                <select class="form-control" id="edit_role" name="role" required>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>


                        </div>

                        <div class="col-md-6">
                          
                           <!-- Signature Preview -->
                            <div class="mb-3">
                                <label for="edit_signature" class="form-label">eSignature</label>
                                <input type="file" class="form-control" id="edit_signature" name="signature" accept="image/*">
                                <div class="mt-2">
                                    <img id="edit_signature_preview" src="" alt="Signature Preview" style="max-width: 200px; max-height: 100px;" class="img-thumbnail">
                                </div>
                            </div>

                            <!-- Current Password Input -->
                            <div class="mb-3">
                                <label for="edit_current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="edit_current_password" name="current_password" placeholder="Enter current password" required>
                            </div>

                            <!-- New Password Input (Optional) -->
                            <div class="mb-3">
                                <label for="edit_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="edit_password" name="password" placeholder="New Password (Leave blank to keep current)">
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<script>
   function editUser(id, name, email, contact, role, signaturePath) {
    // Set the form action dynamically
    const form = document.getElementById('editUserForm');
    form.action = `/settings/users/${id}`;  

    // Set the input field values dynamically
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_contact').value = contact;
    document.getElementById('edit_role').value = role;

    // Set the signature preview
    const signaturePreview = document.getElementById('edit_signature_preview');
    if (signaturePath) {
        signaturePreview.src = `/storage/${signaturePath}`;
        signaturePreview.style.display = 'block';
    } else {
        signaturePreview.style.display = 'none';
    }

    // Initialize and show the modal
    const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
    editModal.show();
}

</script>




@endsection
