@extends ('AdminDashboard.master')

@section('content')

<!-- Display Success Message -->
@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Display Error Message -->
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Display Validation Errors -->
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="content-header">
    <div>
        <h2 class="content-title card-title">Affiliate Customers</h2>
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
                                <th>NIC</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($affiliates as $affiliate)
                            <tr>
                                <td>{{ $loop->iteration }}</td> 
                                <td>{{ $affiliate->name }}</td> 
                                <td>{{ $affiliate->NIC }}</td> 
                                <td>{{ $affiliate->address }}</td> 
                                <td>{{ $affiliate->email }}</td> 
                                <td>{{ $affiliate->contactno }}</td> 
                                <td>{{ $affiliate->gender }}</td>
                                <td>{{ ucfirst($affiliate->status) }}</td>
                                <td class="text-end">

                                    <!-- More Details Button -->
                                    <a href="{{ route('admin.affiliates.show', ['id' => $affiliate->id]) }}" class="btn btn-info btn-sm me-2">More Details</a>


                                    @if($affiliate->status === 'pending')
                                        <form action="{{ route('admin.affiliates.updateStatus', ['id' => $affiliate->id, 'status' => 'approved']) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                    @endif
                                    
                                    @if($affiliate->status !== 'rejected')
                                        <form action="{{ route('admin.affiliates.updateStatus', ['id' => $affiliate->id, 'status' => 'rejected']) }}" method="POST" style="display:inline;">
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
