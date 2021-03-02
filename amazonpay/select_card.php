<?php
    session_start();
    $_SESSION['access_token'] = $_GET['access_token'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>クレジットカード選択ページ</title>
</head>

<body>
<div id="walletWidgetDiv" style="width:300px; height:240px;"></div>
<script>
    window.onAmazonLoginReady = function() {
        amazon.Login.setClientId('--- CLIENT_ID ---');
    };
</script>
<script src='https://static-fe.payments-amazon.com/OffAmazonPayments/jp/sandbox/lpa/js/Widgets.js'></script>
<script type="text/javascript">
    new OffAmazonPayments.Widgets.Wallet({
        sellerId: '--- MERCHANT_ID ---',
        onOrderReferenceCreate: function (orderReference) {
            orderReferenceId = orderReference.getAmazonOrderReferenceId();
            document.getElementById("orderReferenceId").value = orderReferenceId;
        },
        onPaymentSelect: function () {
        },
        design: {
            designMode: 'responsive'
        },
        onError: function (error) {
        }
    }).bind("walletWidgetDiv");
</script>
<form action="/payment.php" method="POST">
    <input type="hidden" id="orderReferenceId" name="orderReferenceId">
    <input type="submit" value="購入する">
</form>
</body>
</html>