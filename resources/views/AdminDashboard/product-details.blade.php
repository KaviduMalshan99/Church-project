@extends ('AdminDashboard.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h3 class="text-center text-primary mb-4">Product Details</h3>
                
                <!-- Product Info & Affiliate Details in Compact Grid -->
                <div class="row mb-3">
                    <div class="col-6 mb-2">
                        <p><strong>Product ID:</strong> {{ $product->product_id }}</p>
                        <p><strong>Name:</strong> {{ $product->product_name }}</p>
                        <p><strong>Category:</strong> <span class="badge bg-info text-white">{{ $product->category->name ?? 'N/A' }}</span></p>
                        <p><strong>Quantity:</strong> {{ $product->quantity }}</p>
                    </div>
                    <div class="col-6 mb-2">
                        <p><strong>Price:</strong> Rs. {{ $product->normal_price }}</p>
                        @if($product->is_affiliate)
                            <p><strong>Affiliate Price:</strong> Rs. {{ $product->affiliate_price }}</p>
                            <p><strong>Commission :</strong> {{ $product->commission_percentage }}%</p>
                            <p><strong>Commission Price:</strong> Rs. {{ $product->commission_price }}</p>
                        @endif

                        <!-- Sizes Section -->
                        @if ($product->variations->pluck('value')->filter()->unique()->isNotEmpty())
                            <div class="flex-between align-items-start flex-wrap gap-16">
                                <div class="d-flex align-items-center mb-5">
                                    <span class="text-gray-900 me-3">Size:</span>
                                    @foreach ($product->variations->pluck('value')->filter()->unique() as $index => $size)
                                        <span>{{ $size }}{{ $index < $product->variations->pluck('value')->filter()->unique()->count() - 1 ? ',' : '' }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Colors Section -->
                        @if ($product->variations->pluck('hex_value')->filter()->unique()->isNotEmpty())
                            <div class="flex-between align-items-center flex-wrap gap-16">
                                <div class="d-flex align-items-center mb-4">
                                    <span class="text-gray-900 me-3">Color:</span>
                                    @foreach ($product->variations->pluck('hex_value')->filter()->unique() as $color)
                                        <span 
                                            class="color-list__button border border-2 border-gray-50 rounded-circle me-2"
                                            style="background-color: {{ $color }}; width: 20px; height: 20px;" 
                                            data-color="{{ $color }}"> 
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                <!-- Product Description Section -->
                <div class="mb-4">
                    <h5 class="text-secondary">Description</h5>
                    <p class="text-muted">{{ $product->product_description ?? 'No description available.' }}</p>
                </div>

                <!-- Images Section -->
                <h5 class="text-secondary mt-4">Product Images</h5>
                <div class="d-flex flex-wrap mt-2">
                    @if($product->images->isNotEmpty())
                        @foreach($product->images as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail me-2 mb-2" style="width: 12%;" alt="Product Image" />
                        @endforeach
                    @else
                        <p class="text-muted">No images available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
