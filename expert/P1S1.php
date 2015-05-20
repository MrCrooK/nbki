<?
header("Content-Type: text/html; charset=cp1251");

$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, ('cookie.txt'));
curl_setopt($ch, CURLOPT_COOKIEJAR, ('cookie.txt'));
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_URL, 'https://iss-expert.ru/P1S1.php' );
$post = $_REQUEST;
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
