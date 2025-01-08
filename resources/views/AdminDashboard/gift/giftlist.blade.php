@extends('AdminDashboard.master')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex">
        <!-- Kawara Pooja Card -->
        <div class="card text-white me-3" style="width: 22rem;">
            <div class="card-body">
            <h4 class="card-title">Kawara Pooja Total Amount</h4>
            <h4 class="card-text text-danger">Rs. {{ number_format($kawaraTotal, 2) }}</h4>
            </div>
        </div>

        <!-- Other Card -->
        <div class="card text-white" style="width: 22rem;">
            <div class="card-body">
            <h4 class="card-title">Other Total Amount</h4>
            <h4 class="card-text text-danger">Rs. {{ number_format($otherTotal, 2) }}</h4>
            </div>
        </div>
    </div>
    <a class="btn btn-primary" href="{{ route('gift.create') }}">Add Gift</a>
</div>


<div class="card">
    <div class="card-body">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="giftTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="kawara-tab" data-bs-toggle="tab" data-bs-target="#kawara" type="button" role="tab" aria-controls="kawara" aria-selected="true">
                    Kawara Pooja
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="other-tab" data-bs-toggle="tab" data-bs-target="#other" type="button" role="tab" aria-controls="other" aria-selected="false">
                    Other 
                </button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content mt-3" id="giftTabsContent">
            <!-- Kawara Pooja Tab -->
            <div class="tab-pane fade show active" id="kawara" role="tabpanel" aria-labelledby="kawara-tab">
                <div class="table-responsive">
                    <table class="table table-hover" id="kawaraTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Sender Name</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($gifts->where('type', 'Kawara Pooja') as $gift)
                            @php
                                $sender = App\Models\Member::firstWhere('member_id', $gift->sender_id);
                            @endphp
                            <tr>
                                <td>@if($sender)
                                        {{ $sender->member_id }}
                                    @else
                                        <span class="text-danger">Sender not found</span>
                                    @endif
                                </td>
                                <td>@if($sender)
                                        {{ $sender->member_name }}
                                    @else
                                        <span class="text-danger">Sender not found</span>
                                    @endif
                                </td>
                                <td>{{ $gift->type }}</td>
                                <td>Rs. {{ $gift->amount }}</td>
                                <td class="text-end">
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

            <!-- Other Types Tab -->
            <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                <div class="table-responsive">
                    <table class="table table-hover" id="otherTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Sender Name</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($gifts->where('type', '!=', 'Kawara Pooja') as $gift)
                            @php
                                $sender = App\Models\Member::firstWhere('member_id', $gift->sender_id);
                            @endphp
                            <tr>
                                <td>@if($sender)
                                        {{ $sender->member_id }}
                                    @else
                                        <span class="text-danger">Sender not found</span>
                                    @endif
                                </td>
                                <td>@if($sender)
                                        {{ $sender->member_name }}
                                    @else
                                        <span class="text-danger">Sender not found</span>
                                    @endif
                                </td>
                                <td>{{ $gift->type }}</td>
                                <td>Rs. {{ $gift->amount }}</td>
                                <td class="text-end">
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
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this item?");
    }

    $(document).ready(function() {
        // Initialize DataTables for both tables
        $('#kawaraTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true
        });

        $('#otherTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true
        });
    });
</script>
@endsection
