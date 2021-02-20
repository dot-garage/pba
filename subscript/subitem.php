<?PHP
	include_once '../common/function.inc';
	include_once '../include/pgsql.inc';

	session_start();
	
	$cDB = new Pgsql;
	
	$cDB->ConnectDB();
	
	$arrData = $arrCategory = [];

	// サブスクインフォ取得
	$strWhere = sprintf( "serialnumber = '%s'", $_REQUEST['no'] );
	$cDB->Select( $arrData, 'user0001.pba_subscription_info', '*', $strWhere );
	if ( count( $arrData ) < 1 ) {
		print "詳細情報がありません";
		exit;
	} else if ( count( $arrData ) > 1 ) {
		print "ページに問題が発生しました";
		exit;
	}
	
	// カテゴリマスタ取得
	$cDB->Select( $arrCategory, 'user0001.pba_subscription_category' );
	
	// 定数系（あとでdefineにして別ファイルにまとめる）
	$strYtubeUrlBase = 'https://www.youtube.com/embed/%s?controls=0&rel=0&fs=0&modestbranding=1';
	$strSumbnailBase = 'http://img.youtube.com/vi/%s/mqdefault.jpg';
	$strCategoryBase = '<li class="cat-item"><a class="%s" href="sublist.php?category=%s">%s</a></li>';
	
	/*
	 * 詳細情報セット
	 */
	$strYtubeUrl = sprintf( $strYtubeUrlBase, $arrData[0]['youtubeurl'] );
	
	/*
	 * カテゴリエリア
	 */
	$strStyle = 'cat-link';
	if ( $_SESSION['category'] == '0000' ) {
		$strStyle = 'cat-link-selected';
	}
	$strCategory = sprintf ( $strCategoryBase, $strStyle, '0000', 'すべて' );
	foreach ( $arrCategory as $arrRow ) {
		$strStyle = 'cat-link';
		if ( $_SESSION['category'] == $arrRow['categorycode'] ) {
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
<body>
    <header>
        <h1><a href=""><img style="height:100px; " src="../assets/img/common/title.png" alt="Personal Branding Academy"></a></h1>
    </header>
    <nav class="navbar">
        <a href="#">
            Personal Branding Academy
        </a>
    </nav>
    <div class="l-wapper">
    <div class="l-main">
        <div class="subarchive">
            <div class="iframe-content">
                <iframe
				<?PHP printf( 'src="%s"', $strYtubeUrl ); ?>
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
                </iframe>
                <h2><?PHP print $arrData[0]['youtubetitle']; ?></h2>
            </div>
            <div class="cp_box">
	            <input id="cp01" type="checkbox">
            	<label for="cp01"></label>
	            <div class="cp_container">
            		<p>コールドリーダーリュウってどんなやつ？って思いますよね！ww<br>
                        自己紹介をちゃんとしないとな～って思ったので簡単に自己紹介動画を創ってみました！<br>
                        是非！是非！みてね<br>

                        ――――――――――――――――――――――――<br>
                        もし、LINEの使い方、SNSの使い方、心理学、恋愛心理学の話で気になる事がありましたら、コメント欄に書いてください！<br>

                        ついに！コールドリーダーリュウの公式サイトができました！<br>
                        これから、色んな情報をお伝えします！そして、ファン限定の情報もありますので！是非是非ファン登録してね！<br>
                        〇コールドリーダーリュウの公式サイト：<br>
                        https://tainers.site/user/ryu/<br>

                        〇Instagram（リュウのインスタ）！フォローしてください：<br>
                        https://www.instagram.com/coldreaderryu/<br>

                        〇Twitterでは、セミナーの告知や日々思った事を書いています！是非フォローしてね！<br>
                        Twitter：https://twitter.com/ryu_ceo_AMG<br>

                        〇TikTokでは、毎日女性がモテるモテ術の話や心理学の話をしています！<br>
                        こちらも是非見てください！<br>
                        TikTok⇒＠coldreaderryu<br>
                        ―――――――――――――――――――――――――――<br>
                    </p>
            	</div>
            </div>
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