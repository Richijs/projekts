@extends("layout")
@section("content")
    
    <div class="page-header">
        <h1>
            All Job Searchers
        </h1>
    </div>


@if (isset($seekers))
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            Job Searcher List
        </div>
    </div>
    <div class="panel-body">
        
        <div class='table-responsive'>
        <table class='table'>
            <thead>
                <tr>
                    <th>Job Search</th>
                    <th>Added by</th>
                    <th>Actions</th>
                    <th>Searching since</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($seekers as $seeker)
                <tr>
                    <td>
                        <a href="{{URL::to("/viewSeeker/".$seeker->id)}}">{{{ $seeker->intro }}}</a>
                    </td>
                    
                    <td>
                        <a href="{{URL::to("/viewUser/".$seeker->user_id)}}">{{{ $seeker->creatorName }}}</a>
                    </td>
                    
                    <td>
                        <a class="btn btn-default" href="{{ URL::to("/getCV/".$seeker->id) }}">DOWNLOAD CV</a>
                        @if (Auth::check() && Auth::user()->userGroup==1)
                            <a class="btn btn-warning" href="{{URL::to("/editJobSeek/".$seeker->id)}}">edit Job Searcher data</a>
                            <a class="btn btn-danger" href="{{URL::to("/deleteJobSeek/".$seeker->id)}}">delete Job Searcher data</a>
                        @endif
                    </td>
                    
                    <td>
                        {{{ date('d.m.y H:i',strtotime($seeker->created_at)) }}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        
    </div>
</div>

<div>
    {{$seekers->links()}} <!-- pagination links -->
</div>

@else

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>No Job searchers to show.</b>
        </div>
    </div>
</div>

@endif

@stop