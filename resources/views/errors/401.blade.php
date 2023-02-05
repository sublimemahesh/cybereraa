@extends('errors::custom-layout')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message',  'You are not allowed to access this page.')
