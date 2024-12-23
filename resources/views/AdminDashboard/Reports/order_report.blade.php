@extends('AdminDashboard.master')

@section('content')
<!DOCTYPE html>
<html lang="en">

<body>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Report - Orders</h2>
        </div>

        <!-- Room Form -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Room Table -->
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="tableData" class="table table-hover display">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order code</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Phone Number</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>   
                                        <th scope="col" class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $index =>$order)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $order->order_code }}</td>
                                        <td><b>{{ $order->customer_name }}</b></td>
                                        <td>{{ $order->phone }}</td>
                                        <td>Rs. {{ number_format($order->total_cost, 2) }}</td>
                                        <td>{{ $order->payment_status }}</td>
                                        <td>{{ $order->date }}</td>
                                        <td>
                                            <span class="status 
                                    {{ strtolower(str_replace(' ', '-', $order->status)) }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div>
                                                <a href="{{ route('order-details', $order->order_code) }}" class="btn btn-view btn-sm me-2">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript to handle delete confirmation -->
    <script>
        $(document).ready(function() {
            var table = $('#tableData').DataTable({
                dom: 'Bfrtip', // Layout for DataTables with Buttons
                buttons: [{
                        extend: 'copyHtml5',
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        footer: true
                    },
                    {
                        extend: 'csvHtml5',
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        footer: true,
                        title: 'Order Report',
                        customize: function(doc) {
                            // Set a margin for the footer
                            doc.content[1].margin = [0, 0, 0, 20];
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        title: 'Order Report',
                    }
                ],

            });


        });
    </script>

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



</body>

</html>
@endsection