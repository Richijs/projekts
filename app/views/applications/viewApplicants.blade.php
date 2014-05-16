@extends("layout")
@section("content")

    <div class="page-header">
        <h1>Applicants applied for 
            <small><a href="{{URL::to("/viewVacancie/".$applications->vacancie->id)}}">{{{$applications->vacancie->name}}}</a></small>
        </h1>
    </div>

@if (isset($applications))
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <b>{{{$applications->count}}}</b> Applicants have applied!
        </div>
    </div>
    <div class="panel-body">
        
        <div class='table-responsive'>
        <table class='table'>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Applied at</th>
                    <th>View</th>
                    @if (Auth::user()->userGroup == 1) <th>Controls</th> @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($applications as $application)
                <tr>
                    <td>
                        <a href="{{URL::to("/viewUser/".$application->user->id)}}">{{{$application->user->username}}}</a>
                    </td>
                    
                    <td>
                        {{{ date('d.m.y H:i',strtotime($application->created_at)) }}}
                    </td>
                    
                    <td>
                        <a class="btn btn-default" href="{{URL::to("/viewApplication/".$application->id)}}">
                            view {{{$application->user->username}}} application
                        </a>
                    </td>
                    @if (Auth::user()->userGroup == 1)
                    <td>
                        <a class="btn btn-warning" href="{{URL::to("/editApplication/".$application->id)}}">
                            edit application
                        </a>
                        <a class="btn btn-danger" href="{{URL::to("/deleteApplication/".$application->id)}}">
                            delete application
                        </a>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        
    </div>
</div>

<div>
    {{$applications->links()}} <!-- pagination links -->
</div>

@else

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>No one applied yet..</b>
        </div>
    </div>
</div>

@endif



        
@stop