@extends('app')

@section('title', 'edit-partner')
@section('page-heading', 'edit-partner')

@section('content')
    <div class="page-content">
        <section class="row">
            <div class="row-10">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{url ('/partner/'.$partner->id) }}" method="POST"enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('title')is-invalid @enderror" id="title" name="title" value="{{$partner->title}}">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Logo</label>
                                    <input type="file" class="form-control @error('logo')is-invalid @enderror" id="logo" name="logo">
                                    <img src="{{asset('/img/partners/'.$partner->logo)}}" alt="{{$partner->logo}}">
                                    @error('logo')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="status"
                                        name="status" @if($partner->status == 'show') checked @endif >
                                    <label class="form-check-label" for="staus">Geser Untuk Menampilkan</label>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection