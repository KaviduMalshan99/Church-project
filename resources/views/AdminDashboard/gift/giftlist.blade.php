@extends('AdminDashboard.master')

@section('content')
<div class="d-flex justify-content-end mb-4">
    <a class="btn btn-primary" href="{{ route('gift.create') }}">Add Gift</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="familyTable">
                <thead>
                    <tr>
                        <th>Gift Code</th>
                        <th>Sender Name</th>
                        <th>Receiver Name</th>
                        <th>Receiver Address</th>
                        <th>Greeting Message</th>
                        <th>Greeting Message Description</th>
                        <th>Gift Recived</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gifts as $gift)
                    @php
                    $sender = App\Models\Member::find($gift->sender_id);
                    $receiver = App\Models\Member::find($gift->receiver_id);
                    @endphp
                    <tr>
                        <td>{{ $gift->gift_code }}</td>
                        <td>{{ $sender->member_name }}</td>
                        <td>{{ $receiver->member_name }}</td>
                        <td>{{ $gift->receiver_address }}</td>
                        <td>{{ $gift->greeting_title }}</td>
                        <td>{{ $gift->greeting_description? $gift->greeting_description : 'No Description' }}</td>
                        @if($gift->gift_status == 'Pending')
                            <td class="text-warning">Pending</td>
                        @elseif($gift->gift_status == 'Sent')
                            <td class="text-success">Sent</td>
                        @endif
                        <td>
                            <!-- Edit and Delete Actions -->
                            <a href="{{ route('gift.edit', $gift->id) }}" class="btn btn-sm btn-outline-primary custom-hover">Edit</a>

                            <form action="{{ route('gift.destroy', $gift->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirmDelete()">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach    
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination links -->


<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this item?");
    }
</script>

@endsection
