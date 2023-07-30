@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbar', ['title' => 'Berita'])
    <div class="px-4 pt-4 mt-2">
        <div id="alert">
            @include('components.alert')
            @include('components.alert-validation')
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card z-index-2 h-200">
                    <div class="card-header pb-0">
                        <h6>Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</h6>
                    </div>
                    <div class="card-body overflow-auto">
                        <div class="row">
                            <div class="col-md-4">
                                <img class="img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                            </div>
                            <div class="col-md-8">
                                <P class="text-sm font-weight-bold mb-0">
                                    Kamis, 01 September 2022
                                </P>
                                <P class="text-sm font-weight-bold mb-0">
                                    Kegiatan Yudisium Luring Semeter Ganjil 2021/2022
                                </P><br>
                                <P class="text-sm font-weight-bold mb-0">
                                    Fakultas Teknologi Informasi Universitas Tarumanagara (FTI UNTAR) menyelenggarakan kegiatan yudisium secara offline (luring) di Kampus 1 Universitas Tarumanagara, Gedung M Lantai 8, Ruang Auditorium. Dari 94 lulusan program studi Teknik Informatika dan Sistem Informasi yang mengikuti kegiatan tersebut, 84 mahasiswa yang memilih untuk offline sehingga sekitar 90% dari lulusan hadir secara luring dengan antusias dan penuh semangat pada hari Kamis, 03 Februari 2021.
                                </P>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card z-index-2 h-200">
                    <div class="card-header pb-0">
                        <h6>Berita</h6>
                    </div>
                    <div class="card-body overflow-auto">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="card" style="width: 100%">
                                    <img class="card-img-top img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                                    <div class="card-body">
                                      <p class="card-text">Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</p>
                                    </div>
                                </div>
                                <a class="mt-4 btn btn-primary btn-md" href="{{ route('news') }}">Lebih Lanjut</a>
                            </div>
                            <div class="col-sm-3">
                                <div class="card" style="width: 100%">
                                    <img class="card-img-top img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                                    <div class="card-body">
                                      <p class="card-text">Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</p>
                                    </div>
                                </div>
                                <a class="mt-4 btn btn-primary btn-md" href="{{ route('news') }}">Lebih Lanjut</a>
                            </div>
                            <div class="col-sm-3">
                                <div class="card" style="width: 100%">
                                    <img class="card-img-top img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                                    <div class="card-body">
                                      <p class="card-text">Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</p>
                                    </div>
                                </div>
                                <a class="mt-4 btn btn-primary btn-md" href="{{ route('news') }}">Lebih Lanjut</a>
                            </div>
                            <div class="col-sm-3">
                                <div class="card" style="width: 100%">
                                    <img class="card-img-top img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                                    <div class="card-body">
                                      <p class="card-text">Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</p>
                                    </div>
                                </div>
                                <a class="mt-4 btn btn-primary btn-md" href="{{ route('news') }}">Lebih Lanjut</a>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-3">
                                <div class="card" style="width: 100%">
                                    <img class="card-img-top img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                                    <div class="card-body">
                                      <p class="card-text">Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</p>
                                    </div>
                                </div>
                                <a class="mt-4 btn btn-primary btn-md" href="{{ route('news') }}">Lebih Lanjut</a>
                            </div>
                            <div class="col-sm-3">
                                <div class="card" style="width: 100%">
                                    <img class="card-img-top img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                                    <div class="card-body">
                                      <p class="card-text">Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</p>
                                    </div>
                                </div>
                                <a class="mt-4 btn btn-primary btn-md" href="{{ route('news') }}">Lebih Lanjut</a>
                            </div>
                            <div class="col-sm-3">
                                <div class="card" style="width: 100%">
                                    <img class="card-img-top img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                                    <div class="card-body">
                                      <p class="card-text">Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</p>
                                    </div>
                                </div>
                                <a class="mt-4 btn btn-primary btn-md" href="{{ route('news') }}">Lebih Lanjut</a>
                            </div>
                            <div class="col-sm-3">
                                <div class="card" style="width: 100%">
                                    <img class="card-img-top img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                                    <div class="card-body">
                                      <p class="card-text">Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</p>
                                    </div>
                                </div>
                                <a class="mt-4 btn btn-primary btn-md" href="{{ route('news') }}">Lebih Lanjut</a>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-3">
                                <div class="card" style="width: 100%">
                                    <img class="card-img-top img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                                    <div class="card-body">
                                      <p class="card-text">Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</p>
                                    </div>
                                </div>
                                <a class="mt-4 btn btn-primary btn-md" href="{{ route('news') }}">Lebih Lanjut</a>
                            </div>
                            <div class="col-sm-3">
                                <div class="card" style="width: 100%">
                                    <img class="card-img-top img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                                    <div class="card-body">
                                      <p class="card-text">Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</p>
                                    </div>
                                </div>
                                <a class="mt-4 btn btn-primary btn-md" href="{{ route('news') }}">Lebih Lanjut</a>
                            </div>
                            <div class="col-sm-3">
                                <div class="card" style="width: 100%">
                                    <img class="card-img-top img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                                    <div class="card-body">
                                      <p class="card-text">Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</p>
                                    </div>
                                </div>
                                <a class="mt-4 btn btn-primary btn-md" href="{{ route('news') }}">Lebih Lanjut</a>
                            </div>
                            <div class="col-sm-3">
                                <div class="card" style="width: 100%">
                                    <img class="card-img-top img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                                    <div class="card-body">
                                      <p class="card-text">Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</p>
                                    </div>
                                </div>
                                <a class="mt-4 btn btn-primary btn-md" href="{{ route('news') }}">Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mt-4">
                        <div class="ms-auto">
                            {{-- <a class="mb-0 btn btn-primary btn-md" href="{{ route('news') }}">Lihat Semua Berita</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection
