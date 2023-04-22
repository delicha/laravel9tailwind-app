<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Post;
use App\Models\Category;
use App\Models\Participation;
use App\Models\ReservationPost;
use App\Http\Requests\PostRequest;

class StripeController extends Controller
{
    private $post;
    private $category;
    private $reservationPost;
    private $participation;

    public function __construct()
    {
        $this->post = new Post();
        $this->category = new Category();
        $this->reservationPost = new ReservationPost();
        $this->participation = new Participation();
    }

    public function subscription(Request $request)
    {
        $categories = $this->category->getAllCategories();
        $user = Auth::user();
        $user_id = $user->id;
        return view('stripe.subscription',  [
            'intent' => $user->createSetupIntent(),
            'user_id' => $user_id,
            'categories' => $categories
        ]);
    }

    public function afterpay(Request $request)
    {
        // ログインユーザーを$userとする
        $user = Auth::user();

        // またStripe顧客でなければ、新規顧客にする
        $stripeCustomer = $user->createOrGetStripeCustomer();

        // フォーム送信の情報から$paymentMethodを作成する
        $paymentMethod = $request->input('stripePaymentMethod');

        // プランはconfigに設定したbasic_plan_idとする
        $plan = config('services.stripe.karaoke_id');

        // 上記のプランと支払方法で、サブスクを新規作成する
        $user->newSubscription('default', $plan)
            ->create($paymentMethod);

        // 処理後に'ルート設定'にページ移行
        return redirect()->route('/');
    }

    // テスト用
    // public function charge(Request $request)
    // {
    //     Stripe::setApiKey(env('STRIPE_SECRET')); //シークレットキー

    //     $charge = Charge::create(array(
    //         'amount' => 10000,
    //         'currency' => 'jpy',
    //         'source' => request()->stripeToken,
    //     ));
    //     return back();
    // }
}
