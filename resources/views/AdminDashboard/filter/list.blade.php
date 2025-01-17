@extends('AdminDashboard.master')

@section('content')

<div class="content-header">
    <h2>Last Week's Birthdays and Anniversaries</h2>
</div>

<h4 class="mb-3">Date Range: {{ $startOfWeek->format('d-m-Y') }} to {{ $endOfWeek->format('d-m-Y') }}</h4>
    
<div class="row">
    <!-- Birthdays Section -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                <h5 class="mb-3">Birthdays</h5>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Member id</th>
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
                                    <td>{{ \Carbon\Carbon::parse($member->birth_date)->format('d-m-Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No birthdays found for last week.</td>
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
                <h5 class="mb-3">Anniversaries</h5>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Member id</th>
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
                                    <td>{{ \Carbon\Carbon::parse($member->married_date)->format('d-m-Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No anniversaries found for last week.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection
