@extends('errors::custom-layout')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __($exception->getMessage()) ?:  __('Service Unavailable'))
