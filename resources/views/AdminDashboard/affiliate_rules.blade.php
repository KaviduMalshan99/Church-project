@extends ('AdminDashboard.master')

@section('content')

<div class="content-header">
    <div>
        <h2 class="content-title card-title">Affiliate Rules</h2>
    </div>
    <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fa-solid fa-plus"></i> Add
            </button>
    </div>
</div>


        <div class="card">
            <div class="card-body">
                <div class="container mt-4 mb-4">
                    <div class="table-responsive">
                        <table id="example" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 10%">#</th>
                                    <th>Rule</th>
                                    <th style="width: 15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rules as $rule)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $rule->rule }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editRuleModal" data-id="{{ $rule->id }}" data-rule="{{ $rule->rule }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form id="deleteForm{{ $rule->id }}" action="{{ route('affiliate_rules.destroy', $rule->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('deleteForm{{ $rule->id }}', 'Are you sure you want to delete this rule?')">
                                                    <i class="fas fa-trash"></i>
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
        </div>


<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New Rule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="addUserForm" action="{{ route('admin_rules.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <textarea name="rule" rows="3" class="form-control w-100" required></textarea>
                    <button type="submit" class="btn btn-success btn-create mt-2">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Rule Modal -->
<div class="modal fade" id="editRuleModal" tabindex="-1" aria-labelledby="editRuleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRuleModalLabel">Edit Rule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editRuleForm" action="{{ route('admin_users.update', ':id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_rule" class="form-label">Rule</label>
                        <textarea id="edit_rule" name="rule" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-create">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const ruleId = this.getAttribute('data-id');
                const ruleText = this.getAttribute('data-rule');

                const form = document.getElementById('editRuleForm');
                form.action = form.action.replace(':id', ruleId);

                document.getElementById('edit_rule').value = ruleText;
            });
        });
    });
</script>

@endsection
