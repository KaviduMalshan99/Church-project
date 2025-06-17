@extends('AdminDashboard.master')

@section('content')
<div class="container mt-4">
    <h2>Donation Report</h2>

    <!-- Filters Form -->
    <form method="GET" action="{{ route('fund.list.area') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <label>Area:</label>
                <select name="area" class="form-select">
                    <option value="">All</option>
                    @foreach($areas as $a)
                        <option value="{{ $a }}" {{ $area == $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>From:</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>

            <div class="col-md-3">
                <label>To:</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-3">
                <label>Member Name:</label>
                 <input type="text" name="member_name" class="form-control" value="{{ request('member_name') }}">
            </div>

           <div class="col-md-3">
            <label>Family Number:</label>
            <input type="text" name="family_no" class="form-control" value="{{ request('family_no') }}">
           </div>

            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('fund.list.area') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <!-- Download Button -->
    <form method="GET" action="{{ route('fund.list.area.pdf') }}" class="mb-3">
        <input type="hidden" name="area" value="{{ $area }}">
        <input type="hidden" name="start_date" value="{{ $startDate }}">
        <input type="hidden" name="end_date" value="{{ $endDate }}">
        <input type="hidden" name="member_name" value="{{ request('member_name') }}">
         <input type="hidden" name="family_no" value="{{ request('family_no') }}">

        <button type="submit"  style="border: 1px solid grey; padding: 5px 10px; font-size: 14px;width:15%;">Download PDF</button>
    </form>

    <!-- Report Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
            <th>Area</th>
                <th>Family Number</th>
                <th>Member Name</th>
           
                <th>Donate Amount</th>
                <th>Donated Date</th>
            </tr>
       
        </thead>
        <tbody>
            @forelse($gifts as $gift)
                <tr>
                <td>{{ $gift->member->area  ?? 'N/A' }}</td>
                    <td>{{ $gift->member->family_no  ?? 'N/A' }}</td>
                    <td>{{ $gift->member->member_name ?? 'N/A' }}</td>
               
                    <td>{{ number_format($gift->amount, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($gift->created_at)->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No data found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Total Amount -->
    <p><strong>Total Donated Amount:</strong> {{ number_format($totalAmount, 2) }}</p>
</div>
@endsection
