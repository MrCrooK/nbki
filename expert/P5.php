<?
header("Content-Type: text/html; charset=cp1251");
$post['E15']=iconv('UTF-8','cp1251',$_REQUEST['E15']);
?>
<pre><?print_r($post)?></pre>
<?
$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, ('cookie.txt'));
curl_setopt($ch, CURLOPT_COOKIEJAR, ('cookie.txt'));
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_URL, 'https://iss-expert.ru/P5.php' );
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
?>
<form action="P1S.php" method="post" target="_blank" id="myform">
<input id="ku01" type="hidden" name="s01" value="1" class="inp3">
<input id="ku02" type="hidden" name="s02" value="1" class="inp3">
<input id="ku03" type="hidden" name="s03" value="1" class="inp3">
<input id="ku21" type="hidden" name="s21" value="1" class="inp3">
<input id="ku05" type="hidden" name="s05" value="1" class="inp3">
<input id="ku09" type="hidden" name="s09" value="1" class="inp3">
<input id="ku06" type="hidden" name="s06" value="1" class="inp3">
<input id="ku10" type="hidden" name="s10" value="1" class="inp3">
<input id="ku07" type="hidden" name="s07" value="1" class="inp3">
<input id="ku24" type="hidden" name="s24" value="1" class="inp3">
<input id="ku23" type="hidden" name="s23" value="1" class="inp3">
<input id="ku08" type="hidden" name="s08" value="1" class="inp3">
<input id="ku13" type="hidden" name="s13" value="1" class="inp3">
<input id="ku26" type="hidden" name="s26" value="1" class="inp3">
<input id="ku14" type="hidden" name="s14" value="1" class="inp3">
<input id="ku15" type="hidden" name="s15" value="1" class="inp3">
<input id="ku16" type="hidden" name="s16" value="1" class="inp3">
<input id="ku18" type="hidden" name="s18" value="1" class="inp3">
<input id="ku19" type="hidden" name="s19" value="1" class="inp3">
<input id="ku20" type="hidden" name="s20" value="1" class="inp3">
<input id="ku25" type="hidden" name="s25" value="1" class="inp3">
<input id="mu1"  type="hidden" name="t1"  size="15" value="">
<input id="mu2"  type="hidden" name="t2"  size="15" value="">
<input id="mu3"  type="hidden" name="t3"  size="15" value="">
<input id="mu4"  type="hidden" name="t4"  size="15" value="">
<input id="mu5"  type="hidden" name="t5"  size="15" value="">
<input id="mu6"  type="hidden" name="t6"  size="15" value="">
<input id="mu8"  type="hidden" name="t8"  size="15" value="">
</form>
<?
    echo $response;
?>
<script>
function loader(mu1,mu2,mu3,mu4,mu5,mu6,mu8,mu7) {
	document.getElementById('mu1').value = mu1;
	document.getElementById('mu2').value = mu2;
	document.getElementById('mu3').value = mu3;
	document.getElementById('mu4').value = mu4;
	document.getElementById('mu5').value = mu5;
	document.getElementById('mu6').value = mu6;
	document.getElementById('mu8').value = mu8;
	document.getElementById('myform').submit();
}
</script>
<?
} else {
echo '<pre>';
print_r($resultStatus);   
echo '</pre>';                      
}



?>
