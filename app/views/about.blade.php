@extends("layout")
@section("content")

<div class="page-header">
    <h2>{{ trans('titles.about') }}</h2>
</div>

<div class="col-sm-offset-2 col-sm-8">
    <p class="newlineText">{{ trans('content.about-text') }}</p>
</div>

@stop