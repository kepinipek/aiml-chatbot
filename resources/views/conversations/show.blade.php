@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbar', ['title' => 'Percakapan'])
    <div class="px-4 pt-4 mt-2">
        <div id="alert">
            @include('components.alert')
            @include('components.alert-validation')
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="card max-height-vh-75 min-vh-75" style="max-height: 75vh">
                    <div class="card-header shadow-xl">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="d-flex align-items-center">
                                    <div class="ms-3">
                                        <h6 class="mb-0">Chatbot - Masukan pertanyaan anda di sini</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body overflow-auto">
                        @foreach ($turns as $turn)
                            @if ($turn->source == 'human')
                                @if ($turn->input != '')
                                    <div class="row justify-content-end text-right mb-4">
                                        <div class="col-auto">
                                            <div class="card bg-gradient-primary text-white">
                                                <div class="card-body p-2">
                                                    <p class="mb-1">
                                                        {{ $turn->input }}
                                                    </p>
                                                    <div class="d-flex align-items-center justify-content-end text-sm opacity-6">
                                                        <small>{{ $turn->created_at->format('d M Y H:i') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($turn->output != '')
                                    <div class="row justify-content-start mb-4">
                                        <div class="col-auto">
                                            <div class="card ">
                                                <div class="card-body p-2">
                                                    <p class="mb-1">
                                                        {{ $turn->output }}
                                                    </p>
                                                    <div class="d-flex align-items-center text-sm opacity-6">
                                                        <small>{{ $turn->updated_at->format('d M Y H:i') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                        <div class="chatbox"></div>
                    </div>
                    <div class="card-footer d-block">
                        @if ($conversation->slug == $latestConversationSlug)
                            <form action="{{ route('turns.store') }}" method="POST">
                                @csrf

                                <input type="hidden" name="slug" id="slug" value="{!! $conversation->slug !!}">
                                <div class="input-group mb-3">
                                    <input name="input" type="text" class="form-control" placeholder="Tulis pertanyaan anda di sini" autofocus>
                                    <button class="btn btn-primary mb-0" type="submit" id="button-addon2"><i class="fa fa-paper-plane"></i></button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @if (count($conversations) > 0 && Auth::check())
                <div class="col-lg-6">
                    <div class="card max-height-vh-75 min-vh-75" style="max-height: 75vh">
                        <div class="card-header pb-0 p-3">
                            <h6 class="mb-0">History Percakapan</h6>
                        </div>
                        <div class="card-body overflow-auto">
                            <ul class="list-group">
                                @foreach ($conversations as $con)
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                @if ($con->slug == $conversation->slug)
                                                    {{ $con->slug }}
                                                @else
                                                    <a class="font-weight-bold mb-0" href="{{ route('conversations.show', $con->slug) }}"><i
                                                    class="fas fa-history text-dark me-2" aria-hidden="true" title="Lihat Petanyaan"></i>{{ $con->slug }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @include('layouts.footer')
    <script>
        window.onload = function() {
            var chatbox = document.querySelector(".chatbox");
            chatbox.scrollIntoView(true);
        }
    </script>
@endsection
