@extends('email.layouts.master')
@section('title', $title)
@section('content')
    <h2 style="font-weight: 600"> {{ $title }} </h2>
    <p>{!! $notice !!}</p>
@endsection
