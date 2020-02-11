@extends('layout')

@section('content')
    <main>
        <div class="container">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('bill.store') }}" method="post">
                @csrf   
                <div class="form-group">
                    <label for="title">タイトル</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}">
                </div>
                <div class="form-group">
                    <label for="total">合計金額</label>
                    <input type="tel"" id="total" name="total" class="form-control" value="{{ old('total') }}">
                </div>
                <div class="form-group">
                    <p>割り勘をするユーザー</p>
                    @foreach($users as $user)
                        <input type="checkbox" id="{{ $user->id }}" name="to_user_id[]" value="{{ $user->id }}">
                        <label for="{{ $user->id }}">{{ $user->name }}</label>
                    @endforeach
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-secondary">
                </div>
            </form>
        </div>
    </main>
@endsection