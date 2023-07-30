@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbar', ['title' => 'Mengedit Pengetahuan'])
    <div class="px-4 pt-4 mt-2">
        <div id="alert">
            @include('components.alert')
            @include('components.alert-validation')
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Mengedit Pengetahuan</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categories.update', $category->slug) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="pattern" class="form-control-label text-sm">Pattern</label>
                                <input class="form-control" id="pattern" name="pattern" type="text" value="{{ old('pattern', $category->pattern) }}">
                            </div>
                            <div class="form-group">
                                <label for="that" class="form-control-label text-sm">That</label>
                                <input class="form-control" id="that" name="that" type="text" value="{{ old('that', $category->that ) }}">
                            </div>
                            <div class="form-group">
                                <label for="topic" class="form-control-label text-sm">Topic</label>
                                <input class="form-control" id="topic" name="topic" type="text" value="{{ old('topic', $category->topic) }}">
                            </div>
                            <div class="form-group">
                                <label for="template" class="form-control-label text-sm">Template</label>
                                <textarea class="form-control" id="template" name="template" type="text">{{ old('template', $category->template) }}</textarea>
                            </div>
                            <div class="d-flex">
                                <div class="ms-auto">
                                    <button type="submit" class="mb-0 btn btn-primary btn-md ">Simpan</button>
                                    <a class="mb-0 btn btn-secondary btn-md" href="{{ route('categories.index') }}">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection
