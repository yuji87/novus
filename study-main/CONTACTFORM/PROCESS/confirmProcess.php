<?php

// 確認画面
  if (!$name) {
    $errmessage["name"] = "blank";
  } else if (mb_strlen($name) > 50) {
    $errmessage["name"] = "exceed";
  }
  $_SESSION['name']  = htmlspecialchars($name, ENT_QUOTES);

  if (!$email) {
    $errmessage["email"] = "blank";
  } else if (mb_strlen($email) > 100) {
    $errmessage["email"] = "exceed";
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errmessage["email"] = "Illegal";
  }
  $_SESSION['email']    = htmlspecialchars($email, ENT_QUOTES);

  if (!$message && isset($errmessage["message"])) {
    $errmessage["message"] = "blank";
  } else if (mb_strlen($message) > 1000) {
    $errmessage["message"] = "exceed";
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

?>