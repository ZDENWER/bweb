<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>

</head>
<body>
<?
$userAddress = explode(",", $_REQUEST['user_address']);

echo "<pre>";       //Предварительно отформатированный текстовый элемент который должен быть представлен точно так, как написано в HTML-файле
var_dump($_REQUEST);//Выводит информацию о вередаваемых через форму данных
var_dump($userAddress); 
echo "</pre>";  //закрывающий тег 11 строки

$arUserInfo = array("name"=>$_REQUEST['user_name'], "second_name"=>$_REQUEST['user_second_name'],"last_name"=>$_REQUEST['user_last_name'],"city"=>$userAddress[0],"street"=>$userAddress[1],"house"=>$userAddress[2],"flat"=>$userAddress[3]);

$strUserInfo = json_encode($arUserInfo, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); 
//возвращает строку, содержащую JSON-представление массива $arUserInfo в котором не будут закодированы многобайтовые символы Unicode с использыванием пробелов для форматирования
?>

	<form action="" method="POST">
		<strong>Ваше имя<span class="mf-req">*</span></strong><br>
		<input type="text" name="user_name" id="user_name" value=""><br>

		<strong>Ваше отчество<span class="mf-req">*</span></strong><br>
		<input type="text" name="user_second_name" id="user_second_name" value=""><br>

		<strong>Ваша фамилия<span class="mf-req">*</span></strong><br>
		<input type="text" name="user_last_name" id="user_last_name" value=""><br>

		<strong>Ваш адрес (город, улица, дом, квартира)<span class="mf-req">*</span></strong><br>
		<input type="text" name="user_address" id="user_address" value=""><br>

		<input type="submit" name="submit" id="submit" value="Отправить">
	</form>
<div id="result">
	<?=$strUserInfo?>
    <!-- Выводит переменную $strUserInfo  -->
</div> 
</body>
</html>