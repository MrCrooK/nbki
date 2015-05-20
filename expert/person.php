<?
$post = array(
's01' => '1',
's02' => '1',
's03' => '1',
's21' => '1',
's05' => '1',
's09' => '1',
's06' => '1',
's10' => '1',
's07' => '1',
's24' => '1',
's23' => '1',
's08' => '1',
's13' => '1',
's26' => '1',
's14' => '1',
's15' => '1',
's16' => '1',
's18' => '1',
's19' => '1',
's20' => '1',
's25' => '1',
't1' => $person[0],
't2' => $person[1],
't3' => $person[2],
't4' => $person[3],
't5' => $person[4],
't6' => $person[5],
't8' => $person[6],
);
header("Content-Type: text/html; charset=cp1251");
$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, ('cookie.txt'));
curl_setopt($ch, CURLOPT_COOKIEJAR, ('cookie.txt'));
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_URL, 'https://iss-expert.ru/P1S.php' );
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
'Accept-Language:ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4', 
'Authorization:Basic dnQwNDp3cmc0Y2huZg==', 
'Cache-Control:max-age=0',
'Connection:keep-alive', 
'Content-Type:application/x-www-form-urlencoded', 
'Host:iss-expert.ru', 
'Origin:https://iss-expert.ru', 
'Referer:https://iss-expert.ru/', 
'User-Agent:Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36'
));

$response = curl_exec($ch);                                          
$resultStatus = curl_getinfo($ch);                                   
curl_close($ch);

if($resultStatus['http_code'] == 200) {
    echo $response;
} else {
echo '<pre>';
print_r($resultStatus);   
echo '</pre>';                      
}



?>
