@extends("layout")
@section("content")

    <div class="page-header">
        <h2>
            Users <a href="{{URL::to("/viewUser/".$user->id)}}">
                @if (Auth::user()->id == $user->id)
                    You
                @else
                    {{{$user->username}}}
                @endif
            </a>recommended.
        </h2>
    </div>



@if (isset($recommendations))
        
        <div class='table-responsive'>
        <table class='table'>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Recommended At</th>
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
            <b>No recommendations done yet</b>
        </div>
    </div>
</div>

@endif

@stop