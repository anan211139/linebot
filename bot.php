<?php


$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = 'whL7cvNKhDmCPOf944M3nAf3zBvnk4is6M6G4R+w5iKhBU/zi+vq2rhwFMND1DppeeIJpTkVy5uLZAJ+Z3rApobOvYY9Z1SlFO2roDt4bfM+5OTrAoHYwrU/ijcIlLN4keD1oKmW7aAWBjG+ze5ZawdB04t89/1O/w1cDnyilFU='; 
$channelSecret = 'e82b26972d4a96baa7861926e3c46012';
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array


function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}


if ( sizeof($request_array['events']) > 0 ) {

    foreach ($request_array['events'] as $event) {

        $reply_message = '';
        $reply_token = $event['replyToken'];

        $text = $event['message']['text'];
        if($text == "content"){
            $data = [
                'replyToken' => $reply_token,
                'messages' => [['type' => 'text', 'text' => json_encode($request_array) ]] // Debug Detail message
            ];
        }else if("สวัสดีครับ"){
            $text = "สวัสดีค่ะ คุณไกรพุฒิ มีอะไรให้ช่วยเหลือคะ"
            $data = [
                'replyToken' => $reply_token,
                'messages' => [['type' => 'text', 'text' => $text ]]
            ];
        }else if("สอบถามวันลาพักร้อน"){
            $text = "สิทธิวันลาพักร้อนคงเหลือ 4 วันค่ะ"
            $data = [
                'replyToken' => $reply_token,
                'messages' => [['type' => 'text', 'text' => $text ]]
            ];
        }else if("ค่ารักษาพยาบาล"){
            $text = "ค่ารักษาพยาบาลคุณไกรพุฒิ มีดังนี้ค่ะ<br>- ค่ารักษาพยาบาลผู้ป่วยนอก (OPD) 25,000/ปี<br>- ค่ารักษาพยาบาลผู้ป่วยใน และค่าอาหาร (IPD) 3,000/วัน"
            $data = [
                'replyToken' => $reply_token,
                'messages' => [['type' => 'text', 'text' => $text ]]
            ];
        }
        // else if("ขอเอกสารสมัครกองทุนสำรองเลี้ยงชีพ"){
        //     $text = "ค่ารักษาพยาบาลคุณไกรพุฒิ มีดังนี้ค่ะ<br>- ค่ารักษาพยาบาลผู้ป่วยนอก (OPD) 25,000/ปี<br>- ค่ารักษาพยาบาลผู้ป่วยใน และค่าอาหาร (IPD) 3,000/วัน"
        //     $data = [
        //         'replyToken' => $reply_token,
        //         'messages' => [['type' => 'text', 'text' => $text ]]
        //     ];
        // }


        
        $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

        $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

        echo "Result: ".$send_result."\r\n";
    }
}

echo "OK";
?>



