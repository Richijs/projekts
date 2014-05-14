@extends("layout")
@section("content")

    <div class="page-header">
        <h1>
            @if (Auth::user()->id == $user->id)
                Users, who <a href="{{URL::to("/viewUser/".$user->id)}}">You</a> have recommended.
            @else
                Users, who <a href="{{URL::to("/viewUser/".$user->id)}}">{{{$user->username}}}</a> has recommended.
            @endif
        </h1>
    </div>



@if (isset($recommendations))
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">
            
        </div>
    </div>
    <div class="panel-body">
        
        <div class='table-responsive'>
        <table class='table'>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Recommended</th>
                    <th>Controls</th>
                    <th>Recommended At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recommendations as $recommendation)
                <tr>
                    <td>
                        <a href="{{URL::to("/viewUser/".$recommendation->user->id)}}">{{{$recommendation->user->username}}}</a>
                    </td>
                    
                    <td>
                        <a href="{{URL::to("/viewRecommenders/".$recommendation->user->id)}}">
                            <b>{{{$recommendation->userRecommends}}}</b> times
                        </a>
                    </td>
                    
                    <td>
                        @if (Auth::check() && $recommendation->user->id!=Auth::user()->id && $recommendation->user->userGroup!=3)
                        <a class="btn btn-default" href="{{URL::to("/recommend/".$recommendation->user->id)}}">
                            @if ($recommendation->recommended)
                                <span class="glyphicon glyphicon-remove-circle"></span>
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                            @else
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
        
    </div>
</div>

<div>
    {{$recommendations->links()}} <!-- pagination links -->
</div>

@else

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>No recommendations done yet</b>
        </div>
    </div>
</div>

@endif

@stop