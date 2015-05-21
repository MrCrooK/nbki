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
	$str = "<?xml version='1.0' encoding='windows-1251' ?><".$matches[0][0].">";

	$xml = simplexml_load_string($str);
	$person = $xml->preply->report->PersonReply;
	$calc = $xml->preply->report->calc;
	$pasport = $xml->preply->report->IdReply;
	$adres = $xml->preply->report->AddressReply;
	$banki = $xml->preply->report->AccountReply;
	if(!$xml) { echo "Сервер НБКИ не отвечает, попробуйте позже.<pre>"; print_r($infoget); print_r($errors); }
	if($xml->preply->err->ctErr->Text) {echo $xml->preply->err->ctErr->Text; }
?>
<?
$tableContact = '
<hr>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr valign="top">
        <td class="h1" valign="top">Заемщик</td>
        <td valign="top">
		<div class="title">ФИО</div>
		<div>'.$person->name1.' '.$person->first.' '.$person->paternal.'</div>
	</td>
        <td valign="top">
		<div class="title">Личные данные</div>
		<div><span>Дата рождения:</span> '.substr($person->birthDt, 0, 10).'</div>
		<div><span>Место рождения:</span> '.$person->placeOfBirth.'</div>
		<div><span>Гражданство:</span> '.$person->nationality.'</div>
		<div><span>Пол:</span> '.$person->genderText.'</div>
	</td>
    </tr>
</table>
';
?>


<?foreach($calc->totalHighCredit as $item):?>
	<?$totalHighCredit .= '<div style="text-align: right;">'.$item->Code.' '.$item->Value.'</div>';?>
<?endforeach?>
<?foreach($calc->totalScheduledPaymnts as $item):?>
	<?$totalScheduledPaymnts .= '<div style="text-align: right;">'.$item->Code.' '.$item->Value.'</div>';?>
<?endforeach?>
<?foreach($calc->totalCurrentBalance as $item):?>
	<?$totalCurrentBalance .= '<div style="text-align: right;">'.$item->Code.' '.$item->Value.'</div>';?>
<?endforeach?>
<?foreach($calc->totalPastDueBalance as $item):?>
	<?$totalPastDueBalance .= '<div style="text-align: right;">'.$item->Code.' '.$item->Value.'</div>';?>
<?endforeach?>
<?foreach($calc->totalScheduledPaymnts as $item):?>
	<?$totalScheduledPaymnts .= '<div style="text-align: right;">'.$item->Code.' '.$item->Value.'</div>';?>
<?endforeach?>

<?
$tableCalc = '
<hr>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr valign="top">
        <td class="h1" valign="top">Сводка</td>
        <td valign="top">
		<div class="title">Счета</div>
		<table border="0" width="100%" class="tgray" cellspacing="0" cellpadding="3">
		<THEAD>
		    <tr>
			<td width="20%">Тип счета</td>
			<td width="20%">Счета</td>
			<td width="20%">Договоры</td>
			<td width="20%">Баланс</td>
			<td width="20%">Открыт</td>
		    </tr>
		</THEAD>
		<TBODY>
		    <tr>
			<td class="h2" valign="top">Все счета</td>
			<td valign="top">
				<div><span>Всего:</span> '.$calc->totalAccts.'</div>
				<div><span>Негативных:</span> '.$calc->negativeRating.'</div>
				<div><span>Открытых:</span> '.$calc->totalActiveBalanceAccounts.'</div>			
			</td>
			<td valign="top">
				<div><span>Кред.лимит:</span><br>'.$totalHighCredit.'
				</div>
				<div><span>Ежемес.плат.:</span><br>'.$totalScheduledPaymnts.'
				</div>			
			</td>
			<td valign="top">
				<div><span>Текущий:</span><br>'.$totalCurrentBalance.'</div>
				<div><span>Задолж-сть:</span><br>'.$totalPastDueBalance.'</div>
				<div><span>Просрочено:</span><br>'.$totalScheduledPaymnts.'</div>
			</td>
			<td valign="top">
				<div><span>Последний:</span> '.substr($calc->mostRecentAcc, 0, 10).'</div>
				<div><span>Первый:</span> '.substr($calc->oldest, 0, 10).'</div>
			</td>
		    </tr>
		</TBODY>
		</table>
		<div class="title">Запросы</div>
		<table border="0" width="100%" class="tgray" cellspacing="0" cellpadding="3">
		<THEAD>
		    <tr>
			<td width="20%">Тип запроса</td>
			<td width="20%">Всего</td>
			<td width="20%">За послед.30 дней</td>
			<td width="20%">Последние (24 месяца)</td>
			<td width="20%">Последний</td>
		    </tr>
		</THEAD>
		<TBODY>
		    <tr>
			<td class="h2" valign="top">Все запросы</td>
			<td valign="top">
				<div>'.$calc->totalInquiries.'</div>			
			</td>
			<td valign="top">
				<div>'.$calc->recentInquiries.'</div>			
			</td>
			<td valign="top">
				<div>'.$calc->collectionsInquiries.'</div>
			</td>
			<td valign="top">
				<div>'.$calc->mostRecentInqText.'</div>
			</td>
		    </tr>
		</TBODY>
		</table>
	</td>
    </tr>
