@extends('app')
@section('content')
{{-- @dd($order) --}}
<div class="container-fliud">
      <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h1>Pay Transaction</h1>
              </div>
              <div class="card-body">
                  <form action="{{ route('paid.order', $order->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row mb-2">
                      <div class="col-6">
                        <label for="" class="form-label">Customer Name</label>
                        <input type="text" value="{{ $order->customer->customer_name }}" class="form-control" readonly>
                        <input type="hidden" id="id_customer" name="id_customer">
                      </div>
                      <div class="col-6">
                        <label for="" class="form-label">Order Code</label>
                        <input type="text" class="form-control" value="{{ $order->order_code }}" readonly>
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-6">
                        <label for="" class="form-label">Start Order</label>
                        <input type="text" class="form-control" name="order_date" readonly value="{{ $order->order_date }}">
                      </div>
                      <div class="col-6">
                        <label for="" class="form-label">End Order</label>
                        <input type="text" class="form-control" name="order_end_date" value="{{ $order->order_end_date }}" readonly>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-12">
                        <div class="table table-responsive">
                          <table id="myTable" class="table table-bordered text-center">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Category Services</th>
                                <th>Quantity (Kg.)</th>
                                <th>Price</th>
                                <th>Notes</th>
                                <th>Status Paid</th>
                              </tr>
                            </thead>
                            <tbody>
                              @php
                                $no = 1;
                              @endphp
                              @foreach ($order->orderDetail as $item)
                                  <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->service->service_name }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $item->subtotal }}</td>
                                    <td>{{ $item->notes }}</td>
                                    <td>{{ $order->order_status === 1 ? "Belum Lunas" : "Lunas" }}</td>
                                  </tr>
                              @endforeach
                            </tbody>
                            <tfoot>
                              <tr>
                                <th colspan="3">Total</th>
                                <td colspan="3"><strong>Rp. {{ number_format($order->total, 2,',','.') }}</strong></td>
                              </tr>
                              <tr>
                                <th colspan="3">Pay</th>
                                <td colspan="3"><input type="number" class="form-control" name="order_pay" id="order_pay" value="{{ $order->order_pay != null ? $order->order_pay : null }}" oninput="countPay()" required></td>
                              </tr>
                              <tr>
                                <th colspan="3">Change</th>
                                <td colspan="3"><input type="hidden" name="order_change" id="order_change" value="0"><strong id="changeText">Rp. 0</strong></td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">Pay</button>
                    <a href="{{ url('transaction') }}" class="btn btn-secondary btn-sm">back</a>
              </div>
             </form>
            </div>
          </div>
      </div>
</div>
{{-- ADD TRANSACT --}}
<script>
  const total = {{ $order->total }};
  function countPay(){
// console.log(total);
    const order_pay = parseInt(document.querySelector("#order_pay").value) || 0;
    let change = 0;
    if (order_pay != "") {
      change = order_pay - total;
    }else{
      change = "Rp. " +0;
    }

    if (order_pay < 0) {
      change = "Rp. " +0;
    }
    document.querySelector("#changeText").textContent = change.toLocaleString('id-ID');
    document.querySelector("#order_change").value = change;
  }
</script>
{{-- <script>
    const tbdy = document.querySelector("#myTable tbody");
    const select = document.querySelector("#id_service");

    const grandTotal = document.querySelector('#grandTotal');
    const grandTotalInput = document.querySelector('#grandTotalInput');
    let no = 1;
    function addTr(){
      const sService = select.options[select.selectedIndex];
      const sServiceName = sService.textContent;
      const sVal = sService.value;
      if (!sVal) {
        alert('select service first!');
        return;
      }
      const servicePrice = sService.dataset.price;
      const tr = document.createElement('tr');
      tr.innerHTML = `
      <td>${no++}</td>
      <td><input type="hidden" name='id_service[]' class="idProducts" value="${sVal}"> ${sServiceName}</td>
      <td>
        <input type="number" name="qty[]" class="form-control qtys" value="1">
        <input type="hidden" name="price[]" class="priceInput" value="${servicePrice}">  
      </td>
      <td><input type="hidden" name="subtotal[]" class='totals' value="${servicePrice}"><span class="totalText">${servicePrice}</span></td>
      <td><textarea class="form-control" name="notes[]" cols="30" rows="5"></textarea></td>
      <td>
        <button class="btn btn-danger btn-sm delRow" type="button">Delete</button></td>
      `;
        tbdy.appendChild(tr);
        select.value = "";
        updtGrandTotal();
    }
    tbdy.addEventListener('click', function(e) {
      if(e.target.classList.contains('delRow')){
        e.target.closest("tr").remove();
      }
      updateNumber();
      updtGrandTotal();
    });
    function updateNumber(){
      const rows = tbdy.querySelectorAll("tr");
      rows.forEach(function(row, index){
        row.cells[0].textContent = index + 1;
      });
      // no = rows.length + 1;
    }
    tbdy.addEventListener("input", function(e){
      if (e.target.classList.contains('qtys')) {
        const row = e.target.closest("tr");
        const qty = parseFloat(e.target.value) || 0.0;

        const price = parseInt(row.querySelector('[name="price[]"]').value);
        row.querySelector('.totalText').textContent = price * qty;
        row.querySelector('.totals').value = price * qty;
      }
      updtGrandTotal();
    });

    function updtGrandTotal() {
      const totalCells = tbdy.querySelectorAll('.totals');
      let = grand = 0;
      totalCells.forEach(function(input){
        grand += parseInt(input.value) || 0.0;
      });
      grandTotal.textContent = grand.toLocaleString('id-ID');
      grandTotalInput.value = grand;
    }
</script> --}}
@endsection