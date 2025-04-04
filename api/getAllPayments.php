<?php
// list_payments.php
$secret_key = "sk_test_QBwYBpDoV3QDqmiNNgPknXkx"; // Replace with your PayMongo Secret Key

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/payments");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Basic " . base64_encode($secret_key . ":"),
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
curl_close($ch);

header('Content-Type: application/json');
echo $response;
?>
