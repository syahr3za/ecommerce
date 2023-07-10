@extends('layout.app')

@section('title', 'Order Packed')

@section('content')
<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">
            Order Packed Data
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Invoice</th>
                        <th>Member Name</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    // Pemanggilan data utk tabel
    $(function() {

        function rupiah(angka) {
            const format = angka.toString().split('').reverse().join('');
            const convert = format.match(/\d{1,3}/g);
            return 'Rp ' + convert.join('.').split('').reverse().join('')
        }

        function date(date) {
            var date = new Date(date);
            var day = date.getDate();
            var month = date.getMonth();
            var year = date.getFullYear();

            return `${day}-${month}-${year}`;
        }

        const token = localStorage.getItem('token')
        $.ajax({
            url: '/api/order/packed',
            headers: {
                "Authorization": 'Bearer ' + token
            },
            success: function({
                data
            }) {
                let row;
                data.map(function(val, index) {
                    row += `
                    <tr>
                        <td>${index+1}</td>
                        <td>${date(val.created_at)}</td>
                        <td>${val.invoice}</td>
                        <td>${val.member.member_name}</td>
                        <td>${rupiah(val.grand_total)}</td>
                        <td>
                            <a href="#" data-id="${val.id}" class="btn btn-success btn-action">Sent</a>
                        </td>
                    </tr>
                    `;
                });
                $('tbody').append(row);
            }
        });

        $(document).on('click', '.btn-action', function() {
            const id = $(this).data('id');

            $.ajax({
                url: '/api/order/changeStatus/' + id,
                type: 'POST',
                data: {
                    status: 'sent',
                },
                headers: {
                    "Authorization": 'Bearer ' + token
                },
                success: function(data) {
                    alert('order has been sent');
                    location.reload();
                }
            })
        })
    });
</script>
@endpush