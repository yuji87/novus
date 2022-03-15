<!--ログインフォーム-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="2.css" />
    <title>新規会員登録</title>
</head>

<body class="h-100 bg-secondary p-4 p-md-5">
    <form class="row g-3 bg-white p-2 p-md-5 shadow-sm" action="insert.php" method="post">
        <h1 class="my-3">アカウント作成</h1>
            <p class="my-2">当サービスを利用するために、次のフォームに必要事項をご記入ください。</p>

            <!--名前を記入-->
            <div class="row my-4">
                <label for="InputName" class="form-label">*Name</label>
                <div class="md-3">
                    <input type="text" class="form-control col-6" name="name" required>
                    <?php if (!empty($error["name"]) && $error['name'] === 'blank'): ?>
                        <p class="error text-danger">＊名前を入力してください</p>
                    <?php endif ?>
                </div>
            </div>

            <!--電話番号を記入-->
            <div class="row my-4">
                <label for="InputPhone" class="form-label">*Phone</label>
                <div class="md-3">
                    <input type="text" class="form-control col-6" name="tel" required>
                    <?php if (!empty($error["tel"]) && $error['tel'] === 'blank'): ?>
                        <p class="error text-danger">＊電話番号を入力してください</p>
                    <?php elseif (!empty($error["tel"]) && $error['tel'] === 'duplicate'): ?>
                        <p class="error">＊この電話番号はすでに登録済みです</p>
                    <?php endif ?>
                </div>
            </div>

            <!--メアドを記入-->
            <div class="row my-4">
                <label for="InputEmail" class="form-label">Email</label>
                <div class="md-3">
                    <input type="email" class="form-control col-6" name="email" required>
                </div>
            </div>

            <!--パスワードを記入-->
            <div class="row my-4">
                <div class="md-3">
                   <p>*Password</p>
                   <input type="password" class="form-control col-4" id="inputPassword8" name="password" required>
                </div>
        </div>

        <div class="col-12 my-4">
            <button type="submit" class="btn btn-primary">Sign up</button>
        </div>
    </form>
</body>
</html>
