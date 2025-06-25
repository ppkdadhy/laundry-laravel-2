@extends('app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>Service Recycle</h1>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                        <a href="{{ url('service') }}" class="btn btn-secondary mt-2 mb-2">Back</a>
                        </div>
                        <div class="table table-responsive">
                        <table class="table table-bordered text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Service</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            @foreach ($services as $index => $serv)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $serv->service_name }}</td>
                                <td>Rp. {{ number_format($serv->price, 2, ',','.') }}</td>
                                <td>{{ $serv->description }}</td>
                                <td>
                                    <a href="{{ route('service.restore', $serv->id) }}" onclick="return confirm('Yakin ingin Restore ?')" class="btn btn-success btn-sm">Restore</a>
                                    <form action="{{ route('service.destroy', $serv->id) }}" method="post" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin Delete Permanen ?')"
                                            class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
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
