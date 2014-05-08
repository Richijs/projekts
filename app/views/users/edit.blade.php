@extends("layout")
@section("content")

    <h2>Editing {{{$username}}} user data</h2>
    
    {{ Form::open([
        //"url"          => URL::route("users/edit"),
        "autocomplete" => "off",
        "enctype" => "multipart/form-data",
        "file" => "true",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('username')) has-error@endif">
        {{ Form::label("username", "Username",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("username", $username/*Input::get("username")*/, [
                "placeholder" => "username",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("username"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group @if ($errors->first('email')) has-error@endif"> 
        {{ Form::label("email", "Email",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("email", $email/*Input::get("email")*/, [
                "placeholder" => "email",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("email"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div class="form-group @if ($errors->first('firstname')) has-error@endif">     
        {{ Form::label("firstname", "Firstname",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("firstname", $firstname, [
                "placeholder" => "firstname",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("firstname"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>    
    
    <div class="form-group @if ($errors->first('lastname')) has-error@endif">   
        {{ Form::label("lastname", "Lastname",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("lastname", $lastname, [
                "placeholder" => "lastname",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("lastname"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    {{-- admin editing his own profile cant change his group --}}
    @if (Auth::check() && Auth::user()->userGroup==1 && Auth::user()->id==$userId)
        <div>
            {{ Form::label("userGroup", "Admin") }}
            {{ Form::radio('userGroup', 1,true, ["disabled"=>"true"]) }}
        </div>
    @endif
    

    {{-- only admin can change groups (except his own group) --}}
    <h3>changing from anything->seeker or anything->employer will delete all user
        created data except his own added recommendations! seeker data/vacancies/applications will all be deleted...
    </h3>
    
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
             <img src="{{URL::to('/')}}/uploads/profileImages/default.jpeg" width="100" alt="profile picture"/>
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
    {{ Form::submit("Save Edit",["class" => "btn btn-warning"]) }}
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop