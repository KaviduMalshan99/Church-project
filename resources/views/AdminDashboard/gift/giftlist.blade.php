@extends('AdminDashboard.master')

@section('content')
@if(session('pdf_url'))
    <script type="text/javascript">
        window.onload = function() {
            var pdfWindow = window.open("{{ session('pdf_url') }}", "_blank");
            pdfWindow.onload = function() {
                pdfWindow.print();
            };
            pdfWindow.onafterprint = function() {
                window.location.href = '{{ route('gift.list') }}';
            };
        };
    </script>
@endif
<div class="container-fluid py-3">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Filters</h5>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs mb-3" id="filterTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ request('date') || request('contribution_type') ? 'active' : (!(request('from_date') || request('to_date') || request('from_month') || request('to_month') || request('main_area') || request('sub_area')) ? 'active' : '') }}" 
                            id="single-date-tab" data-bs-toggle="tab" data-bs-target="#single-date" type="button" role="tab" aria-selected="{{ request('date') || request('contribution_type') ? 'true' : (!(request('from_date') || request('to_date') || request('from_month') || request('to_month') || request('main_area') || request('sub_area')) ? 'true' : 'false') }}">
                        Single Date
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ request('from_date') || request('to_date') ? 'active' : '' }}" 
                            id="weekly-tab" data-bs-toggle="tab" data-bs-target="#weekly" type="button" 
                            aria-selected="{{ request('from_date') || request('to_date') ? 'true' : 'false' }}">
                        Weekly Range
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ request('from_month') || request('to_month') ? 'active' : '' }}" 
                            id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly" type="button" role="tab" 
                            aria-selected="{{ request('from_month') || request('to_month') ? 'true' : 'false' }}">
                        Monthly Range
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ request('main_area') || request('sub_area') ? 'active' : '' }}" 
                            id="area-tab" data-bs-toggle="tab" data-bs-target="#area" type="button" role="tab" 
                            aria-selected="{{ request('main_area') || request('sub_area') ? 'true' : 'false' }}">
                        Area
                    </button>
                </li>
            </ul>
            
            <div class="tab-content" id="filterTabContent">
                <!-- Single Date Filter -->
                <div class="tab-pane fade {{ request('date') || request('contribution_type') ? 'show active' : (!(request('from_date') || request('to_date') || request('from_month') || request('to_month') || request('main_area') || request('sub_area')) ? 'show active' : '') }}" 
                     id="single-date" role="tabpanel" aria-labelledby="single-date-tab">
                    <form method="GET" action="{{ route('gift.list') }}" class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label">Select Date</label>
                            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Contribution Type</label>
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
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="d-flex w-100">
                                <button type="submit" class="btn btn-danger text-center me-2" style="border-radius: 8px; width: 120px;">Apply</button>
                                <a href="{{ route('gift.list') }}" class="btn btn-outline-secondary text-center" style="border-radius: 8px; width: 120px;">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Weekly Date Range Filter -->
                <div class="tab-pane fade {{ request('from_date') || request('to_date') ? 'show active' : '' }}" 
                     id="weekly" role="tabpanel" aria-labelledby="weekly-tab">
                    <form method="GET" action="{{ route('gift.list') }}" class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">To Date</label>
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="d-flex w-100">
                                <button type="submit" class="btn btn-danger text-center me-2" style="border-radius: 8px; width: 120px;">Apply</button>
                                <a href="{{ route('gift.list') }}" class="btn btn-outline-secondary text-center" style="border-radius: 8px; width: 120px;">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Monthly Range Filter -->
                <div class="tab-pane fade {{ request('from_month') || request('to_month') ? 'show active' : '' }}" 
                     id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                    <form method="GET" action="{{ route('gift.list') }}" class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label">From Month</label>
                            <input type="month" name="from_month" class="form-control" value="{{ request('from_month') }}">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">To Month</label>
                            <input type="month" name="to_month" class="form-control" value="{{ request('to_month') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="d-flex w-100">
                                <button type="submit" class="btn btn-danger text-center me-2" style="border-radius: 8px; width: 120px;">Apply</button>
                                <a href="{{ route('gift.list') }}" class="btn btn-outline-secondary text-center" style="border-radius: 8px; width: 120px;">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Area Filter -->
                <div class="tab-pane fade {{ request('main_area') || request('sub_area') ? 'show active' : '' }}" 
                     id="area" role="tabpanel" aria-labelledby="area-tab">
                    <form method="GET" action="{{ route('gift.list') }}" class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label">Main Area</label>
                            <select name="main_area" class="form-select" id="main_area_select">
                                <option value="">Select Main Area</option>
                                @foreach($main_areas as $main_area)
                                    <option value="{{ $main_area }}" {{ request('main_area') == $main_area ? 'selected' : '' }}>
                                        {{ $main_area }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Sub Area</label>
                            <select name="sub_area" class="form-select" id="sub_area_select">
                                <option value="">Select Sub Area</option>
                                @foreach($sub_areas as $sub_area)
                                    <option value="{{ $sub_area }}" {{ request('sub_area') == $sub_area ? 'selected' : '' }}>
                                        {{ $sub_area }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="d-flex w-100">
                                <button type="submit" class="btn btn-danger text-center me-2" style="border-radius: 8px; width: 120px;">Apply</button>
                                <a href="{{ route('gift.list') }}" class="btn btn-outline-secondary text-center" style="border-radius: 8px; width: 120px;">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="card text-white" style="width: 18rem;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Total Amount</h4>
                <h4 class="card-text text-danger mb-0">Rs. {{ number_format($totalAmount, 2) }}</h4>
            </div>
        </div>
    </div>
    <a class="btn btn-primary" href="{{ route('gift.create') }}">Add Fund</a>
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
                                @if (session('role') === 'Super Admin')
                                    <a href="{{ route('gift.edit', $gift->id) }}" class="btn btn-sm btn-outline-primary custom-hover">Edit</a>
                                    <form id="delete-form-{{ $gift->id }}" action="{{ route('gift.destroy', $gift->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete('delete-form-{{ $gift->id }}', 'Are you sure you want to delete this?');">
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
    $(document).ready(function () {
        $('#giftTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true
        });
    });

    function resetFilters() {
        document.querySelector('input[name="date"]').value = '';
        document.querySelector('select[name="contribution_type"]').value = '';
        document.querySelector('input[name="from_date"]').value = '';
        document.querySelector('input[name="to_date"]').value = '';
        document.querySelector('input[name="from_month"]').value = '';
        document.querySelector('input[name="to_month"]').value = '';
        document.querySelector('select[name="main_area"]').value = '';
        document.querySelector('select[name="sub_area"]').value = '';
        document.getElementById('filterForm').submit();
    }

    // Handle dynamic sub area filtering
    document.addEventListener('DOMContentLoaded', function() {
        const mainAreaSelect = document.getElementById('main_area_select');
        const subAreaSelect = document.getElementById('sub_area_select');
        
        if (mainAreaSelect && subAreaSelect) {
            // Function to populate sub areas based on selected main area
            function populateSubAreas(selectedMainArea) {
                // Clear sub area selection
                subAreaSelect.innerHTML = '<option value="">Select Sub Area</option>';
                
                if (selectedMainArea) {
                    // Filter sub areas based on selected main area
                    const allAreas = @json($areas->pluck('area'));
                    const filteredSubAreas = [];
                    
                    allAreas.forEach(function(area) {
                        const parts = area.split('-');
                        if (parts[0] === selectedMainArea && parts[1]) {
                            if (!filteredSubAreas.includes(parts[1])) {
                                filteredSubAreas.push(parts[1]);
                            }
                        }
                    });
                    
                    // Add filtered sub areas to dropdown
                    filteredSubAreas.forEach(function(subArea) {
                        const option = document.createElement('option');
                        option.value = subArea;
                        option.textContent = subArea;
                        subAreaSelect.appendChild(option);
                    });
                }
            }
            
            // Handle main area change
            mainAreaSelect.addEventListener('change', function() {
                populateSubAreas(this.value);
            });
            
            // Populate sub areas on page load if main area is already selected
            if (mainAreaSelect.value) {
                populateSubAreas(mainAreaSelect.value);
            }
        }
    });

    // Add this script to ensure the correct tab is shown when page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Create a Bootstrap tab instance
        var triggerTabList = [].slice.call(document.querySelectorAll('#filterTabs button'))
        triggerTabList.forEach(function(triggerEl) {
            if (triggerEl.classList.contains('active')) {
                var tabTrigger = new bootstrap.Tab(triggerEl)
                tabTrigger.show()
            }
        })
    })
</script>
@endsection
