@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbar', ['title' => 'Menambah User'])
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
                            <p class="mb-0">Menambah User</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="name" class="form-control-label text-sm">Name</label>
                                <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-control-label text-sm">Email</label>
                                <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-control-label text-sm">Password</label>
                                <input class="form-control" id="password" name="password" type="password" value="{{ old('password') }}">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="form-control-label text-sm">Password Confirmation</label>
                                <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" value="{{ old('password_confirmation') }}">
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="is_admin" id="customRadio1" value="1">
                                <label class="custom-control-label" for="customRadio1">Admin</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_admin" id="customRadio2" value="0">
                                <label class="custom-control-label" for="customRadio2">Non Admin</label>
                              </div>
                            <div class="d-flex">
                                <div class="ms-auto">
                                    <button type="submit" class="mb-0 btn btn-primary btn-md ">Simpan</button>
                                    <a class="mb-0 btn btn-secondary btn-md" href="{{ route('users.index') }}">Kembali</a>
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
