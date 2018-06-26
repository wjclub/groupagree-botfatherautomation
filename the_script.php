$apikey = $_GET['apikey'];
if (hash('sha512',$apikey) == 'fbdca9116c628886c4f52eda09590df587c2e1972d14173934f313c1e85dc5875ebec8c2b5a2545a21ada7a22accea8c47805dad9c9d2afd74af84f2d4ec324c') {
	define('API_KEY',$apikey);
} else {
	exit('We\'re done here Mr. '.$_SERVER['REMOTE_ADDR'].' '.$_SERVER['HTTP_X_FORWARDED_FOR']);
}
$content = file_get_contents("php://input");
$update = json_decode($content, true);
$result = preg_replace("/[^a-zA-Z0-9]+/", "", $update['message']['text']);
$botusername = strtolower($result);
sendMessage($update['message']['chat']['id'],"/newbot");
sendMessage($update['message']['chat']['id'],$update['message']['text']);
sendMessage($update['message']['chat']['id'],'@'.$botusername);
sendMessage($update['message']['chat']['id'],"/setinline");
sendMessage($update['message']['chat']['id'],'@'.$botusername);
sendMessage($update['message']['chat']['id'],"Search polls...");
sendMessage($update['message']['chat']['id'],"/setinlinefeedback");
sendMessage($update['message']['chat']['id'],'@'.$botusername);
sendMessage($update['message']['chat']['id'],"Enabled");
sendMessage($update['message']['chat']['id'],"/setjoingroups");
sendMessage($update['message']['chat']['id'],'@'.$botusername);
sendMessage($update['message']['chat']['id'],"Disable");
sendMessage($update['message']['chat']['id'],"/setcommands");
sendMessage($update['message']['chat']['id'],'@'.$botusername);
sendMessage($update['message']['chat']['id'],"start - 📝 Create a new poll\nlist - 📋 List all polls\ncancel - 🚫 Cancel the current operation\nhelp - ℹ️ Get help\nlang - 🗣Change language");

function sendMessage($chat_id,$reply) {
	$reply_content = [
	'method' => "sendMessage",
	'chat_id' => $chat_id,
	'parse_mode' => 'HTML',
	'text' => $reply,
	];
	$reply_json = json_encode($reply_content);
	$url = 'https://api.telegram.org/bot'.API_KEY.'/';
	$cmd = "curl -s -X POST -H 'Content-Type:application/json'";
	$cmd.= " -d '" . $reply_json . "' '" . $url . "'";
	exec($cmd, $output, $exit);
}
 






