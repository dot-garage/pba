<?PHP 
	include_once '../common/function.inc';
	include_once '../include/pgsql.inc';
	
	session_start();
	
	$_SESSION['present'] = VIEW_SUBSCRIPTION;
	
	header('location: edit.php');
	exit;

var_dump($_REQUEST);
exit;
	
	$_SESSION['DB'] = 'user0001';
	
	$cDB = new Pgsql;
	
	$cDB->ConnectDB();
	
/* カンペ
serialnumber
youtubeurl
youtubetitle
addfile
content
registerdate
categorycode
 */
	$arrData = [];
	
	// サブスクインフォ取得
	$cDB->Select( $arrData, $_SESSION['DB'] . '.pba_subscription_info', '*', '', 'serialnumber' );
	
	$strInfo = '';
	foreach ( $arrData as $arrRow ) {
		$strInfo .= '<tr>';
		$strInfo .= '<td>' . $arrRow['youtubetitle'] . '</td>';
		$strInfo .= '<td>' . $arrRow['content'] . '</td>';
		$strInfo .= '<td>' . $arrRow['addfile'] . '</td>';
		$strInfo .= sprintf( '<td><input type="button" name="%s" value="編集"></td>', $arrRow['serialnumber'] );
		$strInfo .= '</tr>';
	}

?>