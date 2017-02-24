<?php

// parameters
$hubVerifyToken = 'facebookMartisorToken';
$accessToken = "EAASDZAXZCTSZCoBABu94tbCTYHu8Jh9pUwQ8m8oKeJdKmchWsFM7NA0JAFVPAnI82J0aUO2hN8hypfzm15XCw5CYRQ1ZAHZBxMNZBfftwNDGd9JjWQGEI5BwtwyocQUZB2SLHv0eolaCYrZBoS9EcQZB1HeyTmZB5C3ZA2vg6CyKU0XzgZDZD";
// check token at setup
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
    echo $_REQUEST['hub_challenge'];
    exit;
}

// handle bot's anwser
$input = json_decode(file_get_contents("php://input"), true);
$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];
$postBack = $input['entry'][0]['messaging'][0]['message']['quick_reply']['payload'];

// ob_start();
// var_dump($postBack);
// $data = ob_get_clean();
// file_put_contents("Search Log.txt", $messageText);

// ob_start();
// var_dump($postBack);
// $data = ob_get_clean();
// file_put_contents("Search Log.txt", $data);

//$stuff = [1, 2, 3, 4];
if($messageText != "") {
        $responseArray =[
            'recipient' => [ 'id' => $senderId ],
            'message' => [
                'text' => 'Salut si tie',
            ]
        ];

        $ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($responseArray));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($ch);
        curl_close($ch);
}
?>