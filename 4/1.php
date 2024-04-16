<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="style.css">
  <title>Задание 4</title>

</head>

<body>



  <form action="2.php" method="POST" class="form" id="form">
    <h2>Форма</h2>
    <label>
      ФИО:<br>
      <?php if (!empty($messages['text'])) {
        print $messages['text'];
      } ?>
      <input name="text" placeholder="Трубиенко Татьяна Алексеевна" class="form_input <?php if ($errors['text']) {
                                                                                        print 'error';
                                                                                      } ?>" type="text" value="<?php print $values['text']; ?>">
    </label><br>
    <label>
      Телефон:<br>
      <?php if (!empty($messages['tel'])) {
        print $messages['tel'];
      } ?>
      <input name="tel" placeholder="+7-123-45-67" type="text" class="form_input <?php if ($errors['tel']) {
                                                                                    print 'error';
                                                                                  } ?>" value="<?php print $values['tel']; ?>">
    </label><br>
    <label>
      Email:<br>
      <?php if (!empty($messages['email'])) {
        print $messages['email'];
      } ?>
      <input name="email" placeholder="rinatiadzua@gmail.com" type="email" class="form_input <?php if ($errors['email']) {
                                                                                                print 'error';
                                                                                              } ?>" value="<?php print $values['email']; ?>">
    </label><br>
    <label>
      Дата рождения:<br>
      <?php if (!empty($messages['date'])) {
        print $messages['date'];
      } ?>
      <input name="date" value="2000-01-01" type="date" class="form_input <?php if ($errors['date']) {
                                                                            print 'error';
                                                                          } ?>" value="<?php print $values['date']; ?>"><br>
      Пол:<br>
      <?php if (!empty($messages['radio1'])) {
        print $messages['radio1'];
      } ?>
      <label>
        <input type="radio" name="radio1" value="male" <?php if ($values['radio1'] == 'male') {
                                                          print 'checked';
                                                        } ?>>
        М
      </label>
      <label>
        <input type="radio" name="radio1" value="female" <?php if ($values['radio1'] == 'female') {
                                                            print 'checked';
                                                          } ?>>
        Ж
      </label>
    </label><br>
    <label>
      Любимый язык программирования:
      <br>
      <?php if (!empty($messages['name'])) {
        print $messages['name'];
      } ?>
      <select name="name[]" multiple="multiple" size="4">
        <option value="1" <?php if (in_array("1", $values['name'])) {
                            print 'selected';
                          } ?>> Pascal</option>
        <option value="2" <?php if (in_array("2", $values['name'])) {
                            print 'selected';
                          } ?>> C</option>
        <option value="3" <?php if (in_array("3", $values['name'])) {
                            print 'selected';
                          } ?>> C++</option>
        <option value="4" <?php if (in_array("4", $values['name'])) {
                            print 'selected';
                          } ?>> JavaScript</option>
        <option value="5" <?php if (in_array("5", $values['name'])) {
                            print 'selected';
                          } ?>> PHP</option>
        <option value="6" <?php if (in_array("6", $values['name'])) {
                            print 'selected';
                          } ?>> Python</option>
        <option value="7" <?php if (in_array("7", $values['name'])) {
                            print 'selected';
                          } ?>> Java</option>
        <option value="8" <?php if (in_array("8", $values['name'])) {
                            print 'selected';
                          } ?>> Haskel</option>
        <option value="9" <?php if (in_array("9", $values['name'])) {
                            print 'selected';
                          } ?>> Clojure</option>
        <option value="10" <?php if (in_array("10", $values['name'])) {
                              print 'selected';
                            } ?>> Prolog</option>
        <option value="11" <?php if (in_array("11", $values['name'])) {
                              print 'selected';
                            } ?>> Scala</option>
      </select><br>
      Биография:<br>
      <?php if (!empty($messages['biog'])) {
        print $messages['biog'];
      } ?>
      <textarea name="biog" class="form_input <?php if ($errors['biog']) {
                                                print 'error';
                                              } ?>" type="text" value="<?php print $values['biog']; ?>"> </textarea>
    </label><br>
    С контрактом ознакомлен(а):<br>
    <?php if (!empty($messages['check1'])) {
      print $messages['check1'];
    } ?>
    <input type="checkbox" value="on" name="check1" <?php if ($values['check1'] == 'on') {
                                                      print 'checked';
                                                    } ?>><br>
    <input type="submit" value="Сохранить">
  </form>
</body>

</html>