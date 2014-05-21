@extends("layout")
@section("content")

<div class="page-header">
    <h1>Viewing message</h1>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <a href="{{URL::to("/viewMessage/".$message->id)}}">{{{ $message->subject }}}</a>
        </div>
    </div>

    
    
    <div class="panel-body">
        
            <div class="newlineText well well-sm">{{{$message->message}}}</div>
    </div>
</div>

@stop