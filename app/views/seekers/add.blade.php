@extends("layout")
@section("content")
    <h2>Add Job Seeker Data</h2>

    {{ Form::open([
        "url"          => URL::route("seekers/add"),
        "autocomplete" => "off",
        "enctype" => "multipart/form-data",
        "file" => "true"
    ]) }}
    
    <div>    
        {{ Form::label("intro", "Intro text") }}
        {{ Form::text("intro", Input::get("intro"), [
            "placeholder" => "Intro text"
        ]) }}
        @if ($error = $errors->first("intro"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div>    
        {{ Form::label("text", "Main Text") }}
        {{ Form::textarea("text", Input::get("text"), [
            "placeholder" => "Main Text"
        ]) }}
        @if ($error = $errors->first("text"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>  
    
    <div>    
        {{ Form::label("phone", "Phone number") }}
        {{ Form::text("phone", Input::get("phone"), [
            "placeholder" => "Phone number"
        ]) }}
        @if ($error = $errors->first("phone"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div>   
        {{ Form::label("cv", "Your CV") }}
        {{ Form::file("cv", Input::file("cv"), [ //input::get varbūt???  lkm input::old nestrādā uz file :(
            "placeholder" => "CV"
        ]) }}
        @if ($error = $errors->first("cv"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>  
    
    <div>   
        {{ Form::submit("Add JobSeek",["class" => "btn btn-success"]) }}
    </div>
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop