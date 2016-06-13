<?php
namespace Lib\Tool;

/**
 * 相关参数计算类
 * 积分计算，等级计算，级别计算等
 */
class Math {
	/**
	 * 根据 a轮中用户的编号，计算b轮中所属的位置父级别分类
	 */
	public function calculationFid( $id ) {
		
		//计算所在区域
		$area = (int)( $id % 3 );

		//根据所在区域计算父类id
		$fid = 0;
		switch ( $area ) {
			case 2: $fid = (int)( ( $id + 1 ) / 3 ); break;
			case 1: $fid = (int)( ( $id - 1 ) / 3 ); break;
			case 0: $fid = (int)( $id / 3 );break;
			default: break;
		}

		//返回 fid
		return $fid;
	}
}