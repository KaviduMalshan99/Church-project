<!-- Filters Form -->
<form method="GET" action="{{ route('fund.list.area') }}">
    <label>Area:
        <select name="area">
            <option value="">All</option>
            @foreach($areas as $a)
                <option value="{{ $a }}" {{ $area == $a ? 'selected' : '' }}>{{ $a }}</option>
            @endforeach
        </select>
    </label>

    <label>From:
        <input type="date" name="start_date" value="{{ $startDate }}">
    </label>

    <label>To:
        <input type="date" name="end_date" value="{{ $endDate }}">
    </label>

    <button type="submit">Filter</button>
</form>

<!-- Download Button -->
<form method="GET" action="{{ route('fund.list.area.pdf') }}">
    <input type="hidden" name="area" value="{{ $area }}">
    <input type="hidden" name="start_date" value="{{ $startDate }}">
    <input type="hidden" name="end_date" value="{{ $endDate }}">
    <button type="submit">Download PDF</button>
</form>

<!-- Report Table -->
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Family ID</th>
            <th>Member Name</th>
            <th>Area</th>
            <th>Donate Amount</th>
            <th>Donated Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($gifts as $gift)
            <tr>
                <td>{{ $gift->member->family->id ?? 'N/A' }}</td>
                <td>{{ $gift->member->member_name ?? 'N/A' }}</td>
                <td>{{ $gift->member->area ?? 'N/A' }}</td>
                <td>{{ number_format($gift->amount, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($gift->created_at)->format('Y-m-d') }}</td>
            </tr>
        @empty
            <tr><td colspan="5">No data found.</td></tr>
        @endforelse
    </tbody>
</table>

<!-- Total Amount -->
<p><strong>Total Donated Amount: </strong>{{ number_format($totalAmount, 2) }}</p>
