
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbar', ['title' => 'User'])
    <div class="px-4 pt-4 mt-2">
        <div id="alert">
            @include('components.alert')
            @include('components.alert-validation')
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 shadow-xl">
                        <h6>Data User</h6>
                    </div>
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <a class="mb-0 btn btn-primary btn-md" href="{{ route('users.create') }}">Tambah User</a>
                            <div class="ms-auto">
                                <form method="GET">
                                    <input type="search" name="q" class="form-control" placeholder="Pencarian ..."
                                        autocomplete="off" value="{{ request('q') }}" />
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 mt-4">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                            Aksi</th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7  ps-2">
                                            Nama</th>
                                        <th
                                            class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                            Email</th>
                                        <th
                                            class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                            Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <form action="{{ route('users.destroy', $user->slug) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah anda sudah yakin ingin menghapus pattern {{ $user->name }}?')"
                                                    class="col-sm-6">
                                                    @csrf
                                                    @method('DELETE')

                                                    <a class="btn btn-link text-dark px-3 mb-0" href="{{ route('users.edit', $user->slug) }}"><i
                                                        class="fas fa-pencil-alt text-dark me-2" aria-hidden="true" title="Mengedit"></i>Mengedit</a>
                                                    <button type="submit"
                                                        class="btn btn-link text-danger text-gradient px-3 mb-0"
                                                        aria-label="true" title="Hapus"><i class="far fa-trash-alt me-2"></i>Hapus
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0 ps-4">{{ $user->name }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $user->email }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $user->roleName() }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer pb-0">
                        {!! $users->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection