@extends ('AdminDashboard.master')

@section('content')
<form method="POST" action="{{ route('gift.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="content-header">
                <h2 class="content-title">Add New Gift</h2>
                <div>
                    <button type="submit" class="btn btn-md rounded font-sm hover-up">Add Gift</button>
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
                                <label for="sender_name" class="form-label">Select Sender Name  <i class="text-danger">*</i></label>
                                <select name="sender_name" class="form-select" id="sender_name">
                                    <option value="">Select sender</option>
                                    @foreach($members as $member)
                                    <option value="{{$member->id}}" {{ old('sender_name') == $member->id ? 'selected' : '' }}>
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
                                <label for="receiver_name" class="form-label">Select Receiver Name  <i class="text-danger">*</i></label>
                                <select name="receiver_name" class="form-select" id="receiver_name">
                                    <option value="">Select receiver</option>
                                    @foreach($members as $member)
                                    <option value="{{$member->id}}" {{ old('receiver_name') == $member->id ? 'selected' : '' }}>
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
            <div class="card-body">
                <label for="receiver_address" class="form-label">Receiver Address <i class="text-danger">*</i></label>
                <textarea name="receiver_address" placeholder="Type here" class="form-control" id="receiver_address">{{ old('receiver_address') }}</textarea>
                @error('receiver_address')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-4">
                    <label for="greeting_title" class="form-label">Greeting Message Title  <i class="text-danger">*</i></label>
                    <input type="text" name="greeting_title" class="form-control" id="greeting_title" value="{{ old('greeting_title') }}" />
                    @error('greeting_title')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" for="greeting_msg">Greeting Description ( Optional )</label>
                    <textarea name="greeting_msg" id="greeting_msg" placeholder="e.g., Teacher, Engineer" class="form-control">{{ old('greeting_msg') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
