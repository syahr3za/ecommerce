@extends('layout.app')

@section('title', 'Income Reports')

@section('content')
<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">
            Report Data
        </h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form>
                    <div class="form-group">
                        <label>From</label>
                        <input type="date" name="from" id="from" class="form-control" value="{{ request()->input('from') }}">
                    </div>
                    <div class="form-group">
                        <label>Until</label>
                        <input type="date" name="until" id="until" class="form-control" value="{{ request()->input('until') }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        @if (request()->input('from'))
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Purchased Amount</th>
                        <th>Total Qty</th>
                        <th>Income</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        @endif
    </div>
</div>

@endsection

@push('js')
<script>
    // Pemanggilan data utk tabel
    $(function() {

        const from = '{{ request()->input('from') }}'
        const until = '{{ request()->input('until') }}'

        function rupiah(angka) {
            const format = angka.toString().split('').reverse().join('');
            const convert = format.match(/\d{1,3}/g);
            return 'Rp ' + convert.join('.').split('').reverse().join('')
        }

        const token = localStorage.getItem('token')
        $.ajax({
            url: `/api/reports?from=${from}&until=${until}`,
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
                        <td>${val.product_name}</td>
                        <td>${rupiah(val.price)}</td>
                        <td>${val.purchased_amount}</td>
                        <td>${val.total_qty}</td>
                        <td>${rupiah(val.income)}</td>
                    </tr>
                    `;
                });
                $('tbody').append(row)
            }
        });
    });
</script>
@endpush