<?php
@session_start();
$url = site_url() . '/securimage/securimage.php';
$error_array = array();
$error_array_show = array();
include_once $_SERVER['DOCUMENT_ROOT'] . '/sos/securimage/securimage.php';

$securimage = new Securimage();

$mobile = array(
        '0' => '55',
        '1' => '91',
        '2' => '99',
        '3' => '96',
        '4' => '77',
        '5' => '93',
        '6' => '94',
        '7' => '98',
        '8' => '95',
        '9' => '97'
);
$telephone = array(
        '0' => '10',
        '1' => '223',
        '2' => '226',
        '3' => '224',
        '4' => '231',
        '5' => '237',
        '6' => '233',
        '7' => '234',
        '8' => '238',
        '9' => '235',
        '10' => '236',
        '11' => '232',
        '12' => '249',
        '13' => '252',
        '14' => '257',
        '15' => '312',
        '16' => '243',
        '17' => '245',
        '18' => '246',
        '19' => '242',
        '20' => '244',
        '21' => '322',
        '22' => '255',
        '23' => '253',
        '24' => '254',
        '25' => '256',
        '26' => '261',
        '27' => '262',
        '28' => '264',
        '29' => '269',
        '30' => '265',
        '31' => '263',
        '32' => '267',
        '33' => '266',
        '34' => '268',
        '35' => '281',
        '36' => '282',
        '37' => '287',
        '38' => '283',
        '39' => '284',
        '40' => '285',
        '41' => '286',
        '42' => '471',
        '43' => '222',
        '44' => '474',
        '45' => '475',
        '46' => '476',
        '47' => '477',
        '48' => '478'
);
$modeles = array(
        '0' => '1254',
        '1' => 'A65656'
);

