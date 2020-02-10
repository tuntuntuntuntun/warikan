@extends('layout')

@section('content')
    <main>
        <div class="container">
            <p>受け取る金額: {{ $receive }}円</p>
            @foreach($bills as $bill)
                @include('share.bill')
            @endforeach
        </div>
    </main>
@endsection