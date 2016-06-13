<?php
/**
 * 计算所在层级，供前台调用
 * @return [type] 
 */
function calfloor( $str ) {
	return pow(3,substr_count( $str, '-', 0 ) + 1);
}