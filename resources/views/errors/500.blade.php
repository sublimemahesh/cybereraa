@extends('errors::custom-layout')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __($exception->getMessage()) ?:  __('Server Error'))
