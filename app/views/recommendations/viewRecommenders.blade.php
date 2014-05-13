@extends("layout")
@section("content")
    
    <div class="page-header">
        <h1>
            Users who recommended 
            <small><a href="/viewUser/{{{$employer->id}}}">{{{$employer->username}}}</a></small>
        </h1>
    </div>

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