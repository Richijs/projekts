@extends("layout")
@section("content")

<span class="page-control btn-group btn-group-sm">
    @if(Auth::user()->id != $user_id)
        <a class="btn btn-default" href="{{ URL::to("/viewUser/".$user_id) }}">{{{ $username }}} {{ trans('buttons.profile') }}</a>
    @elseif (Auth::user()->id == $user_id)
        <a class="btn btn-default" href="{{ URL::to("/profile/") }}">{{ trans('titles.your') }} {{ trans('buttons.profile') }}</a>
    @endif
    
    <a class="btn btn-default" href="{{URL::to("/viewAllUsers/")}}">{{ trans('buttons.all-site-users') }}</a>
</span>

<div class="page-header">
    <h2>
        <a href="{{ URL::to("/viewUser/".$user_id) }}">
            @if(Auth::user()->id == $user_id)
                {{ trans('titles.your') }}
            @else
                {{{ $username }}}
            @endif
        </a> {{ trans('titles.messages') }}
        
        @if (isset($messages))
            <small>
                {{ trans('titles.sent') }}: <b>{{$messages->sentCount}}</b> / {{ trans('titles.received') }}: <b>{{$messages->receivedCount}}</b>
            </small>
        @endif
    </h2>
</div>

@if (isset($messages))
<div class='table-responsive'>
<table class='table'>
    <thead>
        <tr>
            <th>{{ trans('forms.message') }}</th>
            <th>{{ trans('content.date') }}</th>
            <th>{{ trans('content.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($messages as $message)
        <tr @if ($message->viewed != 1) class="unreadBold" @endif>
            <td>
                <a href="{{URL::to("/viewMessage/".$message->id)}}">
                    {{{ $message->subject }}}
                </a>
                @if (isset($message->new))
                    <span class="badge">{{ trans('content.new-a') }}!</span>
                @endif

                @if (isset($message->sent))
                    {{ trans('content.to') }} <a href="{{ URL::to("/viewUser/".$message->receiver_id) }}">{{{$message->sentTo}}}</a>
                @elseif (isset($message->received))
                    {{ trans('content.from') }} <a href="{{ URL::to("/viewUser/".$message->sender_id) }}">{{{$message->receivedFrom}}}</a>
                @endif
            </td>
                    
            <td>
                {{{ date('d.m.y H:i',strtotime($message->created_at)) }}}
            </td>
                    
            <td>
                @if ($message->receiver_id == Auth::user()->id && isset($message->received))
                    <a class="btn btn-default btn-xs" href="{{ URL::to("/sendMessage/".$message->sender_id) }}">{{ trans('buttons.reply') }}</a>
                @endif
                        
                @if (Auth::check() && Auth::user()->userGroup == 1)
                    <a class="btn btn-danger btn-xs" href="{{URL::to("/deleteMessage/".$message->id)}}">
                        {{ trans('buttons.delete-message') }}
                    </a>
                @endif
            </td>
                    
        </tr>
        @endforeach
    </tbody>
</table>
</div>
        
<div>
    {{$messages->links()}} <!-- pagination links -->
</div>

@else

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>{{ trans('content.no-messages-to-show') }}</b>
        </div>
    </div>
</div>

@endif 
 
@stop