</table>
';
?>

<?
$tablePasport = '
<hr>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr valign="top">
        <td class="h1" valign="top">Идентификация<br>заемщика</td>
        <td valign="top">
		<div class="title">Паспорт гражданина РФ</div>
		<table border="0" width="100%" class="tgray" cellspacing="0" cellpadding="3">
		<THEAD>
		    <tr>
			<td width="90">Номер</td>
			<td width="90">Дата выдачи</td>
			<td>Кем выдан</td>
			<td width="60">Дата</td>
		    </tr>
		</THEAD>
		<TBODY>
		    <tr>
			<td valign="top">'.$pasport->seriesNumber.' '.$pasport->idNum.'</td>
			<td valign="top">'.substr($pasport->issueDate, 0, 10).'</td>
			<td valign="top">'.$pasport->issueAuthority.'</td>
			<td valign="top">'.substr($pasport->lastUpdatedDt, 0, 10).'</td>
		    </tr>
		</TBODY>
		</table>
	</td>
    </tr>
</table>
';
?>

<?foreach($adres as $item):?>
<?
$fulladres .= '
		<div class="title">'.$item->addressTypeText.'</div>
		<table border="0" width="100%" class="tgray" cellspacing="0" cellpadding="3">
		<THEAD>
		    <tr>
			<td>Улица</td>
			<td width="90">Страна</td>
			<td width="90">Регион</td>
			<td width="120">Район</td>
			<td width="60">Дата</td>
		    </tr>
		</THEAD>
		<TBODY>
		    <tr>
			<td valign="top">'.$item->postal.', '.$item->city.', '.$item->street.', '.$item->houseNumber.', '.$item->apartment.'</td>
			<td valign="top">'.$item->countryCodeText.'</td>
			<td valign="top">'.$item->prov.'</td>
			<td valign="top">'.$item->provText.'</td>
			<td valign="top">'.substr($item->lastUpdatedDt, 0, 10).'</td>
		    </tr>
		</TBODY>
		</table>
';?>
<?endforeach?>

<?
$tableAdres = '
<hr>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr valign="top">
        <td class="h1" valign="top">Адреа</td>
        <td valign="top">
'.$fulladres.'
	</td>
    </tr>
</table>
';
?>

<?
$tableInfo = '
<hr>
<div style="page-break-after:always; width: 100%;"></div>
<!--<hr>-->
<table border="0" width="100%" cellspacing="0" cellpadding="0>
    <tr valign="top">
        <td class="h1" valign="top">Счета</td>
        <td valign="top">
		<div class="title">Расшифровка своевременности платежей</div>
		<table border="0" width="100%" cellspacing="0" cellpadding="0" class="rash"><tr>
			<td valign="top">
				<div><b style="color: #666; border: 1px solid #666;">0</b> Новый, оценка невозможна</div>
				<div><b style="color: #fff; border: 1px solid #009966; background: #009966;">1</b> Оплата без просрочек</div>
				<div><b style="color: #fff; border: 1px solid #ffcc00; background: #ffcc00;">A</b> Просрочка от 1 до 29 дней</div>
			</td>
			<td valign="top">
				<div><b style="color: #fff; border: 1px solid #fe9800; background: #fe9800;">2</b> Просрочка от 30 до 59 дней</div>
				<div><b style="color: #fff; border: 1px solid #ff6600; background: #ff6600;">3</b> Просрочка от 60 до 89 дней</div>
				<div><b style="color: #fff; border: 1px solid #fe3200; background: #fe3200;">4</b> Просрочка от 90 до 119 дней</div>
			</td>
			<td valign="top">
				<div><b style="color: #fff; border: 1px solid #cc0000; background: #cc0000;">5</b> Просрочка более 120 дней</div>
				<div><b style="color: #fff; border: 1px solid #000; background: #000;">7</b> Регулярн.консолидир.платежи</div>
				<div><b style="color: #fff; border: 1px solid #000; background: #000;">8</b> Взыскание оплаты залогом</div>
			</td>
			<td valign="top">
				<div><b style="color: #fff; border: 1px solid #000; background: #000;">9</b> Безнадёжный долг/ передано на взыскание</div>
				<div><b style="color: #fff; border: 1px solid #c0c0c0; background: #c0c0c0;">X</b> Нет данных</div>
			</td>
		</tr></table>
	</td>
    </tr>
