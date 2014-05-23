@extends("layout")
@section("content")

    <span class="page-control btn-group btn-group-sm">
        <a class="btn btn-default" href="{{URL::to("/viewVacancie/".$id)}}">{{ trans('buttons.to-vacancie') }}</a>
        <a class="btn btn-default" href="{{{ URL::to("/myVacancies") }}}">{{ trans('buttons.my-vacancies') }}</a>
        <a class="btn btn-default" href="{{ URL::to("/viewAllVacancies")}}">{{ trans('buttons.all-vacancies') }}</a>
    </span>

    <div class="page-header">
        <h2>{{ trans('titles.delete-vacancie') }}: 
            <small>
                <a href="{{ URL::to("/viewVacancie/".$id)}}">{{{ $name }}}</a>
            </small>
        </h2>
        <span class="text-danger">{{ trans('titles.to-delete-vacancie-confirm') }}</span>
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
                    {{ Form::label("checkbox",trans('forms.wish-to-delete-vacancie')) }}
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
                {{ Form::submit(trans('titles.delete-vacancie'),["class" => "btn btn-danger btn-block"]) }}
            </div>
        </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop