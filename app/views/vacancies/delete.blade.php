@extends("layout")
@section("content")
<h2>Delete <a href="/viewVacancie/{{{$id}}}">{{{ $name }}}</a> vacancie</h2>
    <h3>To delete Vacancie, Confirm deletionn</h3>

    {{ Form::open([
        //"url"          => URL::route("vacancies/delete"),
        "autocomplete" => "off"
    ]) }}
    
        {{ Form::checkbox("checkbox", 1 ,[
            
        ]) }}
        {{ Form::label("checkbox","I Wish to delete this vaccancie") }}
        
        @if ($error = $errors->first("checkbox"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        
        {{ Form::submit("Delete Vacancie",["class" => "btn btn-danger"]) }}
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop