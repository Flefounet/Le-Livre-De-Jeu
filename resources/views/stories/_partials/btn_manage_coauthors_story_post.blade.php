<button type="button" class="btn btn-primary lined thin" data-toggle="modal" data-target="#modalCoAuthors"
        title="ajouter/retirer des co-auteurs pour ce post uniquement">
    <i class="fas fa-users"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="modalCoAuthors" tabindex="-1" role="dialog" aria-labelledby="modalCoAuthors"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {{ Form::open(array('route' => ['story.update.coauthors.post',$story_post->slug], 'method' => 'POST')) }}
            {!! csrf_field() !!}
            <div class="modal-header">
                <h5 class="modal-title" id="modalCoAuthorsLabel"><i class="fas fa-address-card"></i>Co-Auteurs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input class="form-control" id="searchBar" type="text" placeholder="Cherchage de gens..."/>
                <table>

                    <thead>
                    <th scope="col">Selectionner</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Email</th>
                    </thead>
                    <tbody id="usersLists">

                    @foreach($users as$user)
                        @if($user->username <> $author)
                            <tr>
                                @if($user->checked == true)
                                    <td id="selection">{{Form::checkbox("checkBox[]", $user->id, true, ['class'=>'ckbox'])}}</td>
                                @else
                                    <td id="selection">{{Form::checkbox("checkBox[]", $user->id, false, ['class'=>'ckbox'])}}</td>
                                @endif
                                <td>{{$user->username}}</td>
                                <td>{{$user->email}}</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger lined thin" data-dismiss="modal">Annuler</button>
                {{ Form::submit('Valider', ['class' => 'btn btn-secondary lined thin'])}}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
<!--script for search bar-->
<!-- Note that we start the search in tbody, to prevent filtering the table headers-->
<script type="text/javascript">
    $(document).ready(function () {
        $("#searchBar").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#usersLists tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>