@extends("layout")
@section("content")

<span class="page-control btn-group btn-group-sm">
    <a class="btn btn-default" href="{{ URL::to("/profile/")}}">{{ trans('buttons.my-profile') }}</a>
</span>

<div class="page-header">
    <h2>
        {{trans('titles.all-users')}}
    </h2>
</div>

@if (isset($users))
 
<div class='table-responsive'>
<table class='table'>
    <thead>
        <tr>
            <th>{{trans('content.user')}}</th>
            <th>{{trans('forms.picture')}}</th>
            <th>{{trans('forms.usergroup')}}</th>
            <th>{{trans('content.joined')}}</th>
            @if (Auth::check() && Auth::user()->userGroup==1)
                <th>{{trans('content.status')}}</th>
            @endif
            <th>{{trans('content.actions')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
              
        <td>
            <a href="{{ URL::to("/viewUser/".$user->id)}}">{{{ $user->username }}}</a>
        </td>    
            
        <td>  
            @if ($user->picture)
                <img src="{{URL::to('/')}}/{{{$user->picture}}}" width="36" height="36" alt="user picture"/>
            @else
                <img src="{{URL::to('/')}}/uploads/profileImages/default.jpeg" width="36" height="36" alt="profile picture"/>
            @endif
        </td>
                   
        <td>
            @if ($user->userGroup===1) {{trans('forms.admin')}} @endif
            @if ($user->userGroup===2) {{trans('forms.employer')}} @endif
            @if ($user->userGroup===3) {{trans('forms.job-seeker')}} @endif
        </td>    
                
        <td>
            {{{ date('d.m.y H:i',strtotime($user->created_at)) }}}
        </td>
        
        @if (Auth::check() && Auth::user()->userGroup==1)
            <td>
                @if ($user->active===1)
                    {{trans('content.active')}}
                @else
                    {{trans('content.not-activated')}}
                @endif
            </td>
        @endif
                
        <td>
            @if (Auth::user()->id != $user->id)
                <a class="btn btn-default btn-xs" href="{{{ URL::to("/sendMessage/".$user->id) }}}">{{ trans('forms.send-message') }}</a>
            @endif    
                
            @if (Auth::check() && Auth::user()->userGroup==1 && Auth::user()->id!=$user->id)
                <a class="btn btn-warning btn-xs" href="{{{ URL::to("/editUser/".$user->id) }}}">{{trans('buttons.edit-profile')}}</a>
                <a class="btn btn-danger btn-xs" href="{{{ URL::to("/deleteUser/".$user->id) }}}">{{trans('buttons.delete-profile')}}</a>
            @elseif (Auth::check() && Auth::user()->userGroup==1 && Auth::user()->id==$user->id)
                <a class="btn btn-warning btn-xs" href="#" disabled="disabled">{{trans('buttons.edit-profile')}}</a>
                <a class="btn btn-danger btn-xs" href="#" disabled="disabled">{{trans('buttons.delete-profile')}}</a>
            @endif
        </td>
                
        </tr>
    @endforeach
    </tbody>
    
</table>
</div>

<div>
    {{$users->links()}} <!-- pagination links -->
</div>
@else
           
<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>{{trans('content.no-users-to-show')}}</b>
        </div>
    </div>
</div>       
              
@endif
    
@stop