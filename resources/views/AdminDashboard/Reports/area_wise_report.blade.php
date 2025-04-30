@extends('AdminDashboard.master')

@section('content')
<form method="GET" action="{{ route('areaWiseReport') }}">
    <select name="area">
        <option value="">-- Select Area --</option>
        @foreach ($areas as $a)
            <option value="{{ $a }}" {{ $a == $area ? 'selected' : '' }}>{{ $a }}</option>
        @endforeach
    </select>

    <button type="submit">Search</button>

    @if(isset($area) && $area !== '')
        <a href="{{ route('areaWiseReport.pdf', ['area' => $area]) }}" class="btn btn-success">Download PDF</a>
    @endif
</form>

<table>
    <thead>
        <tr>
            <th>Area</th>
            <th>Family Number</th>
            <th>Member Name</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{ $row->area }}</td>
                <td>{{ $row->family_no }}</td>
                <td>{{ $row->member_name }}</td>
                <td>{{ $row->member_name }}</td>
                
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

