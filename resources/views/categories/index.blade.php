
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbar', ['title' => 'Pengetahuan'])
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
                    <div class="card-header pb-0">
                        <h6>Data Pengetahuan</h6>
                    </div>
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <a class="mb-0 btn btn-primary btn-md" href="{{ route('categories.create') }}">Tambah Pengetahuan</a>
                                <a class="mb-0 btn btn-secondary btn-md" href="{{ route('categories.regenerate') }}" onclick="return confirm('Apakah kamu yakin memperbaharui berkas AIML?')">Perbaharui berkas AIML</a>
                                <a class="mb-0 btn btn-secondary btn-md" href="{{ route('categories.download') }}">Download berkas AIML</a>
                            </div>
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
                                            Pattern</th>
                                        <th
                                            class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                            That</th>
                                        <th
                                            class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                            Template</th>
                                        <th
                                            class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                            Topic</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>
                                                <form action="{{ route('categories.destroy', $category->slug) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah anda sudah yakin ingin menghapus pattern {{ $category->pattern }}?')"
                                                    class="col-sm-6">
                                                    @csrf
                                                    @method('DELETE')

                                                    <a class="btn btn-link text-dark px-3 mb-0" href="{{ route('categories.edit', $category->slug) }}"><i
                                                        class="fas fa-pencil-alt text-dark me-2" aria-hidden="true" title="Mengedit"></i>Mengedit</a>
                                                    <button type="submit"
                                                        class="btn btn-link text-danger text-gradient px-3 mb-0"
                                                        aria-label="true" title="Hapus"><i class="far fa-trash-alt me-2"></i>Hapus
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0 ps-4">{{ $category->pattern }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $category->that }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $category->template }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $category->topic }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer pb-0">
                        {!! $categories->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection