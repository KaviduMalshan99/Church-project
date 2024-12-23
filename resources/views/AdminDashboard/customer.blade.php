@extends('AdminDashboard.master')

@section('content')

<div class="content-header">
    <div>
        <h2 class="content-title card-title">Customers</h2>
    </div>
    <div>
        <a href="#" class="btn btn-light rounded font-md">Export</a>
    </div>
</div>

<div class="card mb-4">
    <header class="card-header">
        <div class="row align-items-center">
            <!-- Removed the date filter form -->
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
                            <th>Phone</th>
                            <th>Registered Date</th>
                            <th>Total Orders</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $index => $customer)
                            <tr>
                                <td>{{ $customers->firstItem() + $index }}</td> <!-- Display correct customer number -->
                                <td>{{ $customer->name }}</td> 
                                <td>{{ $customer->email }}</td> 
                                <td>{{ $customer->phone }}</td> 
                                <td>{{ $customer->created_at->format('Y-m-d') }}</td> 
                                <td>{{ $customer->customer_orders_count }}</td> 
                                <td class="text-end">
                                    <a href="{{ route('customer-details', $customer->id) }}" class="btn btn-view btn-sm me-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
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

<!-- Pagination Area -->
<div class="pagination-area mt-30 mb-50">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-start">
            {{ $customers->links() }}  
        </ul>
    </nav>
</div>

@endsection
