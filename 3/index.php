<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    print('Спасибо, результаты сохранены.');
  }
  // Включаем содержимое файла form.php.
  include('form.html');
  // Завершаем работу скрипта.
  exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
$errors = FALSE;


if (empty($_POST['text']) || !preg_match('/^[a-zA-Z\s]{1,150}$/', $_POST['text'])) {
  print('Заполните имя.<br/>');
  $errors = TRUE;
  }
  
  if (empty($_POST['tel']) || !is_numeric($_POST['tel']) || !preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', $_POST['tel'])) {
  print('Заполните телефон.<br/>');
  $errors = TRUE;
  }
  
  if (empty($_POST['email']) || !preg_match('/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/i', $_POST['email']) ) {
  print('Заполните почту.<br/>');
  $errors = TRUE;
  }
  
  if (empty($_POST['date']) || !preg_match('/^[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])$/', $_POST['date']) ) {
  print('Заполните дату.<br/>');
  $errors = TRUE;
  }
  if (!isset($_POST['radio1']) || !in_array($_POST['radio1'], array('male', 'female'))) {
  print('Выберете пол.<br/>');
  $errors = TRUE;
  }
  
  $valid_languages = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11");
  if (!isset($_POST['name'])) {
  print('Выберете языки.<br/>');
  $errors = TRUE;
  }
  else {
  foreach ($_POST['name'] as $langu) {
  if ( !in_array($langu, $valid_languages)) {
  print('Выберете языки.<br/>');
  $errors = TRUE;
  break;
  }
  }
  }
  
  if (empty($_POST['biog']) ) {
  print('Заполните биографию.<br/>');
  $errors = TRUE;
  }
  
  if(!isset($_POST['check1']) || $_POST['check1'] != 'on') {
  print('Отметьте чекбокс.<br/>');
  $errors = TRUE;
  }
  

// *************
// Тут необходимо проверить правильность заполнения всех остальных полей.
// *************

if ($errors) {
  // При наличии ошибок завершаем работу скрипта.
  exit();
}

// Сохранение в базу данных.

$user = 'u67355'; // Заменить на ваш логин uXXXXX
$pass = '5084964'; // Заменить на пароль, такой же, как от SSH
$db = new PDO('mysql:host=localhost;dbname=u67355', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); // Заменить test на имя БД, совпадает с логином uXXXXX

// Подготовленный запрос. Не именованные метки.
try {
  $stmt = $db->prepare("INSERT INTO form (text, tel, email, date, radio1, biog, check1) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->execute([
  $_POST['text'],
  $_POST['tel'],
  $_POST['email'],
  $_POST['date'],
  $_POST['radio1'],
  $_POST['biog'],
  $_POST['check1']
  ]);
  $form_id = $db->lastInsertId();
  foreach ($_POST['name'] as $language) {
  $stmt = $db->prepare("INSERT INTO pl (name) VALUES (?)");
  $stmt->execute([$language]);

  $pl_id = $db->lastInsertId();

  $stmt = $db->prepare("INSERT INTO form_pl (form_id, pl_id) VALUES (?, ?)");
  $stmt->execute([$form_id, $pl_id]);
  }
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

//  stmt - это "дескриптор состояния".
 
//  Именованные метки.
//$stmt = $db->prepare("INSERT INTO test (label,color) VALUES (:label,:color)");
//$stmt -> execute(['label'=>'perfect', 'color'=>'green']);
 
//Еще вариант
/*$stmt = $db->prepare("INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':email', $email);
$firstname = "John";
$lastname = "Smith";
$email = "john@test.com";
$stmt->execute();
*/

// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.
header('Location: ?save=1');
