@extends("layout")
@section("content")

<span class="page-control btn-group btn-group-sm">
    @if (Auth::user()->id != $user->id)
        <a class="btn btn-default" href="{{{ URL::to("/sendMessage/".$user->id) }}}">{{ trans('forms.send-message') }}</a>
    @endif
    
    @if (Auth::user()->userGroup == 1)
        <a class="btn btn-warning" href="{{{ URL::to("/editUser/".$user->id) }}}">{{trans('buttons.edit-profile')}}</a>                      
        <a class="btn btn-danger" href="{{{ URL::to("/deleteUser/".$user->id) }}}">{{ trans('buttons.delete-profile') }}</a>
    @endif
    <a class="btn btn-default" href="{{URL::to("/viewAllUsers/")}}">{{ trans('buttons.all-site-users') }}</a>
</span>

<div class="page-header">
    <h2>
        <a href="{{ URL::to("/viewUser/".$user->id) }}">{{{ $user->username }}}</a> 
        <small>{{ trans('titles.public-profile') }}</small>
    </h2>
</div>
    
<ul class="list-group col-sm-offset-1 col-sm-6">
     
    <li class="list-group-item profileImg pull-right">
        <div>
            @if ($user->picture)
                <img class="img-thumbnail" src="{{URL::to('/')}}/{{{$user->picture}}}" width="200" alt="user picture"/>
            @else
                <img class="img-thumbnail" src="{{URL::to('/')}}/uploads/profileImages/default.jpeg" width="200" alt="profile picture"/>
            @endif     
        </div>
    </li>
    
    <div class="clearfix"></div>
                  
    <li class="list-group-item">
        {{ trans('forms.username') }}: <b>{{{$user->username}}}</b>
        @if (Auth::check() && $user->id!=Auth::user()->id && $user->userGroup!=3)      
            <a class="btn btn-default btn-xs" href="{{URL::to("/recommend/".$user->id)}}">
                @if ($user->recommended)
                    {{{$user->userRecommends}}}
                    <span class="glyphicon glyphicon-remove-circle"></span>
                @else
                    {{{$user->userRecommends}}}
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                @endif
            </a>
        @endif
    </li>
    
    <li class="list-group-item">
        {{ trans('forms.firstname') }}: <b>{{{$user->firstname}}}</b>
    </li>
    
    <li class="list-group-item">
        {{ trans('forms.lastname') }}: <b>{{{$user->lastname}}}</b>
    </li>
    
    <li class="list-group-item">
        {{ trans('forms.email') }}: <b><a href="mailto:{{{$user->email}}}">{{{$user->email}}}</a></b>
    </li>
        
    @if ($user->about)
    <li class="list-group-item well-item">
        {{ trans('forms.about') }}: 
        <div class="newlineText well well-sm well-item-inside"><b>{{{$user->about}}}</b></div>
    </li>
    @endif
        
    <li class="list-group-item">
        {{ trans('forms.usergroup') }}:
        <b>
            @if ($user->userGroup===1) {{ trans('forms.admin') }} @endif
            @if ($user->userGroup===2) {{ trans('forms.employer') }} @endif
            @if ($user->userGroup===3) {{ trans('forms.job-seeker') }} @endif
        </b>
    </li>
    
    <li class="list-group-item">
        {{ trans('content.joined') }}: <b>{{{ date('d.m.y H:i',strtotime($user->created_at))}}}</b>
    </li>
    
    @if ($user->active!=1)
    <li class="list-group-item list-group-item-danger">
       {{ trans('content.user-has-not-yet-activated-account') }}
    </li>
    @endif
    
</ul>

<div class="btn-group-vertical col-sm-4">
    <a class="btn btn-default" href="{{{ URL::to("/viewRecommendations/".$user->id) }}}">
        {{{$user->username}}} {{ trans('buttons.recommendations') }}
    </a>

    @if ($user->userGroup===1 || $user->userGroup===2)
        <a class="btn btn-default" href="{{{ URL::to("/viewRecommenders/".$user->id) }}}">
            {{{$user->username}}} {{ trans('buttons.recommenders') }}
        </a>
    @endif

    @if (isset($seeker) && ($seeker->user_id == Auth::user()->id || Auth::user()->userGroup == 1 || Auth::user()->userGroup == 2))
        <a class="btn btn-info" href="{{{ URL::to("/viewSeeker/".$seeker->id) }}}">{{{$user->username}}} {{trans('buttons.is-searching-for-job') }}</a>
    @endif
    
    @if (Auth::user()->userGroup===1)
        <a class="btn btn-default" href="{{{ URL::to("/viewMessages/".$user->id) }}}">{{{$user->username}}} {{trans('titles.messages') }}</a>
    @endif
</div>   

@stop