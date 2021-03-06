<ul>

    <li>
        {!! Form::label('title', 'Titre:') !!}
        {!! Form::text('title', $gameSession->title) !!}
    </li>
    <li>
        {!! Form::label('game', 'Jeu:') !!}
        {!! Form::text('game',  $gameSession->game) !!}
    </li>
    <li>
        {!! Form::label('description', 'Description:') !!}
        {!! Form::textarea('description',  $gameSession->description,['id'=>'gamessessionEditDescription']) !!}
    </li>

</ul>
<p>Joueurs actuels</p>
<table class="table-bordered">
    <thead>
    <tr>
        <th scope="col">Pseudo</th>
        <th scope="col">Role</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        @foreach($gamemaster as $gm)
            <td>{{$gm->getusers->username}}</td>
            <td>Maitre de jeu</td>
        @endforeach
    </tr>
    @foreach($players as $player)
        <tr>
            <td>{{$player->getusers->username}}</td>
            <td><p>Joueur</p></td>
        </tr>
    @endforeach
    </tbody>
</table>
<!--this button allows to expand the users' list through a collapsible-->
<button class="btn btn-secondary lined thin" type="button" data-toggle="collapse" data-target="#collapseUserList"
        aria-expanded="false" aria-controls="collapseUserList">
    Ajouter des joueurs
</button>

<div class="collapse" id="collapseUserList">
    <div class="card card-body">

        <!--note that search is inserted in body to avoid searching headers-->

        <input class="form-control" id="searchBar" type="text" placeholder="Cherchage de gens..."/>
        <table>

            <thead>
            <tr>
                <th>Sélectionner</th>
                <th scope="col">pseudo</th>

            </tr>
            </thead>
            <tbody id="usersLists">

            @foreach($users as $user)
                <tr>
                    @if($user->checked == 'true')
                        <td id="selection">{{Form::checkbox("checkBox[]", $user->id, true, ['class'=>'ckbox'])}}</td>
                    @else
                        <td id="selection">{{Form::checkbox("checkBox[]", $user->id, false, ['class'=>'ckbox'])}}</td>
                    @endif
                    <td><p>{{$user->username}}</p></td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>


<script>
    CKEDITOR.replace( 'gamessessionEditDescription' );
</script>