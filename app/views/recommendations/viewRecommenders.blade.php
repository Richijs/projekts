@extends("layout")
@section("content")
    
<span class="page-control btn-group btn-group-sm">
    <a class="btn btn-default" href="{{URL::to("/viewUser/".$employer->id)}}">{{{$employer->username}}} {{ trans('buttons.profile') }}</a>
    <a class="btn btn-default" href="{{URL::to("/viewRecommendations/".$employer->id)}}">{{{$employer->username}}} {{ trans('buttons.recommendations') }}</a>
    <a class="btn btn-default" href="{{URL::to("/viewAllUsers/")}}">{{ trans('buttons.all-site-users') }}</a>
</span>

<div class="page-header">
    <h2>
        {{ trans('titles.users-who') }} {{ trans('titles.recommended-us') }}
            <a href="{{URL::to("/viewUser/".$employer->id)}}">
                @if (Auth::user()->id == $employer->id)
                    {{ trans('titles.you') }}
                @else
                    {{{$employer->username}}}
                @endif
            </a>
    </h2>
</div>

@if (isset($recommenders))
<div class='table-responsive'>
    <table class='table'>
    <thead>
        <tr>
            <th>{{ trans('content.user') }}</th>
            <th>{{ trans('content.recommended-at') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($recommenders as $recommender)
        <tr>
            <td>
                <a href="{{URL::to("/viewUser/".$recommender->user->id)}}">{{{$recommender->user->username}}}</a>
            </td>
                    
            <td>
                {{{ date('d.m.y H:i',strtotime($recommender->created_at)) }}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
        
<div>
    {{$recommenders->links()}} <!-- pagination links -->
</div>

@else

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>{{ trans('content.no-recommenders-yet') }}</b>
        </div>
    </div>
</div>

@endif
    
@stop