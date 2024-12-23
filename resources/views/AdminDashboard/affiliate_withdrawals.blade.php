@extends ('AdminDashboard.master')

@section('content')

<div class="content-header">
    <div>
        <h2 class="content-title card-title">Affiliate withdrawals</h2>
    </div>
</div>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active fw-bold" id="completed-tab" data-bs-toggle="tab" href="#completed" role="tab" aria-controls="completed" aria-selected="true">Completed Payments</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link fw-bold" id="pending-tab" data-bs-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">
                Pending Payments ({{ $pendingRequests->count() }})
                </a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <!-- Completed Tab -->
            <div class="tab-pane fade show active" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                <div class="card mt-1">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Request Amount</th>
                                        <th>Processing Fee</th>
                                        <th>Withdraw Amount</th>
                                        <th>Bank Name</th>
                                        <th>Branch</th>
                                        <th>Account Name</th>
                                        <th>Account No.</th>
                                        <th>Requested Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($completedRequests as $index => $request)
                                        <tr>
                                            <td>{{ $loop -> iteration }}</td>
                                            <td>{{ $request->affiliateUser->name }}</td>
                                            <td>Rs {{ $request->withdraw_amount }}</td>
                                            <td>Rs {{ number_format($request->processing_fee, 2) }}</td>
                                            <td>Rs {{ number_format($request->paid_amount, 2) }}</td>
                                            <td>{{ $request->bank_name }}</td>
                                            <td>{{ $request->branch }}</td>
                                            <td>{{ $request->account_name }}</td>
                                            <td>{{ $request->account_number }}</td>
                                            <td>{{ $request->requested_at->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Tab -->
            <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                <div class="card mt-1">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Withdraw Amount</th>
                                        <th>Bank Name</th>
                                        <th>Branch</th>
                                        <th>Account Name</th>
                                        <th>Account No.</th>
                                        <th>Requested Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendingRequests as $index => $request)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $request->affiliateUser->name }}</td>
                                            <td>{{ $request->withdraw_amount }}</td>
                                            <td>{{ $request->bank_name }}</td>
                                            <td>{{ $request->branch }}</td>
                                            <td>{{ $request->account_name }}</td>
                                            <td>{{ $request->account_number }}</td>
                                            <td>{{ $request->requested_at->format('Y-m-d') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm d-flex align-items-center justify-content-center" 
                                                        style="width: 25px; height: 25px;" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#updatePaymentModal" 
                                                        data-request-id="{{ $request->id }}"
                                                        title="Mark as Completed">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Outside the Table -->
            <div class="modal fade" id="updatePaymentModal" tabindex="-1" aria-labelledby="updatePaymentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updatePaymentModalLabel">Update Payment Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="updatePaymentForm" action="{{ route('affiliate.updatePaymentStatus', '') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="processing_fee" class="form-label">Processing Fee</label>
                                    <input type="text" name="processing_fee" id="processing_fee" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="paid_amount" class="form-label">Paid Amount</label>
                                    <input type="text" name="paid_amount" id="paid_amount" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>

          
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var updatePaymentModal = document.getElementById('updatePaymentModal');
        updatePaymentModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var requestId = button.getAttribute('data-request-id');
            var form = document.getElementById('updatePaymentForm');
            form.action = "{{ route('affiliate.updatePaymentStatus', '') }}/" + requestId;
        });
    });
</script>                        
@endsection
