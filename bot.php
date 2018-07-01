<?php
// กรณีต้องการตรวจสอบการแจ้ง error ให้เปิด 3 บรรทัดล่างนี้ให้ทำงาน กรณีไม่ ให้ comment ปิดไป
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
// include composer autoload
// require_once '../vendor/autoload.php';
require_once './vendor/autoload.php';
 
// การตั้งเกี่ยวกับ bot
require_once 'bot_settings.php';
 
// กรณีมีการเชื่อมต่อกับฐานข้อมูล
//require_once("dbconnect.php");
 
///////////// ส่วนของการเรียกใช้งาน class ผ่าน namespace
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
//use LINE\LINEBot\Event;
//use LINE\LINEBot\Event\BaseEvent;
//use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;
 
// เชื่อมต่อกับ LINE Messaging API
$httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
$bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));
 
// คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
$content = file_get_contents('php://input');
 
// แปลงข้อความรูปแบบ JSON  ให้อยู่ในโครงสร้างตัวแปร array
$events = json_decode($content, true);

if(!is_null($events)){
    // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
    $replyToken = $events['events'][0]['replyToken'];
    $joinevent = $events['events'][0]['type'];
    $typeMessage = $events['events'][0]['message']['type'];
    $userMessage = strtolower($events['events'][0]['message']['text']);
   
    switch ($typeMessage){
        case 'text':
            switch ($userMessage) {
                case "robot1on":
                    $textReplyMessage = "ฉัน เปิด แสงสว่างหน้าบ้านแล้ว ค่ะ";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;

                case "robot1off":
                    $textReplyMessage = "ฉัน ปิด แสงสว่างหน้าบ้านแล้ว ค่ะ";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;

                case "robot2on":
                    $textReplyMessage = "ฉัน เปิด แสงสว่างหลังบ้านแล้ว ค่ะ";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;

                case "robot2off":
                    $textReplyMessage = "ฉัน ปิด แสงสว่างหลังบ้านแล้ว ค่ะ";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;     
					
                case "robot3on":
                    $textReplyMessage = "ฉัน เปิด แสงสว่างในบ้านแล้ว ค่ะ";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;

                case "robot3off":
                    $textReplyMessage = "ฉัน ปิด แสงสว่างในบ้านแล้ว ค่ะ";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;     

                case "robot4on":
                    $textReplyMessage = "ฉัน เปิด แสงสว่างโรงรถแล้ว ค่ะ";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;

                case "robot4off":
                    $textReplyMessage = "ฉัน ปิด แสงสว่างโรงรถแล้ว ค่ะ";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;  


                default:
                    $textReplyMessage = "เรียกฉันได้ ถ้าให้ฉันบริการคุณ";
                    $picFullSize = 'https://esp100chon.herokuapp.com/image/manu.jpg';
                    $picThumbnail = 'https://esp100chon.herokuapp.com/image/manu.jpg';
					$Data1 = new TextMessageBuilder($textReplyMessage);
                    $Data2 = new ImageMessageBuilder($picFullSize,$picThumbnail);
                    $replyData = $Data1,$Data2;
                    break;                                      
            }
            break;
        default:
            $textReplyMessage = json_encode($event);
            $replyData = new TextMessageBuilder($textReplyMessage);         
            break;  
    }
//l ส่วนของคำสั่งตอบกลับข้อความ


$response = $bot->replyMessage($replyToken , $replyData);
 
    if ($response->isSucceeded()) {
        echo 'Succeeded!';
        return;
    }

// Failed
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
 
}
?>