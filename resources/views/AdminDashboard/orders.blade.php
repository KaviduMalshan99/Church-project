@extends('AdminDashboard.master')

@section('content')
<div class="content-header">
    <div>
        <h2 class="content-title card-title">Order Management</h2>
    </div>
</div>

<!-- Tabs for Order Statuses -->
<ul class="nav nav-tabs mb-3" id="orderTabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'All' || !request('status') ? 'active' : '' }}" href="{{ route('orders', ['status' => 'All']) }}">All Orders</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'Packed' ? 'active' : '' }}" href="{{ route('orders', ['status' => 'Packed']) }}">Packed</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'Pickup Done' ? 'active' : '' }}" href="{{ route('orders', ['status' => 'Pickup Done']) }}">Pickup Done</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'Ready to Ship' ? 'active' : '' }}" href="{{ route('orders', ['status' => 'Ready to Ship']) }}">Ready to Ship</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'Shipped' ? 'active' : '' }}" href="{{ route('orders', ['status' => 'Shipped']) }}">Shipped</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'In Transit' ? 'active' : '' }}" href="{{ route('orders', ['status' => 'In Transit']) }}">In Transit</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'Delivered' ? 'active' : '' }}" href="{{ route('orders', ['status' => 'Delivered']) }}">Delivered</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'Cancelled' ? 'active' : '' }}" href="{{ route('orders', ['status' => 'Cancelled']) }}">Cancelled</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'Returned' ? 'active' : '' }}" href="{{ route('orders', ['status' => 'Returned']) }}">Returned</a>
    </li>
</ul>

<!-- Orders Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order Code</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->order_code }}</td>
                            <td><b>{{ $order->customer_name }}</b></td>
                            <td>{{ $order->email }}</td>
                            <td>Rs. {{ number_format($order->total_cost, 2) }}</td>
                            <td>
                                <span class="status {{ strtolower(str_replace(' ', '-', $order->status)) }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>{{ $order->date }}</td>
                            <td class="text-end">
                                <a href="{{ route('order-details', $order->order_code) }}" class="btn btn-view btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form id="deleteForm{{ $order->id }}" action="{{ route('order.delete', $order->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('deleteForm{{ $order->id }}', 'Are you sure you want to delete this order?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No orders found for this section.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="pagination-area mt-15 mb-50">
    {{ $orders->links() }}
</div>

<style>
    .status.packed {
        background-color: #0275d8; /* Blue for Packed */
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
    }

    /* Pickup Done Status */
    .status.pickup-done {
        background-color: #5bc0de; /* Light Blue for Pickup Done */
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
    }

    /* Ready to Ship Status */
    .status.ready-to-ship {
        background-color: #f0ad4e; /* Orange for Ready to Ship */
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
    }

    /* In Transit Status */
    .status.in-transit {
        background-color: #6f42c1; /* Purple for In Transit */
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
    }
</style>

<script>
function submitForm() {
    document.getElementById('orderSearchForm').submit();
}
</script>
@endsection
