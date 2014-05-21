@extends("layout")
@section("content")

<div class="page-header">
    <h1>Viewing 
            <a href="{{ URL::to("/viewUser/".$user_id) }}">
                @if(Auth::user()->id == $user_id)
                    Your
                @else
                    {{{ $username }}}
                @endif
            </a>
        messages
    </h1>
</div>

@if (isset($messages))
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            Messages: sent: <b>{{$messages->sentCount}}</b> / received: <b>{{$messages->receivedCount}}</b>
        </div>
    </div>
    <div class="panel-body">
        
        <div class='table-responsive'>
        <table class='table'>
            <thead>
                <tr>
                    <th>Message</th>
                    <th>date</th>
                    @if (Auth::check() && Auth::user()->userGroup == 1)
                        <th>Delete</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $message)
                <tr 
                    @if ($message->viewed != 1) class="unreadBold" @endif 
                >
                    <td>
                        
                        <a href="{{URL::to("/viewMessage/".$message->id)}}">
                            {{{ $message->subject }}}
                        </a>

                        @if (isset($message->sent))
                            to <a href="{{ URL::to("/viewUser/".$message->receiver_id) }}">{{{$message->sentTo}}}</a>
                        @elseif (isset($message->received))
                            from <a href="{{ URL::to("/viewUser/".$message->sender_id) }}">{{{$message->receivedFrom}}}</a>
                        @endif
                    </td>
                    
                    <td>
                        {{{ date('d.m.y H:i',strtotime($message->created_at)) }}}
                    </td>
                    
                    @if (Auth::check() && Auth::user()->userGroup == 1)
                    <td>
                        <a href="{{URL::to("/deleteMessage/".$message->id)}}" class="delMsg">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        
    </div>
</div>

<div>
    {{$messages->links()}} <!-- pagination links -->
</div>

@else

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>No messages to show.</b>
        </div>
    </div>
</div>

@endif 
 
@stop