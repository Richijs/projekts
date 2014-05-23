@extends("layout")
@section("content")

<span class="page-control btn-group btn-group-sm">
    <a class="btn btn-default" href="{{URL::to("/viewUser/".$user->id)}}">{{{$user->username}}} {{ trans('buttons.profile') }}</a>
    @if ($user->userGroup!=3)
        <a class="btn btn-default" href="{{URL::to("/viewRecommenders/".$user->id)}}">{{{$user->username}}} {{ trans('buttons.recommenders') }}</a>
    @endif
    <a class="btn btn-default" href="{{URL::to("/viewAllUsers/")}}">{{ trans('buttons.all-site-users') }}</a>
</span>

<div class="page-header">
    <h2>
        {{ trans('titles.users-who') }} <a href="{{URL::to("/viewUser/".$user->id)}}">
            @if (Auth::user()->id == $user->id)
                {{ trans('titles.you') }}
            @else
                {{{$user->username}}}
            @endif
            </a>{{ trans('titles.recommended') }}.
    </h2>
</div>

@if (isset($recommendations))
        
<div class='table-responsive'>
<table class='table'>
    <thead>
        <tr>
            <th>{{ trans('content.user') }}</th>
            <th>{{ trans('content.recommended-at') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($recommendations as $recommendation)
        <tr>
            <td>
                <a href="{{URL::to("/viewUser/".$recommendation->user->id)}}">{{{$recommendation->user->username}}}</a>
                        
                @if (Auth::check() && $recommendation->user->id!=Auth::user()->id && $recommendation->user->userGroup!=3)
                    <a class="btn btn-default btn-xs" href="{{URL::to("/recommend/".$recommendation->user->id)}}">
                    @if ($recommendation->recommended)
                        {{{$recommendation->userRecommends}}}
                        <span class="glyphicon glyphicon-remove-circle"></span>
                    @else
                        {{{$recommendation->userRecommends}}}
                        <span class="glyphicon glyphicon-thumbs-up"></span>
                    @endif
                    </a>
                @endif
            </td>
                    
            <td>
                {{{$recommendation->created_at}}}
            </td>
                    
        </tr>
        @endforeach
    </tbody>
</table>
</div>

<div>
    {{$recommendations->links()}} <!-- pagination links -->
</div>

@else

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>{{ trans('content.no-recommendations-done-yet') }}</b>
        </div>
    </div>
</div>

@endif

@stop