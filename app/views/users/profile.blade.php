@extends("layout")
@section("content")

    <span class="page-control btn-group btn-group-sm">
        <a class="btn btn-warning" href="{{{ URL::to("/editUser/".Auth::user()->id) }}}">{{trans('buttons.edit-profile')}}</a>                
        <a class="btn btn-warning" href="{{{ URL::to("/changePass") }}}">{{ trans('titles.change-password') }}</a>
        <a class="btn btn-danger" href="{{{ URL::to("/deleteUser/".Auth::user()->id) }}}">{{ trans('buttons.delete-profile') }}</a>
    </span>

    <div class="page-header">
        <h2>{{ trans('titles.hello') }}, <a href="{{{ URL::to("/viewUser/".Auth::user()->id) }}}">{{{ Auth::user()->username }}}</a>
            <div><small>{{ trans('titles.your-profile-page') }}</small></div>
        </h2>
    </div>


 <ul class="list-group col-sm-offset-1 col-sm-6">
     
    <li class="list-group-item profileImg pull-right">
        <div>
            @if (Auth::user()->picture)
                <img class="img-thumbnail" src="{{URL::to('/')}}/{{{Auth::user()->picture}}}" width="400" alt="user picture"/>
            @else
                <img class="img-thumbnail" src="{{URL::to('/')}}/uploads/profileImages/default.jpeg" width="400" alt="profile picture"/>
            @endif     
        </div>
    </li>
    
    <div class="clearfix"></div>
                  
    <li class="list-group-item">
        {{ trans('forms.username') }}: <b>{{{Auth::user()->username}}}</b>
    </li>
    
    <li class="list-group-item">
        {{ trans('forms.firstname') }}: <b>{{{Auth::user()->firstname}}}</b>
    </li>
    
    <li class="list-group-item">
        {{ trans('forms.lastname') }}: <b>{{{Auth::user()->lastname}}}</b>
    </li>
    
    <li class="list-group-item">
        {{ trans('forms.email') }}: <b>{{{Auth::user()->email}}}</b>
    </li>
        
    @if (Auth::user()->about)
    <li class="list-group-item well-item">
        {{ trans('forms.about') }}: 
        <div class="newlineText well well-sm well-item-inside"><b>{{{Auth::user()->about}}}</b></div>
    </li>
    @endif
        
    <li class="list-group-item">
        {{ trans('forms.usergroup') }}:
        <b>
            @if (Auth::user()->userGroup===1) {{ trans('forms.admin') }} @endif
            @if (Auth::user()->userGroup===2) {{ trans('forms.employer') }} @endif
            @if (Auth::user()->userGroup===3) {{ trans('forms.job-seeker') }} @endif
        </b>
    </li>
    
    <li class="list-group-item">
        {{ trans('content.joined') }}: <b>{{{ date('d.m.y H:i',strtotime(Auth::user()->created_at))}}}</b>
    </li>
    
</ul>

<div class="btn-group-vertical col-sm-4">
    <a class="btn btn-default" href="{{{ URL::to("/viewRecommendations/".Auth::user()->id) }}}">{{ trans('buttons.users-who-i-recommended') }}</a>

    @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===2)
        <a class="btn btn-default" href="{{{ URL::to("/viewRecommenders/".Auth::user()->id) }}}">{{ trans('buttons.users-who-recommended-me') }}</a>
        <a class="btn btn-default" href="{{{ URL::to("/myVacancies") }}}">{{ trans('buttons.my-vacancies') }}</a>
    @endif

    @if (Auth::user()->userGroup===1 || Auth::user()->userGroup===3)
        <a class="btn btn-default" href="{{{ URL::to("/myJobSeek") }}}">{{ trans('buttons.my-jobseek') }}</a>
        <a class="btn btn-default" href="{{{ URL::to("/myApplications") }}}">{{ trans('buttons.my-applications') }}</a>
    @endif
    
    <a class="btn btn-default" href="{{{ URL::to("/viewMessages/".Auth::user()->id) }}}">{{ trans('buttons.my-messages') }}</a>
</div>   

@stop