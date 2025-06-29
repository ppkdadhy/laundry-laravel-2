@extends('app')
@section('content')
<div class="container-fliud">
      <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h1>Order</h1>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-6">
                    <label for="" class="form-label">Search Customer</label>
                    <input type="text" id="searc" class="form-control" oninput="search(this.value)">
                    <div id="results" style="border: 1px solid #ddd; max-height: 200px; overflow-y:auto;"></div>
                  </div>
                </div>
                  <form action="{{ route('transaction.store') }}" method="post">
                    @csrf
                    <div class="row mb-2">
                      <div class="col-6">
                        <label for="" class="form-label">Customer Name</label>
                        <input type="text" id="customer_name" class="form-control" readonly>
                        <input type="hidden" id="id_customer" name="id_customer">
                      </div>
                      <div class="col-6">
                        <label for="" class="form-label">Order Code</label>
                        <input type="text" class="form-control" placeholder="Order Code" readonly id="order_code" name="order_code">
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-6">
                        <label for="" class="form-label">Start Order</label>
                        <input type="text" class="form-control" name="order_date" readonly value="{{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}">
                      </div>
                      <div class="col-6">
                        <label for="" class="form-label">End Order</label>
                        <input type="datetime-local" class="form-control" name="order_end_date" required>
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-6">
                        <label for="" class="form-label">Choose Service</label>
                        <select id="id_service" class="form-control">
                          <option value="">--Choose--</option>
                          @foreach ($services as $i)
                              <option data-price="{{ $i->price }}" value="{{ $i->id }}">{{ $i->description }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" onclick="addTr()">Add Transaction</button>
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
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">Order</button>
                    <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
              </div>
              <div class="card-footer">
                <p><strong>Grand Total: Rp. <span id="grandTotal">0</span></strong></p>
                <input type="hidden" name="total" id="grandTotalInput" value="0">
              </div>
             </form>
            </div>
          </div>
      </div>
</div>
{{-- Search Customer --}}
<script>
  function search(value){
    let v = value.trim();
    const now = new Date();
    const h = now.getHours();
    const m = now.getMinutes();
    if (v.length >2) {
      fetch(`/search-customers?q=${encodeURIComponent(v)}`)
        .then(response => response.json())
        .then(data => {
          let rDiv = document.getElementById("results");
          rDiv.innerHTML = "";
          if (data.length === 0) {
            rDiv.innerHTML = "<p>Tidak ada hasil</p>";
            return;
          }

          data.forEach(customer => {
            let item = document.createElement("div");
            item.textContent = customer.customer_name;
            item.classList.add("p-2", "border-bottom");
            item.style.cursor = "pointer";

            item.addEventListener("click", function () {
              document.getElementById("customer_name").value = customer.customer_name;
              document.getElementById("id_customer").value = customer.id;
              document.querySelector("#order_code").value = "TR-" + customer.id + h + m;
            });

            rDiv.appendChild(item);
          });
        })
    }
  } 
</script>
{{-- ADD TRANSACT --}}
<script>
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
</script>
@endsection