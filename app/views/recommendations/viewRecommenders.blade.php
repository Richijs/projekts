@extends("layout")
@section("content")
<h2>Users who recommended <a href="/viewUser/{{{$employer->id}}}">{{{$employer->username}}}</a></h2>
    <div>
        @if (isset($recommenders))
            @foreach ($recommenders as $recommender)
            <div>
                
                <a href="/viewUser/{{{$recommender->user->id}}}">{{{$recommender->user->username}}}</a>
                <b>at</b>
                {{{$recommender->created_at}}}
                
            </div>
            @endforeach
            <div>
                {{$recommenders->links()}} <!-- pagination links -->
            </div>
        @else
            <div>No recommenders yet :(</div>
        @endif
    </div>
@stop