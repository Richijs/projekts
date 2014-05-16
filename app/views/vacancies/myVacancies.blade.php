@extends("layout")
@section("content")

    <div class="page-header">
        <h1>
            Vacancies added by You, <small>{{{ Auth::user()->username }}}</small>
        </h1>
    </div>


        @if (isset($vacancies))
        
 <div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            You have added <b>{{{$vacancies->count}}}</b> vaccancies
        </div>
    </div>
    <div class="panel-body">
        
        <div class='table-responsive'>
        <table class='table'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Poster</th>
                    <th>Applicants</th>
                    <th>Created At</th>
                    <th>Actions</th>
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

                        <img src="{{URL::to('/')}}/{{{$vacancie->poster}}}" width="50" height="50" alt="vacancie poster"/>
                
                    @else
                
                        <img src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" width="50" height="50" alt="vacancie poster"/>
                
                    @endif
                </td>
                        
                <td>
                    <a class="btn btn-default" href="{{URL::to("/viewApplicants/".$vacancie->id)}}">
                        @if (isset($vacancie->new))
                            <span class="badge">new applicants!</span>
                        @endif
                        
                        Applied: <b>{{{$vacancie->applied}}}</b>
                    </a>
                </td>
                
                <td>
                    {{{ date('d.m.y H:i',strtotime($vacancie->created_at)) }}}
                </td>
                
                <td>
                    <a class="btn btn-warning" href="{{URL::to("/editVacancie/".$vacancie->id)}}">edit Vacancie</a>
                    <a class="btn btn-danger" href="{{URL::to("/deleteVacancie/".$vacancie->id)}}">delete Vacancie</a>
                </td>

            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        
    </div>
</div>
        
            <div>
                {{$vacancies->links()}} <!-- pagination links -->
            </div>
        @else

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>You havent added any Vacancies.</b>
        </div>
    </div>
</div>
        
        @endif

@stop