</table>
';
?>


<?foreach($banki as $bankiitm):?>
<?
unset($arTimeLine);
$i=0;
$daystr = '';
$str = '';
$str = (string) $bankiitm->paymtPat;
$openCredit = substr($bankiitm->openedDt, 0, 10);
$daystr .= "<tr>";
while ($i < strlen($str)):
 $daystr .= "<td class='clasitm".$str[$i]."'>".$str[$i]."</td>";
 
 $d = new DateTime($openCredit);
 $arTimeLine[$d->format("Y")]++;
 $d->modify("+1 month");
 $openCredit = $d->format("Y-m-d");
 
 $i++; 
endwhile;
$daystr .= "</tr>";

$daystr .= "<tr class='timeline'>";
krsort($arTimeLine);
foreach($arTimeLine as $k => $v) {
	$daystr .= "<td style='border: 1px solid #000; border-top: 0; text-align: center;' colspan=".$v.">".$k."</td>";
}
$daystr .= "</tr>";
?>

<?
$tableBanki .= '
<table border="0" width="100%" class="tgray" cellspacing="0" cellpadding="3">
		<TBODY>
		    <tr>
			<td valign="top" width="25%">
				<div class="title">Счет</div>
				<div><span>Вид:</span> '.$bankiitm->acctTypeText.'</div>
				<div><span>Отношение:</span> '.$bankiitm->ownerIndicText.'</div>
			</td>
			<td valign="top" width="25%">
				<div class="title">Договор</div>
				<div><span>Размер/лимит:</span> '.$bankiitm->currencyCode.' '.$bankiitm->creditLimit.'</div>
			</td>
			<td valign="top" width="25%">
				<div class="title">Состояние</div>
				<div><span>Открыт:</span> '.substr($bankiitm->openedDt, 0, 10).'</div>
				<div><span>Статус:</span> '.$bankiitm->accountRatingText.'</div>
				<div><span>Дата статуса:</span> '.substr($bankiitm->reportingDt, 0, 10).'</div>
				<div><span>Последн.выплата:</span> '.substr($bankiitm->lastPaymtDt, 0, 10).'</div>
				<div><span>Последн.обновление:</span> '.substr($bankiitm->paymtPatStartDt, 0, 10).'</div>
			</td>
			<td valign="top" width="25%">
				<div class="title">Баланс</div>
				<div><span>Всего выплачено:</span> '.$bankiitm->currencyCode.' '.$bankiitm->curBalanceAmt.'</div>
				<div><span>Задолж-сть:</span> '.$bankiitm->currencyCode.' '.$bankiitm->amtOutstanding.'</div>
				<div><span>Просрочено:</span> '.$bankiitm->currencyCode.' '.$bankiitm->amtPastDue.'</div>
				<div><span>След.платеж:</span> '.$bankiitm->currencyCode.' '.$bankiitm->termsAmt.'</div>
			</td>
		    </tr>
		    <tr>	
			<td valign="top" width="25%">
				<div class="title">Просроч.платежей</div>
				<div><span>Просрочек от 30 до 59 дн.:</span> '.substr($bankiitm->numDays30, 0, 10).'</div>
				<div><span>Просрочек от 60 до 89 дн.:</span> '.substr($bankiitm->numDays60, 0, 10).'</div>
				<div><span>Просрочек более, чем на 90 дн.:</span> '.substr($bankiitm->numDays90, 0, 10).'</div>
			</td>
			<td valign="top" colspan="3">
				<div class="title">Своевременность платежей (за '.$bankiitm->monthsReviewed.' мес, последний - слева)</div>
				<table cellspacing="1">
				'.$daystr.'
				</table>
			</td>
		    </tr>
		</TBODY>
</table>
';
?>
<?endforeach?>
<?
//Выводим собранные данные
if($xml) { echo $tableContact.$tableCalc.$tablePasport.$tableAdres.$tableInfo.$tableBanki; }
} else {
echo "Все поля должны быть заполнены";
} 
?>