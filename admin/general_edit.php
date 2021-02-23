<?PHP 
	include_once '../common/function.inc';
	include_once '../include/pgsql.inc';
	
	$strChecked = $_SESSION['present'] == VIEW_GENERAL ? ' checked="checked"' : '';
	
	$cDB = new Pgsql;
	
	$cDB->ConnectDB();

print <<< HTML
<input id="TAB-01" type="radio" name="TAB" class="tab-switch"{$strChecked}/><label class="tab-label" for="TAB-01">一般</label>
<div class="tab-content">
	<h1>一般設定</h1>
	<!-- novalidate : フォームの入力内容の検証を無効 -->
	<form method="post" action="edit.php" novalidate="novalidate">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="sitename">サイトのタイトル</label>
					</th>
					<td>
					<input name="sitename" type="text" id="sitename" value="" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="sitename">サイト タイトル画像</label>
					</th>
					<td>
						<input type="file" onChange="imgPreView(event, 'siteimage', 'previewsite')">
						<div class="imageframe logoimage" id="logoimage">
							<img src="../assets/img/common/introimg.png" id="previewsite">
						</div>
						<p class="description">800px × 100pxの画像を紹介画面の上部に表示します</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="sitename">サイト ロゴ画像</label>
					</th>
					<td>
						<input type="file" onChange="imgPreView(event, 'logoimage', 'previewlogo')">
						<div class="imageframe logoimage" id="logoimage">
							<img src="../assets/img/common/introimg.png" id="previewlogo">
						</div>
						<p class="description">100px × 100pxの画像を紹介画面の左上に表示します</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="sitename">サイトURL</label>
					</th>
					<td>
					<input name="siteurl" type="url" id="siteurl" value="" class="regular-text">
					<p class="description">このサイトの簡単な説明</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="sitename">管理者メールアドレス</label>
					</th>
					<td>
					<input name="admin_email" type="email" id="admin_email" value="" class="regular-text">
					<p class="description">このアドレスはファン登録した方への返信等に使用します。</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="sitename">twitter URL</label>
					</th>
					<td>
						<input name="url_twitter" type="text" id="url_twitter" value="" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="sitename">facebook URL</label>
					</th>
					<td>
						<input name="url_facebook" type="text" id="url_facebook" value="" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="sitename">instagram URL</label>
					</th>
					<td>
						<input name="url_instagram" type="text" id="url_instagram" value="" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="sitename">Youtube URL</label>
					</th>
					<td>
						<input name="url_youtube" type="text" id="url_youtube" value="" class="regular-text">
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" name="submit" id="submit" value="変更を保存">
		</p>
	</form>
</div>
HTML;

