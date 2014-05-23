@extends("layout")
@section("content")

    <span class="page-control btn-group btn-group-sm">
        @if (Auth::user()->userGroup == 3)
            <a class="btn btn-default" href="{{ URL::to("/profile/")}}">{{ trans('buttons.my-profile') }}</a>
            <a class="btn btn-default" href="{{ URL::to("/myJobSeek/")}}">{{ trans('buttons.my-jobseek') }}</a>
        @endif

        @if (Auth::user()->userGroup == 1)
            <a class="btn btn-default" href="{{URL::to("/viewSeeker/".$id)}}">{{ trans('buttons.to-jobseek') }}</a>
            <a class="btn btn-default" href="{{URL::to("/viewAllSeekers")}}">{{ trans('buttons.all-job-seekers') }}</a>
        @endif
    </span>
    
    <div class="page-header">
        <h2>{{ trans('titles.edit-jobseek') }}
            <small>
                <a href="{{URL::to("/viewSeeker/".$id)}}">{{{ $intro }}}</a>
            </small>
        </h2>
    </div>

    {{ Form::open([
        "autocomplete" => "off",
        "enctype"      => "multipart/form-data",
        "file"         => "true",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('intro')) has-error@endif">   
        {{ Form::label("intro", trans('forms.intro-text'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("intro", $intro, [
                "placeholder" => trans('forms.intro-text'),
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("intro"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div class="form-group @if ($errors->first('text')) has-error@endif">    
        {{ Form::label("text", trans('forms.text'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-6">
            {{ Form::textarea("text", $text, [
                "placeholder" => trans('forms.text'),
                "class"       => "form-control",
                "rows"        => "7"
            ]) }}
        </div>
        
        @if ($error = $errors->first("text"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>  
    
    <div class="form-group @if ($errors->first('phone')) has-error@endif">  
        {{ Form::label("phone", trans('forms.phone'),[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("phone", $phone, [
                "placeholder" => trans('forms.phone'),
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("phone"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div> 
    
    <div class="form-group">
        {{ Form::label("currentCV", trans('forms.current-cv'),[
            "class"  => "col-sm-4 control-label"
        ]) }}
            <div class="col-sm-4">
                <a class="btn btn-default" href="{{ URL::to("/getCV/".$id) }}">{{ trans('forms.download-current-cv') }}</a>
            </div>
    </div>
    
    <div class="form-group @if ($errors->first('cv')) has-error@endif">
        {{ Form::label("cv", trans('forms.upload-new-cv'),[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            <div class="form-control">
                {{ Form::file("cv", Input::file("cv"), [
                    "placeholder" => trans('forms.upload-new-cv')
                ]) }}
            </div>
        </div>
        
        @if ($error = $errors->first("cv"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>  
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">    
            {{ Form::submit(trans('buttons.edit-jobseek-data'),["class" => "btn btn-warning btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop