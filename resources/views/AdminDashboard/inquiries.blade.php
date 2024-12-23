@extends ('AdminDashboard.master')

@section('content')

<div class="content-header">
    <div>
        <h2 class="content-title card-title">Customer Inquiries</h2>
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
                                <th>Customer</th>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>12345</td>
                                <td>02.05.2021</td>
                                <td>Order Issue</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-view btn-sm me-2" onclick="showInquiryModal('John Doe', '12345', 'Order Issue', 'I am facing an issue with my order.')">
                                        <i class="fas fa-file"></i>
                                    </a>
                                </td>                                  
                            </tr>
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

<!-- Pagination -->
<div class="pagination-area mt-30 mb-50">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-start">
        </ul>
    </nav>
</div>

<!-- Customer Inquiry Modal -->
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="inquiryModalLabel">Inquiry Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-1">
                    <strong class="fw-bold">Customer Name:</strong> <span id="customerName"></span>
                </div>
                <div class="mb-1">
                    <strong class="fw-bold">Order ID:</strong> <span id="orderId"></span>
                </div>
                <div class="mb-1">
                    <strong class="fw-bold">Subject:</strong> <span id="inquirySubject"></span>
                </div>
                <div class="mt-3 mb-3">
                    <strong class="fw-bold">Message:</strong>
                    <p id="inquiryMessage"></p>
                </div>
                <form id="replyForm" action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="replyMessage" class="form-label fw-bold">Reply</label>
                        <textarea class="form-control" id="replyMessage" name="replyMessage" rows="4" placeholder="Type your reply..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Response</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function showInquiryModal(customerName, orderId, subject, message) {
        document.getElementById('customerName').innerText = customerName;
        document.getElementById('orderId').innerText = orderId;
        document.getElementById('inquirySubject').innerText = subject;
        document.getElementById('inquiryMessage').innerText = message;

        const modal = new bootstrap.Modal(document.getElementById('inquiryModal'));
        modal.show();
    }
</script>

@endsection
