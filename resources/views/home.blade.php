@extends('layout')

@section('content')
<main>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    割り勘をしよう
                </div>
                <div class="card-text">
                    <a href="{{ route('bill.create') }}">割り勘をする</a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection