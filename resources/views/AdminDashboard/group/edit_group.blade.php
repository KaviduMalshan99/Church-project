@extends ('AdminDashboard.master')

@section('content')
<form method="POST" action="{{ route('group.update', $group->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- Important for Laravel's update method -->
    
    <div class="row">
        <div class="col-12">
            <div class="content-header">
                <h2 class="content-title">Edit Group</h2>
                <div>
                    <button type="submit" class="btn btn-md rounded font-sm hover-up">Save</button>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <div class="row g-3">

                <!-- Group Name -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Group Name</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="group_name" class="form-label">Group Name<i class="text-danger">*</i></label>
                                <input type="text" name="group_name" id="group_name" class="form-control" value="{{ old('group_name', $group->group_name) }}" placeholder="Enter Group Name">
                                @error('group_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Member Selection -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Group Members</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="member_id" class="form-label">Select or Search Member Name <i class="text-danger">*</i></label>
                                <select name="member_id[]" class="form-select select2" id="member_id" multiple>
                                    @foreach($members as $member)
                                    <option value="{{ $member->member_id }}" 
                                        @if(in_array($member->member_id, $group->group_members)) selected @endif>
                                        {{ $member->member_name }} ({{ $member->member_id }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Selected Members List -->
                            <div id="selected-members" class="mt-3">
                                @foreach($group->group_members as $member_id)
                                    @php
                                        $member = $members->where('member_id', $member_id)->first();
                                    @endphp
                                    @if($member)
                                        <div class="selected-member badge bg-primary p-2 me-2" data-id="{{ $member_id }}">
                                            {{ $member->member_name }} ({{ $member->member_id }})
                                            <span class="remove-member" style="cursor: pointer; margin-left: 5px;">&times;</span>
                                            <input type="hidden" name="member_id[]" value="{{ $member_id }}">
                                        </div>
                                    @endif
                                @endforeach
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
        let selectedMembers = {};

        $('.select2').select2({
            placeholder: "Search or select members",
            allowClear: true
        });

        $('#member_id').on('select2:select', function(e) {
            let data = e.params.data;
            let memberId = data.id;
            let memberName = data.text;

            // Store selected member
            selectedMembers[memberId] = memberName;

            // Disable selected member in dropdown
            $('#member_id option[value="' + memberId + '"]').prop('disabled', true);
            $('#member_id').trigger('change');

            // Show selected members
            updateSelectedMembers();
        });

        function updateSelectedMembers() {
            let selectedHtml = "";
            $.each(selectedMembers, function(id, name) {
                selectedHtml += `
                    <div class="selected-member badge bg-primary p-2 me-2" data-id="${id}">
                        ${name} <span class="remove-member" style="cursor: pointer; margin-left: 5px;">&times;</span>
                        <input type="hidden" name="member_id[]" value="${id}">
                    </div>`;
            });
            $('#selected-members').html(selectedHtml);
        }

        // Remove member when clicked
        $(document).on('click', '.remove-member', function() {
            let memberDiv = $(this).closest('.selected-member');
            let memberId = memberDiv.data('id');

            delete selectedMembers[memberId];

            // Enable member in dropdown
            $('#member_id option[value="' + memberId + '"]').prop('disabled', false);
            $('#member_id').trigger('change');

            updateSelectedMembers();
        });
    });
</script>

@endsection
