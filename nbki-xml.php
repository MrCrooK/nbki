<?
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Yekaterinburg');
$str = "\r\n------------------------------\r\n";
$str .= date("m.d.Y H:i:s")."\r\n";
foreach($_REQUEST as $key => $val)
	$str .= $key .":". $val."\r\n";
$str .= $_SERVER["REQUEST_URI"]."\r\n";
file_put_contents('log.txt',$str,FILE_APPEND);

if($_REQUEST["true_nbki"]&&$_REQUEST["ldate"]&&$_REQUEST["pdate"]&&$_REQUEST["propul"]&&$_REQUEST["propcity"]&&$_REQUEST["projul"]&&$_REQUEST["projcity"]&&$_REQUEST["pnum"]&&$_REQUEST["pseri"]&&$_REQUEST["pmesto"]&&$_REQUEST["pkem"]&&$_REQUEST["lfam"]&&$_REQUEST["lname"]&&$_REQUEST["lotch"]&&$_REQUEST["lmesto"]){
$dateb = explode(".", $_REQUEST["ldate"] );
$datep = explode(".", $_REQUEST["pdate"] );
$nbkibdate = $dateb[2]."-".$dateb[1]."-".$dateb[0];
$nbkipdate = $datep[2]."-".$datep[1]."-".$datep[0];

if($_REQUEST["true_nbki"]==9) {
$auth= '
					<MemberCode>7C01GG000000</MemberCode>
					<UserID>7C01GG000003</UserID>
					<Password>5KeKydlo</Password>	
';
$urlset = 'icrs.demo.nbki.ru';
$adr = "http://icrs.demo.nbki.ru/products/B2BRequestServlet";
}
if($_REQUEST["true_nbki"]==1) {
$auth= '
					<MemberCode>Y101FF000000</MemberCode>
					<UserID>Y101FF000002</UserID>
					<Password>1WsQyMNJ</Password>	
';
$urlset = 'icrs.nbki.ru';
$adr = "https://icrs.nbki.ru/products/B2BRequestServlet";
}
if($_REQUEST["true_nbki"]==3) {
$auth= '
					<MemberCode>7C01GG000000</MemberCode>
					<UserID>7C01GG000002</UserID>
					<Password>HgeT66y1</Password>	
';
$urlset = 'icrs.nbki.ru';
$adr = "https://icrs.nbki.ru/products/B2BRequestServlet";
}
if($_REQUEST["true_nbki"]==4) {
$auth= '
					<MemberCode>W901GG000000</MemberCode>
					<UserID>W901GG000002</UserID>
					<Password>MDJuFz1n</Password>	
';
$urlset = 'icrs.nbki.ru';
$adr = "https://icrs.nbki.ru/products/B2BRequestServlet";
}

	$ch = curl_init();
	$headers = array(
		"POST /products/B2BRequestServlet HTTP/1.0",
		"Host: ".$urlset, //.demo
		"Content-Type: text/xml;charset=\"windows-1251\""
	);

	$dd = '
	<?xml version="1.0" encoding="windows-1251" ?>
	<product>
		<prequest>
			<req>
				<AddressReq>
					<street>'.$_REQUEST["propul"].'</street>
					<city>'.$_REQUEST["propcity"].'</city>
					<addressType>1</addressType>
				</AddressReq>
				<AddressReq>
					<street>'.$_REQUEST["projul"].'</street>
					<city>'.$_REQUEST["projcity"].'</city>
					<addressType>2</addressType>
				</AddressReq>
				<IdReq>
					<idNum>'.$_REQUEST["pnum"].'</idNum>
					<idType>21</idType>
					<seriesNumber>'.$_REQUEST["pseri"].'</seriesNumber>
					<issueCountry>'.$_REQUEST["pmesto"].'</issueCountry>
					<issueDate>'.$nbkipdate.'</issueDate>
					<issueAuthority>'.$_REQUEST["pkem"].'</issueAuthority>
				</IdReq>
				<InquiryReq>
					<inqPurpose>01</inqPurpose>
					<inqAmount>0</inqAmount>
					<currencyCode>RUB</currencyCode>
				</InquiryReq>
				<PersonReq>
					<name1>'.$_REQUEST["lfam"].'</name1>
					<first>'.$_REQUEST["lname"].'</first>
					<paternal>'.$_REQUEST["lotch"].'</paternal>
					<gender>1</gender>
					<birthDt>'.$nbkibdate.'</birthDt>
					<placeOfBirth>'.$_REQUEST["lmesto"].'</placeOfBirth>
				</PersonReq>
				<RequestorReq>'.$auth.'				</RequestorReq>
				<RefReq>
					<product>CHST</product>
				</RefReq>
				<IOType>B2B</IOType>
				<OutputFormat>XML</OutputFormat>
				<lang>ru</lang>
			</req>
		</prequest>
	</product>
	';	
	
	$dd = trim(iconv('utf-8','cp1251',$dd));
	curl_setopt ($ch, CURLOPT_REFERER, $adr);
	curl_setopt($ch, CURLOPT_URL, $adr);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $dd);
	// не проверять SSL сертификат
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'ALL');
	curl_setopt($ch, CURLOPT_SSLENGINE, 'gost');

	$output = curl_exec($ch); 
	$infoget = curl_getinfo($ch);
	$errors = curl_error($ch);

	curl_close ($ch);

	preg_match_all("/product(.*)product/s", $output, $matches);
	if($matches[0][0]){
		$strxml = "<?xml version='1.0' encoding='windows-1251' ?><".$matches[0][0].">";
	} else {
		$strxml = "Ошибка";
	}

	//Выводим собранные данные
	echo $strxml;
} else {
	echo "Все поля должны быть заполнены";
} 
?>