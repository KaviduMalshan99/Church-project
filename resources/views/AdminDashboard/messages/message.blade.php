@extends('AdminDashboard.master')

@section('content')



    <div class="content-header">
        <h2 class="content-title">Send SMS to Main Members</h2>
    </div>


<div class="row mt-4">
    <div class="col-md-7">
    <form id="sendSMSForm" method="POST" action="{{ route('admin.sendGroupSMS') }}">
        @csrf
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="mainmemberTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Member Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                        <tr>
                            <td>
                                <input type="checkbox" name="member_ids[]" value="{{ $member->id }}" class="select-member">
                            </td>
                            <td>{{ $member->member_name }}</td>
                            <td>{{ $member->contact_info }}</td>
                            <td>{{ $member->email }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No members found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>  
    </div> 

    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-body">
                <div class="form-group mt-4">
                    <label for="message" class="form-label">Message</label>
                    <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Send SMS</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- JavaScript to handle Select All -->
<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.select-member');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script>
<script>
    $(document).ready(function() {
        $('#mainmemberTable').DataTable({
            "paging": true,           
            "searching": true,      
            "ordering": true,       
            "info": true,            
            "lengthChange": true     
        });
    });
</script>
@endsection