if ($_GET['lang'] == 'ru')
{
    $mail_subject = 'Заявка подключения';
    
    $error_array['t_captcha_input'] = 'Ввод Captch-и обьязателен';
    $error_array['t_firstname_lastname'] = 'Ввод имени обьязателен';
    $error_array['t_actual_address'] = 'Ввод Фактический адрес обьязателен';
    $error_array['t_telephone'] = 'Ввод домашний телефон обьязателен';
    $error_array['t_respperson_firstname'] = 'Ввод ответственное лицо обьязателен';
    $error_array['t_resppers_phone'] = 'Ввод Телефон ответственного лица обьязателен';
    $error_array['t_mobile'] = 'Ввод Сотовый телефон ответственного лица  обьязателен';
    $error_array['t_resppers_email'] = 'Ввод почты обьязателен';
    $sub_class = 'send_ru';
    $error_array['t_resppers_email'] = 'Неправильный емаил';
    $intro_text = 'Предварительная заявка номер___  на присоединение к системе мониторингового оповещения МЧС/ на установку внутриобъектового оборудования';
    $bajanordi_anvanum = 'Название абонента';
    $kazmaperp_anvanum = 'Название организации';
    $iravabanakan_hasce = 'Юридический адрес (Город / Улица / Дом)';
    $qaxaq = 'Город';
    $poxoc = 'Улица';
    $pastaci_hasce = 'Фактический адрес';
    
    $kazmakerp_vaverapayman = 'Реквизиты компании';
    $bank = 'Банк';
    $hashveh = 'Расчетный счет';
    $hvhh = 'ИНН';
    
    $tun = 'Дом';
    $makeres = 'Площадь';
    $heraxos = 'Телефон ';
    $fax = 'Факс';
    $t_kayq = 'Сайт';
    $tnoren = 'Директор (Имя / Фамилия)';
    $anun = 'Имя';
    $azganun = 'Фамилия';
    $patasxanatu = 'Ответственное лицо (Имя / Фамилия)';
    $pashton = 'Должность';
    $ptel = 'Эл.адр.ответственного лица';
    $pth = 'Тел. ответственного лица';
    $bjj = 'Тел.';
    $lracucich = 'Дополнительная информация';
    $nobj = 'Модель внутриобъектовой  системы ';
    
    $nobjn = 'Назв. установителя внутриобъектов.оборудовани (Имя / Фамилия)';
    $hldate = 'Дата заполнения заявки ';
    $tesuch = 'Подпись инспектора';
}
elseif ($_GET['lang'] == 'en')
{}
else
{
    $mail_subject = 'Միացման հայտ';
    
    $error_array['t_captcha_input'] = 'Captch-ն պարտադիր է';
    $error_array['t_firstname_lastname'] = 'Անուն - դաշտը պարտադիր է';
    $error_array['t_actual_address'] = 'Փաստացի հասցե - դաշտը պարտադիր է';
    $error_array['t_telephone'] = 'Քաղաքային հեռախոս - դաշտը պարտադիր է';
    $error_array['t_respperson_firstname'] = 'Պատասխանատու անձ - դաշտը պարտադիր է';
    $error_array['t_resppers_phone'] = 'Պատասխանատու անձի հեռախոսահամարը - դաշտը պարտադիր է';
    $error_array['t_mobile'] = 'Պատասխանատու անձի բջջային հեռախոսահամար - դաշտը պարտադիր է';
    $error_array['t_resppers_email'] = 'Էլ փոստ դաշտը պարտադիր է';
    $error_array['t_resppers_email'] = 'Սխալ էլ հասցե';
    $sub_class = 'send_am';
    $intro_text = 'ԱԻՆ հրդեհի ազդարարման մոնիթորինգային համակարգին համակցման /ներօբյեկտային սարքի տեղադրման նախնական հայտ թիվ 25';
    $bajanordi_anvanum = 'Բաժանորդի անվանումը';
    $kazmaperp_anvanum = 'Կազմակերպության անվանումը';
    $iravabanakan_hasce = 'Իրավաբանական հասցեն (Քաղաք / Փողոց / Տուն)';
    $qaxaq = 'Քաղաք';
    $poxoc = 'Փողոց';
    $pastaci_hasce = 'Փաստացի հասցե';
    
    $kazmakerp_vaverapayman = 'Կազմակերպության վավերապայմանները';
    $bank = 'Բանկ';
    $hashveh = 'Հաշվեհամար';
    $hvhh = 'ՀՎՀՀ';
    
    $tun = 'Տուն';
    $makeres = 'Մակերես';
    $heraxos = 'Հեռախոսահամար՝ ';
    $fax = 'Ֆաքս՝';
    $t_kayq = 'Կայք';
    $tnoren = 'Տնօրեն՝ (Անուն / Ազգանուն)';
    $anun = 'Անուն';
    $azganun = 'Ազգանուն';
    $patasxanatu = 'Պատասխանատու անձ՝ (Անուն / Ազգանուն)';
    $pashton = 'Պաշտոն';
    $ptel = 'Պատասխանատու անձի էլ. հասցեն՝';
    $pth = 'Պատասխանատու անձի հեռախոսահամարը՝';
    $bjj = 'Բջջ՝';
    $lracucich = 'Լրացուցիչ տեղեկություններ';
    $nobj = 'Ներօբյեկտային համակարգի մոդելը՝ ';
    $nobjn = 'Ներօբյեկտային համակարգը՝  տեղադրողի անվանումը  (Անուն / Ազգանուն)';
    $hldate = 'Հայտի լրացման ամսաթիվը՝';
    $tesuch = 'ԱԻՆ տեսուչի Ա.Ա.Հ.՝';
}
?>
<style>
.error label {
	color: #941F00 !important;
	font-weight: 600;
}

input {
	font-family: Tahoma, Geneva, sans-serif;
}
</style>
<?php

