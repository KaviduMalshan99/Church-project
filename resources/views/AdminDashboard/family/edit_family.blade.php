@extends ('AdminDashboard.master')

@section('content')
<form method="POST" action="{{ route('family.update', $family->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12">
            <div class="content-header">
                <h2 class="content-title">Update Family</h2>
                <div>
                    <button type="submit" class="btn btn-md rounded font-sm hover-up">Update</button>
                </div>
            </div>
        </div>


        <div class="card mb-4 ml-3">
            <div class="card-header">
                <h4>Family Name (optional)</h4>
            </div>
            <div class="card-body">
                <!-- The same form continues here -->
                <div class="mb-4">
                    <label for="family_name" class="form-label">Family Name </label>
                    <input type="text" name="family_name" value="{{$family->family_name}}" placeholder="Type here Family Name" class="form-control" id="family_name" />
                </div>

            </div>
        </div>



        <div class="col-lg-7">
            <div class="card mb-4">
                <div class="card-header">
                    <br>
                    <h4>Basic Details of Main Member</h4>
                </div>
                <div class="card-body">

                    <br>

                    <div class="mb-4">
                        <label class="form-label">Select Sub Church <i class="text-danger">*</i></label>
                        <select name="sub_church_id" class="form-select" required>
                            <option value="">Select Sub Church</option>
                            @foreach($churches as $subChurch)
                            <option value="{{ $subChurch->id }}"
                                {{ old('sub_church_id', $member->church_id ?? '') == $subChurch->id ? 'selected' : '' }}>
                                {{ $subChurch->church_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-4">
                        <label for="member_name" class="form-label">Member Name <i class="text-danger">*</i></label>
                        <input type="text" name="member_name" value="{{$member->member_name}}" placeholder="Type here" class="form-control" id="member_name" required />
                    </div>
                    <div class="mb-4">
                        <label for="birth_date" class="form-label">Birth Date</label>
                        <input type="date" name="birth_date" value="{{$member->birth_date}}" class="form-control" id="birth_date" />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Gender <i class="text-danger">*</i></label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender', $member->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $member->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $member->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Occupation</label>
                        <input type="text" name="occupation" value="{{$member->occupation}}" placeholder="e.g., Teacher, Engineer" class="form-control" />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Contact Info</label>
                        <input type="text" name="contact_info" value="{{$member->contact_info}}" placeholder="e.g., 0712345678" class="form-control" />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{$member->email}}" placeholder="e.g., example@example.com" class="form-control" />
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Media</h4>
                </div>
                <div class="card-body">
                    <div class="input-upload">
                        <img src="{{ asset('backend/assets/imgs/theme/upload.svg') }}" alt="" />
                        <input name="images[]" id="media_upload" class="form-control" type="file" multiple />
                    </div>
                    <div class="image-preview mt-4" id="image_preview_container" style="display: flex; gap: 5px; flex-wrap: wrap;">
                        <!-- Image previews will appear here -->
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Organization</h4>
                </div>
                <div class="card-body">
                    <div class="row gx-2">
                        <div class="mb-4">
                            <label class="form-label">Religion (If Not Catholic)</label>
                            <input type="text" name="religion_if_not_catholic" value="{{$member->religion_if_not_catholic}}" placeholder="Specify religion" class="form-control" />
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Nikaya</label>
                            <input type="text" name="nikaya" value="{{$member->nikaya}}" placeholder="e.g., Malwatta, Asgiriya" class="form-control" />
                        </div>
                        <div class="mb-4">
                            <label class="form-check">
                                <input type="checkbox" name="baptized" value="1"
                                    class="form-check-input"
                                    {{ old('baptized', $member->baptized) ? 'checked' : '' }} />
                                <span class="form-check-label">Baptized</span>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="form-check">
                                <input type="checkbox" name="full_member" value="1"
                                    class="form-check-input"
                                    {{ old('full_member', $member->full_member) ? 'checked' : '' }} />
                                <span class="form-check-label">Full Member</span>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="form-check">
                                <input type="checkbox" name="methodist_member" value="1"
                                    class="form-check-input"
                                    {{ old('methodist_member', $member->methodist_member) ? 'checked' : '' }} />
                                <span class="form-check-label">Methodist Member</span>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="form-check">
                                <input type="checkbox" name="sabbath_member" value="1"
                                    class="form-check-input"
                                    {{ old('sabbath_member', $member->sabbath_member) ? 'checked' : '' }} />
                                <span class="form-check-label">Sabbath Member</span>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="form-check">
                                <input type="checkbox" name="held_office_in_council" value="1"
                                    class="form-check-input"
                                    {{ old('held_office_in_council', $member->held_office_in_council) ? 'checked' : '' }} />
                                <span class="form-check-label">Held Office in Council</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</form>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const affiliateCheckbox = document.getElementById('affiliate_checkbox');
        const normalPriceInput = document.getElementById('normal_price');
        const affiliatePriceInput = document.getElementById('affiliate_price');
        const commissionInput = document.getElementById('commission');
        const comPriceInput = document.getElementById('com_price');

        // Set initial state for inputs
        affiliatePriceInput.value = normalPriceInput.value || 0;
        affiliatePriceInput.readOnly = true; // Affiliate price should be equal to normal price and readonly
        comPriceInput.readOnly = true;
        commissionInput.readOnly = true; // Commission input should be readonly initially

        affiliateCheckbox.addEventListener('change', function() {
            if (affiliateCheckbox.checked) {
                // When affiliate checkbox is checked
                affiliatePriceInput.value = normalPriceInput.value || 0; // Set affiliate price equal to normal price
                affiliatePriceInput.readOnly = true;

                commissionInput.readOnly = false; // Allow the commission to be edited when affiliate is checked
                commissionInput.value = ''; // Reset commission if unchecked
                calculateCommissionPrice();
            } else {
                // When affiliate checkbox is unchecked
                affiliatePriceInput.value = '';
                commissionInput.value = '';
                comPriceInput.value = '';
                commissionInput.readOnly = true; // Disable commission input when checkbox is unchecked
            }
        });

        normalPriceInput.addEventListener('input', function() {
            if (affiliateCheckbox.checked) {
                // Update affiliate price when normal price changes
                affiliatePriceInput.value = normalPriceInput.value || 0;
            }
            calculateCommissionPrice();
        });

        commissionInput.addEventListener('input', function() {
            if (affiliateCheckbox.checked) {
                calculateCommissionPrice(); // Recalculate commission price only if affiliate is checked
            }
        });

        function calculateCommissionPrice() {
            const normalPrice = parseFloat(normalPriceInput.value) || 0;
            const commissionRate = parseFloat(commissionInput.value) || 0; // Get commission rate from input
            const commissionPrice = normalPrice * (commissionRate / 100); // Calculate commission price

            comPriceInput.value = commissionPrice.toFixed(2); // Display commission price
        }
    });



    //image upload
    document.addEventListener('DOMContentLoaded', function() {
        const mediaUploadInput = document.getElementById('media_upload');
        const imagePreviewContainer = document.getElementById('image_preview_container');
        let currentFiles = [];

        mediaUploadInput.addEventListener('change', function() {
            const files = Array.from(mediaUploadInput.files);
            files.forEach((file, index) => {
                currentFiles.push(file);
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageUrl = e.target.result;
                    const imageContainer = document.createElement('div');
                    imageContainer.classList.add('position-relative');
                    imageContainer.style.width = '100px';
                    imageContainer.style.height = '100px';

                    const imgElement = document.createElement('img');
                    imgElement.src = imageUrl;
                    imgElement.classList.add('img-thumbnail');
                    imgElement.style.width = '100%';
                    imgElement.style.height = '100%';
                    imgElement.style.objectFit = 'cover';

                    const deleteIcon = document.createElement('span');
                    deleteIcon.classList.add('position-absolute', 'top-0', 'end-0', 'bg-danger', 'text-white', 'rounded-circle', 'p-1', 'cursor-pointer');
                    deleteIcon.innerHTML = '&times;';
                    deleteIcon.style.cursor = 'pointer';

                    deleteIcon.addEventListener('click', function() {
                        imageContainer.remove();
                        removeImageFromFileList(currentFiles.indexOf(file));
                    });

                    imageContainer.appendChild(imgElement);
                    imageContainer.appendChild(deleteIcon);
                    imagePreviewContainer.appendChild(imageContainer);
                };

                reader.readAsDataURL(file);
            });

            updateFileInput();
        });

        function removeImageFromFileList(index) {
            currentFiles.splice(index, 1);
            updateFileInput();
        }

        function updateFileInput() {
            const dt = new DataTransfer();
            currentFiles.forEach(file => {
                dt.items.add(file);
            });
            mediaUploadInput.files = dt.files;
        }
    });


    //categories dropdown
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('categorySelect');
        const subcategorySelect = document.getElementById('subcategorySelect');
        const subsubcategorySelect = document.getElementById('subsubcategorySelect');

        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;

            subcategorySelect.innerHTML = '<option value="">Select a subcategory</option>';
            subsubcategorySelect.innerHTML = '<option value="">Select a sub-subcategory</option>';
            subcategorySelect.disabled = true;
            subsubcategorySelect.disabled = true;

            if (categoryId) {
                fetch(`/api/subcategories/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(subcategory => {
                            const option = document.createElement('option');
                            option.value = subcategory.id;
                            option.textContent = subcategory.name;
                            subcategorySelect.appendChild(option);
                        });
                        subcategorySelect.disabled = false;
                    })
                    .catch(error => console.error('Error fetching subcategories:', error));
            }
        });

        subcategorySelect.addEventListener('change', function() {
            const subcategoryId = this.value;

            subsubcategorySelect.innerHTML = '<option value="">Select a sub-subcategory</option>';
            subsubcategorySelect.disabled = true;

            if (subcategoryId) {
                fetch(`/api/sub-subcategories/${subcategoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(subSubcategory => {
                            const option = document.createElement('option');
                            option.value = subSubcategory.id;
                            option.textContent = subSubcategory.name;
                            subsubcategorySelect.appendChild(option);
                        });
                        subsubcategorySelect.disabled = false;
                    })
                    .catch(error => console.error('Error fetching sub-subcategories:', error));
            }
        });
    });
