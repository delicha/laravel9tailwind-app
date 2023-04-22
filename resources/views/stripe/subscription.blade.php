{{-- layouts.common.blade.phpのレイアウト継承 --}}
@extends('layouts.common')

{{-- ヘッダー呼び出し --}}
@include('common.header')
{{-- サイドバー呼び出し --}}
@include('common.sidebar')
{{-- メイン部分作成 --}}
@section('content')

<style>
.MyCardElement {
	height: 40px;
	padding: 10px 12px;
	width: 100%;
	color: #32325d;
	background-color: #e6ebf1;
	border: 1px solid black;
	border-radius: 4px;
  
	box-shadow: 0 1px 3px 0 #e6ebf1;
	-webkit-transition: box-shadow 150ms ease;
	transition: box-shadow 150ms ease;
  }
  
  .MyCardElement--focus {
	box-shadow: 0 1px 3px 0 #cfd7df;
  }
  
  .MyCardElement--invalid {
	border-color: #fa755a;
  }
  
  .MyCardElement--webkit-autofill {
	background-color: #fefde5 !important;
  }

</style>

<h3 class="mb-3 ml-3">ご登録フォーム</h3>

<form action="{{route('stripe.afterpay')}}" method="post" id="payment-form">
  @csrf
  
    <label for="exampleInputEmail1">お名前</label>
    <input type="text" class="form-control MyCardElement col-sm-5" id="card-holder-name" required>
 
    <label for="exampleInputPassword1">カード番号</label>
    <div class="form-group MyCardElement col-sm-5" id="card-element"></div>
 
    <div id="card-errors" role="alert" style='color:red'></div>
 
    <button class="btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">送信する</button>
 
</form>
<script src="https://js.stripe.com/v3/"></script>

<script>
  const stripe = Stripe('stripe-public-key');

  const elements = stripe.elements();
  const cardElement = elements.create('card');

  cardElement.mount('#card-element');

  const cardHolderName = document.getElementById('card-holder-name');

  const cardButton = document.getElementById('card-button');
  
  cardButton.addEventListener('click', async (e) => {
      const { paymentMethod, error } = await stripe.createPaymentMethod(
          'card', cardElement, {
              billing_details: { name: cardHolderName.value }
          }
      );
  
      if (error) {
          // Display "error.message" to the user...
      } else {
          // The card has been verified successfully...
      }
  });
</script>
@endsection
{{-- フッター呼び出し --}}
@include('common.footer')



{{-- <script>
 
	// HTMLの読み込み完了後に実行するようにする
	window.onload = my_init;
	function my_init() {
 
		// Configに設定したStripeのAPIキーを読み込む  
		const stripe = Stripe("{{ config('services.stripe.pb_key') }}");
		const elements = stripe.elements();
 
		var style = {
			base: {
			color: "#32325d",
			fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
			fontSmoothing: "antialiased",
			fontSize: "16px",
			"::placeholder": {
			color: "#aab7c4"
			}
		},
		invalid: {
			color: "#fa755a",
			iconColor: "#fa755a"
		}
		};
		
		const cardElement = elements.create('card', {style: style, hidePostalCode: true});
		cardElement.mount('#card-element');
 
		const cardHolderName = document.getElementById('card-holder-name');
		const cardButton = document.getElementById('card-button');
		const clientSecret = cardButton.dataset.secret;
 
		cardButton.addEventListener('click', async (e) => {
			// formのsubmitボタンのデフォルト動作を無効にする
			e.preventDefault();
			const { setupIntent, error } = await stripe.confirmCardSetup(
				clientSecret, {
					payment_method: {
					card: cardElement,
					billing_details: { name: cardHolderName.value }
					}
				}
			);
			
			if (error) {
			// エラー処理
			console.log('error');
			
			} else {
			// 問題なければ、stripePaymentHandlerへ
			stripePaymentHandler(setupIntent);
			}
		});
	}
	
	function stripePaymentHandler(setupIntent) {
	var form = document.getElementById('payment-form');
	var hiddenInput = document.createElement('input');
	hiddenInput.setAttribute('type', 'hidden');
	hiddenInput.setAttribute('name', 'stripePaymentMethod');
	hiddenInput.setAttribute('value', setupIntent.payment_method);
	form.appendChild(hiddenInput);
	// フォームを送信
	form.submit();
	}
</script>
 --}}
