@extends('layout')

@section('content')
    <main>
        <div class="container">
            <p>受け取る金額: {{ $receive }}円</p>
            <p>支払う金額</p>
            <ul>
                @if(isset($my_payments))
                    @foreach($my_payments as $my_payment)
                        <li>{{ $my_payment[0]->user->name }}: {{ $to_user[$my_payment[0]->user_id] }}円</li>
                    @endforeach
                @else
                    @foreach($my_bills as $my_bill)
                        <li>{{ $my_bill[0]->user->name }}: {{ $to_user[$my_bill[0]->user_id] }}円</li>
                    @endforeach
                @endif
            </ul>
            @foreach($bills as $bill)
                @if($bill->user_id === Auth::id())
                    <div class="mt-3 card">
                        <div class="card-body">
                            <p class="car-text">お金を払った人: {{ $bill->user->name }}</p>
                            <p class="card-text">{{ $bill->title }}</p>
                            <p class="card-text">合計: {{ $bill->total }}円</p>
                            <p class="card-text">割り勘をした相手: 
                                @foreach($payment_users as $payment_user)
                                    @if($bill->id === $payment_user->bill_id)
                                        {{ $payment_user->user->name }}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </main>
@endsection