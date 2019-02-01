@extends('layouts.app')

@section('head')

@endsection

@section('js')
    <!--<script src="{{ url('/js/jquery.js') }}"></script>-->
    <script src="{{ url('/js/dropzone.js') }}"></script>
    <script src="{{ url('/js/dropzone-config.js') }}"></script>
@endsection

@section('content')
    @if(session('message'))
        <div class='alert alert-success'>
            {{ session('message') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Top strip -->
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
        <div class="row">
            <div class="col-md-9 nopadding">
                <div id="card_container_auto">
                    <div id="card">

                        <div class="shine"></div>
                        <div class="text-block gamesession-description">

                            <h3 class="welcome-card-title yellow">{{$gameSession->title}}
                            </h3>
                            <p>Créée le:{{date('d-M-Y à H:i', strtotime($gameSession->created_at))}}</p>
                            {!!  $gameSession->description !!}
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-3 nopadding">
                <div id="card_container_auto">
                    <div class="evenboxinner">{{$gameSession->game}}</div>
                    <div id="card">

                        <div class="shine"></div>
                        <div class="text-block">
                            <br/>
                            <p><strong>Maitre de jeu :</strong>
                                @foreach($gamemaster as $gm)
                                    {{$gm->getusers->name}}
                                @endforeach
                                <br/>
                                <strong>Joueurs :</strong>
                                @foreach($players as $player)
                                    @if($loop->last)
                                        {{$player->getusers->name}}
                                    @else
                                        {{$player->getusers->name}} -

                                    @endif
                                @endforeach</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--End top strip-->
        <!-- game master actions strip -->
        @auth
            @if(Auth::User()->id == $gameSession->user_id or Auth::User()->status == 'Admin' )
                <div class="row strip">
                    <div class="vignette blue-bg">
                        <div class="col-lg-9 offset-lg-1">

                            @include("gamesessions.modals.modalAddTurn")
                            @include("gamesessions.modals.modalGameSessionEdit")
                            @include("gamesessions.modals.modalDeleteGameSession")

                        </div>
                    </div>
                </div>
            @endif
        @endauth

    <!--end game master acctions strip-->

        <!--turn strip left pane is turn, left pane are associated orders-->
        @foreach($gameTurns->reverse() as $gameTurn)
            <div class="row strip" id="orderdisplay">
                <div class="col-lg-6 vignette padding-5px-left green-bg">
                    <div class="evenboxinner-turn">Le {{date('d-M-Y à H:i', strtotime($gameTurn->created_at))}}</div>
                    <h4 class="padding-10px-top">
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


                    <div class="text-left turn-description">{!! $gameTurn->description!!}</div>
                    @auth
                        @if($gameTurn->id == $lastTurnId and $canSendOrder == true and $gameTurn->locked == false)
                            @include("gamesessions.modals.modalTurnOrders")
                        @endif
                    @endauth
                    @auth
                        @if( Auth::User()->id == $gameSession->user_id)
                            @include("gamesessions.modals.modalTurnNotification")
                        @endif
                    @endauth
                    @auth
                        @if(Auth::User()->id == $gameSession->user_id and $gameTurn->locked == false)
                            @include('gamesessions.modals.modalDropzone')
                            @include("gamesessions.modals.modalEditTurn")
                            @include("gamesessions.modals.modalDeleteTurn")

                        @endif
                    @endauth
                </div>
                <div class="col-lg-6 strip-left white-bg ">
                    <div class="col-12 vignette orange-bg all-auto float-right">
                        @foreach($orders->reverse() as $order)
                            @if($order->gameturn_id == $gameTurn->id)
                                <div class="text-orders">
                                    <p>{{date('H:i d-M-y', strtotime($order->orderDate))}} {{$order->name}}:</p>


                                </div>
                                <div class="text-orders">{!!$order->message!!}     @auth
                                        @if(($gameTurn->locked == false and $order->user_id == Auth::User()->id) or Auth::User()->status == 'Admin')
                                            @include('gamesessions._partials.menuOrderActions')
                                        @endif
                                    @endauth</div>
                                @auth
                                    @if( ($gameTurn->locked == false and $order->user_id == Auth::User()->id) or Auth::User()->status == 'Admin')

                                        @include('gamesessions.modals.modalDropzoneOrder')
                                        @include('gamesessions.modals.modalEditOrder')
                                        @include('gamesessions.modals.modalDeleteOrder')
                                    @endif
                                @endauth


                            @endif

                        @endforeach
                    </div>
                </div>
                <br/>
            </div>
    @endforeach
    <!--end turn strip-->

    </div>




@endsection

