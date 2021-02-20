<?PHP 
	include_once '../common/function.inc';
	include_once '../include/pgsql.inc';

	$cDB = new Pgsql;
	
	if ( !isset( $_REQUEST['category'] ) ) {
		$_REQUEST['category'] = '0000';
	}
	
	$cDB->ConnectDB();
	
	$arrData = $arrCategory = [];
	
	// カテゴリマスタ取得
	$cDB->Select( $arrCategory, 'user0001.pba_subscription_category' );

	// サブスクインフォ取得
	$strWhere = $_REQUEST['category'] == '0000'? '' : sprintf( "categorycode = '%s'", $_REQUEST['category'] );
	$cDB->Select( $arrData, 'user0001.pba_subscription_info', '*', $strWhere );
	
	// 定数系（あとでdefineにして別ファイルにまとめる）
	$strYtubeUrlBase = 'https://youtu.be/';
	$strSumbnailBase = 'http://img.youtube.com/vi/%s/mqdefault.jpg';
	$strCategoryBase = '<li class="cat-item"><a class="%s" href="sublist.php?category=%s">%s</a></li>';
	$strInfoBase =
<<< INFO
			<div class="archive-item">
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
	
	/*
	 * INFOエリア
	 */
	$strInfo = '';
	foreach ( $arrData as $arrRow ) {
		$strSumbnail = sprintf( $strSumbnailBase, $arrRow['youtubeurl'] );
		$strInfo .= sprintf ( $strInfoBase,
				$strSumbnail,
				FromatDate( $arrRow['registerdate'] ),
				$arrRow['youtubetitle'],
				$arrRow['content']
				);		
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