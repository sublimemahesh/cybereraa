@extends('errors::custom-layout')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message',  __($exception->getMessage()) ?: __('Too Many Requests'))
