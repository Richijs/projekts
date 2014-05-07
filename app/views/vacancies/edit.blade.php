@extends("layout")
@section("content")
    <h2>Editing vacancie: <a href="/viewVacancie/{{{$id}}}">{{{ $name }}}</a></h2>

    {{ Form::open([
        //"url"          => URL::route("vacancies/edit"),
        "autocomplete" => "off",
        "enctype" => "multipart/form-data",
        "file" => "true"
    ]) }}
    
    <div>    
        {{ Form::label("vacancieName", "Vacancie Name") }}
        {{ Form::text("name", $name, [
            "placeholder" => "Vacancie Name"
        ]) }}
        @if ($error = $errors->first("name"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div>    
        {{ Form::label("vacancieText", "Vacancie Text") }}
        {{ Form::textarea("text", $text, [
            "placeholder" => "Vacancie Text"
        ]) }}
        @if ($error = $errors->first("text"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div>    
        {{ Form::label("company", "Company name") }}
        {{ Form::text("company", $company, [
            "placeholder" => "Compan name"
        ]) }}
        @if ($error = $errors->first("company"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div> 
    
    @if ($poster)
        <div>Current poster
            <img src="{{URL::to('/')}}/{{{$poster}}}" width="100" alt="vacancie poster"/>
        </div>
    @else
        <div>
            No poster currently uploaded
        </div>    
    @endif
    
    <div>   
        {{ Form::label("poster", "Vacancie Poster") }}
        {{ Form::file("poster", Input::file("poster"), [ //input::get varbūt???  lkm input::old nestrādā uz file :(
            //"placeholder" => "Vacancie Poster"
        ]) }}
        @if ($error = $errors->first("poster"))
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
        {{ Form::submit("Edit vacancie",["class" => "btn btn-warning"]) }}
    </div>
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop