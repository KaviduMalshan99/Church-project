@extends ('AdminDashboard.master')

@section('content')
<div class="content-header">
    <div>
        <h2 class="content-title card-title">Dashboard</h2>
    </div>
</div>
<div class="row">
<div class="col-lg-3">
        <div class="card card-body mb-4">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-info-light"><i class="text-info material-icons md-family_restroom"></i></span>
                <div class="text">
                    <h6 class="mb-1 card-title">Families</h6>
                    <p>{{ $totalFamilies }}</p>
                </div>
            </article>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card card-body mb-4">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-warning-light"><i class="text-warning material-icons md-groups"></i></span>
                <div class="text">
                    <h6 class="mb-1 card-title">Members</h6>
                    <p>{{ $totalMembers }}</p>
                </div>
            </article>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card card-body mb-4">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-primary-light"><i class="text-primary material-icons md-monetization_on"></i></span>
                <div class="text">
                    <h6 class="mb-1 card-title">Today Revenue</h6>
                    <!-- Add content if needed for revenue -->
                </div>
            </article>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card card-body mb-4">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-success-light"><i class="text-success material-icons md-local_shipping"></i></span>
                <div class="text">
                    <h6 class="mb-1 card-title">Orders</h6>
                    <!-- Add content if needed for orders -->
                </div>
            </article>
        </div>
    </div>
   
</div>
@endsection