$post = $_POST;
if (! empty($post))
{
    // echo "<pre>"; print_r($_POST); exit;
    if ($securimage->check($_POST['t_captcha_input']) == false)
    {
        $error_array_show['t_captcha_input'] = $error_array['t_captcha_input'];
    }
    if (empty($post['t_firstname_lastname'])) $error_array_show['t_firstname_lastname'] = $error_array['t_firstname_lastname'];
    if (empty($post['t_actual_address'])) $error_array_show['t_actual_address'] = $error_array['t_actual_address'];
    if (empty($post['t_telephone_code']) || empty($post['t_telephone'])) $error_array_show['t_telephone'] = $error_array['t_telephone'];
    if (empty($post['t_respperson_firstname']) ||
             empty($post['t_respperson_lastname'])) $error_array_show['t_respperson_firstname'] = $error_array['t_respperson_firstname'];
    if (empty($post['t_resppers_phone_code']) || empty(
            $post['t_resppers_phone'])) $error_array_show['t_resppers_phone'] = $error_array['t_resppers_phone'];
    if (empty($post['t_mobile_code']) || empty($post['t_mobile'])) $error_array_show['t_mobile'] = $error_array['t_mobile'];
    if (empty($post['t_resppers_email'])) $error_array['t_resppers_email'];
    elseif (! filter_var($post['t_resppers_email'], FILTER_VALIDATE_EMAIL)) $error_array_show['t_resppers_email'] = $error_array['t_resppers_email'];
    if (empty($error_array_show))
    {
        $mail_content = <<<EOT
			<table border="1">
			 <!-- 1 item  -->
				<tr>
					<td style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif " colspan="3"> <label for="t_firstname_lastname">{$bajanordi_anvanum}</label> </td>
				</tr>
				<tr>
					<td colspan="3" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif ">
						&nbsp; {$post['t_firstname_lastname']}
					</td>
				</tr>
			    <!-- new  -->
				<tr>
					<td colspan="3" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> <label for="t_firstname_lastname_kazmakerp">{$kazmaperp_anvanum}</label> </td>
				</tr>
				<tr>
					<td colspan="3" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif ">
						&nbsp; {$post['t_firstname_lastname_kazmakerp']}
					</td>
				</tr>
				<!-- 2 item  -->
				<tr>
					<td colspan="3" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "><label>{$iravabanakan_hasce}</label></td>
				</tr>
				<tr>
					<td style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> &nbsp; {$post['t_sity']} </td>
					<td style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> 
						&nbsp; {$post['t_street']}
					</td>
					<td style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> &nbsp; {$post['t_home']} </td>
				</tr>
				<!-- 3 item  -->
				<tr>
					<td colspan="2" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> <label>{$pastaci_hasce} </label> </td>
					<td style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> <label>{$makeres}</label></td>
				</tr>
				<tr>
					<td colspan="2" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> {$post['t_actual_address']} </td>

					<td style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif ">&nbsp; {$post['t_area']} </td>
				</tr>
				<!-- new  -->
				<tr>
					<td colspan="3"><label for="t_bank">{$kazmakerp_vaverapayman} ( {$bank} / {$hashveh} / {$hvhh} )</label></td>
				</tr>
				<tr>
					<td> &nbsp; {$post['t_bank']} </td>
					<td> &nbsp; {$post['t_hashvehamar']} </td>
					<td> &nbsp; {$post['t_hvhh']} </td>
				</tr>
				<!-- 4 item  -->
				<tr>
					<td style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> <label>{$heraxos}</label> </td>
					<td class="t_td_right_colum" colspan="2" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> <label for="t_fax">{$fax}</label></td>
				</tr>
				<tr>
					<td style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> 
						&nbsp; (0{$post['t_telephone_code']}) {$post['t_telephone']}
					</td>
					<td colspan="2" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> 
						<div class="t_right_colum">
							&nbsp; (0{$post['t_fax_code']}) {$post['t_fax']}
						</div> 
					</td>
				</tr>
				<!-- new  -->
				<tr>
					<td colspan="3"><label for="t_kayq">{$t_kayq}</label></td>
				</tr>
				<tr>
					<td colspan="3">{$post['t_kayq']}</td>
				</tr>
				<!-- 5 item  -->
				<tr>
					<td colspan="3" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> <label>{$tnoren}</label> </td>
				</tr>
				<tr>
					<td style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif ">&nbsp; {$post['t_director_firstname']}</td>
					<td colspan="2" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif ">
						<div class="t_right_colum">
							&nbsp; {$post['t_director_lastname']}
						</div>
					</td>
				</tr>
				<!-- 6 item  -->
				<tr>
					<td colspan="3" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> <label>{$patasxanatu}</label> </td>
				</tr>
				<tr>
					<td style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif ">&nbsp;{$post['t_respperson_firstname']}</td>
					<td colspan="2" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif ">
						<div class="t_right_colum">
							&nbsp; {$post['t_respperson_lastname']}
						</div>
					</td>
				</tr>
				<!-- 7 item  -->
				<tr>
					<td colspan="3" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> <label>{$pashton}</label> </td>
				</tr>
				<tr>
					<td colspan="3" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif ">&nbsp; {$post['t_position']} </td>
				</tr>
				<!-- 8 item  -->
				<tr>
					<td style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> <label>{$pth}</label> </td>
					<td colspan="2" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> <label>{$bjj}</label> </td>
				</tr>
				<tr>
					<td style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif ">
						&nbsp; (0{$post['t_resppers_phone_code']}) {$post['t_resppers_phone']}
					</td>
					<td colspan="2" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif ">
						<div class="t_right_colum">
							&nbsp; (0{$post['t_mobile_code']}) {$post['t_mobile']}
						</div>
					</td>
				</tr>
				<!-- 9 item  -->
				<tr>
					<td colspan="3" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> <label>{$ptel}</label> </td>
				</tr>
				<tr>
					<td colspan="3" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif "> {$post['t_resppers_email']} </td>
				</tr>
				
			</table>
			<div class="t_content_text"><h5>{$lracucich} </h5></div>
			<table border="1">
				<!-- 1 item  -->
				<tr>
					<td colspan="3"><label>{$nobj} </label></td>
				</tr>
				<tr>
					<td colspan="3"> 
					&nbsp;	{$post['t_other_model_new']}
					</td>
				</tr>
				<!-- 2 item  -->
				<tr>
					<td colspan="3"> <label>{$nobjn}   </label> </td>
				</tr>
				<tr>
					<td>&nbsp; {$post['t_other_installer_firstname']}</td>
					<td>
						<div class="t_right_colum">
						&nbsp;
							{$post['t_other_installer_lastname']}
						</div>
					</td>
				</tr>
				<!-- 3 item  -->
				<tr>
					<td colspan="3"> <label>{$heraxos}</label> </td>
				</tr>
				<tr>
					<td colspan="1">
						(0{$post['t_other_installer_tel_code']}) {$post['t_other_installer_tel']}
					</td>
					<td colspan="2">
						(0{$post['t_other_installer_mob_code']}) {$post['t_other_installer_mob']}
					</td>
				</tr>
			</table>
EOT;
        $to = 'tigran.makaryan@x-tech.am'; // 'narekmamikonyan@gmail.com';
        
       
        
        $headers = "From: info@sossystems.am \r\n";
        /*
         * $headers .= "Reply-To: \r\n"; $headers .= "CC: \r\n";
         */
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset: utf8\r\n";
        
        mail($to, $mail_subject, $mail_content, $headers);
    }
}
?>


