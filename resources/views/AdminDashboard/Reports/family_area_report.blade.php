<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Family Area Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-section {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Family Area Report</h2>

    <div class="form-section">
        <form method="GET" action="{{ route('families.area.report') }}">
            <label for="area">Select Area:</label>
            <select name="area" id="area">
                <option value="">-- All Areas --</option>
                @foreach ($areas as $a)
                    <option value="{{ $a }}" {{ $area == $a ? 'selected' : '' }}>{{ $a }}</option>
                @endforeach
            </select>
            <button type="submit">Filter</button>
        </form>
    </div>

    @if($data->count())
        <form method="POST" action="{{ route('families.area.report.download') }}">
            @csrf
            <input type="hidden" name="area" value="{{ $area }}">
            <button type="submit">Download PDF</button>
        </form>

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
                @foreach ($data as $f)
                    <tr>
                        <td>{{ $f->family_number }}</td>
                        <td>{{ $f->main_member }}</td>
                        <td>{{ $f->email }}</td>
                        <td>{{ $f->phone_number }}</td>
                        <td>{{ $f->area }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No records found.</p>
    @endif
</body>
</html>
