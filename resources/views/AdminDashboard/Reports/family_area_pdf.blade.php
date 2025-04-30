<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Family Area Report - {{ $area }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 8px;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h2>Family Area Report - {{ $area ?: 'All Areas' }}</h2>
    <table>
        <thead>
            <tr>
                <th>Family No</th>
                <th>Main Member</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Area</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $family)
                <tr>
                    <td>{{ $family->family_number }}</td>
                    <td>{{ $family->main_member }}</td>
                    <td>{{ $family->email }}</td>
                    <td>{{ $family->phone_number }}</td>
                    <td>{{ $family->area }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
