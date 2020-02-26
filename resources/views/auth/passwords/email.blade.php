@extends('layout')

@section('content')
    <main>
        <div class="container">
            <h2>パスワード再発行</h2>
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $message)
                                {{ $message }}
                            @endforeach
                        </div>
                    @endif
                    <form action="{{ route('password.email') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="email">メールアドレス</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">再発行リンクを送る</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection