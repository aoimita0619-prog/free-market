<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Item;


class PurchaseController extends Controller
{
    public function create($itemId){

        $item =  Item::findOrFail($itemId);
        $user = auth()->user();
        $address = session('purchase_address', [
          'post_code' => $user->post_code,
          'address'   => $user->address,
          'building'  => $user->building,
        ]);
        
         if ($item->user_id === auth()->id()) {
          return redirect()
            ->route('item.show', $item)
            ->with('error', '自分が出品した商品は購入できません。');
        }

        if ($item->is_sold) {
          return redirect()
            ->route('item.show', $item)
            ->with('error', 'この商品は売り切れです。');
        }

        return view('purchase',compact('item','user', 'address'));
    }

    

    public function editAddress(Item $item){
        
        $user = auth()->user();
        return view('purchase-address',compact('item','user',));
    }

    public function updateAddress(Request $request, Item $item){

         session([
        'purchase_address' => [
            'post_code' => $request->post_code,
            'address'   => $request->address,
            'building'  => $request->building,
        ]
    ]);

    return redirect()->route('purchase.create', $item);
    }

    public function checkout(Request $request, Item $item)
{
    $request->validate([
        'method' => 'required|in:1,2',
    ], [
        'method.required' => '支払い方法を選択してください。',
        'method.in' => '支払い方法を正しく選択してください。',
    ]);
    
    if ($item->user_id === auth()->id()) {
        return back()->with('error', '出品した商品は購入できません。');
    }

    if ($item->is_sold) {
        return back()->with('error', 'この商品は売り切れです。');
    }

    $request->validate([
        'method' => 'required|in:1,2',
    ]);

    $user = auth()->user();

    $address = session('purchase_address', [
        'post_code' => $user->post_code,
        'address'   => $user->address,
        'building'  => $user->building,
    ]);

    /*
     * 支払い方法
     * 1 = コンビニ
     * 2 = カード
     */
    $method = $request->method;

    $paymentMethod = $method == 1
        ? 'konbini'
        : 'card';


    /*
     * ① purchasesテーブルに保存
     */
    $purchase = Purchase::create([
        'user_id' => $user->id,
        'item_id' => $item->id,
        'price' => $item->price,

        'method' => $method,

        // まだ決済完了していない
        'status' => 'pending',

        'post_code' => $address['post_code'],
        'address' => $address['address'],
        'building' => $address['building'],
    ]);


    Stripe::setApiKey(config('services.stripe.secret'));


    /*
     * ② Stripe Checkoutを作成
     */
    $session = Session::create([
        'payment_method_types' => [
            $paymentMethod,
        ],

        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'jpy',

                    'product_data' => [
                        'name' => $item->name,
                    ],

                    'unit_amount' => $item->price,
                ],

                'quantity' => 1,
            ],
        ],

        'mode' => 'payment',

        'customer_email' => $user->email,

        'success_url' => route('purchase.success', $item),

        'cancel_url' => route('purchase.cancel', $item),

        /*
         * ③ Webhookで使う情報
         */
        'metadata' => [
            'purchase_id' => $purchase->id,
            'item_id' => $item->id,
            'user_id' => $user->id,
        ],
    ]);


    /*
     * ④ Stripe Session IDを保存
     */
    $purchase->update([
        'stripe_session_id' => $session->id,
    ]);


    /*
     * ⑤ Stripe Checkoutへ
     */
    return redirect($session->url);
}

    public function success()
{
    return redirect()
        ->route('top')
        ->with('message', '購入が完了しました。');
}

public function cancel(Item $item)
{
    return redirect()
        ->route('purchase.create', $item)
        ->with('message', '購入をキャンセルしました');
}

}

