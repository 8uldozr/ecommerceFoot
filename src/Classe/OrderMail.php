<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class OrderMail
{
     private $api_key = 'a294581d820ca4801f80b91c6b1aff56';
     private $api_key_secret = '6b6e56d41a2cebbc549376b352a67a48';

    public function send($to_email, $to_name, $subject, $content) {

        $mj = new \Mailjet\Client($this->api_key,$this->api_key_secret,true,['version' => 'v3.1']);
        $body = [
          'Messages' => [
            [
              'From' => [
                'Email' => "8uld0zr@pm.me",
                'Name' => "Footix.fr"
              ],
              'To' => [
                [
                  'Email' => $to_email,
                  'Name' => $to_name
                ]
              ],
              'TemplateID' => 3205207,
              'TemplateLanguage' => true,
              'Subject' => $subject,
              'Variables' => [
                  'content' => $content
              ]
            ]
          ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() ;
}
}