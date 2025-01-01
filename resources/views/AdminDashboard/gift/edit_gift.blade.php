@extends ('AdminDashboard.master')

@section('content')
<form method="POST" action="{{ route('gift.update', $gift->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12">
            <div class="content-header">
                <h2 class="content-title">Update Gift</h2>
                <div>
                    <button type="submit" class="btn btn-md rounded font-sm hover-up">Update Gift</button>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <div class="row g-3">
                <!-- Sender Card -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Sender Name</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="sender_name" class="form-label">Select Sender Name <i class="text-danger">*</i></label>
                                <select name="sender_name" class="form-select" id="sender_name">
                                    <option value="">Select sender</option>
                                    @foreach($members as $member)
                                    <option value="{{$member->id}}" {{ $gift->sender_id ? 'selected' : '' }}>
                                        {{$member->member_name}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('sender_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Receiver Card -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Receiver Name</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="receiver_name" class="form-label">Select Receiver Name <i class="text-danger">*</i></label>
                                <select name="receiver_name" class="form-select" id="receiver_name">
                                    <option value="">Select receiver</option>
                                    @foreach($members as $member)
                                    <option value="{{$member->id}}" {{ $gift->receiver_id ? 'selected' : '' }}>
                                        {{$member->member_name}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('receiver_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h4>Receiver Address</h4>
            </div>
            <div class="card-body">
                <label for="receiver_address" class="form-label">Receiver Address <i class="text-danger">*</i></label>
                <textarea name="receiver_address" placeholder="Type here" class="form-control" id="receiver_address">{{ $gift->receiver_address }}</textarea>
                @error('receiver_address')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h4>Greeting</h4>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label for="greeting_title" class="form-label">Greeting Message Title <i class="text-danger">*</i></label>
                    <input type="text" name="greeting_title" class="form-control" id="greeting_title" value="{{ $gift->greeting_title }}" />
                    @error('greeting_title')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" for="greeting_msg">Greeting Description ( Optional )</label>
                    <textarea name="greeting_msg" id="greeting_msg" placeholder="e.g., Teacher, Engineer" class="form-control">{{ $gift->greeting_description }}</textarea>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h4>Gift Status</h4>
            </div>
            <div class="mb-3">
                <label for="gift_status" class="form-label">Select Sender Name <i class="text-danger">*</i></label>
                <select name="gift_status" class="form-select" id="gift_status">
                    <option value="Pending">Pending</option>
                    <option value="Sent">Sent</option>                    
                </select>
            </div>
        </div>
    </div>
</form>
@endsection