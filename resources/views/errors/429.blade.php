@extends('errors::custom-layout')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message',  'We’re sorry, but you have sent too many requests to us recently. Please try again later. That’s all we know.')
