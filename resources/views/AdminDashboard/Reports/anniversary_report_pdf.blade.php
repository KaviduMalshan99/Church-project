<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Wedding Anniversary Report</title>
    <style>
        body { font-family: DejaVu Sans; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Wedding Anniversary Report</h2>
    <p>Date Range: {{ $from }} to {{ $to }}</p>
    <table>
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
</body>
</html>
