@extends('front.layout.page-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Document title')
@section('meta_tags')
    {!! SEO::generate() !!}
@endsection
@section('content')

@endsection