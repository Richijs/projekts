@extends("layout")
@section("content")

<div class="page-header">
    <h1>Viewing message</h1>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <a href="{{URL::to("/viewMessage/".$message->id)}}">{{{ $message->subject }}}</a>
        </div>
    </div>

    
    
    <div class="panel-body col-sm-8 col-sm-offset-2">
        @if ($message->sender_id != Auth::user()->id)
            from <a href="{{URL::to("/viewUser/".$message->sender_id)}}">{{{ $message->senderName }}}</a>
        @endif
        
        @if ($message->receiver_id != Auth::user()->id) 
            to <a href="{{URL::to("/viewUser/".$message->receiver_id)}}">{{{ $message->receiverName }}}</a>
        @endif
        
        at {{{ date('d.m.y H:i',strtotime($message->created_at)) }}}
        
        @if ($message->sender_id != Auth::user()->id && $message->receiver_id == Auth::user()->id)
            <a class="btn btn-default" href="{{URL::to("/sendMessage/".$message->sender_id)}}">Reply</a>
        @endif
        
            <div class="newlineText well well-sm">{{{$message->message}}}</div>
    </div>
</div>

@stop