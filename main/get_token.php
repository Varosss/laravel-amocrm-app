<?php

$subdomain = 'mytestaccount908975'; //Поддомен нужного аккаунта
$link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса

/** Соберем данные для запроса */
$data = [
    'client_id' => '3b62508f-759f-48de-8373-d06964115fc6',
    'client_secret' => 'PJg14ZGLJEfZsOg6MzwzQCfwbLfNwYRsoYqu6ja2kSRP1rOnr7hVOjwyPABONl1D',
    'grant_type' => 'authorization_code',
    'code' => "def50200a9cc6c242df87634e9b641e1a20b372618b9ae4fd07777c68220cdd377c3aeb0d6f881b040490bf6ffa4f8839c52ff42d58c1c6ab9766baa320ea2cb08a1ad69c7e28b256e5e889fe2dea45ad3662f329bf43d00069e6718d7ef43fb7f47a3c0ff8324089f05dd8b916acc0d2ea6cd2d4a85d68390fef0f138a822c51054e015d164afffa6a2c5d64d1470bdf828ad12822eb98b5331f56e037157714c9568d003c10c48d0c235cdddd712524ee94bd6ac59ce1f6b82d832348b3d9681d0f123381c695928f18f0cab5a3f2f3adae2befdb2dd02092d76ea009225d7cfe9c5cc6c7454d1598ca6b7736d7b04fb4aadca61a402765311162ee4eadeb07ef68045ba50d9e9675044486b5dd9947f9a617d12ceb1d91a643ca04c059a3e09b08c61cb1e4f69a40f3d8ab71fb2798f960d61a61662bed747cd7ab643e6a10d746eaaf7800ab9268ac01a62474ab6f3bf4fe9c5309e2023c4691a5ef204f219891e4c3742331fa3fd18f5d5ab92ae6f5e621d6920becd50aa1f42c8e8f6286e993ec04f453b26ed79e1df8de4341f897664c8d0007e4249123f557817ea471b976fa93aa3bd0ca19b1dfd1a8a4d04e002fdc4ec239a6f2a2e3ac506c19a83",
    'redirect_uri' => 'https://webhook.site/'
];

/**
 * Нам необходимо инициировать запрос к серверу.
 * Воспользуемся библиотекой cURL (поставляется в составе PHP).
 * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
 */
$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
/** Устанавливаем необходимые опции для сеанса cURL  */
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
// curl_setopt ($curl, CURLOPT_CAINFO, "C:\php\cacert.pem");

$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
/** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
$code = (int)$code;

$errors = [
    400 => 'Bad request',
    401 => 'Unauthorized',
    403 => 'Forbidden',
    404 => 'Not found',
    500 => 'Internal server error',
    502 => 'Bad gateway',
    503 => 'Service unavailable',
];


try
{
    /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
    if ($code < 200 || $code > 204) {
        throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
    }
}
catch(Exception $e)
{
    die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
}

/**
 * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
 * нам придётся перевести ответ в формат, понятный PHP
 */
$response = json_decode($out, true);

$access_token = $response['access_token']; //Access токен
$refresh_token = $response['refresh_token']; //Refresh токен
$token_type = $response['token_type']; //Тип токена
$expires_in = $response['expires_in']; //Через сколько действие токена истекает

$token_data = [
    "accessToken" => $response['access_token'],
    "refreshToken" => $response['refresh_token'],
    "expires" => $response['expires_in'],
    "baseDomain" => $subdomain . ".amocrm.com"
];

$token_info = json_encode($token_data);
file_put_contents("token_info.json", $token_info);