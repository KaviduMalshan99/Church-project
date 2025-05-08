<style>
         th { background-color: #f2f2f2; }
</style>

<h2 style="text-align:center;">Fund Report</h2>

<p><strong>Area:</strong> {{ $area ?? 'All' }}</p>
<p><strong>Date Range:</strong> {{ $startDate }} to {{ $endDate }}</p>

<table border="1" cellpadding="6" cellspacing="0" width="100%">
    <thead>
        <tr>
        <th>Family Number</th>
                <th>Member Name</th>
           
                <th>Donate Amount</th>
                <th>Donated Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($gifts as $gift)
            <tr>
            <td>{{ $gift->member->family_no  ?? 'N/A' }}</td>
                    <td>{{ $gift->member->member_name ?? 'N/A' }}</td>
               
                    <td>{{ number_format($gift->amount, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($gift->created_at)->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p><strong>Total Donated Amount:</strong> {{ number_format($totalAmount, 2) }}</p>
