<?php

require_once 'lib/botlib.php';

define(TOKEN, '5498542961:AAGebxcoFWCfxYDtlmoHRATqds2PUZov5uw');

$update = json_decode(file_get_contents('php://input'), true);
file_put_contents('update.txt', file_get_contents('php://input'));

if (isset($update['message'])) {
    $m = $update['message'];
    $chat = $m['chat']['id'];
    if ($m['text'] == '/start')
        sm($chat,
            'axaxa nichego sebe, qizcha, botimizi topib kiraldizmi, qoyil lekin qoyil?',
            json_encode(['inline_keyboard' => [
                [['text' => 'latifa qidirish', 'switch_inline_query_current_chat' => 'latifa']]
            ]]));
}

if (isset($update['inline_query'])){
    $iid = $update['inline_query']['id'];
    $query = $update['inline_query']['query'];
    inline_query_response($iid, $query);
}