<script type="text/javascript">
<!--
jQuery(function($) {
	  $('.sparkbox-custom').selectbox();
	  $("#t_other_model").selectbox({
		  classHolder:"sbHolder_big",
		  classOptions:"sbOptions_big",
		  classSelector:"sbSelector_big"
		});
	  var browser = $.browser;
	  if(browser.msie)
	  {
			if(browser.version=="8.0" || browser.version=="7.0" )
			{
				 $("#t_firstname_lastname,#t_director_firstname,#t_director_lastname,#t_respperson_firstname,#t_respperson_lastname,#t_position,#t_sity,#t_street,#t_home,#t_actual_address,#t_area,#t_telephone,#t_fax,#t_resppers_phone,#t_mobile,#t_resppers_email,#t_other_installer_firstname,#t_other_installer_lastname,#t_other_submission_date,#t_other_firstname_lastname").css("padding-top","10px");
			} 
	  }
	  
	});
//-->
</script>

</head>
<body>
	<div id="t_form_center">
		<?php if (!empty($error_array_show)): ?>
		<div class="error">
			<ul>
			<?php foreach ($error_array_show as $key=>$error): ?>
				<li><label for="<?php echo $key; ?>"> <?php echo $error; ?> </label></li>
			<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>
		<form action="" method="post">
			<div class="t_content_text">
				<h4><?php echo $intro_text; ?></h4>
			</div>
			<table width="647">
				<!-- 1 item  -->
				<tr>
					<td colspan="3"><label for="t_firstname_lastname"><?php echo $bajanordi_anvanum; ?></label>
					</td>
				</tr>
				<tr>
					<td colspan="3"><input id="t_firstname_lastname"
						name="t_firstname_lastname" type="text" /></td>
				</tr>
				<!-- new  -->
				<tr>
					<td colspan="3"><label for="t_firstname_lastname_kazmakerp"><?php echo $kazmaperp_anvanum; ?></label>
					</td>
				</tr>
				<tr>
					<td colspan="3"><input id="t_firstname_lastname_kazmakerp"
						name="t_firstname_lastname_kazmakerp" type="text" /></td>
				</tr>
				<!-- 2 item  -->
				<tr>
					<td colspan="3"><label for="t_sity"><?php echo $iravabanakan_hasce; ?></label></td>
				</tr>
				<tr>
					<td><input id="t_sity" name="t_sity" type="text"
						placeholder="<?php echo $qaxaq; ?>" /></td>
					<td style="display: block; left: -67px; position: relative;"><input
						id="t_street" name="t_street" type="text"
						placeholder="<?php echo $poxoc; ?>" /></td>
					<td><input id="t_home" name="t_home" type="text"
						placeholder="<?php echo $tun; ?>" /></td>
				</tr>
				<!-- 3 item  -->
				<tr>
					<td colspan="2"><label for="t_actual_address"><?php echo $pastaci_hasce; ?></label>
					</td>
					<td><label style="margin-left: -61px;" for="t_area"><?php echo $makeres ; ?></label></td>
				</tr>
				<tr>
					<td colspan="2"><input id="t_actual_address"
						name="t_actual_address" type="text" /></td>

					<td class="t_td_right_small_cplimn"><input id="t_area"
						name="t_area" type="text" /></td>
				</tr>
				<!-- new  -->
				<tr>
					<td colspan="3"><label for="t_bank"><?php echo $kazmakerp_vaverapayman.' ('. $bank.' / '.$hashveh.' / '.$hvhh .')'; ?></label></td>
				</tr>
				<tr>
					<td><input id="t_bank" name="t_bank" type="text"
						placeholder="<?php echo $bank; ?>" /></td>
					<td style="display: block; left: -67px; position: relative;"><input
						id="t_hashvehamar" name="t_hashvehamar" type="text"
						placeholder="<?php echo $hashveh; ?>" /></td>
					<td><input id="t_hvhh" name="t_hvhh" type="text"
						placeholder="<?php echo $hvhh; ?>" /></td>
				</tr>
				<!-- 4 item  -->
				<tr>
					<td><label for="t_telephone"><?php echo $heraxos ; ?></label></td>
					<td class="t_td_right_colum" colspan="2"><label for="t_fax"><?php echo $fax; ?></label></td>
				</tr>
				<tr>
					<td><select name="t_telephone_code" class="sparkbox-custom">
							<?php foreach ($telephone as $tel): ?>
							<option value="<?php echo $tel ?>"><?php echo "0".$tel ?></option>
							<?php endforeach; ?> 
						</select> <input id="t_telephone" name="t_telephone" type="text" />
					</td>
					<td colspan="2">
						<div class="t_right_colum">
							<select name="t_fax_code" class="sparkbox-custom">
								<?php foreach ($telephone as $tel): ?>
								<option value="<?php echo $tel ?>"><?php echo "0".$tel ?></option>
								<?php endforeach; ?> 
							</select> <input id="t_fax" name="t_fax" type="text" />
							<div class="t_clear"></div>
						</div>
					</td>
				</tr>
				<!-- new  -->
				<tr>
					<td colspan="3"><label for="t_kayq"><?php echo $t_kayq; ?></label>
					</td>
				</tr>
				<tr>
					<td colspan="3"><input id="t_kayq" name="t_kayq" type="text" /></td>
				</tr>
				<!-- 5 item  -->
				<tr>
					<td colspan="3"><label for="t_director_firstname"><?php echo $tnoren; ?></label>
					</td>
				</tr>
				<tr>
					<td><input id="t_director_firstname" name="t_director_firstname"
						type="text" placeholder="<?php echo $anun; ?>" /></td>
					<td colspan="2">
						<div class="t_right_colum">
							<input id="t_director_lastname" name="t_director_lastname"
								type="text" placeholder="<?php echo $azganun; ?>" />
						</div>
					</td>
				</tr>
				<!-- 6 item  -->
				<tr>
					<td colspan="3"><label for="t_respperson_firstname "><?php echo $patasxanatu; ?></label>
					</td>
				</tr>
				<tr>
					<td><input id="t_respperson_firstname"
						name="t_respperson_firstname" type="text"
						placeholder="<?php echo $anun; ?>" /></td>
					<td colspan="2">
						<div class="t_right_colum">
							<input id="t_respperson_lastname" name="t_respperson_lastname"
								type="text" placeholder="<?php echo $azganun; ?>" />
						</div>
					</td>
				</tr>
				<!-- 7 item  -->
				<tr>
					<td colspan="3"><label for="t_position"><?php echo $pashton; ?></label>
					</td>
				</tr>
				<tr>
					<td colspan="3"><input id="t_position" name="t_position"
						type="text" /></td>
				</tr>
				<!-- 8 item  -->
				<tr>
					<td><label for="t_resppers_phone"><?php echo $pth; ?></label></td>
					<td class="t_td_right_colum"><label for="t_mobile"><?php echo $bjj; ?></label>
					</td>
				</tr>
				<tr>
					<td><select name="t_resppers_phone_code" class="sparkbox-custom">
							<?php foreach ($telephone as $tel): ?>
							<option value="<?php echo $tel ?>"><?php echo "0".$tel ?></option>
							<?php endforeach; ?>  
						</select> <input id="t_resppers_phone" name="t_resppers_phone"
						type="text" /></td>
					<td colspan="2">
						<div class="t_right_colum">
							<select name="t_mobile_code" class="sparkbox-custom">
								<?php foreach ($mobile as $mob): ?>
								<option value="<?php echo $mob ?>"><?php echo "0".$mob ?></option>
								<?php endforeach; ?>
							</select> <input id="t_mobile" name="t_mobile" type="text" />
						</div>
					</td>
				</tr>
				<!-- 9 item  -->
				<tr>
					<td colspan="3"><label for="t_resppers_email"><?php echo $ptel; ?></label>
					</td>
				</tr>
				<tr>
					<td><input id="t_resppers_email" name="t_resppers_email"
						type="text" /></td>
				</tr>

			</table>
			<div class="t_content_text">
				<h5> <?php echo $lracucich; ?> </h5>
			</div>
			<table width="647">
				<!-- 1 item  -->
				<tr>
					<td colspan="3"><label for="t_other_model_new"><?php echo $nobj; ?></label></td>
				</tr>
				<tr>
					<td colspan="3"><input id="t_other_model_new"
						name="t_other_model_new" type="text" /></td>
				</tr>
				<!-- 2 item  -->
				<tr>
					<td colspan="3"><label for="t_other_installer_firstname"> <?php echo $nobjn; ?>   </label>
					</td>
				</tr>
				<tr>
					<td><input id="t_other_installer_firstname"
						name="t_other_installer_firstname" type="text"
						placeholder="<?php echo $anun; ?>" /></td>
					<td>
						<div class="t_right_colum">
							<input id="t_other_installer_lastname"
								name="t_other_installer_lastname" type="text"
								placeholder="<?php echo $azganun; ?>" />
						</div>
					</td>
				</tr>
				<!-- 3 item  -->
				<tr>
					<td><label for="t_other_installer_tel"><?php echo $heraxos; ?></label>
					</td>
				</tr>
				<tr>
					<td><select name="t_other_installer_tel_code"
						class="sparkbox-custom">
							<?php foreach ($telephone as $tel): ?>
								<option value="<?php echo $tel?>"><?php echo "0".$tel?></option>
							<?php endforeach; ?>
						</select> <input id="t_other_installer_tel"
						name="t_other_installer_tel" type="text" /></td>
					<td colspan="2">
						<div class="t_right_colum">
							<select name="t_other_installer_mob_code" class="sparkbox-custom">
								<?php foreach ($mobile as $mob): ?>
								<option value="<?php echo $mob ?>"><?php echo "0".$mob ?></option>
								<?php endforeach; ?>
							</select> <input id="t_other_installer_mob"
								name="t_other_installer_mob" type="text" />
						</div>
					</td>
				</tr>
				
				<!-- 5 item  -->
				<tr>
					<td><img id="captcha"
						src="<?php echo site_url(); ?>/securimage/securimage_show.php"
						alt="CAPTCHA Image" width="150" border="1" align="left" /> <a
						href="#" class="sec_ref"
						onClick="document.getElementById('captcha').src = '<?php echo site_url(); ?>/securimage/securimage_show.php?' + Math.random(); return false"><img
							src="<?php echo site_url(); ?>/securimage/captcha_refresh.png" /></a>
					</td>
					<td><input id="t_captcha_input" name="t_captcha_input" type="text" />
					</td>
					<td><input type="submit" value=""
						class="<?php echo $sub_class ?> t_send_button"></td>
				</tr>
			</table>
		</form>
	</div>