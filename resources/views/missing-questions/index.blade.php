
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbar', ['title' => 'Pertanyaan Asing'])
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
                        <h6>Data Pertanyaan Asing</h6>
                    </div>
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <a class="mb-0 btn btn-primary btn-md" href="{{ route('categories.create') }}">Tambah Pengetahuan</a>
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
                                            Input</th>
                                        <th
                                            class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($missingQuestions as $missingQuestion)
                                        <tr>
                                            <td>
                                                <form action="{{ route('missing-questions.destroy', $missingQuestion->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah anda sudah yakin ingin ingin mengganti status input {{ $missingQuestion->input }}?')"
                                                    class="col-sm-6">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="btn btn-link text-dark px-3 mb-0" href="{{ route('conversations.show', $missingQuestion->conversation->slug) }}"><i
                                                        class="fas fa-list text-dark me-2" aria-hidden="true" title="Lihat Petanyaan"></i>Lihat Petanyaan</a>
                                                    @if ($missingQuestion->status == 0)
                                                        <button type="submit"
                                                            class="btn btn-link text-danger text-gradient px-3 mb-0"
                                                            aria-label="true" title="Ubah Status"><i class="far fa-check-circle me-2"></i>Ubah Status
                                                        </button>
                                                    @endif
                                                </form>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0 ps-4">{{ $missingQuestion->input }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0 ps-4">{{ $missingQuestion->statusName() }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer pb-0">
                        {!! $missingQuestions->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection