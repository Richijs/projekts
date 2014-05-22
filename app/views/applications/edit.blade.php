@extends("layout")
@section("content")

    <span class="page-control">
        <a class="btn btn-default btn-sm" href="{{URL::to("/viewUser/".$userId)}}">{{{$userName}}} {{ trans('buttons.profile') }}</a>
        <a class="btn btn-default btn-sm" href="{{URL::to("/viewApplication/".$applicationId)}}">{{ trans('buttons.to-application') }}</a>
        <a class="btn btn-default btn-sm" href="{{URL::to("/viewVacancie/".$vacancieId)}}">{{ trans('buttons.to-vacancie') }}</a>
    </span>

    <div class="page-header">
        <h2>{{ trans('titles.edit') }}
            <small>
                <a href="{{URL::to("/viewApplication/".$applicationId)}}">{{ trans('titles.application-u') }}</a>
            </small>
        </h2>
    </div>
    
    {{ Form::open([
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
      
    <div class="form-group @if ($errors->first('letter')) has-error@endif">    
        {{ Form::label("letter", trans('forms.apply-letter'),[
            "class"  => "col-sm-2 control-label required"
        ]) }}
        
        <div class="col-sm-8">
            {{ Form::textarea("letter", $letter, [
                "placeholder" => trans('forms.letter'),
                "class"       => "form-control",
                "rows"        => "10"
            ]) }}
        </div>
        
        @if ($error = $errors->first("letter"))
            <div class="error col-sm-offset-2 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">  
            {{ Form::submit(trans('forms.edit-application'),["class" => "btn btn-warning btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop