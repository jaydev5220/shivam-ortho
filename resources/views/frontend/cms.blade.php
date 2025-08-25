@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">{{ $page->title }}</h1>
    <div>{!! $page->description !!}</div>
</div>
@endsection
