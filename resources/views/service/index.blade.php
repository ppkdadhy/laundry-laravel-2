@extends('app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>Service Manage</h1>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                        <a href="{{ url('insert/service') }}" class="btn btn-primary mt-2 mb-2">Create</a>
                        <a href="{{ url('recycle/service') }}" class="btn btn-warning mt-2 mb-2">Recycle</a>
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
                                    <a href="{{ route('service.edit', $serv->id) }}" class="btn btn-success btn-sm">Edit</a>
                                    <form action="{{ route('service.softDelete', $serv->id) }}" method="post" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin Delete ?')"
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
