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
            {{ trans('titles.delete') }}
                <a href="{{URL::to("/viewUser/".$userId)}}">
                    @if (Auth::user()->id == $userId)
                        {{ trans('titles.your') }}
                    @else
                        {{{$username}}}
                    @endif
                </a> 
            {{ trans('titles.profile-u') }}
        </h2>
        <span class='text-danger'>{{ trans('titles.to-delete-account-enter-your-password') }}</span>
        <div class='text-danger'><b>{{ trans('titles.warning-all-userdata-will-delete') }}</b></div>
    </div>

    {{ Form::open([
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('password')) has-error@endif">
        {{ Form::label("password", trans('forms.password'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::password("password", [
                "placeholder" => trans('forms.password'),
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("password"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4"> 
            {{ Form::submit(trans('buttons.delete-profile'),["class" => "btn btn-danger btn-block"]) }}
        </div>
    </div>
        
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop