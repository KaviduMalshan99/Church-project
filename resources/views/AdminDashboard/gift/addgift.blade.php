@extends ('AdminDashboard.master')

@section('content')
<form method="POST" action="{{ route('gift.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="content-header">
                <h2 class="content-title">Add New Gift</h2>
                <div>
                    <button type="submit" class="btn btn-md rounded font-sm hover-up">Add</button>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <div class="row g-3">
                <!-- Sender Selection -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Sender Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="sender_id" class="form-label">Select or Search Sender Name <i class="text-danger">*</i></label>
                                <select name="sender_id" class="form-select select2" id="sender_id">
                                    <option value="">Select sender</option>
                                    @foreach($members as $member)
                                    <option value="{{$member->member_id}}" {{ old('sender_id') == $member->member_id ? 'selected' : '' }}>
                                        {{$member->member_name}} ({{$member->member_id}})
                                    </option>
                                    @endforeach
                                </select>
                                @error('sender_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gift Type -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Gift Type</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="type" class="form-label">Select Gift Type <i class="text-danger">*</i></label>
                                <select name="type" class="form-select" id="type">
                                    <option value="Kawara Pooja" {{ old('type') == 'Kawara Pooja' ? 'selected' : '' }}>Kawara Pooja</option>
                                    <option value="Other" {{ old('type') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Amount -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Amount</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Enter Amount <i class="text-danger">*</i></label>
                                <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" step="0.01" min="0" placeholder="Enter the amount">
                                @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Search or select a sender",
            allowClear: true
        });
    });
</script>

@endsection
