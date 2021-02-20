<?php

include_once 'defineDB.inc';

class Pgsql
{
    // コンストラクタ
	function __construct()
	{
		$this->cCon = '';
	}

	/**
	 * DB接続
	 * @return object $db ハンドラ
	 */
	function ConnectDB()
	{
		$strConnect = sprintf( DB_STRING, DB_HOST, DB_PORT,DB_NAME, DB_USER, DB_PASS );
		$db = pg_connect( $strConnect );
		if ( !$db ) {
			print "DB接続失敗";
			exit;	
		}
		$this->cCon = $db;
	}
	
	/**
	 * 
	 * SQL実行
	 * 
	 * @param string $AstrSQL SQL文
	 * @return array $result 実行結果
	 */
	function SqlExec( $AstrSQL )
	{
		$result = pg_query( $this->cCon, $AstrSQL );
		if ( !$result ) {
		  print "SQLエラー";
		  exit;
		}
		$result = pg_fetch_all( $result );
		return $result;
	}

	/**
	 * SELECT文の実行
	 * 
	 * @param array $Aret 実行結果
	 * @param string $Atable テーブル名
	 * @param string $Aselect SELECT対象のカラム
	 * @param string $Awhere 条件
	 * @param string $Aorder 順序
	 */
	function Select( &$Aret, $Atable, $Aselect = '*', $Awhere = '', $Aorder = '' )
	{
		$sql = sprintf( "SELECT %s FROM %s", $Aselect, $Atable );
		if ( $Awhere !== '' ) {
			$sql .= sprintf( " WHERE %s", $Awhere );
		}
		if ( $Aorder !== '' ) {
			$sql .= sprintf( " ORDER BY %s", $Aorder );
		}
		$Aret = $this->SqlExec( $sql );
	}
	
	/**
	 * 
	 * INSERT文の実行
	 * 
	 * @param string $Atable テーブル
	 * @param string $Acol カラム
	 * @param string $Aval 値
	 */
	function Insert( $Atable, $Acol, $Aval )
	{
		$sql = sprintf( "INSERT INTO %s ( %s ) VALUE ( %s )", $Atable, $Acol, $Aval );
		// クエリの実行
		$this->SqlExec( $sql );
		
	}
}


?>


