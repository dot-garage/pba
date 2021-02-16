<?php
require('function.php');

// DB接続
$pdo = connectDB();

session_start();
$_SESSION['id']=0;
$_SESSION['mail_address']="";
$_SESSION['login']=0;

$error="";
$mail_address = "";
$password = "";

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if(isset($_POST["login"])){
            // htmlspecialchars():エスケープ文字を変換
            $mail_address = htmlspecialchars($_POST["mail_address"], ENT_QUOTES);
            $password = htmlspecialchars($_POST["password"], ENT_QUOTES);
            if(strlen($mail_address)==0)
                $error = "メールアドレスが入力されていません。";
            if(strlen($password)==0)
                $error = "パスワードが入力されていません。";

            // メールアドレス・パスワード入力チェックOK
            if(strlen($error)==0){
                // バッファクエリ:True （全ての情報をDBから取得しておく）
                $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
                $st = $pdo->prepare("SELECT * FROM common_admin WHERE mail_address=:mail_address");
                $st->bindParam(':mail_address', $mail_address);
                $st->execute();
                if($st->rowCount()>0){
                  $row = $st->fetch();
                  if($row['password']==$password){
                      //ログイン成功!
                      login($row);
                  }else{
                      $error ="メールアドレスまたはパスワードが違います。";
                  }
              }else{
                  $error = "メールアドレスまたはパスワードが違います。";
              }
          }
      }
      break;

  default:
      if(isset($_COOKIE['cookie'])){
          $cookie = $_COOKIE['cookie'];
          $mail_address = $cookie['mail_address'];
          $password = $cookie['password'];
      }
      break;
}
//　ログイン処理
// セッション情報を保持し画面遷移
function login($user){
  $_SESSION["id"]=$user["id"];
  $_SESSION["mail_address"]=$user["mail_address"];
  $_SESSION["login"]=1;

  $checkboxValue = $_POST['remember'];
  if($checkboxValue){
      setcookie("cookie[mail_address]", $user["mail_address"]);
      setcookie("cookie[password]", $user["password"]);
  }else{
      if(isset($_COOKIE['cookie[mail_address]']))
          setcookie('cookie[mail_address]', time() -1800);
      if(isset($_COOKIE['cookie[password]']))
          setcookie('cookie[password]', time() - 1800);
  }

  header("Location: http://sandbox.localhost/edit_profile.php");
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/account.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>管理画面</title>
</head>
<body>
    <!-- jsファイル(bootstlap) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="../assets/js/account.js"></script>
    <header>
    </header>
    <div class="login">
      <h2>管理画面</h2>
      <p>登録時に入力したアカウントIDとパスワードを<br class="br-sp">設定してください</p>
      <form class="loginform" action="admin.php" method="post">
          <?php
            if(strlen($error)>0){
                echo "<div class='alert alert-danger' > エラー : {$error}</div>";
            }
            ?>
        <div class="form-group row">
            <label for="accountid" class="col-md-3 col-form-label">アカウントID</label>
            <input type="text" class="form-control" id="accountid" required>
        </div>
        <div class="form-group row">
            <label for="password" class="col-md-3 col-form-label">パスワード</label>
            <input type="text" class="form-control" id="password" required>
        </div>
        <input class="loginbtn" id="loginbtn" type="submit" value="ログイン">
      </form>
    </div>
    <footer>
    </footer>
</body>
</html>