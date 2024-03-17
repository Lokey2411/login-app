@extends('layout')
@section('title', 'Home page')
@section('content')
    {{ auth()->user() }}
@endsection
