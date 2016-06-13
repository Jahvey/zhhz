<?php
namespace Lib\Tool;

/**
 * 字符串操作类
 */
class String {

	/**
	 * 生成用户编号
	 * @return 返回生成的用户编号
	 */
	public static function generateNumber( $bit ) {
		return substr( mt_rand(), 0, $bit );
	}

	/**
	 * 加密字符串
	 * @param  string $str  要加密的字符串
	 * @param  int    $type 是否进行双层加密（否：0， 是：1， 默认：0）
	 * @return 返回加密的字符串
	 */
	public static function encryptionString( $str, $type = 0 ) {
		$estr = '';
		switch ( $type ) {
			case 0 :
				$estr = md5( $str );
				break;
			case 1 :
				$estr = md5( md5( $str ) );
				break;
			default:
				exit('Error!');
				break;
		}
		return $estr;
	}
}