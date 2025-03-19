<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->library('Twilio_lib');

class SendingSMS extends CI_Controller
{
public function send_loan_request_sms($phone_number, $status) {
// Prepare message based on loan status
if ($status == 'pending') {
$message = 'Your loan request is currently pending. We will notify you once it is processed.';
} elseif ($status == 'approved') {
$message = 'Your loan request has been approved! Please check your account for further details.';
} else {
$message = 'There was an error processing your loan request. Please try again later.';
}

// Send SMS using Twilio
$to = '+' . $phone_number; // Ensure the phone number is in the correct format (with country code)
$result = $this->twilio_lib->send_sms($to, $message);

if ($result) {
echo 'SMS sent successfully!';
} else {
echo 'Failed to send SMS.';
}
}
}