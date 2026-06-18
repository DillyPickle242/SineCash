<?php
include_once 'sessionStart.php';
include_once 'db_people.php';

$recipient = $_SESSION['id'];
$amount = floatval($_POST['requestCashAmount'] ?? 0);
$sendOrRequest = "request";
$note = trim($_POST['requestNote'] ?? '');
$fulfilled = 'new';
$response = ' ';
$transactionId = ' ';

$selectedPeople = $_POST['requestPersonSelect'] ?? [];
if (!is_array($selectedPeople)) {
    $selectedPeople = [$selectedPeople];
}

$selectedPeople = array_filter(array_map('intval', $selectedPeople));
$count = count($selectedPeople);

if ($count > 0 && $amount > 0) {
    $cents = round($amount * 100);
    $baseCents = intdiv($cents, $count);
    $remainder = $cents - ($baseCents * $count);

    foreach ($selectedPeople as $index => $sender) {
        $splitCents = $baseCents + ($index === $count - 1 ? $remainder : 0);
        $splitAmount = $splitCents / 100;
        transaction($sender, $recipient, $splitAmount, $sendOrRequest, $note, $fulfilled, $response, $transactionId);
    }
}

header("location: index.php");
