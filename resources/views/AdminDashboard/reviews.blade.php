@extends ('AdminDashboard.master')

@section('content')

<div class="content-header">
    <div>
        <h2 class="content-title card-title">Reviews</h2>
    </div>
    <div>
        <input type="text" placeholder="Search by name" class="form-control bg-white" />
    </div>
</div>


<div class="card mb-4">
    <header class="card-header">
        <ul class="nav nav-tabs" id="reviewTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="published-tab" data-bs-toggle="tab" data-bs-target="#published" type="button" role="tab" aria-controls="published" aria-selected="true">Published</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="false">Pending</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab" aria-controls="rejected" aria-selected="false">Rejected</button>
            </li>
        </ul>
    </header>

    <div class="card-body">
        <div class="tab-content" id="reviewTabContent">
            <!-- Published Tab -->
            <div class="tab-pane fade show active" id="published" role="tabpanel" aria-labelledby="published-tab">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Reviewer</th>
                                <th>Rating</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($publishedReviews as $index=>$review)    
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td><b>{{ $review->product->product_name }}</b></td>
                                <td>{{ $review->is_anonymous ? 'Anonymous' : $review->reviewer->name }}</td>
                                <td>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="{{ $review->rating >= $i ? 'fa-star fas filled' : 'far fa-star' }}" style="color: gold;"></i>
                                        @endfor
                                </td>
                                <td>{{ $review->created_at->format('d.m.Y') }}</td>
                                <td><span class="badge bg-success">Published</span></td>
                                <td class="text-end">
                                <a href="{{route('viewReviewDetails',$review->id)}}" class="btn btn-view btn-sm me-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this review?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No published reviews found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $publishedReviews->links() }}
            </div>

            <!-- Pending Tab -->
            <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Reviewer</th>
                                <th>Rating</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingReviews as $index=>$review)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td><b>{{ $review->product->product_name }}</b></td>
                                <td>{{ $review->is_anonymous ? 'Anonymous' : $review->reviewer->name }}</td>
                                <td>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="{{ $review->rating >= $i ? 'fa-star fas filled' : 'far fa-star' }}" style="color: gold;"></i>
                                        @endfor
                                </td>
                                <td>{{ $review->created_at->format('d.m.Y') }}</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td class="text-end">
                                    <a href="{{route('viewReviewDetails',$review->id)}}" class="btn btn-view btn-sm me-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this review?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No pending reviews found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $pendingReviews->links() }}
            </div>


            <!-- Pending Tab -->
            <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Reviewer</th>
                                <th>Rating</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rejectedReviews as $index=>$review)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td><b>{{ $review->product->product_name }}</b></td>
                                <td>{{ $review->is_anonymous ? 'Anonymous' : $review->reviewer->name }}</td>
                                <td>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="{{ $review->rating >= $i ? 'fa-star fas filled' : 'far fa-star' }}" style="color: gold;"></i>
                                        @endfor
                                </td>
                                <td>{{ $review->created_at->format('d.m.Y') }}</td>
                                <td><span class="badge bg-danger">Rejected</span></td>
                                <td class="text-end">
                                    <a href="{{route('viewReviewDetails',$review->id)}}" class="btn btn-view btn-sm me-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this review?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No rejected reviews found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $pendingReviews->links() }}
            </div>


        </div>
    </div>
</div>








@endsection