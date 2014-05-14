@extends("layout")
@section("content")
    
    <div class="page-header">
        <h1>Jobs You have applied to, 
            <small>{{{ Auth::user()->username }}}</small>
        </h1>
    </div>
    

@if (isset($applications))
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            You have applied to <b>{{{$applications->count}}}</b> Vacancies
        </div>
    </div>
    <div class="panel-body">
        
        <div class='table-responsive'>
        <table class='table'>
            <thead>
                <tr>
                    <th>Vacancie</th>
                    <th>Applied at</th>
                    <th>View</th>
                    <th>Controls</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applications as $application)
                <tr>
                    <td>
                        <a href="{{URL::to("/viewVacancie/".$application->vacancieId)}}">
                            {{{ $application->vacancieName }}}
                        </a>
                    </td>
                    
                    <td>
                        {{{ date('d.m.y H:i',strtotime($application->created_at)) }}}
                    </td>
                    
                    <td>
                        <a class="btn btn-default" href="{{URL::to("/viewApplication/".$application->id)}}">View Your application</a>
                    </td>
                    
                    <td>
                        <a class="btn btn-warning" href="/editApplication/{{{$application->id}}}">edit application letter data</a>
                        <a class="btn btn-danger" href="/deleteApplication/{{{$application->id}}}">delete application letter data</a>
                    </td>
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
            <b>Havent applied any Vacancies yet.</b>
        </div>
    </div>
</div>

@endif

@stop