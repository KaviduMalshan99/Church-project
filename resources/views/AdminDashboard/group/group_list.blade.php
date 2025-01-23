@extends ('AdminDashboard.master')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

<div class="d-flex justify-content-end mb-4">
    <a class="btn btn-primary" href="{{ route('group.create') }}">Create New Group</a>
</div>
<div class="card py-2 px-4 fs-5 fw-bold">
    {{$groupsCount}} Groups
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="groupTable">
                <thead class="fs-6">
                    <tr>
                        <th>Group Name</th>
                        <th>Created At</th>
                        <th>Send Message</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groups as $group)
                    <tr>
                        <td>{{ $group->group_name }}</td>
                        <td>
                            {{$group->created_at}}
                        </td>

                        <td>
                            <form action="{{ route('group.send_message', $group->id) }}" method="POST">
                                @csrf
                                <input type="text" name="message" required/>
                                <button type="submit" class="btn btn-sm btn-outline-primary">Send</button>
                            </form>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('group.edit', $group->id ) }}" class="btn btn-sm btn-outline-primary custom-hover">Edit</a>
                            <form action="{{ route('group.destroy', $group->id ) }}" method="POST" style="display:inline-block;">
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

            </div>
        </div>
    </div>
</div>





<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this item?");
    }
    $(document).ready(function() {
        $('#groupTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true
        });
    });
</script>

@endsection