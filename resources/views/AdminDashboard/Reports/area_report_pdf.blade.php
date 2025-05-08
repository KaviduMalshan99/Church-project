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
            border: 0.5px solid black;
        }
        th, td {
            padding: 8px;
        }

        
       
   
        th { background-color: #f2f2f2; }

    </style>
</head>
<body>
    <h2 style="text-align:center;">Area-wise Members Report</h2>
    <h3>{{ $area }}</h3>
    <table  class="table table-striped">
        <thead  class="thead-dark">
            <tr>
            
                <th>Family Number</th>
                <th>Member Name</th>
                <th>Email</th>
                <th>Contact</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                  
                    <td>{{ $row->family_no }}</td>
                    <td>{{ $row->member_name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->contact_info }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>