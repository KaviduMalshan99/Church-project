@extends('AdminDashboard.master')

@section('content')
<style>

</style>
<div class="content-header">
    <div>
        <h2 class="content-title card-title">Categories</h2>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
        Create category
    </button>
</div>

<div class="card">
    <div class="card-body">
       

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
              
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Main Category</th>
                                    <th>Sub Category</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                @foreach ($category->subcategories as $subcategory)
                                                    <div class="d-flex align-items-center mb-1">
                                                        <span class="me-1">{{ $subcategory->name }}</span>
                                                        @if ($subcategory->subSubcategories->isNotEmpty())
                                                            <div class="dropdown">
                                                                <a href="#" data-bs-toggle="dropdown" class="btn p-0" style="width: 24px; height: 24px; border: none; background: none;">
                                                                    <i class="fa fa-caret-down" style="font-size: 14px;"></i>
                                                                </a>
                                                                <div class="dropdown-menu">
                                                                    @foreach ($subcategory->subSubcategories as $subSubcategory)
                                                                        <a class="dropdown-item" href="#">{{ $subSubcategory->name }}</a>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm me-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form id="deleteForm{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('deleteForm{{ $category->id }}', 'Are you sure you want to delete this category?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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


<!-- Modal for creating a category -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryLabel">Create New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createCategoryForm">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label" style="font-size: 15px;">Main Category</label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Enter category name" required>
                    </div>
                    <button type="button" class="btn btn-secondary mb-3" id="addSubcategoryGroup">
                        Add Subcategory
                    </button>
                    <div id="subcategories" class="mb-3">
                        <!-- Subcategories will be added here  -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveCategoryBtn">Save Category</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let subcategoryIndex = 0;

        const addSubcategoryButton = document.getElementById('addSubcategoryGroup');
        const subcategoriesContainer = document.getElementById('subcategories');

        addSubcategoryButton.addEventListener('click', function () {
            const subcategoryWrapper = document.createElement('div');
            subcategoryWrapper.className = 'subcategory-wrapper mb-3';
            subcategoryWrapper.dataset.index = subcategoryIndex;

            const inputGroup = document.createElement('div');
            inputGroup.className = 'input-group mb-3';

            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control';
            input.name = `subcategories[${subcategoryIndex}][name]`;
            input.placeholder = 'Enter subcategory name';

            const addSubSubcategoryButton = document.createElement('button');
            addSubSubcategoryButton.className = 'btn btn-secondary add-subsubcategory';
            addSubSubcategoryButton.type = 'button';
            addSubSubcategoryButton.innerHTML = '<i class="fas fa-plus"></i>';

            const deleteButton = document.createElement('button');
            deleteButton.className = 'btn btn-danger delete-subcategory';
            deleteButton.type = 'button';
            deleteButton.innerHTML = '<i class="fas fa-trash"></i>';

            inputGroup.appendChild(input);
            inputGroup.appendChild(addSubSubcategoryButton);
            inputGroup.appendChild(deleteButton);
            subcategoryWrapper.appendChild(inputGroup);

            const subSubcategoriesContainer = document.createElement('div');
            subSubcategoriesContainer.className = 'sub-subcategories ms-4';
            subcategoryWrapper.appendChild(subSubcategoriesContainer);

            subcategoriesContainer.appendChild(subcategoryWrapper);

            subcategoryIndex++;

            addSubSubcategoryButton.addEventListener('click', function () {
                const subSubcategoryIndex = subSubcategoriesContainer.children.length;

                const subSubInputGroup = document.createElement('div');
                subSubInputGroup.className = 'input-group mb-3';

                const subSubInput = document.createElement('input');
                subSubInput.type = 'text';
                subSubInput.className = 'form-control';
                subSubInput.name = `subcategories[${subcategoryWrapper.dataset.index}][sub_subcategories][${subSubcategoryIndex}][name]`;
                subSubInput.placeholder = 'Enter sub-subcategory name';

                const subSubDeleteButton = document.createElement('button');
                subSubDeleteButton.className = 'btn btn-danger';
                subSubDeleteButton.type = 'button';
                subSubDeleteButton.innerHTML = '<i class="fas fa-trash"></i>';

                subSubDeleteButton.addEventListener('click', function () {
                    subSubInputGroup.remove();
                });

                subSubInputGroup.appendChild(subSubInput);
                subSubInputGroup.appendChild(subSubDeleteButton);
                subSubcategoriesContainer.appendChild(subSubInputGroup);
            });
        });

        subcategoriesContainer.addEventListener('click', function (e) {
            if (e.target.closest('.delete-subcategory')) {
                e.target.closest('.subcategory-wrapper').remove();
            }
        });
    });

    document.getElementById('saveCategoryBtn').addEventListener('click', function() {
    const formData = new FormData(document.getElementById('createCategoryForm'));

    // Prepare subcategories
    const subcategories = [];
    const subcategoryWrappers = document.querySelectorAll('.subcategory-wrapper');

    subcategoryWrappers.forEach(wrapper => {
        const subcategory = {
            name: wrapper.querySelector('input[name^="subcategories"]').value,
            sub_subcategories: []
        };

        const subSubcategories = wrapper.querySelectorAll('.sub-subcategories input');
        subSubcategories.forEach(subSubInput => {
            subcategory.sub_subcategories.push({ name: subSubInput.value });
        });

        subcategories.push(subcategory);
    });

    subcategories.forEach((subcat, index) => {
        formData.append(`subcategories[${index}][name]`, subcat.name);
        subcat.sub_subcategories.forEach((subSubcat, subSubIndex) => {
            formData.append(`subcategories[${index}][sub_subcategories][${subSubIndex}][name]`, subSubcat.name);
        });
    });

    fetch('{{ route('categories.store') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    })
    .then(response => response.text())
    .then(data => {

        var modal = bootstrap.Modal.getInstance(document.getElementById('createCategoryModal'));
        modal.hide();

        Swal.fire('Success', 'Category created successfully!', 'success').then(() => {
            location.reload(); 
        });
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'There was an issue saving the category.', 'error');
    });
});


</script>
<script>
    function submitForm() {
        document.getElementById('categorySearchForm').submit();
    }
</script>

@endsection
