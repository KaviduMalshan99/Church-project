@extends ('AdminDashboard.master')

@section('content')
<style>
  .pending-status {
    color: #B8860B;
}

.approved-status {
    color: blue;
}

.rejected-status {
    color: red;
}

</style>

<div class="content-header">
    <div>
        <h2 class="content-title card-title">Vendors</h2>
    </div>
    <div>
        <a href="#" class="btn btn-light rounded font-md">Export</a>
    </div>
</div>

<div class="card mb-4">
    <header class="card-header">
        <div class="row align-items-center">
            <div class="col-md-2 col-6">
                <input type="date" value="02.05.2021" class="form-control" />
            </div>
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
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vendors as $vendor)
                            <tr>
                                <td>{{ $loop->iteration }}</td> 
                                <td>{{ $vendor->name }}</td> 
                                <td>{{ $vendor->address }}</td> 
                                <td>{{ $vendor->email }}</td> 
                                <td>{{ $vendor->phone }}</td> 
                                <td>
                                    <span class="{{ strtolower($vendor->status) }}-status">
                                        {{ ucfirst($vendor->status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    @if($vendor->status === 'approved')
                                        <!-- More Details Button -->
                                        <a href="{{ route('vendor-details', $vendor->id) }}" class="btn btn-info btn-sm me-2 text-white">More Details</a>
                                    @endif

                                    @if($vendor->status === 'pending')
                                        <form action="{{ route('admin.vendors.updateStatus', ['id' => $vendor->id, 'status' => 'approved']) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                    @endif

                                    @if($vendor->status !== 'rejected')
                                        <form action="{{ route('admin.vendors.updateStatus', ['id' => $vendor->id, 'status' => 'rejected']) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    @endif
                                </td>
                              
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- .col// -->
        </div>
        <!-- .row // -->
    </div>
    <!-- card-body end// -->
</div>
<!-- card end// -->

<div class="pagination-area mt-30 mb-50">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-start">
            {{-- Pagination links if needed --}}
        </ul>
    </nav>
</div>

@endsection
