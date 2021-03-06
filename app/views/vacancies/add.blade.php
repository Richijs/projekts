@extends("layout")
@section("content")

<span class="page-control btn-group btn-group-sm">
    <a class="btn btn-default" href="{{URL::to("/myVacancies/")}}">{{ trans('buttons.my-vacancies') }}</a>
    <a class="btn btn-default" href="{{URL::to("/viewAllVacancies/")}}">{{ trans('buttons.all-vacancies') }}</a>
</span>

<div class="page-header">
    <h2>
        {{ trans('titles.add-vacancie') }}
    </h2>
</div>

    {{ Form::open([
        "url"          => URL::route("vacancies/add"),
        "autocomplete" => "off",
        "enctype"      => "multipart/form-data",
        "file"         => "true",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('name')) has-error@endif">   
        {{ Form::label("vacancieName", trans('forms.vacancie-name'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("name", Input::get("name"), [
                "placeholder" => trans('forms.vacancie-name'),
                "class"       => "form-control"
            ]) }}
        </div>    
            
        @if ($error = $errors->first("name"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group @if ($errors->first('text')) has-error@endif">    
        {{ Form::label("vacancieText", trans('forms.text'),[
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
    
    <div class="form-group @if ($errors->first('company')) has-error@endif"> 
        {{ Form::label("company", trans('forms.company-name'),[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("company", Input::get("company"), [
                "placeholder" => trans('forms.company-name'),
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("company"))
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
    
    <div class="form-group @if ($errors->first('poster')) has-error@endif"> 
        {{ Form::label("poster", trans('forms.poster'),[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            <div class="form-control">
                {{ Form::file("poster", Input::file("poster"), [
                    "placeholder" => trans('forms.poster')
                ]) }}
            </div>
        </div>
        
        @if ($error = $errors->first("poster"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div> 
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">  
            {{ Form::submit(trans('titles.add-vacancie'),["class" => "btn btn-success btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop