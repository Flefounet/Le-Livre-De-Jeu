@extends('layouts.app')

@section('head')

@endsection

@section('js')
    <!--<script src="{{ url('/js/jquery.js') }}"></script>-->
    <script src="{{ url('/js/dropzone.js') }}"></script>
    <script src="{{ url('/js/dropzone-config.js') }}"></script>
@endsection

@section('content')


    <!-- Edit GameSession Form -->
    <div class="container mt-5 mb-5" id="showgamessesionMain">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row" id="showgamesession">
            <div class="col-lg-9"><h2>{{$gameSession->title}}</h2>{!! $gameSession->description!!}</div>
            <div class="col-lg-3" ><h5><strong>Maitre de jeu :</strong></h5>
                @foreach($gamemaster as $gm)
                    <h5> {{$gm->getusers->name}}</h5>
                @endforeach
                <hr>
                <h5><strong>Joueurs :</strong></h5>
                <h5>@foreach($players as $player)
                    @if($loop->last)
                        {{$player->getusers->name}}
                    @else
                        {{$player->getusers->name}} -

                    @endif
                @endforeach</h5>
            </div>
            <hr>
        </div>

        <div class="row" id="buttonsrow">
            <div class="col-lg-9 offset-lg-1">
                @auth
                    @if(Auth::User()->id == $gameSession->user_id)
                        @include("gamesessions.modals.modalAddTurn")
                        @include("gamesessions.modals.modalGameSessionEdit")
                    @endif
                @endauth
            </div>
        </div>

        <div class="row" id="orderdisplay">

            <div class="col-lg-10 offset-md-1">
                <hr>
                @foreach($gameTurns->reverse() as $gameTurn)
                    <p class="float-right datetime">{{date('H:i d-M-Y', strtotime($gameTurn->created_at))}}</p>
                    <h4>
                        @auth
                            @if( Auth::User()->id == $gameSession->user_id)
                                @include("gamesessions._partials.menuTurnActions")
                            @endif
                        @endauth{{$gameTurn->title}}</h4>

                    @if($gameTurn->locked == true)
                        <p class="text-left statut">statut : <i class="fas fa-lock"></i></p>
                    @elseif($gameTurn->locked == false)
                        <p class="text-left">statut : <i class="fas fa-lock-open"></i></p>
                    @endif


                    <div class="text-left">{!! $gameTurn->description!!}</div>
                    @auth
                        @if($gameTurn->id == $lastTurnId and $canSendOrder == true and $gameTurn->locked == false)
                            @include("gamesessions.modals.modalTurnOrders")
                        @endif
                    @endauth
                    <ul class="timeline">

                        @foreach($orders->reverse() as $order)
                            @if($order->gameturn_id == $gameTurn->id)
                                <li>
                                    <div class="text-left">
                                        @auth
                                            @if($gameTurn->locked == false and $order->user_id == Auth::User()->id)
                                                @include('gamesessions._partials.menuOrderActions')
                                            @endif
                                        @endauth
                                        {{date('H:i d-M-y', strtotime($order->orderDate))}} {{$order->name}}
                                        : {!! $order->message!!}
                                        @auth
                                            @if($gameTurn->locked == false and $order->user_id == Auth::User()->id)
                                                @include('gamesessions.modals.modalDropzoneOrder')
                                                @include('gamesessions.modals.modalEditOrder')
                                                @include('gamesessions.modals.modalDeleteOrder')
                                            @endif
                                        @endauth
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    @auth
                        @if(Auth::User()->id == $gameSession->user_id and $gameTurn->locked == false)
                            @include('gamesessions.modals.modalDropzone')
                            @include("gamesessions.modals.modalEditTurn")
                            @include("gamesessions.modals.modalDeleteTurn")

                        @endif
                    @endauth
                    <br/>
                @endforeach
            </div>
        </div>
    </div>


@endsection

