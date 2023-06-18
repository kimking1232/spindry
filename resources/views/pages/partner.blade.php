@extends('app')

@section('title', 'partner')
@section('page-heading', 'partner')

@section('content')
    <div class="page-content">
        <section class="row">
            <div class="row">
                <div class="col-5">
                    @if (session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            <i class="fa-solid fa-circle-check fa-bounce"></i> {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="row mb-5">
                            <div class="col-4">
                                <a href="{{ url('/partner/create') }}" class="btn btn-primary">Tambah Data</a>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <select name="pagination" id="pagination" class="form-control">
                                        <option>5</option>
                                        <option>10</option>
                                        <option>15</option>
                                        <option>20</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="q" value="{{ $q }}"
                                        placeholder="Cari...">
                                </div>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>Title</th>
                                        <th>Logo</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($partners as $partner)
                                            <tr>
                                                <td>{{ $partner->title }}</td>
                                                <td>{{ $partner->logo }}</td>
                                                <td>{{ $partner->status }}</td>
                                                <td>
                                                    <a href="{{url ('/partner/' . $partner->id . '/edit')}}"
                                                    class="btn btn-warning"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                                    <form class="d-inline" action="{{url ('/partner/' . $partner->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger"><i
                                                            class="fa-solid fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $partners->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection