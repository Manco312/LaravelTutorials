@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
    <div class="alert alert-success">
        Product created
    </div>
@endsection
