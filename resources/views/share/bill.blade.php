<div class="mt-3 card">
    <div class="card-body">
        <p class="card-text">{{ $bill->title }}</p>
        <p class="card-text">合計: {{ $bill->total }}円</p>
        <p class="card-text">割り勘をした相手: 
            @foreach($to_user_names as $to_user_name)
                {{ $to_user_name }}
            @endforeach
        </p>
    </div>
</div>