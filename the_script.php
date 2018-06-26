$apikey = $_GET['apikey'];
if (hash('sha512',$apikey) == '') {
		define('API_KEY',$apikey);
} else {
		exit('We\'re done here Mr. '.$_SERVER['REMOTE_ADDR'].' '.$_SERVER['HTTP_X_FORWARDED_FOR']);
}
 


$content = file_get_contents("php://input");
$update = json_decode($content, true);

 
if ($exp_msg_text[0] == "/start") {
	sendMessage($update['message']['chat']['id'],"Hello, \nI can extract the bot token from the ugly message the @botfather sends you...\n\n<b>NOTE: WE DO NOT STORE ANYTHING YOU SEND US (INCLUDING THE TOKEN)!</b>\n\n<i>Source code: </i>https://github.com/wjclub/telegram-bot-tokenextract"); 
} else {
	$res = getToken($update['message']['text']);
	if ($res['ok'] == true) {
		sendMessage($update['message']['chat']['id'],$res['bot_info']);
		sendMessage($update['message']['chat']['id'],'<code>'.$res['token'].'</code>');
	} else {
		sendMessage($update['message']['chat']['id'],'"<code>'.$res['token'].'</code>" is not a valid bot token...'."\nCorrect your input or contact @wjclub about it");
	}
}
 
function sendMessage($chat_id,$reply){
	$reply_content = [
	'method' => "sendMessage",
	'chat_id' => $chat_id,
	'parse_mode' => 'HTML',
	'text' => $reply,
	];
	$reply_json = json_encode($reply_content);
//async request
	$url = 'https://api.telegram.org/bot'.API_KEY.'/';
	$cmd = "curl -s -X POST -H 'Content-Type:application/json'";
	$cmd.= " -d '" . $reply_json . "' '" . $url . "'";
	exec($cmd, $output, $exit);
}
 






