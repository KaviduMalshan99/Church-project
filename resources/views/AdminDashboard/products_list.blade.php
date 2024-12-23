@extends ('AdminDashboard.master')

@section('content')

<div class="content-header">
    <div>
        <h2 class="content-title card-title">Products List</h2>
    </div>
    <div>
        <a href="#" class="btn btn-light rounded font-md">Export</a>
        <a href="{{ route('add_products') }}" class="btn btn-primary btn-sm rounded">Create new</a>
    </div>
</div>

<div class="card mb-4">
    <header class="card-header">
        <div class="row align-items-center">
            <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
            <select class="form-select" id="categoryFilter">
                <option value="all" selected>All categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            </div>

            <div class="col-md-2 col-6">
                <input type="date" value="02.05.2021" class="form-control" />
            </div>
        </div>
    </header>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover" id="productsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product ID</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr class="product-row" data-category="{{ $product->category->id ?? 'none' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->product_id }}</td>
                                    <td>
                                        <div class="col-lg-2 col-sm-4 col-8 flex-grow-1 col-name" style="white-space: nowrap; ">
                                            <a class="itemside" href="#">
                                                <div class="left">
                                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="img-sm img-thumbnail" alt="Item" />
                                                </div>
                                                <div class="info">
                                                    <h6 class="mb-0">{{ $product->product_name }}</h6>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>Rs. {{ $product->normal_price }}</td>
                                    <td class="text-end">
                                        <div>
                                            <a href="{{ route('products.view', $product->id) }}" class="btn btn-view btn-sm me-2">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm me-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form id="deleteForm{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('deleteForm{{ $product->id }}', 'Are you sure you want to delete this product?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
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

<div class="pagination-area mt-30 mb-50">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-start">
            {{ $products->links('pagination::bootstrap-4') }}
        </ul>
    </nav>
</div>


<script>
    document.getElementById('categoryFilter').addEventListener('change', function() {
        const selectedCategory = this.value;
        const rows = document.querySelectorAll('.product-row');

        rows.forEach(row => {
            const category = row.getAttribute('data-category');

            if (selectedCategory === "all" || category === selectedCategory) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>
@endsection
