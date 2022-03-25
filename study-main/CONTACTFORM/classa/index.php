<h1 class="formTitle">
        お問い合わせ
      </h1>
      <form action="./contactForm.php" method="post" id="form" class="" enctype="multipart/form-data">
        <input id="name" type="text" name="fullname" value="<?php echo $_SESSION['fullname'] ?>" class="" placeholder="NAME"><br>
        <input id="email" type="email" name="email" value="<?php echo $_SESSION['email'] ?>" class="" placeholder="E-MAIL"><br>
        <textarea id="message" type="text" name="message" placeholder="MESSAGE"><?php echo $_SESSION['message'] ?></textarea><br>
        <input id="submit" type="submit" name="confirm" value="送信内容を確認" class="" >
      </form>