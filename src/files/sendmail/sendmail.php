<?php
	// use PHPMailer\PHPMailer\PHPMailer;
	// use PHPMailer\PHPMailer\Exception;

	// require 'phpmailer/src/Exception.php';
	// require 'phpmailer/src/PHPMailer.php';
	// require 'phpmailer/src/SMTP.php';

	// $mail = new PHPMailer(true);
	// $mail->CharSet = 'UTF-8';
	// $mail->setLanguage('ru', 'phpmailer/language/');
	// $mail->IsHTML(true);
	
	// $mail->isSMTP();                                            //Send using SMTP
	// $mail->Host       = smtp.gmail.com;                     //Set the SMTP server to send through
	// $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	// $mail->Username   = 'osipavanadezda@gmail.com';                     //SMTP username
	// $mail->Password   = 'wkixrpqxonmiffbl';                               //SMTP password
	// $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
	// $mail->Port       = 465;                 
	 
	//  //От кого письмо
	//  $mail->setFrom('osipavanadezda@gmail.com', 'Osipova Nadezda'); // Указать нужный E-mail
	// // //Кому отправить
	// $mail->addAddress('osipavanadezda@gmail.com');
	// $mail->addAddress('kaliadina@mail.ru');
	// // //Тема письма
	//  $mail->Subject = 'Reserve a table"';

	// //Тело письма
	// $body = '<h1>Reserve a table</h1>';

	// if(trim(!empty($_POST['email']))){
	// 	$body.=$_POST['email'];
	// }	
	
	// /*
	// // //Прикрепить файл
	// // if (!empty($_FILES['image']['tmp_name'])) {
	// // 	//путь загрузки файла
	// // 	$filePath = __DIR__ . "/files/sendmail/attachments/" . $_FILES['image']['name']; 
	// // 	//грузим файл
	// // 	if (copy($_FILES['image']['tmp_name'], $filePath)){
	// // 		$fileAttach = $filePath;
	// // 		$body.='<p><strong>Фото в приложении</strong>';
	// // 		$mail->addAttachment($fileAttach);
	// // 	}
	// // }
	// // */

	//  $mail->Body = $body;

	// //Отправляем
	// if (!$mail->send()) {
	// 	$message = 'Ошибка';
	// } else {
	// 	$message = 'Данные отправлены!';
	// }

	// $response = ['message' => $message];

	// header('Content-type: application/json');
	// echo json_encode($response);


	// Файлы phpmailer
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $form = $_POST['form'];

	
// Формирование самого письма
$title = "Reserve a table";

$body = " <h2>Reserve a table</h2>
  <tr style='background-color: #f8f8f8;'>
    <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>Имя: </b>$name</td>
    <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>Номер телефона: </b>$phone</td>
	<td style='padding: 10px; border: #e9e9e9 1px solid;'><b>E-mail: </b>$form</td>
  </tr>
  ";
$body = "<table style='width: 100%;'>$body</table>";

}
//$json = file_get_contents('php://input');
//$obj = json_decode($json, true);

// $name = $obj['name'];
// $phone = $obj['phone'];
// $form = $obj['form[]'];

// // Формирование самого письма
// $title = "Reserve a table";

// $body = " <h2>Reserve a table</h2>
//   <tr style='background-color: #f8f8f8;'>
//     <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>Имя: </b>$name</td>
//     <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>Номер телефона: </b>$phone</td>
// 	<td style='padding: 10px; border: #e9e9e9 1px solid;'><b>E-mail: </b>$form</td>
//   </tr>
//   ";
// $body = "<table style='width: 100%;'>$body</table>";

// // Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();

try {
  $mail->isSMTP();
  $mail->CharSet = "UTF-8";
  $mail->SMTPAuth   = true;
  // $mail->SMTPDebug = 2; 
  $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

  // Настройки вашей почты
  $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
  $mail->Username   = 'osipavanadezda@gmail.com'; // Логин на почте
  $mail->Password   = 'wkixrpqxonmiffbl'; // Пароль 
  $mail->SMTPSecure = 'ssl';
  $mail->Port       = 465;

  $mail->setFrom('osipavanadezda@gmail.com', 'Osipova Nadezda'); // Адрес самой почты и имя отправителя

  // Получатель письма
  $mail->addAddress('osipavanadezda@gmail.com');
  $mail->addAddress('kaliadina@mail.ru');

   // Отправка сообщения
   $mail->isHTML(true);
   $mail->Subject = $title;
   $mail->Body = $body;
 
 // Проверяем отравленность сообщения
 if ($mail->send()) {$result = "success";} 
 else {$result = "error";}
 
 } catch (Exception $e) {
   $result = "error";
   $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
 }
 
 //Отображение результата
 echo json_encode(["result" => $result, "status" => $status]);
?>