@extends('app')
@section('content')
      <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h1>Transactions</h1>
                </div>
                <div class="card-body">
                  <div class="table table-responsive">
                      <div class="d-flex justify-content-between">
                        <a href="{{ url('order/transaction') }}" class="btn btn-primary mt-2 mb-2">Order</a>
                        <a href="" class="btn btn-warning mt-2 mb-2">Recycle</a>
                      </div>
                    <table class="table table-bordered text-center">
                      <tr>
                        <th>No</th>
                        <th>No. Order</th>
                        <th>Customer Name</th>
                        <th>Status Order</th>
                        <th>Actions</th>
                      </tr>
                      @foreach ($orders as $index => $i)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><a href="{{ url('pay/order', $i->id) }}">{{ $i->order_code }}</a></td>
                        <td>{{ $i->customer->customer_name }}</td>
                        <td>{{ $i->order_status === 1 ? 'on process': 'Done'}}</td>
                        <td></td>
                      </tr>
                      @endforeach
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
@endsection