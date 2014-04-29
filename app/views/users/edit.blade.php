@extends("layout")
@section("content")

    <h2>Editing {{{$username}}} user data</h2>
    
    {{ Form::open([
        //"url"          => URL::route("users/edit"),
        "autocomplete" => "off",
        "enctype" => "multipart/form-data",
        "file" => "true"
    ]) }}
    
    <div>
    {{ Form::label("username", "Username") }}
        {{ Form::text("username", $username/*Input::get("username")*/, [
            "placeholder" => "username"
        ]) }}
        @if ($error = $errors->first("username"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div>
        {{ Form::label("email", "Email") }}
        {{ Form::text("email", $email/*Input::get("email")*/, [
            "placeholder" => "email"
        ]) }}
        @if ($error = $errors->first("email"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div>    
        {{ Form::label("firstname", "Firstname") }}
        {{ Form::text("firstname", $firstname, [
            "placeholder" => "firstname"
        ]) }}
        @if ($error = $errors->first("firstname"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>    
    <div>    
        {{ Form::label("lastname", "Lastname") }}
        {{ Form::text("lastname", $lastname, [
            "placeholder" => "lastname"
        ]) }}
        @if ($error = $errors->first("lastname"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>
    
    {{-- only admin can change groups (except his own group) --}}
    @if (Auth::check() && Auth::user()->userGroup==1 && Auth::user()->id!=$userId)
    <div>    
        {{ Form::label("userGroup", "Job seeker") }}
        @if ($userGroup==3)
        {{ Form::radio('userGroup', 3,true) }}
        @else
        {{ Form::radio('userGroup', 3) }}
        @endif
        
        {{ Form::label("userGroup", "Employer") }}
        @if ($userGroup==2)
        {{ Form::radio('userGroup', 2,true) }}
        @else
        {{ Form::radio('userGroup', 2) }}
        @endif
        
        {{ Form::label("userGroup", "Admin") }}
        @if ($userGroup==1)
        {{ Form::radio('userGroup', 1,true) }}
        @else
        {{ Form::radio('userGroup', 1) }}
        @endif
        
        @if ($error = $errors->first("userGroup")) <!-- needed? -->
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>
    @endif
    
    <div>    
        {{ Form::label("about", "About") }}
        {{ Form::textarea("about", $about, [
            "placeholder" => "about"
        ]) }}
        @if ($error = $errors->first("about"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>
    
    @if ($picture)
        <div>Current profile picture
            <img src="{{URL::to('/')}}/{{{$picture}}}" width="100" alt="profile picture"/>
        </div>
    @else
        <div>
            No profile picture currently uploaded
        </div>    
    @endif
    
    <div>   
        {{ Form::label("picture", "Profile Picture") }}
        {{ Form::file("picture", Input::file("picture"),[ //input::get varbūt???  lkm input::old nestrādā uz file :(
           // "placeholder" => "profile picture"
        ]) }}
        @if ($error = $errors->first("picture"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div>
    {{ Form::submit("Save Edit") }}
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop