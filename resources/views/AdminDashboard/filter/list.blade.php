@extends('AdminDashboard.master')

@section('content')



<div class="content-header">
    <h2>Birthdays and Wedding Anniversaries</h2>
</div>

<!-- Filter Form -->
<form method="GET" action="{{ route('show.list') }}" class="mb-4">
    <div class="row g-2 align-items-center">
        <div class="col-auto">
            <label for="from_date" class="col-form-label">From:</label>
        </div>
        <div class="col-auto">
            <input type="date" id="from_date" name="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>
        <div class="col-auto">
            <label for="to_date" class="col-form-label">To:</label>
        </div>
        <div class="col-auto">
            <input type="date" id="to_date" name="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">View</button>
        </div>
    </div>
</form>

@if(request('from_date') && request('to_date'))
    <h4 class="mb-3">Date Range: {{ \Carbon\Carbon::parse(request('from_date'))->format('d-m-Y') }} to {{ \Carbon\Carbon::parse(request('to_date'))->format('d-m-Y') }}</h4>
@endif

<div class="row">
    <!-- Birthdays Section -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <h5 class="mb-3">Birthdays</h5>
                    <table class="table table-hover birthday-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Member ID</th>
                                <th>Name</th>
                                <th>Birth Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($birthdays as $index => $member)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $member->member_id }}</td>
                                    <td>{{ $member->member_name }}</td>
                                    <td style="white-space: nowrap;">{{ \Carbon\Carbon::parse($member->birth_date)->format('d-m-Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No birthdays found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Anniversaries Section -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <h5 class="mb-3"> Wedding Anniversaries</h5>
                    <table class="table table-hover anniversary-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Member ID</th>
                                <th>Name</th>
                                <th>Anniversary Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($anniversaries as $index => $member)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $member->member_id }}</td>
                                    <td>{{ $member->member_name }}</td>
                                    <td style="white-space: nowrap;">{{ \Carbon\Carbon::parse($member->married_date)->format('d-m-Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No anniversaries found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const fromDate = "{{ request('from_date') ? \Carbon\Carbon::parse(request('from_date'))->format('d-m-Y') : '' }}";
        const toDate = "{{ request('to_date') ? \Carbon\Carbon::parse(request('to_date'))->format('d-m-Y') : '' }}";
        const dateRange = fromDate && toDate ? `Date Range: ${fromDate} to ${toDate}` : '';

        // Initialize Birthdays Table
        $('.birthday-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    title: 'Birthdays',
                    messageTop: dateRange
                },
                {
                    extend: 'excelHtml5',
                    title: 'Birthdays',
                    messageTop: dateRange
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Birthdays Report',
                    messageTop: dateRange
                },
                {
                    extend: 'print',
                    title: 'Birthdays Report',
                    messageTop: dateRange
                }
            ]
        });

        // Initialize Anniversaries Table
        $('.anniversary-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    title: 'Wedding Anniversaries',
                    messageTop: dateRange
                },
                {
                    extend: 'excelHtml5',
                    title: 'Wedding Anniversaries',
                    messageTop: dateRange
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Wedding Anniversary Report',
                    messageTop: dateRange
                },
                {
                    extend: 'print',
                    title: 'Wedding Anniversary Report',
                    messageTop: dateRange
                }
            ]
        });
    });
</script>


@endsection
