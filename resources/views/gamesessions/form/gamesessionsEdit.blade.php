@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Edit GameSession Form -->

{!! Form::model($gamesession, array('route' => array('gamesession.update', $gamesession->id),'method' => 'PUT')) !!}
{!! csrf_field() !!}

<ul>

    <li>
        {!! Form::label('title', 'Title:') !!}
        {!! Form::text('title', $gamesession->title) !!}
    </li>
    <li>
        {!! Form::label('game', 'Game:') !!}
        {!! Form::text('game',  $gamesession->game) !!}
    </li>
    <li>
        {!! Form::label('description', 'Description:') !!}
        {!! Form::textarea('description',  $gamesession->description) !!}
    </li>

</ul>
<p>Joueurs actuels</p>
<table>
    <thead>
    <th>Pseudo</th>
    <th>Role</th>
    </thead>
<tr>
    @foreach($gamemasters as $gamemaster)

        <td>{{$gamemaster->getusers->name}}</td>
        <td>Maitre de jeu</td>

    @endforeach
</tr>
    @foreach($players as $player)
        <tr>
            <td>{{$player->getusers->name}}</td>
            <td><p>Joueur</p></td>
        </tr>
    @endforeach
</table>
<!--this button allows to expand the users' list through a collapsible-->
<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseUserList"
        aria-expanded="false" aria-controls="collapseUserList">
    Ajouter des joueurs
</button>

<div class="collapse" id="collapseUserList">
    <div class="card card-body">

        <!--note that search is inserted in body to avoid searching headers-->

        <input class="form-control" id="searchBar" type="text" placeholder="Cherchage de gens..."/>
        <table>

            <thead>
            <th>Sélectionner</th>
            <th scope="col">pseudo</th>
            <th scope="col">email</th>
            </thead>
            <tbody id="usersLists">

            @foreach($users as $user)
                <tr>
                    @if($user->checked == 'true')
                        <td id="selection">{{Form::checkbox("checkBox[]", $user->id, true, ['class'=>'ckbox'])}}</td>
                    @else
                        <td id="selection">{{Form::checkbox("checkBox[]", $user->id, false, ['class'=>'ckbox'])}}</td>
                    @endif
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

{!! Form::submit() !!}
{!! Form::close() !!}