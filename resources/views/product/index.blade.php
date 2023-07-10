@extends('layout.app')

@section('title', 'Product')

@section('content')
<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">
            Product Data
        </h4>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end mb-4">
            <a href="#modal-form" class="btn btn-primary modal-add">Add Data</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Category Name</th>
                        <th>SubCategory Name</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Material</th>
                        <th>Sku</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-product">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="product_name" placeholder="Product Name" required>
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>SubCategory</label>
                                <select name="subcategory_id" id="subcategory_id" class="form-control">
                                    @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" class="form-control" name="price" placeholder="Price" required>
                            </div>
                            <div class="form-group">
                                <label>Discount</label>
                                <input type="number" class="form-control" name="discount" placeholder="Discount" required>
                            </div>
                            <div class="form-group">
                                <label>Material</label>
                                <input type="text" class="form-control" name="material" placeholder="Material" required>
                            </div>
                            <div class="form-group">
                                <label>Tags</label>
                                <input type="text" class="form-control" name="tags" placeholder="Tags" required>
                            </div>
                            <div class="form-group">
                                <label>Sku</label>
                                <input type="text" class="form-control" name="sku" placeholder="Sku" required>
                            </div>
                            <div class="form-group">
                                <label>Size</label>
                                <input type="text" class="form-control" name="size" placeholder="Size" required>
                            </div>
                            <div class="form-group">
                                <label>Color</label>
                                <input type="text" class="form-control" name="color" placeholder="Color" required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" placeholder="Description" id="" cols="30" rows="10" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    // Pemanggilan data utk tabel
    $(function() {
        $.ajax({
            url: '/api/products',
            success: function({
                data
            }) {
                let row;
                data.map(function(val, index) {
                    row += `
                    <tr>
                        <td>${index+1}</td>
                        <td>${val.product_name}</td>
                        <td>${val.category.category_name}</td>
                        <td>${val.subcategory.subcategory_name}</td>
                        <td>${val.price}</td>
                        <td>${val.discount}</td>
                        <td>${val.material}</td>
                        <td>${val.sku}</td>
                        <td>${val.size}</td>
                        <td>${val.color}</td>
                        <td><img src="/uploads/${val.image}" width="150"</td>
                        <td>
                            <a href="#modal-form" data-id="${val.id}" class="btn btn-warning modal-edit">Edit</a>
                            <a href="#" data-id="${val.id}" class="btn btn-danger btn-delete">Delete</a>
                        </td>
                    </tr>
                    `;
                });
                $('tbody').append(row);
            }
        });
        // Delete data
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id')
            const token = localStorage.getItem('token');
            confirm_dialog = confirm('Are you sure you want to delete this');
            if (confirm_dialog) {
                $.ajax({
                    url: '/api/products/' + id,
                    type: "DELETE",
                    headers: {
                        "Authorization": 'Bearer ' + token
                    },
                    success: function(data) {
                        if (data.message == 'success') {
                            alert('deleted successfully')
                            location.reload();
                        }
                    }
                });
            }
        });
        // Add data
        $('.modal-add').click(function() {
            $('#modal-form').modal('show');
            $('select[name="category_id"]').val('');
            $('textarea[name="description"]').val('');
            $('input[name="product_name"]').val('');
            $('select[name="subcategory_id"]').val('');
            $('input[name="price"]').val('');
            $('input[name="discount"]').val('');
            $('input[name="material"]').val('');
            $('input[name="tags"]').val('');
            $('input[name="sku"]').val('');
            $('input[name="size"]').val('');
            $('input[name="color"]').val('');
            $('.form-product').submit(function(e) {
                e.preventDefault()
                const token = localStorage.getItem('token')
                const frmdata = new FormData(this);
                $.ajax({
                    url: 'api/products',
                    type: 'POST',
                    data: frmdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {
                        "Authorization": 'Bearer ' + token
                    },
                    success: function(data) {
                        if (data.success) {
                            alert('created category successfully')
                            location.reload();
                        }
                    }
                })
            });
        });
        // Edit data
        $(document).on('click', '.modal-edit', function() {
            $('#modal-form').modal('show')
            const id = $(this).data('id');
            $.get('/api/products/' + id, function({
                data
            }) {
                $('select[name="category_id"]').val(data.category_id);
                $('textarea[name="description"]').val(data.description);
                $('input[name="product_name"]').val(data.product_name);
                $('select[name="subcategory_id"]').val(data.subcategory_id);
                $('input[name="price"]').val(data.price);
                $('input[name="discount"]').val(data.discount);
                $('input[name="material"]').val(data.material);
                $('input[name="tags"]').val(data.tags);
                $('input[name="sku"]').val(data.sku);
                $('input[name="size"]').val(data.size);
                $('input[name="color"]').val(data.color);
            })
            $('.form-product').submit(function(e) {
                e.preventDefault()
                const token = localStorage.getItem('token')
                const frmdata = new FormData(this);
                $.ajax({
                    url: `/api/products/${id}?_method=PUT`,
                    type: 'POST',
                    data: frmdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {
                        "Authorization": 'Bearer ' + token
                    },
                    success: function(data) {
                        if (data.success) {
                            alert('Data has been changed successfully')
                            location.reload();
                        }
                    }
                })
            });
        });
    });
</script>
@endpush