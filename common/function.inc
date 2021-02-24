<?php

include_once 'define.inc';

/**
 * 
 * 日付のフォーマットを行う
 * 
 * @param stirng $AstrDate フォーマット対象文字列
 * @param string $AstrDiv 区切り記号
 * @return string フォーマット後日付
 */
function FromatDate( $AstrDate, $AstrDiv = '.' )
{
	$Y = substr($AstrDate , 0, 4 );
	$M = substr($AstrDate , 4, 2 );
	$D = substr($AstrDate , 6, 2 );
	$ret = implode( $AstrDiv, [ $Y, $M, $D ] );
	return $ret;
}

/**
 * 
 * youtubeURLから特定コードを取り出す
 * 加工しやすいようにコードのみをDBに格納する
 * 
 * @param string $AstrURL もとのURL
 * @return string 切り出した文字列
 */
function GetYoutubeCode( $AstrURL )
{
	$strRet = str_replace('https://www.youtube.com/watch?v=', '', $AstrURL );
	return $strRet;
}

?>