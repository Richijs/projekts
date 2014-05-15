@extends("layout")
@section("content")

    <div class="page-header">
        <h1>
            Editing <a href="{{URL::to("/viewUser/".$userId)}}">{{{$username}}}</a>  
            <small>user data</small>
        </h1>
    </div>

    {{ Form::open([
        "autocomplete" => "off",
        "enctype"      => "multipart/form-data",
        "file"         => "true",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('username')) has-error@endif">
        {{ Form::label("username", "Username",[
            "class"  => "col-sm-4 control-label required"
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
            "class"  => "col-sm-4 control-label required"
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
            "class"  => "col-sm-4 control-label required"
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
            "class"  => "col-sm-4 control-label required"
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
    
    <!-- ja ir admins, tad vispār displayo šo sadaļu -->
    @if (Auth::check() && Auth::user()->userGroup==1)
    
        <!-- only admin can change groups (except his own group) -->
        <div class="text-danger col-sm-offset-2 col-sm-7">
            Changing user group will delete all user
            created data, except, his own added recommendations!
        </div>
    
    <div class="form-group @if ($errors->first('userGroup')) has-error@endif">
        {{ Form::label("userGroup", "User Group",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        <div class="col-sm-4">

        <!-- admin editing his own profile cant change his group -->
        @if (Auth::check() && Auth::user()->userGroup==1 && Auth::user()->id==$userId)
            <div class="radio">
                {{ Form::label("admin", "Admin") }}
                {{ Form::radio('userGroup', 1,true, [
                    "disabled"=>"true",
                    "id" => "admin"
                ]) }}
            </div>
        @endif
        
        @if (Auth::check() && Auth::user()->userGroup==1 && Auth::user()->id!=$userId)
            
            <div class="radio">
                {{ Form::label("seeker", "Job seeker") }}
                @if ($userGroup==3)
                    {{ Form::radio('userGroup', 3,true, [
                        "id" => "seeker"
                    ]) }}
                @else
                    {{ Form::radio('userGroup', 3,false, [
                        "id" => "seeker"
                    ]) }}
                @endif
            </div>
            
            <div class="radio">
                {{ Form::label("employer", "Employer") }}
                @if ($userGroup==2)
                    {{ Form::radio('userGroup', 2,true, [
                        "id" => "employer"
                    ]) }}
                @else
                    {{ Form::radio('userGroup', 2,false, [
                        "id" => "employer"
                    ]) }}
                @endif
            </div>
        
            <div class="radio">
                {{ Form::label("admin", "Admin") }}
                @if ($userGroup==1)
                    {{ Form::radio('userGroup', 1,true, [
                        "id" => "admin"
                    ]) }}
                @else
                    {{ Form::radio('userGroup', 1,false, [
                        "id" => "admin"
                    ]) }}
                @endif
            </div>
        
            @if ($error = $errors->first("userGroup")) <!-- needed? -->
                <div class="error col-sm-offset-4 col-sm-4">
                    {{ $error }}
                </div>
            @endif
            
        @endif
        </div>
    </div>     
    @endif
        
    
    <div class="form-group @if ($errors->first('about')) has-error@endif">    
        {{ Form::label("about", "About",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-6">
            {{ Form::textarea("about", $about, [
                "placeholder" => "about",
                "class"       => "form-control",
                "rows"        => "7"
            ]) }}
        </div>
        
        @if ($error = $errors->first("about"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group">
        {{ Form::label("profilePic", "Current profile picture",[
            "class"  => "col-sm-4 control-label"
        ]) }}
    
        @if ($picture)
            <div class="col-sm-4">
                <img src="{{URL::to('/')}}/{{{$picture}}}" width="100" alt="profile picture"/>
            </div>
        @else
            <div class="col-sm-4">
                <img src="{{URL::to('/')}}/uploads/profileImages/default.jpeg" width="100" alt="profile picture"/>
            </div>
        @endif
    </div>
    
    
    <div class="form-group @if ($errors->first('picture')) has-error@endif">    
        {{ Form::label("picture", "Profile Picture",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            <div class="form-control">
                {{ Form::file("picture", Input::file("picture"),[ //input::get varbūt???  lkm input::old nestrādā uz file :(
                     "placeholder" => "profile picture"
                ]) }}
            </div>
        </div>
        
        @if ($error = $errors->first("picture"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">
            {{ Form::submit("Save Edit",["class" => "btn btn-warning btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop