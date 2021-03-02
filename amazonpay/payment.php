<?php
require '/home/hoge/amazon/AmazonPay/Client.php';

Use AmazonPay\Client;

class Payment
{
    const MERCHANT_ID = '--- MERCHANT_ID ---';
    // 決済金額
    const AMOUNT = 100;

    public function execute()
    {
        $referenceId = $_REQUEST['orderReferenceId'];

        // (1) Clientインスタンスを作成
        $config = array(
            'merchant_id' => self::MERCHANT_ID,
            'access_key' => '--- ACCESS_KEY ---',
            'secret_key' => '--- SECRET_KEY---',
            'client_id' => '--- CLIENT_ID ---',
            'currency_code' => 'jpy',
            'region' => 'jp',
            'sandbox' => true,
        );
        $client = new Client($config);

        // (2) 注文情報をセット
        $setOrderParams = array(
            'merchant_id' => self::MERCHANT_ID,
            'amazon_order_reference_id' => $referenceId,
            'amount' => self::AMOUNT,
            'currency_code' => 'JPY',
            'seller_note' => 'ご購入ありがとうございます',
            'seller_order_id' => 'Order_' . time(),
            'store_name' => 'ショップ名',
        );
        $client->SetOrderReferenceDetails($setOrderParams);

        if ($client->success === false) {
            header('Location: /error.html');
            exit;
        }

        // (3) 注文情報を確定
        $confirmOrderParams = array(
            'amazon_order_reference_id' => $referenceId
        );
        $client->confirmOrderReference($confirmOrderParams);

        if ($client->success === false) {
            header('Location: /error.html');
            exit;
        }

        // (4) オーソリをリクエスト
        $authorizeParams = array(
            'amazon_order_reference_id' => $referenceId,
            'authorization_amount' => self::AMOUNT,
            'authorization_reference_id' => 'Order_' . time(),
            'seller_authorization_note' => 'Authorizing payment',
            'transaction_timeout' => 0,
        );
        $response = $client->authorize($authorizeParams);
        $result = $response->toArray();

        // オーソリが成功したか確認
        $amazonAuthorizationId = $result['AuthorizeResult']['AuthorizationDetails']['AmazonAuthorizationId'];
        if (empty($amazonAuthorizationId)) {
            header('Location: /error.html');
            exit;
        }
        if ($client->success === false) {
            header('Location: /error.html');
            exit;
        }

        // (5) 注文を確定
        $captureParams = array(
            'amazon_authorization_id' => $amazonAuthorizationId,
            'capture_amount' => self::AMOUNT,
            'currency_code' => 'JPY',
            'capture_reference_id' => 'Order_' . time(),
            'seller_capture_note' => '購入が完了しました',
        );
        $response = $client->capture($captureParams);
        $result = $response->toArray();

        // 注文の確定に失敗したらオーソリを取り消して、注文をクローズする
        if ($result['ResponseStatus'] !== '200') {
            $cancelParams = array(
                'merchant_id' => self::MERCHANT_ID,
                'amazon_order_reference_id' => $referenceId,
            );
            $client->cancelOrderReference($cancelParams);
            $closeParams = array(
                'merchant_id' => self::MERCHANT_ID,
                'amazon_authorization_id' => $amazonAuthorizationId,
            );
            $client->closeAuthorization($closeParams);

            header('Location: /error.html');
            exit;
        }

        header('Location: /success.html');
        exit;
    }
}

$payment = new Payment();
$payment->execute();
?>