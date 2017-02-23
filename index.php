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

$stuff = [1, 2, 3, 4];
if($messageText != "") {
  if($messageText == "ok"){
  $responseArray =[
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 
                        'text' => 'Care este culoarea ei favorita', 
                        'quick_replies' => [
                             0 => [
                                 "content_type"=>"text",
                                 "title"=>"Rosu",
                                 "payload"=>"1",
                                 "image_url"=>"https://martisor-bogdanneacsu.c9users.io/raw/1.png"
                                 ],
                            1 => [
                                 "content_type"=>"text",
                                 "title"=>"Albastru",
                                 "payload"=>"2",
                                 "image_url"=>"https://martisor-bogdanneacsu.c9users.io/raw/1.png"
                                 ]
                            
                            ]
                    ] 
      ];

    $ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($responseArray));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_exec($ch);
    curl_close($ch);
  }elseif($postBack != '' || $postBack != null){
      if(in_array($postBack, $stuff)){
        $answer = "Cum o cheama?";
        $file = $senderId.'.txt';
        file_put_contents($file, $postBack);
        $response = [
        
            'recipient' => [ 'id' => $senderId ],
            'message' => [ 'text' => $answer ]
        ];
        $ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($ch);
        curl_close($ch);    
      }elseif($postBack == 'name'){
        $responseArray =[
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 
                        'text' => 'Care este culoarea ei favorita', 
                        'quick_replies' => [
                             0 => [
                                 "content_type"=>"text",
                                 "title"=>"Rosu",
                                 "payload"=>"1",
                                 "image_url"=>"https://martisor-bogdanneacsu.c9users.io/raw/1.png"
                                 ],
                            1 => [
                                 "content_type"=>"text",
                                 "title"=>"Albastru",
                                 "payload"=>"2",
                                 "image_url"=>"https://martisor-bogdanneacsu.c9users.io/raw/1.png"
                                 ]
                            
                            ]
                    ] 
      ];

    $ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($responseArray));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_exec($ch);
    curl_close($ch);
      }elseif($postBack == 'text'){
          $answer = "Schimb textul";
      
          $response = [
        
            'recipient' => [ 'id' => $senderId ],
            'message' => [ 'text' => $answer ]
        ];
        $ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($ch);
        curl_close($ch);
      }
}elseif($messageText != "ok"){
    // file_put_contents("Search Log.txt", $senderActions[$senderId]);
    // Create objects
    $imageChoosen = file_get_contents($senderId.'.txt');
    $image = new Imagick('raw/'.$imageChoosen.'.png');
    
    // Watermark text
    $text = ucfirst($messageText).",";
    
    // Create a new drawing palette
    $draw = new ImagickDraw();
    
    // Set font properties
    $draw->setFont('Montserrat-Bold.ttf');
    $draw->setFontSize(30);
    $draw->setFillColor('#7f7f7f');
    
    // Position text at the bottom-right of the image
    // $draw->setGravity(Imagick::GRAVITY_SOUTHEAST);
    
    // Draw text on the image
    $image->annotateImage($draw, 60, 132, 0, $text);
    
    // Draw text again slightly offset with a different color
    $draw->setFillColor('white');
    $image->annotateImage($draw, 60, 130, 0, $text);
    
    // // Set output image format
    $image->setImageFormat('png');
    $nameImageUnique = time().$senderId;
    file_put_contents ($nameImageUnique.".png", $image); // works, or:
        
    $raspunPoza = '{"recipient":{"id":"'.$senderId.'"},"message":{"attachment":{"type":"image","payload":{"url":"martisor-bogdanneacsu.c9users.io/'.$nameImageUnique.'.png"}}}}';
  
    $ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $raspunPoza);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($ch);
        curl_close($ch);
        $responseArray =[
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 
                        'text' => 'Vrei sa schimbi ceva?', 
                        'quick_replies' => [
                             0 => [
                                 "content_type"=>"text",
                                 "title"=>"Schimb numele",
                                 "payload"=>"name",
                                 "image_url"=>"https://martisor-bogdanneacsu.c9users.io/raw/1.png"
                                 ],
                            1 => [
                                 "content_type"=>"text",
                                 "title"=>"Schimb Textul",
                                 "payload"=>"text",
                                 "image_url"=>"https://martisor-bogdanneacsu.c9users.io/raw/1.png"
                                 ]
                            
                            ]
                    ] 
      ];

    $ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($responseArray));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_exec($ch);
    curl_close($ch);
}
else{
      $answer = "Daca vrei sa faci un martisor penteu o colega scrie: ok";
      
      $response = [
    
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer ]
    ];
    $ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_exec($ch);
    curl_close($ch);
  }
}
?>