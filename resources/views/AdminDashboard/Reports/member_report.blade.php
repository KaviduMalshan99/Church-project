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
            <h2 class="content-title">Report - Members</h2>
        </div>

           
                <div class="row">
                    <!-- Filter Form -->
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <form method="GET" action="{{ route('reports.members') }}">
                                <div class="d-flex justify-content-between mb-4">
                                    <button type="submit" class="btn btn-primary"  style="padding:10px 15px">Filter</button>
                                    <a href="{{ route('reports.members') }}" class="btn btn-secondary">Reset</a>
                                </div>
                                    <!-- Full Members Filter -->
                                    <div class="form-group">
                                        <label for="full_members_filter" class="mb-1">Full Members:</label>
                                        <select class="form-control" name="full_members_filter" id="full_members_filter">
                                            <option value="">-- Select Filter --</option>
                                            <option value="yes" {{ request('full_members_filter') == 'yes' ? 'selected' : '' }}>Yes</option>
                                            <option value="no" {{ request('full_members_filter') == 'no' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="baptized" class="mb-1">Baptized:</label>
                                        <select class="form-control" name="baptized" id="baptized">
                                            <option value="">-- Select Filter --</option>
                                            <option value="yes" {{ request('baptized') == 'yes' ? 'selected' : '' }}>Yes</option>
                                            <option value="no" {{ request('baptized') == 'no' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="baptized_filter" class="mb-1">Baptized Members by Age:</label>
                                        <select class="form-control" name="baptized_filter" id="baptized_filter">
                                            <option value="">-- Select Filter --</option>
                                            <option value="baptised_less_5" {{ request('baptized_filter') == 'baptised_less_5' ? 'selected' : '' }}>Age Less Than 5 Years</option>
                                            <option value="baptised_5_to_15" {{ request('baptized_filter') == 'baptised_5_to_15' ? 'selected' : '' }}>Ages 5 to 15 Years</option>
                                            <option value="baptised_over_15" {{ request('baptized_filter') == 'baptised_over_15' ? 'selected' : '' }}>Over 15 Years</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label class="mb-1">Age Range</label>
                                        <select name="age_range" class="form-select">
                                            <option value="">Select Age Range</option>
                                            <option value="0-18" {{ request('age_range') == '0-18' ? 'selected' : '' }}>0-18</option>
                                            <option value="19-25" {{ request('age_range') == '19-25' ? 'selected' : '' }}>19-25</option>
                                            <option value="26-35" {{ request('age_range') == '26-35' ? 'selected' : '' }}>26-35</option>
                                            <option value="36-50" {{ request('age_range') == '36-50' ? 'selected' : '' }}>36-50</option>
                                            <option value="51+" {{ request('age_range') == '51+' ? 'selected' : '' }}>51+</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label class="mb-1">Baptized During Period</label>
                                        <div class="input-group">
                                            <input type="date" name="baptized_start" class="form-control" value="{{ request('baptized_start') }}">
                                            <span class="input-group-text">to</span>
                                            <input type="date" name="baptized_end" class="form-control" value="{{ request('baptized_end') }}">
                                        </div>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label class="mb-1">Marriages During Period</label>
                                        <div class="input-group">
                                            <input type="date" name="marriage_start" class="form-control" value="{{ request('marriage_start') }}">
                                            <span class="input-group-text">to</span>
                                            <input type="date" name="marriage_end" class="form-control" value="{{ request('marriage_end') }}">
                                        </div>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label class="mb-1">Deaths During Period</label>
                                        <div class="input-group">
                                            <input type="date" name="death_start" class="form-control" value="{{ request('death_start') }}">
                                            <span class="input-group-text">to</span>
                                            <input type="date" name="death_end" class="form-control" value="{{ request('death_end') }}">
                                        </div>
                                    </div>

                                    <!--<div class="form-group mt-3">
                                        <label>Full Members Accepted in Year</label>
                                        <input type="number" name="full_member_year" class="form-control" placeholder="e.g., 2023" value="{{ request('full_member_year') }}">
                                    </div>-->

                                </form>
                            </div>
                        </div>
                    </div>

    <!-- Table -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <!-- Filter Details Title -->
                <div class="mb-3">
                    <h4>
                        @if(request('full_members_filter'))
                            Full Members - {{ ucfirst(request('full_members_filter')) }}
                        @endif
                        @if(request('baptized_filter'))
                            @if(request('full_members_filter')) | @endif
                            Baptized - 
                            @switch(request('baptized_filter'))
                                @case('baptised_less_5') Age Less Than 5 Years @break
                                @case('baptised_5_to_15') Ages 5 to 15 Years @break
                                @case('baptised_over_15') Over 15 Years @break
                            @endswitch
                        @endif
                        @if(request('age_range'))
                            @if(request('full_members_filter') || request('baptized_filter')) | @endif
                            Age Range - {{ str_replace('-', ' to ', request('age_range')) }}
                        @endif
                        @if(request('baptized_start') && request('baptized_end'))
                            @if(request('full_members_filter') || request('baptized_filter') || request('age_range')) | @endif
                            Baptized During Period - {{ request('baptized_start') }} to {{ request('baptized_end') }}
                        @endif
                        @if(request('marriage_start') && request('marriage_end'))
                            @if(request('full_members_filter') || request('baptized_filter') || request('age_range') || request('baptized_start')) | @endif
                            Marriages During Period - {{ request('marriage_start') }} to {{ request('marriage_end') }}
                        @endif
                        @if(request('full_member_year'))
                            @if(request('full_members_filter') || request('baptized_filter') || request('age_range') || request('baptized_start') || request('marriage_start')) | @endif
                            Full Members Accepted in {{ request('full_member_year') }}
                        @endif
                        @if(request('baptized'))
                            @if(request('full_members_filter') || request('baptized_filter') || request('age_range') || request('baptized_start') || request('marriage_start') || request('full_member_year')) | @endif
                            Baptized - {{ ucfirst(request('baptized')) }}
                        @endif
                        @if(request('death_start') && request('death_end'))
                            @if(request('full_members_filter') || request('baptized_filter') || request('age_range') || request('baptized_start') || request('marriage_start') || request('full_member_year') || request('baptized')) | @endif
                            Deaths During Period - {{ request('death_start') }} to {{ request('death_end') }}
                        @endif

                    </h4>
                    <h5>Total Records: {{ $members->count() }}</h5><br>
                    <a href="{{ route('areaWiseReport') }}">
    <button style="border: 1px solid grey; padding: 5px 10px; font-size: 13px;">
        Area-wise Report
    </button>
</a><br>
                </div>
    
                <!-- Table -->
                <div class="table-responsive">
                    <table id="tableData" class="table table-hover display">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Member id</th>
                                <th>Member Name</th>
                                <th>Main Member</th>
                                <th>Relationship to Main Member</th>
                                <th>Gender</th>
                                <th>Contact No</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $index => $family_member)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $family_member->member_id }}</td>
                                    <td>{{ $family_member->member_name }}</td>
                                    <td>
                                        @php
                                            $mainPerson = \App\Models\Member::where('family_no', $family_member->family_no)
                                                                            ->where('relationship_to_main_person', 'Main Member')
                                                                            ->first();
                                        @endphp
                                        {{ $mainPerson ? $mainPerson->member_name : 'N/A' }}
                                    </td>
                                    <td>{{ $family_member->relationship_to_main_person }}</td>
                                    <td>{{ $family_member->gender }}</td>
                                    <td>{{ $family_member->contact_info }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for DataTables -->
<script>
    $(document).ready(function() {
        var table = $('#tableData').DataTable({
            dom: 'Bfrtip', // Layout for DataTables with Buttons
            buttons: [
                {
                    extend: 'copyHtml5',
                    footer: true,
                    title: function() {
                        return generateTitle();
                    }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,
                    title: function() {
                        return generateTitle();
                    }
                },
                {
                    extend: 'pdfHtml5',
                    footer: true,
                    title: function() {
                        return generateTitle();
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    title: function() {
                        return generateTitle();
                    }
                }
            ]
        });

        function generateTitle() {
        let filterDetails = '';
        @if(request('full_members_filter'))
            filterDetails += 'Full Members - {{ ucfirst(request('full_members_filter')) }}';
        @endif
        @if(request('baptized_filter'))
            filterDetails += (filterDetails ? ' | ' : '') + 'Baptized - ';
            @switch(request('baptized_filter'))
                @case('baptised_less_5') filterDetails += 'Age Less Than 5 Years'; @break;
                @case('baptised_5_to_15') filterDetails += 'Ages 5 to 15 Years'; @break;
                @case('baptised_over_15') filterDetails += 'Over 15 Years'; @break;
            @endswitch
        @endif
        @if(request('age_range'))
            filterDetails += (filterDetails ? ' | ' : '') + 'Age Range - {{ str_replace('-', ' to ', request('age_range')) }}';
        @endif
        @if(request('baptized_start') && request('baptized_end'))
            filterDetails += (filterDetails ? ' | ' : '') + 'Baptized During - {{ request('baptized_start') }} to {{ request('baptized_end') }}';
        @endif
        @if(request('marriage_start') && request('marriage_end'))
            filterDetails += (filterDetails ? ' | ' : '') + 'Marriages During - {{ request('marriage_start') }} to {{ request('marriage_end') }}';
        @endif
        @if(request('full_member_year'))
            filterDetails += (filterDetails ? ' | ' : '') + 'Full Members Accepted in {{ request('full_member_year') }}';
        @endif
        @if(request('baptized'))
            filterDetails += (filterDetails ? ' | ' : '') + 'Baptized - {{ ucfirst(request('baptized')) }}';
        @endif
        @if(request('death_start') && request('death_end'))
            filterDetails += (filterDetails ? ' | ' : '') + 'Deaths During - {{ request('death_start') }} to {{ request('death_end') }}';
        @endif
        return 'Member Report (' + filterDetails + ') - Total Records: {{ $members->count() }}';
    }

    });
</script>


<script>
    $(document).on('change', '#filter_option', function () {
    this.form.submit(); 
});

</script>

@endsection