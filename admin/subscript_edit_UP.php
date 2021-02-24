<?PHP 
	include_once '../common/function.inc';
	include_once '../include/pgsql.inc';
	
	session_start();
	
	$_SESSION['present'] = VIEW_SUBSCRIPTION;

	$arrInsert = $_REQUEST;

	$today = date('Ymd');

	$cDB = new Pgsql;
	
	$cDB->ConnectDB();
	
	$strYURL = GetYoutubeCode( $arrInsert['youtubeurl'] );
	$objFile = $arrInsert['addfile'] == '' ? 'NULL' : $arrInsert['addfile'];
	
	$strSQL = 'INSERT INTO'
			.	' user0001.pba_subscription_info'
			. ' SELECT'
			.	" lpad( cast( cast( max( serialnumber ) as integer )+1 as character), 10, '0' ) AS maxdata,"
			.	"'{$strYURL}',"
			.	"'{$arrInsert['youtubetitle']}',"
			.	$objFile . ","
			.	"'{$arrInsert['subsctext']}',"
			.	"'{$today}',"
			.	"'{$arrInsert['categorycode']}'"
			. ' FROM'
			.	' user0001.pba_subscription_info';
	$cDB->SqlExec($strSQL);
	
	$_SESSION['result'] = '登録しました';
	
	header('location: edit.php');
	exit;
	
?>