@extends("layout")
@section("content")

    <span class="page-control btn-group btn-group-sm">
        @if ($message->sender_id != Auth::user()->id && $message->receiver_id == Auth::user()->id)
            <a class="btn btn-default" href="{{URL::to("/sendMessage/".$message->sender_id)}}">{{ trans('buttons.reply') }}</a>
        @endif
        
        @if ($message->sender_id != Auth::user()->id)
            <a class="btn btn-default" href="{{URL::to("/viewUser/".$message->sender_id)}}">{{{ $message->senderName }}} {{ trans('buttons.profile') }}</a>
        @endif
        
        @if ($message->receiver_id != Auth::user()->id) 
            <a class="btn btn-default" href="{{URL::to("/viewUser/".$message->receiver_id)}}">{{{ $message->receiverName }}} {{ trans('buttons.profile') }}</a>
        @endif
        
        <a class="btn btn-default" href="{{URL::to("/viewMessages/".Auth::user()->id)}}">{{ trans('buttons.to-my-messages') }}</a>
        <a class="btn btn-default" href="{{URL::to("/viewAllUsers/")}}">{{ trans('buttons.all-site-users') }}</a>
    </span>

    <div class="page-header">
        <h2>{{ trans('titles.viewing-message') }}</h2>
    </div>

    <div class="panel-body col-sm-8 col-sm-offset-2">
        <b>{{{ $message->subject }}}</b>
        
        @if ($message->sender_id != Auth::user()->id)
            {{ trans('content.from') }} <a href="{{URL::to("/viewUser/".$message->sender_id)}}">{{{ $message->senderName }}}</a>
        @endif
        
        @if ($message->receiver_id != Auth::user()->id) 
            {{ trans('content.to') }} <a href="{{URL::to("/viewUser/".$message->receiver_id)}}">{{{ $message->receiverName }}}</a>
        @endif
        
        {{ trans('content.at') }} {{{ date('d.m.y H:i',strtotime($message->created_at)) }}}
        
       <div class="newlineText well well-sm">{{{$message->message}}}</div>
    </div>

@stop