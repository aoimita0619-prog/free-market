<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Item;
use Illuminate\Http\Request;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();

        $signature = $request->header('Stripe-Signature');

        try {

            $event = Webhook::constructEvent(
                $payload,
                $signature,
                config('services.stripe.webhook_secret')
            );

        } catch (\UnexpectedValueException $e) {

            return response()->json([
                'message' => 'Invalid payload'
            ], 400);

        } catch (\Stripe\Exception\SignatureVerificationException $e) {

            return response()->json([
                'message' => 'Invalid signature'
            ], 400);
        }


        /*
         * Checkout Session 完了
         */
        if ($event->type === 'checkout.session.completed') {

            $session = $event->data->object;

            \Log::info('===== Stripe Webhook =====');

            \Log::info('Session ID: ' . $session->id);

            \Log::info('Purchase ID: ' .
                ($session->metadata->purchase_id ?? 'なし')
            );


            /*
             * metadataからpurchase_idを取得
             */
            $purchaseId = $session->metadata->purchase_id ?? null;

            if (!$purchaseId) {

                \Log::error('purchase_idがありません');

                return response()->json([
                    'message' => 'purchase_id not found'
                ], 400);
            }


            /*
             * purchasesから取得
             */
            $purchase = Purchase::find($purchaseId);

            if (!$purchase) {

                \Log::error(
                    'Purchase not found: ' . $purchaseId
                );

                return response()->json([
                    'message' => 'Purchase not found'
                ], 404);
            }


            /*
             * 二重処理防止
             */
            if ($purchase->status === 'completed') {

                return response()->json([
                    'message' => 'Already completed'
                ]);
            }


            /*
             * 購入完了
             */
            $purchase->update([
                'status' => 'completed',
            ]);


            /*
             * 商品を売却済みにする
             */
            $purchase->item->update([
                'is_sold' => '1',
            ]);


            \Log::info(
                'Purchase completed: ' . $purchase->id
            );

            \Log::info(
                'Item sold: ' . $purchase->item_id
            );
        }


        return response()->json([
            'status' => 'success'
        ]);
    }
}