@extends('errors.minimal')

@section('title', $title ?? __('site.labels.Error'))
@section('code', '')
@section('message', $message ?? __('site.labels.Error'))
