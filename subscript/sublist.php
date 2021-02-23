<?PHP 
	include_once '../common/function.inc';
	include_once '../include/pgsql.inc';

	session_start();
	
	$cDB = new Pgsql;
	
	if ( isset( $_REQUEST['category'] ) ) {
		$_SESSION['category'] = $_REQUEST['category'];
	} else {
		$_REQUEST['category'] = isset( $_SESSION['category'] ) ? $_SESSION['category'] : '0000';
	}
	
	$cDB->ConnectDB();
	
	$arrData = $arrCategory = [];
	
	// サブスクインフォ取得
	$strWhere = $_REQUEST['category'] == '0000'? '' : sprintf( "categorycode = '%s'", $_REQUEST['category'] );
	$cDB->Select( $arrData, 'user0001.pba_subscription_info', '*', $strWhere, 'registerdate DESC' );
	
	// カテゴリマスタ取得
	$cDB->Select( $arrCategory, 'user0001.pba_subscription_category' );
	
	$strCategoryBase = '<li class="cat-item"><a class="%s" href="sublist.php?category=%s">%s</a></li>';
	$strInfoBase = <<< INFO
			<div class="archive-item" onclick="location.href='subitem.php?no=%s'">
                <div class="sumbnail">
                    <a href=""><img width="730px" height="410px" src="%s" alt=""></a>
                </div>
                <p class="far fa-calendar-alt">%s</p>
                <h2 class="heading">
                    <a href="">%s</a>
                </h2>
                <p>%s</p>
            </div>
INFO;
	
	/*
	 * INFOエリア
	 */
	$strInfo = '';
	foreach ( $arrData as $arrRow ) {
		$strSumbnail = sprintf( BASE_SUMBNAIL, $arrRow['youtubeurl'] );
		$strInfo .= sprintf ( $strInfoBase,
				$arrRow['serialnumber'],
				$strSumbnail,
				FromatDate( $arrRow['registerdate'] ),
				$arrRow['youtubetitle'],
				$arrRow['subsctext']
				);		
	}
	
	/*
	 * カテゴリエリア
	 */
	$strStyle = 'cat-link';
	if ( $_REQUEST['category'] == '0000' ) {
		$strStyle = 'cat-link-selected';
	}
	$strCategory = sprintf ( $strCategoryBase, $strStyle, '0000', 'すべて' );
	foreach ( $arrCategory as $arrRow ) {
		$strStyle = 'cat-link';
		if ( $_REQUEST['category'] == $arrRow['categorycode'] ) {
			$strStyle = 'cat-link-selected';
		}
		$strCategory .= sprintf ( $strCategoryBase, $strStyle, $arrRow['categorycode'], $arrRow['categoryname'] );
	}

?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/subscript.css" type="text/css">
    <!-- SNSアイコン -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/bc92a187b7.js" crossorigin="anonymous"></script>
    <title>サンプルページ</title>
</head>
<header>
    <h1><a href=""><img style="height:100px; " src="../assets/img/common/title.png" alt="Personal Branding Academy"></a></h1>
</header>
<body>
    <nav class="navbar">
        <a href="#">
            Personal Branding Academy
        </a>
    </nav>
    <div class="l-wapper">
    <div class="l-main">
        <div class="archive">
			<?PHP print $strInfo; ?>
        </div>
    </div>
    <div class="l-sidebar">
        <aside class="widget">
            <h2 class="heading heading-widget">カテゴリ</h2>
            <ul>
				<?PHP print $strCategory; ?>
            </ul>
        </aside>
    </div>
    </div>
</body>
</html>