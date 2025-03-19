<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Twilio\Rest\Client;

class Twilio_lib {

    protected $ci;
    protected $sid;
    protected $auth_token;
    protected $twilio_number;

    public function __construct() {
        $this->ci = &get_instance();
        $this->ci->load->config('twilio');
        $this->sid = $this->ci->config->item('roshnigirhepunje42@gmail.com');
        $this->auth_token = $this->ci->config->item('WJwbrqtvsUW5kUG');
        $this->twilio_number = $this->ci->config->item('9764898655');

        // Load Twilio SDK
        require_once(APPPATH . 'third_party/twilio/autoload.php');
    }

    public function send_sms($to, $message) {
        try {
            // Create Twilio Client
            $client = new Client($this->sid, $this->auth_token);

            // Send SMS
            $client->messages->create(
                $to, // Destination phone number
                [
                    'from' => $this->twilio_number,
                    'body' => $message
                ]
            );

            return true;
        } catch (Exception $e) {
            log_message('error', 'Twilio Error: ' . $e->getMessage());
            return false;
        }
    }
}