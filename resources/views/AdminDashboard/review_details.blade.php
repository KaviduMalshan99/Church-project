@extends ('AdminDashboard.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h3 class="text-center text-primary mb-4">Review Details</h3>

                <div class="mb-4">
                    <h5 class="text-secondary mb-1">Reviewer</h5>
                    @if($review->is_anonymous)
                    <p>Anonymous</p>
                    @else
                    <p class="text-muted">{{$review->reviewer->name }}</p>
                    <p class="text-muted">{{$review->reviewer->phone }}</p>
                    <p class="text-muted">{{$review->reviewer->email }}</p>
                    @endif

                </div>

                <div class="mb-4">
                    <h5 class="text-secondary mb-1">Product</h5>
                    <p class="text-muted">{{ $review->product->product_id}}</p>
                    <p class="text-muted">{{ $review->product->product_name}}</p>
                </div>

                <div class="mb-4">
                    <h5 class="text-secondary mb-1">Rating & Review</h5>
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="{{ $review->rating >= $i ? 'fa-star fas filled' : 'far fa-star' }}" style="color: gold;"></i>
                        @endfor
                        <br />
                        <p class="text-muted">{{ $review->review ?? 'No review available.' }}</p>
                </div>

                <div class="mb-4">
                    <h5 class="text-secondary mb-1">Date</h5>
                    <p class="text-muted">{{ $review->created_at->format('d.m.Y') }}</p>
                </div>

                <div class="mb-4">
                    <h5 class="text-secondary mb-1">Review Media</h5>
                    <div class="d-flex flex-wrap mt-2">
                        @php
                        $mediaFiles = is_string($review->media) ? json_decode($review->media, true) : $review->media;
                        @endphp

                        @if (!empty($mediaFiles))
                        @foreach ($mediaFiles as $media)
                        @if (in_array(pathinfo($media, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                        <!-- Display Image -->
                        <div class="me-2 mb-2">
                            <img src="{{ asset('storage/' . $media) }}" alt="Review Media" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        @elseif (in_array(pathinfo($media, PATHINFO_EXTENSION), ['mp4', 'avi', 'mov', 'webm']))
                        <!-- Display Video -->
                        <div class="me-2 mb-2">
                            <video controls class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                                <source src="{{ asset('storage/' . $media) }}" type="video/{{ pathinfo($media, PATHINFO_EXTENSION) }}">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        @else
                        <!-- Unsupported Media -->
                        <div class="me-2 mb-2">
                            <span class="badge bg-warning">Unsupported Media Type</span>
                        </div>
                        @endif
                        @endforeach
                        @else
                        <p>No media available for this review.</p>
                        @endif
                    </div>
                </div>


                <div class="mb-4">
                    <h5 class="text-secondary mb-1">Status</h5>
                    <span class="badge 
                        @if($review->status == 'Pending')
                            bg-warning
                        @elseif($review->status == 'Rejected')
                            bg-danger
                        @else
                            bg-success
                        @endif
                    ">
                        {{$review->status}}
                    </span>
                </div>

                <div class="mb-4 col-md-6">
                    <h5 class="text-secondary mb-1">Change Status</h5>
                    <form action="{{ route('reviews.updateStatus', $review->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="Pending" {{ $review->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Published" {{ $review->status == 'Published' ? 'selected' : '' }}>Published</option>
                                <option value="Rejected" {{ $review->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection