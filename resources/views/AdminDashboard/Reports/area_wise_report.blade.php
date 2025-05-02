@extends('AdminDashboard.master')

@section('content')
<!-- Form for selecting area -->
<form method="GET" action="{{ route('areaWiseReport') }}" style="width:50%; display: flex; align-items: center;">
    <select name="area" class="form-control mb-3" style="margin-right: 10px;border: 1px solid black;" placeholder ="Select Area">
   
    <option value="">-- Select Area --</option>
        @foreach ($areas as $a)
            <option value="{{ $a }}" {{ $a == $area ? 'selected' : '' }}>{{ $a }}</option>
        @endforeach
    </select>

    <button type="submit" class="btn btn-primary mb-3" style="margin-right: 10px;">Search</button>

    @if(isset($area) && $area !== '')
    <button class=" mb-3" style="border: 1px solid grey; padding: 5px 10px; font-size: 14px;width:40%;">   <a href="{{ route('areaWiseReport.pdf', ['area' => $area]) }}">Download PDF</a></button>
    @endif
</form>

<!-- Table displaying the data -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Area</th>
            <th>Family Number</th>
            <th>Member Name</th>
            <th>Email</th>
            <th>Contact</th>
     

        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{ $row->area }}</td>
                <td>{{ $row->family_no }}</td>
                <td>{{ $row->member_name }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->contact_info}}</td>
              
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination links -->
<div class="d-flex justify-content-center">
    {{ $data->links() }}  <!-- This generates the pagination links -->
</div>
@endsection
