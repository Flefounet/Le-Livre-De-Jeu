@foreach($uploadedFiles as $uploadedFile)
        @if($uploadedFile->user_id == $gamemaster->id)
            <tr>
                <td>
                    {{$uploadedFile->created_at}}
                </td>
                <td>
                    {{$gamemaster->username}}
                </td>
                <td>
                    {{$uploadedFile->original_name}}
                </td>
                @foreach($orders as $order)
                    @if($order->message != "" and $order->gameturn_id == $gameTurn->id and ($order->user_id ==  $gamemaster->id))

                        <td>
                            <p>{!! $order->message !!}</p>
                        </td>
                    @endif
                @endforeach
            </tr>
            @break
        @endif
@endforeach