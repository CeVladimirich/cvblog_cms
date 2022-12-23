<?php
$step = $_GET['step'];
switch($step) {
	case 2:
	$random = random_key($_POST['size']);
	echo 'Сгенерированный код: '.$random.'<br>';
	echo 'Приятного пользования CeBlog CMS!';
	break;
	default:
	?>
	Данная страница поможет в генерации кода для config.php.
	<form method="post" action="?step=2">
	Кол-во символов: <input type="text" name="size" size="3"><br>
	<input type="submit" value="Продолжить">
	</form>
	<?php
}
function random_key($length = 6) {
	$arr = array(
		'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 
		'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
		'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 
		'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
	);
	$res = '';
	for ($i = 0; $i < $length; $i++) {
		$res .= $arr[random_int(0, count($arr) - 1)];
	}
	return $res;
}
?>
