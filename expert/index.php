<?
//header("Content-Type: text/html; charset=cp1251");

$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, ('cookie.txt'));
curl_setopt($ch, CURLOPT_COOKIEJAR, ('cookie.txt'));
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_URL, 'https://iss-expert.ru/' );

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
<form action="P1.php" method="post" target="_blank">
	<h3>Поиск по ФИО и дате рождения</h3>
	<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td2">
		<tbody>
			<tr height="20">
				<td align="left" valign="bottom"><span class="d2">Фамилия </span></td>
				<td align="left" valign="bottom"><span class="d2">Имя </span></td>
				<td align="left" valign="bottom"><span class="d2">Отчество</span></td>
				<td align="left" valign="bottom"><span class="d2">Дата рождения</span></td>
			</tr>
			<tr height="20">
				<td align="left" width="140"><input type="text" name="A1" style="width: 130px;" class="inp1"></td>
				<td align="left" width="140"><input type="text" name="A2" style="width: 130px;" class="inp1"></td>
				<td align="left" width="140"><input type="text" name="A3" style="width: 130px;" class="inp1"></td>
				<td align="left"><input type="text" name="A4" style="width: 95px;" class="inp1"></td>
			</tr>
			<tr height="18">
				<td align="left" colspan="4">
				<input class="d2" type="submit" value=" Поиск ">
				<span class="d1">&nbsp;&nbsp;</span>
				<input class="d2" type="reset" value="Сброс">
				</td>
			</tr>
		</tbody>
	</table>
</form>
<?
} else {
echo '<pre>';
print_r($resultStatus);   
echo '</pre>';                      
}
?>
