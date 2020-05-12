<?php

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Middleware\ApiAi;
use App\Http\Controllers\BotManController;

$dialogFlowToken = env('DIALOG_FLOW_TOKEN');

$dialogFlow = ApiAi::create($dialogFlowToken)->listenForAction();

/** @var BotMan $botman */
$botman = resolve('botman');

$botman->middleware->received($dialogFlow);

$botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->hears('input.welcome', function (BotMan $bot){

$extras = $bot->getMessage()->getExtras();
$apiReply = $extras['apiReply'];
$apiAction = $extras['apiAction'];
$apiIntent = $extras['apiIntent'];

$bot->reply($apiReply);
})->middleware($dialogFlow);