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
            width: 300px;
            margin: 20px auto;
            padding: 10px;
            background-color: #fff;
            border: 1px dashed #333;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header img {
            width: 40px;
            height: auto;
        }
        .header h1 {
            font-size: 18px;
            margin: 5px 0;
        }
        .header p {
            font-size: 12px;
            margin: 0;
        }
        .bill-info {
            font-size: 14px;
            margin-top: 10px;
        }
        .bill-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .bill-info th, .bill-info td {
            text-align: left;
            padding: 5px;
        }
        .bill-info th {
            font-weight: bold;
        }
        .bill-info td {
            border-bottom: 1px solid #ccc;
        }
        .total {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 10px;
        }
        .footer p {
            margin: 0;
        }
    </style>
    
</head>
<body>
<div class="container">
    <!-- Header Section -->
    <div class="header">
        <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('backend/assets/logo.jpg'))) }}" alt="Logo">

        <h1>Community Gift Fund</h1>
        <p>Thank you for your generous contribution!</p>
    </div>

    <!-- Bill Info Section -->
    <div class="bill-info">
        <table>
            <tr>
                <th>Sender Name:</th>
                <td>{{ $gift->member->member_title }} {{ $gift->member->name_with_initials }}</td>
            </tr>
            <tr>
                <th>Sender ID:</th>
                <td>{{ $gift->sender_id }}</td>
            </tr>
            <tr>
                <th>Type:</th>
                <td>{{ $gift->type }}</td>
            </tr>
            <tr>
                <th>Date:</th>
                <td>{{ \Carbon\Carbon::parse($gift->date)->format('F j, Y') }}</td>
            </tr>
            <tr>
                <th>Amount:</th>
                <td>Rs. {{ number_format($gift->amount, 2) }}</td>
            </tr>
        </table>
    </div>

      <!-- Total Amount Section -->
      <div class="total">
        Total: Rs. {{ number_format($gift->amount, 2) }}
    </div>


    <!-- Signature Section -->
    {{-- @if ($userSignature)
        <div class="signature">
            <p>Received By: <br>{{ $receivedBy }}</p>
            <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('storage/'. $userSignature))) }}" alt="Signature"  width="100">
        </div>
    @else
        <div class="signature">
            <p>Signature:No signature available</p>
        </div>
    @endif --}}

    <!-- Signature Section -->
<div class="signature" style="margin-top: 40px;">
    <p>Received By: {{ $receivedBy }}</p>
    <p>Signature: ....................................</p>
</div>


  
    <!-- Footer Section -->
    <div class="footer">
        <p>Contact Us: support@communitygiftfund.com</p>
        <p>Phone: +91-9876543210</p>
        <p>Visit Us: www.communitygiftfund.com</p>
    </div>
</div>

</body>
</html>