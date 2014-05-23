@extends("layout")
@section("content")

    <span class="page-control btn-group btn-group-sm">
        @if (Auth::user()->id == $userId)
            <a class="btn btn-default" href="{{ URL::to("/profile/")}}">{{ trans('buttons.my-profile') }}</a>
        @else
            <a class="btn btn-default" href="{{URL::to("/viewUser/".$userId)}}">{{{$username}}} {{ trans('buttons.profile') }}</a>
        @endif
        <a class="btn btn-default" href="{{URL::to("/viewAllUsers/")}}">{{ trans('buttons.all-site-users') }}</a>
    </span>

    <div class="page-header">
        <h2>
            {{ trans('titles.edit') }} 
                <a href="{{URL::to("/viewUser/".$userId)}}">
                    @if (Auth::user()->id == $userId)
                        {{ trans('titles.your') }}
                    @else
                        {{{$username}}}
                    @endif
                </a>  
            {{ trans('titles.user-data-us') }}
        </h2>
    </div>

    {{ Form::open([
        "autocomplete" => "off",
        "enctype"      => "multipart/form-data",
        "file"         => "true",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('username')) has-error@endif">
        {{ Form::label("username", trans('forms.username'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("username", $username, [
                "placeholder" => trans('forms.username'),
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
        {{ Form::label("email", trans('forms.email'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("email", $email, [
                "placeholder" => trans('forms.email'),
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
        {{ Form::label("firstname", trans('forms.firstname'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("firstname", $firstname, [
                "placeholder" => trans('forms.firstname'),
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
        {{ Form::label("lastname", trans('forms.lastname'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("lastname", $lastname, [
                "placeholder" => trans('forms.lastname'),
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("lastname"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    {{-- tikai administratoram --}}
    @if (Auth::check() && Auth::user()->userGroup==1)
    
        {{-- tikai administrators drīkst mainīt grupas (izņemot paša grupu) --}}
        <div class="text-danger col-sm-offset-2 col-sm-7">
            {{ trans('forms.changing-usergroup-will-delete-user-data-except') }}
        </div>
    
    <div class="form-group @if ($errors->first('userGroup')) has-error@endif">
        {{ Form::label("userGroup", trans('forms.usergroup'),[
            "class"  => "col-sm-4 control-label"
        ]) }}
        <div class="col-sm-4">

        {{-- administrators nevar mainīt savu grupu --}}
        @if (Auth::check() && Auth::user()->userGroup==1 && Auth::user()->id==$userId)
            <div class="radio">
                {{ Form::label("admin", trans('forms.admin')) }}
                {{ Form::radio('userGroup', 1,true, [
                    "disabled"=>"true",
                    "id" => "admin"
                ]) }}
            </div>
        @endif
        
        @if (Auth::check() && Auth::user()->userGroup==1 && Auth::user()->id!=$userId)
            
            <div class="radio">
                {{ Form::label("seeker", trans('forms.job-seeker')) }}
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
                {{ Form::label("employer", trans('forms.employer')) }}
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
                {{ Form::label("admin", trans('forms.admin')) }}
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
        
            @if ($error = $errors->first("userGroup"))
                <div class="error col-sm-offset-4 col-sm-4">
                    {{ $error }}
                </div>
            @endif
            
        @endif
        </div>
    </div>     
    @endif
        
    
    <div class="form-group @if ($errors->first('about')) has-error@endif">    
        {{ Form::label("about", trans('forms.about'),[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-6">
            {{ Form::textarea("about", $about, [
                "placeholder" => trans('forms.about'),
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
        {{ Form::label("profilePic", trans('forms.current-profile-picture'),[
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
        {{ Form::label("picture", trans('forms.new-profile-picture'),[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            <div class="form-control">
                {{ Form::file("picture", Input::file("picture"),[
                     "placeholder" => trans('forms.new-profile-picture')
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
            {{ Form::submit(trans('buttons.edit-profile'),["class" => "btn btn-warning btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop