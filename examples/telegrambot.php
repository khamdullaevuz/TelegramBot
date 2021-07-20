<?php

/**
 * @description Telegram bot library
 * @author Elbek Khamdullaev <elbekh75@gmail.com>
 * @license free and open source
 */

require_once __DIR__ . '/../vendor/autoload.php';

use TelegramBot\TelegramBot;

$bot = new TelegramBot("API_KEY");

$update = $bot->getData('php://input');
if(empty($update)) exit;
$message = $update['message'];
$chat_id = $message['chat']['id'];
$user_id = $message['from']['id'];
$username = $message['from']['username'];
$name = $message['from']['first_name'].' '.$message['from']['last_name'];
$text = $message['text'];
$message_id = $message['message_id'];
$callback_query = $update['callback_query'];
$callback_id = $callback_query['id'];
$callback_data = $callback_query['data'];
$callback_chat_id = $callback_query['message']['chat']['id'];
$callback_message_id = $callback_query['message']['message_id'];

$main = $bot->buildInlineKeyboard([
	[["Inline Keyboard test","inline"],["Custom keyboard test","custom"]],
]);

if($text == "/start"){

	$bot->sendAction($chat_id, "typing");

	$bot->sendMessage($chat_id, [
		'text'=>"Assalomu alaykum ".$name,
		'reply_markup'=>$main
	]);

}

if($callback_data == 'inline'){
	$bot->answerCallback($callback_id, "Test uchun", true);
}

if($callback_data == 'custom'){

	$bot->deleteMessage($callback_chat_id, $callback_message_id);

	$keyboard = $bot->buildKeyboard([
		['Test','Test'],
		['Test']
	]);

	$bot->sendMessage($callback_chat_id, [
		'text'=>"Custom keyboard",
		'reply_markup'=>$keyboard
	]);

}
