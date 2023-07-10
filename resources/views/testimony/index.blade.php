@extends('layout.app')

@section('title', 'Testimony')

@section('content')
<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">
            Testimony Data
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
                        <th>Description</th>
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
                <h5 class="modal-title">Form Testimony</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-testimony">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="testimony_name" placeholder="Testimony Name" required>
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
            url: '/api/testimonies',
            success: function({
                data
            }) {
                let row;
                data.map(function(val, index) {
                    row += `
                    <tr>
                        <td>${index+1}</td>
                        <td>${val.testimony_name}</td>
                        <td>${val.description}</td>
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
                    url: '/api/testimonies/' + id,
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
            $('input[name="testimony_name"]').val('')
            $('textarea[name="description"]').val('')
            $('.form-testimony').submit(function(e) {
                e.preventDefault()
                const token = localStorage.getItem('token')
                const frmdata = new FormData(this);
                $.ajax({
                    url: 'api/testimonies',
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
                            alert('created testimony successfully')
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
            $.get('/api/testimonies/' + id, function({
                data
            }) {
                $('input[name="testimony_name"]').val(data.testimony_name);
                $('textarea[name="description"]').val(data.description);
            })
            $('.form-testimony').submit(function(e) {
                e.preventDefault()
                const token = localStorage.getItem('token')
                const frmdata = new FormData(this);
                $.ajax({
                    url: `/api/testimonies/${id}?_method=PUT`,
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