@extends('layout.app')

@section('title', 'Payment')

@section('content')
<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">
            Payment Data
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Order</th>
                        <th>Qty</th>
                        <th>Account Number</th>
                        <th>Payer Name</th>
                        <th>Status</th>
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
                <h5 class="modal-title">Form Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-payment">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" class="form-control" name="date" placeholder="Date" readonly>
                            </div>
                            <div class="form-group">
                                <label>Qty</label>
                                <input type="text" class="form-control" name="qty" placeholder="Qty" readonly>
                            </div>
                            <div class="form-group">
                                <label>Account Number</label>
                                <input type="text" class="form-control" name="account_number" placeholder="Account number" readonly>
                            </div>
                            <div class="form-group">
                                <label>Payer Name</label>
                                <input type="text" class="form-control" name="payer_name" placeholder="Payer name" readonly>
                            </div>
                            <div class="form-group">
                                <select name="status" id="status" class="form-control">
                                    <option value="ACCEPTED">ACCEPTED</option>
                                    <option value="REJECTED">REJECTED</option>
                                    <option value="AWAIT">AWAIT</option>
                                </select>
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
            url: '/api/payments',
            success: function({
                data
            }) {
                let row;
                data.map(function(val, index) {
                    date = new Date(val.created_at);
                    full_date = `${date.getDate()}-${date.getMonth()}-${date.getFullYear()}`
                    row += `
                    <tr>
                        <td>${index+1}</td>
                        <td>${full_date}</td>
                        <td>${val.order_id}</td>
                        <td>${val.qty}</td>
                        <td>${val.account_number}</td>
                        <td>${val.payer_name}</td>
                        <td>${val.status}</td>
                        <td>
                            <a href="#modal-form" data-id="${val.id}" class="btn btn-warning modal-edit">Edit</a>
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
                    url: '/api/payments/' + id,
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
        // Edit data
        function formatDate(date) {
            var dateObj = new Date(date);
            var day = dateObj.getDate();
            var month = dateObj.getMonth();
            var year = dateObj.getFullYear();

            return `${day}-${month}-${year}`;
        }

        $(document).on('click', '.modal-edit', function() {
            $('#modal-form').modal('show')
            const id = $(this).data('id');
            $.get('/api/payments/' + id, function({
                data
            }) {
                $('input[name="date"]').val(formatDate(data.created_at));
                $('input[name="qty"]').val(data.qty);
                $('input[name="account_number"]').val(data.account_number);
                $('input[name="payer_name"]').val(data.payer_name);
                $('select[name="status"]').val(data.status);
            })
            $('.form-payment').submit(function(e) {
                e.preventDefault()
                const token = localStorage.getItem('token')
                const frmdata = new FormData(this);
                $.ajax({
                    url: `/api/payments/${id}?_method=PUT`,
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