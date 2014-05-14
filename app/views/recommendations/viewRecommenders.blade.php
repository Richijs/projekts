@extends("layout")
@section("content")
    
    <div class="page-header">
        <h1>
            Users, who recommended 
            <small><a href="{{URL::to("/viewUser/".$employer->id)}}">{{{$employer->username}}}</a></small>
        </h1>
    </div>






@if (isset($recommenders))
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
                    <th>Recommended at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recommenders as $recommender)
                <tr>
                    <td>
                        <a href="{{URL::to("/viewUser/".$recommender->user->id)}}">{{{$recommender->user->username}}}</a>
                    </td>
                    
                    <td>
                        {{{$recommender->created_at}}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        
    </div>
</div>

<div>
    {{$recommenders->links()}} <!-- pagination links -->
</div>

@else

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>No recommenders yet</b>
        </div>
    </div>
</div>

@endif
    
@stop