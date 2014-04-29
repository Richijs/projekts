@extends("layout")
@section("content")
    <h2>Editing Job Seek: <a href="/viewSeeker/{{{$id}}}">{{{ $intro }}}</a></h2>

    {{ Form::open([
        //"url"          => URL::route("seekers/edit"),
        "autocomplete" => "off",
        "enctype" => "multipart/form-data",
        "file" => "true"
    ]) }}
    
    <div>    
        {{ Form::label("intro", "Intro text") }}
        {{ Form::text("intro", $intro, [
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
        {{ Form::textarea("text", $text, [
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
        {{ Form::text("phone", $phone, [
            "placeholder" => "Phone number"
        ]) }}
        @if ($error = $errors->first("phone"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div> 
    
    <div> 
        
        <div>
            <a href="{{ URL::to("/getCV/".$id) }}">View Current CV</a>
        </div>
        
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
        {{ Form::submit("Edit JobSeek") }}
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop