<?php

/**
 * Реализовать проверку заполнения обязательных полей формы в предыдущей
 * с использованием Cookies, а также заполнение формы по умолчанию ранее
 * введенными значениями.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['text'] = !empty($_COOKIE['text_error']);
  $errors['tel'] = !empty($_COOKIE['tel_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['date'] = !empty($_COOKIE['date_error']);
  $errors['radio1'] = !empty($_COOKIE['radio1_error']);
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['biog'] = !empty($_COOKIE['biog_error']);
  $errors['check1'] = !empty($_COOKIE['check1_error']);

  // TODO: аналогично все поля.

  // Выдаем сообщения об ошибках.
  if ($errors['text']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('text_error', '', 100000);
    // Выводим сообщение.
    $messages['text'] = '<div class="error">Заполните имя.</div>';
  }
  if ($errors['tel']) {
    setcookie('tel_value', '', 100000);
    $messages['tel'] = '<div class="error">Заполните телефон.</div>';
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages['email'] = '<div class="error">Заполните email.</div>';
  }
  if ($errors['date']) {
    setcookie('date_value', '', 100000);
    $messages['date'] = '<div class="error">Заполните дату рождениян.</div>';
  }
  if ($errors['radio1']) {
    setcookie('radio1_error', '', 100000);
    $messages['radio1'] = '<div class="error">Заполните пол.</div>';
  }
  if ($errors['name']) {
    setcookie('name_value', '', 100000);
    $messages['name'] = '<div class="error">Заполните таблицу.</div>';
  }
  if ($errors['biog']) {
    setcookie('biog_error', '', 100000);
    $messages['biog'] = '<div class="error">Заполните биографию.</div>';
  }
  if ($errors['check1']) {
    setcookie('check1_error', '', 100000);
    $messages['check1'] = '<div class="error">Поставьте галочку.</div>';
  }
  // TODO: тут выдать сообщения об ошибках в других полях.

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['text'] = empty($_COOKIE['text_value']) ? '' : $_COOKIE['text_value'];
  $values['tel'] = empty($_COOKIE['tel_value']) ? '' : $_COOKIE['tel_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['date'] = empty($_COOKIE['date_value']) ? '' : $_COOKIE['date_value'];
  $values['radio1'] = empty($_COOKIE['radio1_value']) ? '' : $_COOKIE['radio1_value'];
  $values['name'] = empty($_COOKIE['name_value']) ? [] : json_decode($_COOKIE['name_value'], true);
  $values['biog'] = empty($_COOKIE['biog_value']) ? '' : $_COOKIE['biog_value'];
  $values['check1'] = empty($_COOKIE['check1_value']) ? '' : $_COOKIE['check1_value'];
  // TODO: аналогично все поля.

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('1.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;
  if (empty($_POST['text'])  || !preg_match('/^[a-zA-Z\s]{1,150}$/', $_POST['text'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('text_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($_POST['tel']) || !is_numeric($_POST['tel']) || !preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7}$/', $_POST['tel'])) {
    setcookie('tel_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($_POST['email']) || !preg_match('/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/i', $_POST['email'])) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($_POST['date']) || !preg_match('/^[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])$/', $_POST['date'])) {
    setcookie('date_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (!isset($_POST['radio1']) || !in_array($_POST['radio1'], array('male', 'female'))) {
    setcookie('radio1_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('radio1_value', $_POST['radio1'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['name'])) {
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  $valid_languages = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11");
  if (!isset($_POST['name'])) {
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    foreach ($_POST['name'] as $n1) {
      if (!in_array($n1, $valid_languages)) {
        setcookie('name_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
        break;
      }
    }
  }
  if (empty($_POST['biog'])) {
    setcookie('biog_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($_POST['check1']) || $_POST['check1'] != 'on') {
    setcookie('check1_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('check1_value', $_POST['check1'], time() + 30 * 24 * 60 * 60);
  }
  // Сохраняем ранее введенное в форму значение на месяц.
  setcookie('text_value', $_POST['text'], time() + 30 * 24 * 60 * 60);
  setcookie('tel_value', $_POST['tel'], time() + 30 * 24 * 60 * 60);
  setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  setcookie('date_value', $_POST['date'], time() + 30 * 24 * 60 * 60);

  setcookie('name_value', json_encode($_POST['name']), time() + 30 * 24 * 60 * 60);
  setcookie('biog_value', $_POST['biog'], time() + 30 * 24 * 60 * 60);


  // *************
  // TODO: тут необходимо проверить правильность заполнения всех остальных полей.
  // Сохранить в Cookie признаки ошибок и значения полей.
  // *************

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: 2.php');
    exit();
  } else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('text_error', '', 100000);
    setcookie('tel_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('date_error', '', 100000);
    setcookie('radio1_error', '', 100000);
    setcookie('name_error', '', 100000);
    setcookie('biog_error', '', 100000);
    setcookie('check1_error', '', 100000);
    // TODO: тут необходимо удалить остальные Cookies.
  }

  // Сохранение в БД.
  // ...
  $user = 'u67355'; // Заменить на ваш логин uXXXXX
  $pass = '5084964'; // Заменить на пароль, такой же, как от SSH
  $db = new PDO(
    'mysql:host=localhost;dbname=u67355',
    $user,
    $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  ); // Заменить test на имя БД, совпадает с логином uXXXXX

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
  } catch (PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
  }

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: 2.php');
}
