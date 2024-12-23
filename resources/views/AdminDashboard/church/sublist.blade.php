@extends('AdminDashboard.master') <!-- Inherit the master template -->

@section('content') <!-- Content section will be injected here -->

<div class="content-header">
    <section>
        <div>
            <h2 class="content-title card-title">Sub Churches</h2>
            <p>View and manage sub-church data for each main church</p>
        </div>
    </section>
</div>

<!-- Alert Messages -->
<div class="container mt-3">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <!-- Form for creating a sub-church -->
            <div class="col-md-3">
                <form method="POST" action="{{ route('church.sub.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="parent_church" class="form-label">Parent Church * </label>
                        <select name="parent_church_id" class="form-control" id="parent_church" required>
                            <option value="">Select Parent Church</option>
                            @foreach ($churches as $church)
                                <option value="{{ $church->id }}">{{ $church->church_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="church_name" class="form-label">Sub Church Name * </label>
                        <input type="text" name="church_name" placeholder="Type here" class="form-control" id="church_name" required />
                    </div>
                    <div class="mb-4">
                        <label for="location" class="form-label">Location * </label>
                        <input type="text" name="location" placeholder="Type here" class="form-control" id="location" required />
                    </div>
                    <div class="mb-4">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" name="contact_info" placeholder="Type here" class="form-control" id="contact_number" />
                    </div>
                    
                    <div class="d-grid">
                        <button class="btn btn-primary" type="submit">Create Sub Church</button>
                    </div>
                </form>
            </div>

            <!-- Table for listing sub-churches -->
            <div class="col-md-9">
                <div class="table-responsive">
                    <table class="table table-hover" id="subChurchTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Parent Church</th>
                                <th>Sub Church Name</th>
                                <th>Location</th>
                                <th>Contact No</th>
                                <th>Created At</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subChurches as $subChurch)
                                <tr>
                                    <td>{{ $subChurch->id }}</td>
                                    <td><b>{{ $subChurch->church->church_name }}</b></td>
                                    <td>{{ $subChurch->church_name }}</td>
                                    <td>{{ $subChurch->location }}</td>
                                    <td>{{ $subChurch->contact_info }}</td>
                                    <td>{{ $subChurch->created_at->format('d/m/Y') }}</td>
                                    <td class="text-end">
                                        <!-- Edit and Delete Actions -->
                                        <a href="{{ route('church.sub.edit', $subChurch->id) }}" class="btn btn-sm btn-outline-primary custom-hover">Edit</a>

                                        <form action="{{ route('church.sub.delete', $subChurch->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirmDelete()">Delete</button>
                                        </form>

                                        <script>
                                            function confirmDelete() {
                                                return confirm("Are you sure you want to delete this Sub Church?");
                                            }
                                        </script>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination (if needed) -->
                    {{ $subChurches->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
