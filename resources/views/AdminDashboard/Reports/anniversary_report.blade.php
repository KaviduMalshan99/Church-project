@extends('AdminDashboard.master')

@section('content')

<div class="container mt-4">
    <h2>Wedding Anniversary Report</h2>

    <form method="GET" action="{{ route('anniversary.report') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <label>From (MM-DD):</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}" required>
            </div>
            <div class="col-md-3">
                <label>To (MM-DD):</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}" required>
            </div>
            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary">Filter Anniversaries</button>
            </div>
            <div class="col-md-3 align-self-end">
                @if($members->count())
                    <a href="{{ route('anniversary.report.pdf', ['from' => request('from'), 'to' => request('to')]) }}" class="btn btn-success">
                        Download PDF
                    </a>
                @endif
            </div>
        </div>
    </form>

    @if($members->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Member Name</th>
                    <th>Spouse Name</th>
                    <th>Contact Info</th>
                    <th>Wedding Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                    <tr>
                        <td>{{ $member->member_name }}</td>
                   
                        <td>{{ $member->contact_info }}</td>
                        <td>{{ \Carbon\Carbon::parse($member->married_date)->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No anniversaries found for the selected date range.</p>
    @endif
</div>
@endsection
