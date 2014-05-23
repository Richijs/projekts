@extends("layout")
@section("content")
    
    <span class="page-control btn-group btn-group-sm">
        @if (Auth::user()->userGroup == 3)
            <a class="btn btn-default" href="{{ URL::to("/profile/")}}">{{ trans('buttons.my-profile') }}</a>
        @endif
        <a class="btn btn-default" href="{{URL::to("/viewSeeker/".$id)}}">{{ trans('buttons.to-jobseek') }}</a>
        @if (Auth::user()->userGroup == 1)
            <a class="btn btn-default" href="{{URL::to("/viewAllSeekers")}}">{{ trans('buttons.all-job-seekers') }}</a>
        @endif
    </span>

    <div class="page-header">
        <h2>{{ trans('titles.delete') }}
            <small>
                <a href="{{URL::to("/viewSeeker/".$id)}}">{{{ $intro }}}</a>
            </small>
            {{ trans('titles.job-seeker-data') }}
        </h2>
        <span class="text-danger">{{ trans('titles.to-delete-jobseek-confirm') }}</span>
    </div>

    {{ Form::open([
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('checkbox')) has-error@endif">
        {{ Form::label("confirmation", trans('forms.confirmation'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            <div class="checkbox">
                {{ Form::checkbox("checkbox",true,false,[
                        "id" => "checkbox"
                ]) }}
                {{ Form::label("checkbox",trans('forms.wish-to-delete-jobseek')) }}
            </div>
        </div>
        
        @if ($error = $errors->first("checkbox"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">
            {{ Form::submit(trans('buttons.delete-jobseek-data'),["class" => "btn btn-danger btn-block"]) }}
        </div>
    </div>
        
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop