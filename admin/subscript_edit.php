<?PHP 
	include_once '../common/function.inc';
	include_once '../include/pgsql.inc';
	
	$strChecked = $_SESSION['present'] == VIEW_SUBSCRIPTION ? ' checked="checked"' : '';
	$strResult = $_SESSION['result'];
	$_SESSION['result'] = '';
	
	$cDB = new Pgsql;
	
	$cDB->ConnectDB();
	
	$arrData = $arrCategory = [];

	// カテゴリマスタ取得
	$cDB->Select( $arrCategory, $_SESSION['DB'] . '.pba_subscription_category' );
	
	// サブスクインフォ取得
	$strSQL = 'SELECT '
			.	'T1.serialnumber, T1.youtubetitle, T1.subsctext, T1.addfile, T2.categoryname'
			. ' FROM '
			.	$_SESSION['DB'] . '.pba_subscription_info T1'
			. ' LEFT JOIN ' . $_SESSION['DB'] . '.pba_subscription_category T2'
			. ' ON T1.categorycode = T2.categorycode'
			. ' ORDER BY T1.serialnumber';
	$arrData = $cDB->SqlExec($strSQL);
	
	// カテゴリ選択肢生成
	$strCategory = '<option value="0000">なし</option>';
	foreach ( $arrCategory as $arrRow ) {
		$strCategory .= sprintf( '<option value="%s">%s</option>'
				, $arrRow['categorycode'], $arrRow['categoryname'] );
	}
	
	// 下部インフォテーブル生成
	$strInfo = '';
	foreach ( $arrData as $arrRow ) {
		$strInfo .= '<tr>';
		$strInfo .= sprintf( '<td class="edit_button"><input type="button" name="%s" value="編集"></td>'
					, $arrRow['serialnumber'] );
		$strInfo .= '<td>' . $arrRow['youtubetitle'] . '</td>';
		$strInfo .= '<td>' . $arrRow['subsctext'] . '</td>';
		$strInfo .= '<td>' . $arrRow['categoryname'] . '</td>';
		$strInfo .= '<td>' . $arrRow['addfile'] . '</td>';
		$strInfo .= '</tr>';
	}
	
	

print <<< HTML
<input id="TAB-04" type="radio" name="TAB" class="tab-switch"{$strChecked}/><label class="tab-label" for="TAB-04">サブスクリプション<br>画面</label>
<div class="tab-content">
	<form method="post" action="subscript_edit_UP.php">
		<table class="form-table">
			<tbody>
			<tr>
				<th scope="row">
					<label for="sitename">登録内容</label>
				</th>
				<td>
					<p class='result'>{$strResult}</p>
					<p class="description">Youtube URL</p>
					<input name="youtubeurl" type="text" id="youtubelink" value="" class="regular-text">
					<p class="description">タイトル</p>
					<input name="youtubetitle" type="text" id="youtubetitle" value="" class="regular-text">
					<p class="description">説明文</p>
					<textarea name="subsctext" id="subsctext" cols="30" rows="10" wrap="hard"></textarea>
					<p class="description">カテゴリ</p>
					<select name="categorycode" id="categorycode" class="regular-text">
						{$strCategory}
					</select>
					<p class="description">その他資料</p>
					<input type="file" name="addfile" accept=".pdf">
				</td>
			</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" name="submit" id="submit3" value="登録">
		</p>
	</form>
	<table class="subscriptlist">
		<thead>
			<tr>
				<th scope="col">編集</th>
				<th scope="col">タイトル</th>
				<th scope="col">説明文</th>
				<th scope="col">カテゴリ</th>
				<th scope="col">その他資料</th>
			</tr>
		</thead>
		<tbody>
			{$strInfo}
		</tbody>
	</table>
</div>
HTML;

?>