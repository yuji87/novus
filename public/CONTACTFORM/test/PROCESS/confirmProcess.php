<?php
// 確認画面
  if ($name === "") {
    $error["name"] = "blank";
  } else if (mb_strlen($name) > 50) {
    $error["name"] = "exceed";
  }
  $_SESSION['name']  = htmlspecialchars($name, ENT_QUOTES);

  if ($email === "") {
    $error["email"] = "blank";
  } else if (mb_strlen($email) > 100) {
    $error["email"] = "exceed";
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error["email"] = "Illegal";
  }
  $_SESSION['email']    = htmlspecialchars($email, ENT_QUOTES);

$array = array(' ', '　', "\r\n", "\r", "\n", "\t");
$space = str_replace($array, '', $message);
  if ($message === "" || $space === "") {
    $error["message"] = "blank";
  } else if (mb_strlen($message) > 1000) {
    $error["message"] = "exceed";
  }
  $_SESSION['message'] = htmlspecialchars($message, ENT_QUOTES);

  if (!empty($error)) {
    $mode = 'input';
  } else {
    $token = bin2hex(random_bytes(32));    
    $_SESSION['token']  = $token;
    $mode = 'confirm';
    
    $statement = $pdo->prepare("INSERT INTO contacts(name, email, message) VALUES(:name, :email, :message)");
    $statement->bindValue("name", $name, PDO::PARAM_STR);
    $statement->bindValue("email", $email, PDO::PARAM_STR);
    $statement->bindValue("message", $message, PDO::PARAM_STR);
    $statement->execute();
  }