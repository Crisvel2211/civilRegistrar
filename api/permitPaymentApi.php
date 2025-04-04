<?php
header("Content-Type: application/json");

// Replace with your PayMongo Secret API Key
$secretKey = "sk_test_QBwYBpDoV3QDqmiNNgPknXkx"; 

// Get the JSON input from frontend
$data = json_decode(file_get_contents("php://input"), true);

// Get customer name and email from frontend data
$customerName = isset($data['name']) ? $data['name'] : "Customer";
$customerEmail = isset($data['email']) ? $data['email'] : "customer@example.com";

$amount = 1000 * 100; // Convert 200 PHP to centavos (20000)


// Define the Checkout Session data
$checkoutData = [
    "data" => [
        "attributes" => [
            "billing" => [
                "name" => $customerName,
                "email" => $customerEmail
            ],
            "line_items" => [
                [
                    "currency" => "PHP",
                    "amount" => $amount,
                    "name" => "Permit Fee",
                 "description" => "Payment for official Request A Permit",
                "quantity" => 1
                ]
            ],
            "description" => "Payment for services", // ✅ Fix: Added at session level
            "payment_method_types" => ["card", "gcash", "paymaya"],
            "send_email_receipt" => true,
            "show_description" => true,
            "show_line_items" => true,
            "success_url" => "https://civilregistrar.lgu2.com/pages/resident/permit.php",
            "cancel_url" => "https://civilregistrar.lgu2.com/pages/cancel.php"
        ]
    ]
];

// Initialize cURL request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/checkout_sessions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($checkoutData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Basic " . base64_encode($secretKey . ":")
]);

// Execute request
$response = curl_exec($ch);
curl_close($ch);

// Decode the response
$result = json_decode($response, true);

// Check if Checkout Session was created successfully
if (isset($result['data']['attributes']['checkout_url'])) {
    echo json_encode(["checkout_url" => $result['data']['attributes']['checkout_url']]);
} else {
    echo json_encode(["error" => "Failed to create checkout session", "details" => $result]);
}
?>
