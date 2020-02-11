@extends('layout')

@section('content')
    <main>
        <div class="container">
            <p>受け取る金額: {{ $receive }}円</p>
            @foreach($bills as $bill)
                @if($bill->user_id === Auth::id())
                    <div class="mt-3 card">
                        <div class="card-body">
                            <p class="car-text">お金を払った人: {{ $bill->user->name }}</p>
                            <p class="card-text">{{ $bill->title }}</p>
                            <p class="card-text">合計: {{ $bill->total }}円</p>
                            <p class="card-text">割り勘をした相手: 
                                @foreach($to_user_names as $to_user_name)
                                    {{ $to_user_name }}
                                @endforeach
                            </p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </main>
@endsection