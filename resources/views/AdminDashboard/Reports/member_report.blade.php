@extends('AdminDashboard.master')

@section('content')
<!DOCTYPE html>
<html lang="en">

<body>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


        <div class="content-header">
            <h2 class="content-title">Report - Members</h2>
        </div>

        <!-- Room Form -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Room Table -->
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="tableData" class="table table-hover display">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Family Number</th>
                                        <th>Member id</th>
                                        <th>Main Member</th>
                                        <th>Family Member Name</th>
                                        <th>Relationship to Main Member</th>
                                        <th>Gender</th>
                                        <th>Contact No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($members as $index=> $family_member)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $family_member->family_no }}</td>
                                        <td>{{ $family_member->member_id }}</td>
                                        <td>
                                            @php
                                                // Fetch the main member (assumed to be the first member with the same family_no)
                                                $mainPerson = \App\Models\Member::where('family_no', $family_member->family_no)
                                                                                ->where('relationship_to_main_person', 'Main Member')
                                                                                ->first();
                                            @endphp

                                            @if ($mainPerson)
                                                {{ $mainPerson->member_name }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $family_member->member_name }}</td>
                                        <td>{{ $family_member->relationship_to_main_person }}</td>
                                        <td>{{ $family_member->gender }}</td>
                                        <td>{{ $family_member->contact_info }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    <!-- JavaScript to handle delete confirmation -->
    <script>
        $(document).ready(function() {
            var table = $('#tableData').DataTable({
                dom: 'Bfrtip', // Layout for DataTables with Buttons
                buttons: [{
                        extend: 'copyHtml5',
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        footer: true
                    },
                    {
                        extend: 'csvHtml5',
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        footer: true,
                        title: 'Family Report',
                        customize: function(doc) {
                            // Set a margin for the footer
                            doc.content[1].margin = [0, 0, 0, 20];
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        title: 'Family Report',
                    }
                ],

            });


        });
    </script>



</body>

</html>
@endsection