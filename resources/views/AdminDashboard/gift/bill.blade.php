<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            color: #bd0f0f;
        }
        .header h1 {
            font-size: 36px;
            margin: 0;
        }
        .header p {
            font-size: 18px;
        }
        .bill-info {
            margin-top: 30px;
            font-size: 16px;
        }
        .bill-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .bill-info table, .bill-info th, .bill-info td {
            border: 1px solid #bd0f0f;
        }
        .bill-info th, .bill-info td {
            padding: 12px;
            text-align: left;
        }
        .bill-info th {
            color: black;
        }
        .bill-info td {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #333;
        }
        .footer p {
            margin: 0;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            color: #bd0f0f;
            text-align: right;
            margin-top: 20px;
        }
        .bill-details {
            margin-top: 30px;
            text-align: left;
            font-size: 14px;
        }
        .bill-details p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <h2>Gift Fund Receipt</h2>
            <p>Fund ID: {{ $gift->id }}</p>
        </div>

        <!-- Bill Info Section -->
        <div class="bill-info">
            <table>
                <tr>
                    <th>Sender Name</th>
                    <td>{{ $gift->member->member_name }}</td>
                </tr>
                <tr>
                    <th>Sender ID</th>
                    <td>{{ $gift->sender_id }}</td>
                </tr>
                <tr>
                    <th>Contribution Type</th>
                    <td>{{ $gift->type }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ \Carbon\Carbon::parse($gift->created_at)->format('F j, Y') }}</td>
                </tr>
                <tr>
                    <th>Amount</th>
                    <td>Rs. {{ number_format($gift->amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Total Amount Section -->
        <div class="total">
            Total Amount: Rs. {{ number_format($gift->amount, 2) }}
        </div>

        <!-- Additional Details Section -->
        <div class="bill-details">
            <p><strong>Thank you for your contribution!</strong></p>
            <p>Your generous donation will make a significant impact.</p>
        </div>

    </div>
</body>
</html>
