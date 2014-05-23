@extends("layout")
@section("content")
 
    <span class="page-control btn-group btn-group-sm">
        <a class="btn btn-default" href="{{ URL::to("/profile/")}}">{{ trans('buttons.my-profile') }}</a>
        @if (Auth::user()->userGroup == 1)
            <a class="btn btn-default" href="{{ URL::to("/viewAllSeekers/")}}">{{ trans('buttons.all-job-seekers') }}</a>
        @endif
    </span>

    <div class="page-header">
        <h2>
            {{ trans('titles.add-jobseek-data') }}
        </h2>
    </div>

    {{ Form::open([
        "url"          => URL::route("seekers/add"),
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
            {{ Form::text("intro", Input::get("intro"), [
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
            {{ Form::textarea("text", Input::get("text"), [
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
            {{ Form::text("phone", Input::get("phone"), [
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
    
    <div class="form-group @if ($errors->first('cv')) has-error@endif"> 
        {{ Form::label("cv", trans('forms.your-cv'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            <div class="form-control">
                {{ Form::file("cv", Input::file("cv"), [
                    "placeholder" => trans('forms.your-cv')
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
            {{ Form::submit(trans('titles.add-jobseek-data'),["class" => "btn btn-success btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop