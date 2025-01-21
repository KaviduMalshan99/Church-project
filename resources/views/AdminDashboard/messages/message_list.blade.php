@extends('AdminDashboard.master')

@section('content')


    <div class="content-header">
        <h2 class="content-title">Message List</h2>
    </div>


<div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Member Name</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Sent At</th>
                        </tr>
                    </thead>
                        <tbody>
                            @forelse($messages as $message)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $message->member->member_name ?? 'Unknown' }}</td>
                                <td>{{ $message->message }}</td>
                                <td class="fw-bold">
                                    @if ($message->status === 'success')
                                        <span class="text-success">{{ ucfirst($message->status) }}</span>
                                    @elseif ($message->status === 'failed')
                                        <span class="text-danger">{{ ucfirst($message->status) }}</span>
                                    @else
                                        <span>{{ ucfirst($message->status) }}</span>
                                    @endif
                                </td>

                                <td>{{ $message->sent_at ? $message->sent_at->format('Y-m-d H:i:s') : 'Not Sent' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No messages found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                </table>

                <div class="mt-4">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
