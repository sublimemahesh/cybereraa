@extends('errors::custom-layout')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', "The service you requested is not available at this time. That's all we know")
