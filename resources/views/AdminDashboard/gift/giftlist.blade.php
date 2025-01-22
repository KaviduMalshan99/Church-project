@extends('AdminDashboard.master')

@section('content')
@if(session('pdf_url'))
    <script type="text/javascript">
        window.onload = function() {
            // Open the PDF in a new tab
            var pdfWindow = window.open("{{ session('pdf_url') }}", "_blank");

            // Trigger print after the PDF is loaded
            pdfWindow.onload = function() {
                pdfWindow.print();
            };

            // After printing (or canceling), redirect to the gift list page
            pdfWindow.onafterprint = function() {
                window.location.href = '{{ route('gift.list') }}';
            };
        };
    </script>
@endif

    
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex">
        <!-- Total Card -->
        <div class="card text-white" style="width: 30rem;">
            <div class="card-body">
                <form method="GET" action="{{ route('gift.list') }}" class="d-flex align-items-center" id="filterForm">
                    <div class="me-3">
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}" onchange="this.form.submit()">
                    </div>

                    <div class="me-3">
                        <select name="contribution_type" class="form-select" onchange="this.form.submit()">
                            <option value="">Select Contribution Type</option>
                            <option value="all" {{ request('contribution_type') == 'all' ? 'selected' : '' }}>All</option>
                            @foreach($contribution_types as $type)
                                <option value="{{ $type->name }}" {{ request('contribution_type') == $type->name ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Reset Button -->
                    <button type="button" class="btn btn-secondary" onclick="resetFilters()">Reset</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="d-flex">
        <!-- Total Card -->
        <div class="card text-white" style="width: 18rem;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Total Amount</h4>
                    <h4 class="card-text text-danger mb-0">Rs. {{ number_format($totalAmount, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <a class="btn btn-primary mb-3" href="{{ route('gift.create') }}">Add Fund</a>
</div>





<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="giftTable">
                <thead>
                    <tr>
                        <th>Member Id</th>
                        <th>Sender Name</th>
                        <th>Received By</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Bill</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gifts as $gift)
                        @php
                            $sender = App\Models\Member::firstWhere('member_id', $gift->sender_id);
                        @endphp
                        <tr>
                            <td>@if($sender) {{ $sender->member_id }} @else <span class="text-danger">Sender not found</span> @endif</td>
                            <td>@if($sender) {{ $sender->member_name }} @else <span class="text-danger">Sender not found</span> @endif</td>
                            <td>{{ $gift->received_by }}</td>
                            <td>{{ $gift->type }}</td>
                            <td>Rs. {{ $gift->amount }}</td>
                            <td>{{ $gift->date }}</td>
                            <td>
                                @if($gift->bill_path)
                                    <a href="{{ asset('storage/' . $gift->bill_path) }}" target="_blank">
                                        <i class="fas fa-file-pdf" style="font-size: 20px; color: red;"></i>
                                    </a>
                                @else
                                    No Bill Available
                                @endif
                            </td>
                            <td class="text-end">
                                @if (session('role') === 'admin')
                                    <a href="{{ route('gift.edit', $gift->id) }}" class="btn btn-sm btn-outline-primary custom-hover">Edit</a>
                                    <form id="delete-form-{{ $gift->id }}" action="{{ route('gift.destroy', $gift->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn  btn-outline-danger btn-sm" onclick="confirmDelete('delete-form-{{ $gift->id }}', 'Are you sure you want to delete this?');">
                                        Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>

    $(document).ready(function() {
        // Initialize DataTable for the combined table
        $('#giftTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true
        });
    });
</script>
<script>
    // Reset Filters Function
    function resetFilters() {
        document.querySelector('input[name="date"]').value = '';
        document.querySelector('select[name="contribution_type"]').value = '';
        document.getElementById('filterForm').submit(); // Trigger form submission to reset filters
    }
</script>

@endsection
