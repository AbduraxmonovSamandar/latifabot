<?php


$in_pass = json_encode([
    'inline_keyboard' => [
        [['text' => "Создать пароль", 'switch_inline_query' => " "]],
        [['text' => "Рандомное число", 'switch_inline_query' => " "]],
    ]
]);


if ($text == "inline") {
    bot('sendmessage', [
        'chat_id' => $cid,
        'text' => "<b>Наш бот теперь работает и в инлайн режиме!</b>",
        'parse_mode' => 'html',
        'reply_markup' => $in_pass,
    ]);
}

//inline

$iuid = $update->inline_query->from->id;
$iid = $update->inline_query->id;
$icid = $update->inline_query->chat->id;
$imid = $update->inline_query->message->id;
$bot = '@LuciRand_Bot' . bot('getme', ['bot'])->result->username;
$query = $update->inline_query->query;

// if(mb_stripos($query,"pass")!==false){
//   bot('answerInlineQuery',[
//     'inline_query_id'=>$iid,
//     'cache_time'=>1,
//     'results'=>json_encode([[
//     'type'=>'article',
//     'id'=>base64_encode(1),
//     'thumb_url'=>"https://i.pinimg.com/originals/77/92/e6/7792e685d1e213b67bfcafacae03651c.jpg",
//     'title'=>"Рандомный пароль!",
//     'input_message_content'=>[
//     'disable_web_page_preview'=>true,
//     'parse_mode'=>'MarkDown',
//     'message_text'=>"`$password`",
//   ],

//     'reply_markup'=>[
//             'inline_keyboard'=>[
//  [['text'=>"Перейти в бот",'url'=>"t.me/lucirand_bot"]],
//         ]],
//         ]
//         ])
// ]);
// }

#===================================================
if (mb_stripos($query) !== true) {
    bot('answerInlineQuery', [
        'inline_query_id' => $iid,
        'cache_time' => 1,
        'results' => json_encode([[

                'type' => 'article',
                'id' => base64_encode(1),
                'thumb_url' => "https://lucifer.xvest.ru/random/img/rand.png",
                'title' => "Рандомные числа!",
                'input_message_content' => [
                    'disable_web_page_preview' => true,
                    'parse_mode' => 'MarkDown',
                    'message_text' => "👉*$rand_numb100*",
                ]],
                [
                    'type' => 'article',
                    'id' => base64_encode(2),
                    'thumb_url' => "https://lucifer.xvest.ru/random/img/pass.jpg",
                    'title' => "Рандомный пароль!",
                    'input_message_content' => [
                        'disable_web_page_preview' => true,
                        'parse_mode' => 'MarkDown',
                        'message_text' => "`$password`",
                    ]],
            ]
        )
    ]);
}
//

