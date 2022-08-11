<?php

use Sunra\PhpSimple\HtmlDomParser;

define(TOKEN, '5498542961:AAGebxcoFWCfxYDtlmoHRATqds2PUZov5uw');

function request($method, $data = [])
{
    $url = 'https://api.telegram.org/bot' . TOKEN . '/' . $method;
    $ch = curl_init($url);
    var_dump($ch);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $res = curl_exec($ch);
//    header("Content-Type: application/json");
//    $data['method'] = $method;
//    echo json_encode($data);

    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        return json_decode($res);
    }
    return json_decode($res);
}

function sm(
    $chat_id,
    $text,
    $reply_markup = null,
    $parse_mode = null
)
{
    $data = [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => $parse_mode,
        'reply_markup' => $reply_markup];
    return request('sendMessage', $data);
}


function answer_inline_query(
    $inline_query_id,
    $results = [],
    $switch_pm_text = null,
    $switch_pm_parameter = null
)
{
    $data = [
        'inline_query_id' => $inline_query_id,
        'results' => $results,
        'cache_time' => 0
    ];
    if ($switch_pm_text) $data['switch_pm_text'] = $switch_pm_text;
    if ($switch_pm_parameter) $data['switch_pm_parameter'] = $switch_pm_parameter;
    return request('answerInlineQuery', $data);
}

//function parseByQuery($query){
//    $html = file_get_html('https://latifa.uz/?search=' . $query);
//    $data = [];
//    foreach ($html->find('.bg-white.rounded.mb-2.p-3') as $key => $value) {
//        foreach ($html->find('div[data-id]') as $key1 => $item) {
//            $data[$key1] = $item->innertext;
//        }
//    }
//    return $data;
//}

function inline_query_response($query_id, $query)
{

    if (isset($query)) {
        $html = HtmlDomParser::file_get_html('https://latifa.uz/?search=' . $query);
        $data = [];
        foreach ($html->find('.bg-white.rounded.mb-2.p-3') as $key => $value) {
            foreach ($html->find('div[data-id]') as $key1 => $item) {
                $data[$key1] = $item->innertext;
            }
        }
        $i = 1;
        file_put_contents('test.txt', json_encode($data));
        foreach ($data as $value) {
            $value = htmlspecialchars($value);
            $results[] = [
                'type' => 'article',
                'id' => $i,
                'title' => 'latifani dodasi',
                'description' => 'axaxax',
                'input_message_content' => [
                    'message_text' => $value,
                    'parse_mode' => 'HTML',
                    'disable_web_page_preview' => true,
                ],
            ];
            $i++;
        }
    } else $results = [
        'type' => 'article',
        'id' => 1,
        'title' => 'LATIFALARNI DODASI',
        'description' => '@LAQMA',
        'input_message_content' => [
            'message_text' => "@LAQMA kanaliga obuna bo'ling",
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true,
        ],
    ];
    return answer_inline_query($query_id, json_encode($results));
}

function inline_query_result_article($id, $title, $message_text)
{
    return request('InlineQueryResultArticle',
        [
            "type" => 'article',
            "id" => $id,
            "title" => $title,
            "input_message_content" => json_encode(["message_text" => $message_text]),
        ]);
}

function toCyrill($textlat = null)
{
    $cyr = array('ш', 'щ', 'ч', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й',
        'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у',
        'ф', 'х', 'ц', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'ў', 'қ', 'ғ', 'ҳ',
        'Ч', 'Ш', 'Щ', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н',
        'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'Ў', 'Қ', 'Ғ', 'Ҳ');
    $lat = array('sh', 'sht', 'ch', 'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z',
        'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u',
        'f', 'h', 'ts', 'a', 'i', 'y', 'e', 'yu', 'ya', "o'", "q", "g'", 'h',
        'Ch', 'Sh', 'Sht', 'A', 'B', 'V', 'G', 'D', 'E', 'Zh',
        'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U',
        'F', 'H', 'Ts', 'A', 'Y', 'Yu', 'Ya', "O'", "Q", "G'", "H");
    if ($textlat) return str_replace($lat, $cyr, $textlat);
    else return null;
}

function toLatin($textcyr = null)
{
    $cyr = array('ш', 'щ', 'ч', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й',
        'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у',
        'ф', 'х', 'ц', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'ў', 'қ', 'ғ', 'ҳ',
        'Ч', 'Ш', 'Щ', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н',
        'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'Ў', 'Қ', 'Ғ', 'Ҳ');
    $lat = array('sh', 'sht', 'ch', 'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z',
        'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u',
        'f', 'h', 'ts', 'a', 'i', 'y', 'e', 'yu', 'ya', "o'", "q", "g'", 'h',
        'Ch', 'Sh', 'Sht', 'A', 'B', 'V', 'G', 'D', 'E', 'Zh',
        'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U',
        'F', 'H', 'Ts', 'A', 'Y', 'Yu', 'Ya', "O'", "Q", "G'", "H");
    if ($textcyr) return str_replace($cyr, $lat, $textcyr);
    else return null;
}

function transliterate($text)
{
    if (ifLatin($text)) {
        return toCyrill($text);
    } else return toLatin($text);
}

function ifLatin($string)
{
    if (!preg_match('/[^A-Za-z0-9] ,.\'":;/', $string))
        return true;
    else return false;
}