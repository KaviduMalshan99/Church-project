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

    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Report - Families</h2>
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
                                        <th></th>
                                        <th>Family Number</th>
                                        <th>Main Person</th>
                                        <th>Member id</th>
                                        <th>Phone number</th>
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
    </section>

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