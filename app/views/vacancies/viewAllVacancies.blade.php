@extends("layout")
@section("content")
    
<div class="page-header">
    <h1>
        Vacancies
    </h1>
</div>

  
@if (isset($vacancies))
<!--<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            All Vacancie List
        </div>
    </div>
    <div class="panel-body"> -->
        
        <div class='table-responsive'>
        <table class='table'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Poster</th>
                    <th>Applicants</th>
                    <th>Added By</th>
                    <th>Created At</th>
                    @if (Auth::check()) <th>Actions</th> @endif
                </tr>
            </thead>
            <tbody>
            @foreach ($vacancies as $vacancie)
                <tr>
                    <td>
                        <a href="{{URL::to("/viewVacancie/".$vacancie->id)}}">{{{ $vacancie->name }}}</a>
                    </td>
                    
                    <td>
                        {{{$vacancie->company}}} 
                    </td>
                    
                    <td>
                    @if ($vacancie->poster)
                        <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="36" height="36" alt="vacancie poster"/>
                    @else
                        <img src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" width="36" height="36" alt="vacancie poster"/>
                    @endif
                    </td>
                    
                    <td>
                        @if (Auth::check() && (Auth::user()->userGroup == 1 || $vacancie->creator_id==Auth::user()->id))
                        <a class="btn btn-default btn-xs" href="{{URL::to("/viewApplicants/".$vacancie->id)}}">
                            Applied: <b>{{{$vacancie->applied}}}</b>
                        </a>
                        @else
                            Applied: <b>{{{$vacancie->applied}}}</b>
                        @endif
                    </td>
                    
                    <td>
                        <a href="{{URL::to("/viewUser/".$vacancie->creator_id)}}">{{{ $vacancie->creatorName }}}</a>
                        
                        @if (Auth::check() && $vacancie->creator_id!=Auth::user()->id)
                    
                        <a class="btn btn-default btn-xs" href="{{URL::to("/recommend/".$vacancie->creator_id)}}">
                            @if ($vacancie->recommended)
                                {{{$vacancie->userRecommends}}}
                                <span class="glyphicon glyphicon-remove-circle"></span>
                            @else
                                {{{$vacancie->userRecommends}}}
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                            @endif
                        </a>
                   
                        @endif
                        
                    </td>
                    
                    <td>
                        {{{ date('d.m.y H:i',strtotime($vacancie->created_at)) }}}
                    </td>
                    
                   
                    @if (Auth::check())
                        <td>
                        @if ((Auth::user()->userGroup===1 || Auth::user()->userGroup===3) && $vacancie->creator_id!=Auth::user()->id)
                            <a class="btn btn-success btn-xs" href="{{URL::to("/apply/".$vacancie->id)}}">Apply</a>
                        @endif
                        
                        @if (Auth::user()->userGroup == 1 || Auth::user()->id == $vacancie->creator_id)
                            <a class="btn btn-warning btn-xs" href="{{{ URL::to("/editVacancie/".$vacancie->id) }}}">Edit</a>               
                            <a class="btn btn-danger btn-xs" href="{{{ URL::to("/deleteVacancie/".$vacancie->id) }}}">Delete</a>
                        @endif
                        </td>
                    @endif         
                    
                    
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        <!--
    </div>
</div>-->

    <div>
        {{$vacancies->links()}} <!-- pagination links -->
    </div>

@else

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>No Vacancies to show.</b>
        </div>
    </div>
</div>

@endif

@stop