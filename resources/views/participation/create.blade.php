{{-- layouts.common.blade.phpのレイアウト継承 --}}
@extends('layouts.common')

{{-- ヘッダー呼び出し --}}
@include('common.header')
{{-- サイドバー呼び出し --}}
@include('common.sidebar')
{{-- メイン部分作成 --}}
@section('content')
<div class="px-8 py-8 mx-auto bg-white">
    <div class="flex items-center justify-between">
        <span class="text-sm font-light text-gray-600">最終更新日時:</span>
    </div>

    <div class="mt-2">
        <p class="text-2xl font-bold text-gray-800"></p>
        <form action="{{ route('participation.store') }}" method="post" class="max-w-md mx-auto p-4">
            @csrf
            <div class="mb-4">
                <input type="hidden" name="post_id" value="{{ request()->get('post_id') }}">
                <input type="hidden" name="status" value="参加">
              <label for="name" class="block text-gray-700 font-bold mb-2">名前:</label>
              <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required value="{{ $user->name }}">
            </div>
            <div class="mb-4">
              <label for="email" class="block text-gray-700 font-bold mb-2">Eメール:</label>
              <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required value="{{ $user->email }}">
            </div>
            <div class="mb-4">
              <label for="comment" class="block text-gray-700 font-bold mb-2">コメント:</label>
              <textarea name="comment" id="comment" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>
            <div class="text-center">
              <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">参加する</button>
            </div>
          </form>

          
        <form action="{{route('stripe.charge')}}" method="POST">
        @csrf
        <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{ env('STRIPE_KEY') }}"
            data-amount="1000"
            data-name="お支払い画面"
            data-label="payment"
            data-description="現在はデモ画面です"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto"
            data-currency="JPY">
        </script>
        </form>
    </div>
</div>
@endsection
{{-- フッター呼び出し --}}
@include('common.footer')
