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
            <h2 class="content-title">Report - Families</h2>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                
                    <!-- Table -->
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="tableData" class="table table-hover display">
                                <div class="mt-3 mb-3">
                                    <strong>No. of Families: {{ $totalFamilies }}</strong><br><br>
                                  

                                </div>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Family Number</th>
                                        <th>Main Person</th>
                                        <th>Member id</th>
                                        <th>Phone number</th>
                                        <th>Email</th>
                                        <th>Registered Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($families as $index=> $family)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $family->family_number }}</td>
                                        <td>
                                            @if($family->mainPerson)
                                                {{ $family->mainPerson->member_name }}
                                            @else
                                                N/A (Main person ID: {{ $family->main_person_id }})
                                            @endif
                                        </td>
                                        <td> {{ $family->main_person_id }}</td>
                                        <td> {{ $family->mainPerson->contact_info }}</td>
                                        <td> {{ $family->mainPerson->email }}</td>
                                        <td>
                                            @if ($family->mainPerson)
                                                {{ $family->mainPerson->registered_date }}
                                            @else
                                                <span class="text-danger">Main person not set</span>
                                            @endif
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


    <!-- JavaScript to handle delete confirmation -->
    <script>
        $(document).ready(function() {
            var table = $('#tableData').DataTable({
                dom: 'Bfrtip', // Layout for DataTables with Buttons
                buttons: [{
                        extend: 'copyHtml5',
                        footer: true,
                        messageTop: 'No. of Families: {{ $totalFamilies }}'
                    },
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        messageTop: 'No. of Families: {{ $totalFamilies }}'
                    },
                    {
                        extend: 'pdfHtml5',
                        footer: true,
                        title: 'Family Report',
                        messageTop: 'No. of Families: {{ $totalFamilies }}',
                        customize: function(doc) {
                            // Set a margin for the footer
                            doc.content[1].margin = [0, 0, 0, 20];
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        title: 'Family Report',
                        messageTop: 'No. of Families: {{ $totalFamilies }}'
                    }
                ],

            });


        });
    </script>



</body>

</html>
@endsection