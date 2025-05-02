@extends('AdminDashboard.master')

@section('content')

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

        <div class="content-header">
            <h2 class="content-title">Report - Fund</h2>
        </div>
        <a href="{{ route('fund.list.area') }}">
    <button class="mb-3" style="border: 1px solid grey; padding: 5px 10px; font-size: 13px;margin-left:5px;">
        Area-Wise Fund Report
    </button>
</a>      
        <!-- Date and Type Filter Form -->
        <form method="GET" action="{{ route('reports.fund_list') }}">
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <select name="contribution_type" class="form-select">
                        <option value="">Select Contribution Type</option>
                        <option value="all" {{ request('contribution_type') == 'all' ? 'selected' : '' }}>All</option>
                        @foreach($contribution_types as $type)
                            <option value="{{ $type->name }}" {{ request('contribution_type') == $type->name ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
                <div class="col-md-1">
                    <a href="{{route('reports.fund_list')}}"><button type="button" class="btn btn-secondary">Reset</button></a>
                </div>
               
            </div>
        </form>
 


        <!-- Room Form -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Room Table -->
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="tableData" class="table table-hover display">
                                <!-- Total Amount -->
                                <div class="mt-3 mb-3">
                                    <strong>Total Amount: Rs. {{ number_format($totalAmount, 2) }}</strong>
                                </div>
                                <thead>
                                    <tr>
                                        <th>Member Id</th>
                                        <th>Sender Name</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gifts as $gift)
                                    <tr>
                                        <td>@if($gift->member) {{ $gift->member->member_id }} @else <span class="text-danger">Sender not found</span> @endif</td>
                                        <td>@if($gift->member) {{ $gift->member->member_name }} @else <span class="text-danger">Sender not found</span> @endif</td>
                                        <td>{{ $gift->type }}</td>
                                        <td>Rs. {{ number_format($gift->amount, 2) }}</td>
                                        <td>{{ $gift->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>


    <!-- JavaScript to handle delete confirmation -->
    <script>
        $(document).ready(function() {
            var table = $('#tableData').DataTable({
                dom: 'Bfrtip', // Layout for DataTables with Buttons
                buttons: [{
                        extend: 'copyHtml5',
                        footer: true,
                        text: 'Copy'
                    },
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        title: 'Fund Report',
                        messageTop: 'Total Amount: Rs. {{ number_format($totalAmount, 2) }}'
                    },
                    {
                        extend: 'pdfHtml5',
                        footer: true,
                        title: 'Fund Report',
                        messageTop: 'Total Amount: Rs. {{ number_format($totalAmount, 2) }}',
                        customize: function(doc) {
                            // Add the total amount to the footer
                            doc.content[1].margin = [0, 0, 0, 20];
                            doc.content.push({
                                text: 'Total Amount: Rs. {{ number_format($totalAmount, 2) }}',
                                alignment: 'right',
                                margin: [0, 20, 0, 0]
                            });
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        title: 'Fund Report',
                        messageTop: 'Total Amount: Rs. {{ number_format($totalAmount, 2) }}'
                    }
                ],
            });
        });
    </script>

@endsection
