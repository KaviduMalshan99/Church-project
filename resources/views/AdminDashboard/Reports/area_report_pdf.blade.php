<!DOCTYPE html>
<html>
<head>
    <title>Area Report PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2>Area-wise Members Report</h2>
    <h2>{{ $area }}</h2>
    <table>
        <thead>
            <tr>
                <th>Area</th>
                <th>Family Number</th>
                <th>Member Name</th>
                <th>Contact</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row->area }}</td>
                    <td>{{ $row->family_no }}</td>
                    <td>{{ $row->member_name }}</td>
                    <td>{{ $row->contact_info }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>