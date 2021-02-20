<?php

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

?>