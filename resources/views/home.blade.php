@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbar', ['title' => ''])
    <div class="px-4 pt-4 mt-2">
        <div id="alert">
            @include('components.alert')
            @include('components.alert-validation')
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="card card-carousel overflow-hidden h-100 p-0">
                    <div id="carouselIndicators" class="carousel slide" data-bs-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselIndicators" data-bs-slide-to="0" class="active"></li>
                        <li data-target="#carouselIndicators" data-bs-slide-to="1"></li>
                        <li data-target="#carouselIndicators" data-bs-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner border-radius-lg h-100">
                        <div class="carousel-item active">
                        <img class="d-block w-100" src="{{ asset('assets/images/18.jpg') }}" alt="First slide">
                        </div>
                        <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('assets/images/19.jpg') }}" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('assets/images/32.jpg') }}" alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselIndicators" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card z-index-2 h-200">
                    <div class="card-header pb-0">
                        <h6>Visi dan Misi Fakultas</h6>
                    </div>
                    <div class="card-body overflow-auto">
                        <P class="text-sm font-weight-bold mb-0">
                            Menjadi fakultas entrepreneurial unggul yang memiliki integritas dan profesionalisme di bidang teknologi informasi di kawasan Asia Tenggara pada tahun 2025
                        </P>
                        <ul>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Menghasilkan lulusan yang kompeten, berintegritas, profesional di bidang teknologi informasi dan berjiwa entrepreneurial..
                                </P>
                            </li>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Menyelenggarakan dan mengembangkan kegiatan tridharma perguruan tinggi di bidang teknologi informasi untuk mencapai keunggulan institusi berlandaskan nilai-nilai integritas, profesional dan entrepreneurship.
                                </P>
                            </li>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Memanfaatkan ilmu pengetahuan, dan teknologi informasi secara berkesinambungan untuk meningkatkan kesejahteraan masyarakat.
                                </P>
                            </li>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Menyelenggarakan kerjasama yang saling menguntungkan di bidang teknologi informasi dengan institusi di dalam maupun di luar negeri untuk mendukung pertumbuhan organisasi.
                                </P>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6 d-flex align-items-stretch">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Tujuan Fakultas</h6>
                    </div>
                    <div class="card-body overflow-auto">
                        <ul>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Menghasilkan lulusan yang kompeten di bidang teknologi Informasi, berbudi luhur, berwawasan kebangsaan dan menghargai pluralitas.
                                </P>
                            </li>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Menghasilkan lulusan di bidang teknologi informasi yang berintegritas, profesional, serta memiliki jiwa entrepreneurial.
                                </P>
                            </li>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Menciptakan pusat-pusat keilmuan untuk pengembangan SDM dan penerapan IPTEK di bidang teknologi informasi secara berkelanjutan.
                                </P>
                            </li>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Menjalin dan memperluas kerjasama di dalam dan di luar negeri melalui nilai-nilai integritas, profesional dan entrepreneurial untuk meningkatkan kualitas pembelajaran secara berkelanjutan dan mendukung pertumbuhan organisasi.
                                </P>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-stretch">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Sasaran Fakultas</h6>
                    </div>
                    <div class="card-body  overflow-auto">
                        <ul>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Meningkatkan kualitas mahasiswa dan lulusan Fakultas Teknologi Informasi
                                </P>
                            </li>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Meningkatkan kualitas dan dampak tridharma di bidang teknologi informasiberlandaskan nilai-nilai integritas, profesional dan entrepreneurship.
                                </P>
                            </li>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Meningkatkan nilai akreditasi program studi di Fakultas Teknologi Informasi
                                </P>
                            </li>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Meningkatkan reputasi Fakultas Teknologi Informasi
                                </P>
                            </li>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Menciptakan diversifikasi pendapatan melalui kegiatan di bidang teknologi informasi
                                </P>
                            </li>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Meningkatkan kepuasan stakeholders
                                </P>
                            </li>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Melakukan integrasi pada sistem dan teknologi informasi untuk mendukung pembelajaran
                                </P>
                            </li>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Mengembangkan sumber daya manusia dalam peningkatan kualifikasi dosen
                                </P>
                            </li>
                            <li>
                                <P class="text-sm font-weight-bold mb-0">
                                    Meningkatkan kepuasan sumber daya manusia
                                </P>
                            </li>
                        </ul>
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
                            </div>
                            <div class="col-sm-3">
                                <div class="card" style="width: 100%">
                                    <img class="card-img-top img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                                    <div class="card-body">
                                      <p class="card-text">Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="card" style="width: 100%">
                                    <img class="card-img-top img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                                    <div class="card-body">
                                      <p class="card-text">Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="card" style="width: 100%">
                                    <img class="card-img-top img-thumbnail" src="{{ asset('assets/images/2207.jpg') }}" alt="Card image cap">
                                    <div class="card-body">
                                      <p class="card-text">Kegiatan Yudisium Luring Semeter Ganjil 2021/2022</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex mt-4">
                            <div class="ms-auto">
                                <a class="mb-0 btn btn-primary btn-md" href="{{ route('news') }}">Lihat Semua Berita</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection
