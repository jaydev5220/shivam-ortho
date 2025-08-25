@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Our Doctors</h1>
    <div class="row">
        @foreach($doctors as $doctor)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($doctor->image)
                        <img src="{{ asset('storage/' . $doctor->image) }}" class="card-img-top" alt="{{ $doctor->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $doctor->name }}</h5>
                        <p class="card-text"><strong>{{ $doctor->specialization }}</strong></p>
                        <p class="card-text">{{ $doctor->description }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
