<?php
	include_once '../common/function.inc';
	
	session_start();
	
	$_SESSION['DB'] = 'user0001';
	
	if ( !isset( $_SESSION['present'] ) ) { 
		$_SESSION['present'] = VIEW_GENERAL;
	}
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/edit.css">
    <title>Document</title>
</head>
<body>
    <script>
    function imgPreView(event, preview, Image) {
        var file = event.target.files[0];
        var reader = new FileReader();
        var preview = document.getElementById(preview);
        var previewImage = document.getElementById(Image);
   
        if(previewImage != null) {
            preview.removeChild(previewImage);
        }
        reader.onload = function(event) {
            var img = document.createElement("img");
            img.setAttribute("src", reader.result);
            img.setAttribute("id", Image);
            preview.appendChild(img);
        };
 
        reader.readAsDataURL(file);
    }
    </script>
    <div class="">
        <h2>画面編集</h2>
    </div>
    <div class="tab-wrap">
        <!-- 一般設定 -->
		<?php include_once "general_edit.php"; ?>
		
        <!-- 紹介画面設定 -->
        <input id="TAB-02" type="radio" name="TAB" class="tab-switch" /><label class="tab-label" for="TAB-02">紹介画面</label>
        <div class="tab-content">
            <form method="post" action="edit.php" novalidate="novalidate">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="sitename">紹介画像１</label>
                            </th>
                            <td>
                                <input type="file" onChange="imgPreView(event, 'preview1', 'previewImage1')">
                                <div class="imageframe preview1" id="preview1">
                                    <img src="../assets/img/common/introimg.png" id="previewImage1">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sitename">紹介画像1<br>キャッチフレーズ</label>
                            </th>
                            <td>
                                <p class="description">タイトル</p>
                                <input name="introtitle1" type="text" id="introtitle1" value="" class="regular-text">
                                <p class="description">文章</p>
                                <textarea name="introtext1" id="introtext1" cols="30" rows="10" wrap="hard"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sitename">紹介画像２</label>
                            </th>
                            <td>
                                <input type="file" onChange="imgPreView(event, 'preview2', 'previewImage2')">
                                <div class="imageframe preview2" id="preview2">
                                    <img src="../assets/img/common/introimg.png" id="previewImage2">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sitename">紹介画像2<br>キャッチフレーズ</label>
                            </th>
                            <td>
                                <p class="description">タイトル</p>
                                <input name="introtitle2" type="text" id="introtitle2" value="" class="regular-text">
                                <p class="description">文章</p>
                                <textarea name="introtext2" id="introtext2" cols="30" rows="10" wrap="hard"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sitename">紹介画像3</label>
                            </th>
                            <td>
                                <input type="file" onChange="imgPreView(event, 'preview3', 'previewImage3')">
                                <div class="imageframe preview3" id="preview3">
                                    <img src="../assets/img/common/introimg.png" id="previewImage3">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sitename">紹介画像3<br>キャッチフレーズ</label>
                            </th>
                            <td>
                                <p class="description">タイトル</p>
                                <input name="introtitle3" type="text" id="introtitle3" value="" class="regular-text">
                                <p class="description">文章</p>
                                <textarea name="introtext3" id="introtext3" cols="30" rows="10" wrap="hard"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sitename">プロフィール名</label>
                            </th>
                            <td>
                            <input name="profilename" type="text" id="profilename" value="" class="regular-text">
                            <p class="description">プロフィール画像の上に表示される名前です</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sitename">プロフィール画像</label>
                            </th>
                            <td>
                                <input type="file" onChange="imgPreView(event, 'profileImage', 'previewProfile')">
                                <div class="imageframe profileImage" id="profileImage">
                                    <img src="../assets/img/common/introimg.png" id="previewProfile">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sitename">プロフィール<br>紹介文</label>
                            </th>
                            <td>
                                <p class="description">タイトル</p>
                                <input name="profiletitle" type="text" id="profiletitle" value="" class="regular-text">
                                <p class="description">文章</p>
                                <textarea name="profiletext" id="profiletext" cols="30" rows="10" wrap="hard"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sitename">プロフィール動画</label>
                            </th>
                            <td>
                                <p class="description">Youtube URL</p>
                                <input name="profilemovie" type="text" id="profilemovie" value="" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sitename">youtubeリンク1</label>
                            </th>
                            <td>
                                <p class="description">URL</p>
                                <input name="ytblink1" type="text" id="ytblink1" value="" class="regular-text">
                                <p class="description">タイトル</p>
                                <input name="ytbtitle1" type="text" id="ytbtitle1" value="" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sitename">youtubeリンク2</label>
                            </th>
                            <td>
                                <p class="description">URL</p>
                                <input name="ytblink2" type="text" id="ytblink2" value="" class="regular-text">
                                <p class="description">タイトル</p>
                                <input name="ytbtitle2" type="text" id="ytbtitle2" value="" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sitename">youtubeリンク3</label>
                            </th>
                            <td>
                                <p class="description">URL</p>
                                <input name="ytblink3" type="text" id="ytblink3" value="" class="regular-text">
                                <p class="description">タイトル</p>
                                <input name="ytbtitle3" type="text" id="ytbtitle3" value="" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="sitename">youtubeリンク4</label>
                            </th>
                            <td>
                                <p class="description">URL</p>
                                <input name="ytblink4" type="text" id="ytblink4" value="" class="regular-text">
                                <p class="description">タイトル</p>
                                <input name="ytbtitle4" type="text" id="ytbtitle4" value="" class="regular-text">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="submit">
                    <input type="submit" name="submit" id="submit2" value="変更を保存">
                </p>
            </form>
        </div>
		
		<!-- LP画面設定 -->
        <input id="TAB-03" type="radio" name="TAB" class="tab-switch" /><label class="tab-label" for="TAB-03">LP画面</label>
        <div class="tab-content">
        </div>
		
		<!-- サブスク画面設定 -->
		<?php include_once "subscript_edit.php"; ?>
    </div>
</body>
</html>