</script>

<script>
    let variationIndex = 1;

    function addVariation() {
        const variationsContainer = document.getElementById('variationsContainer');

        const newVariationRow = document.createElement('div');
        newVariationRow.className = 'row mb-3 variation-row';
        newVariationRow.innerHTML = `
            <div class="col-lg-4">
                <label class="form-label">Select Type</label>
                <select name="variations[${variationIndex}][type]" class="form-select" onchange="toggleColorInput(this)">
                    <option value="">Select</option>
                    <option value="size">Size</option>
                    <option value="color">Color</option>
                </select>
            </div>
            <div class="col-lg-4">
                <label class="form-label">Value</label>
                <input type="text" name="variations[${variationIndex}][value]" class="form-control" placeholder="Enter value" />
                <input type="color" name="variations[${variationIndex}][hex_value]" class="form-control color-input" style="display: none;" />
            </div>
            <div class="col-lg-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="variations[${variationIndex}][quantity]" class="form-control" placeholder="Qty" />
            </div>
            <div class="col-lg-1 text-center">
                <label class="form-label">Delete</label>
                <button type="button" class="btn btn-danger delete-variation" onclick="removeVariation(this)">✖</button>
            </div>
        `;

        variationsContainer.appendChild(newVariationRow);
        variationIndex++;
    }

    function toggleColorInput(select) {
        const colorInput = select.closest('.variation-row').querySelector('.color-input');
        const valueInput = select.closest('.variation-row').querySelector('input[name*="[value]"]');

        if (select.value === 'color') {
            colorInput.style.display = 'block';
            valueInput.style.display = 'none';
            valueInput.value = '';
        } else {
            colorInput.style.display = 'none';
            valueInput.style.display = 'block';
            colorInput.value = '';
        }
    }

    function removeVariation(button) {
        const variationRow = button.closest('.variation-row');
        variationRow.remove();
    }
</script>

@endsection