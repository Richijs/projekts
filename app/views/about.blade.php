@extends("layout")
@section("content")

<span class="page-control btn-group btn-group-sm">
    <a class="btn btn-default" href="{{ URL::route("home") }}">{{ trans('titles.home') }}</a>
</span>

<div class="page-header">
    <h2>
        {{ trans('titles.about') }}
    </h2>
</div>

<div class="col-sm-offset-2 col-sm-8">
    <p class="newlineText">{{ trans('content.about-text') }}</p>
</div>

@stop