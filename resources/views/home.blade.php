@extends('layout')

@section('content')
<main>
    <div class="container">
        <div class="text-center">
            <a href="{{ route('bill.create') }}" class="btn btn-primary">割り勘をする</a>
        </div>
    </div>
</main>
@endsection