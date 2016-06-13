<?php
namespace Lib\Data;

/**
 * 用户数据提取类
 * 根据 id 进行数据查询
 */
class Fetch {
	/**
	 * 从 父类id为0 开始，将其所属子级元素，追加入其对应的父级元素中
	 * @param  array   $cate 原始数据
	 * @param  integer $fid  父级id，初始为0
	 * @param  string  $name 子级数组的键名
	 * @return array   $arr  组合后数组
	 */
	public static function mergeCateToTwoArray($cate, $fid = 0, $name = 'child') {
	    $arr = array();
	    foreach ( $cate as $v ) {
	        if ( $v['fid'] == $fid ) {
	            $v[$name] = self::mergeCateToTwoArray($cate, $v['id'], $name);
	            $arr[] = $v;
	        }
	    }
	    return $arr;
	}

	/**
	 * 从 父类id为0 开始，将其所属子级元素，排列到其父级元素之后
	 * @param  array   $cate  原始数据
	 * @param  integer $fid   父级id，默认 0
	 * @param  integer $level 所属等级，默认 0
	 * @param  string  $html  分割符号， 默认 '--'
	 * @return array   $arr   返回整理好的数据       
	 */
	public static function mergeCateToOneArray($cate, $fid = 0, $le = 0, $html = '-') {
	    $arr = array();
	    foreach ( $cate as $v ) {
	        if ( $v['fid'] == $fid ) {
	            $v['le'] = $le + 1;
	            $v['html']  = str_repeat($html, $le);
	            $arr[] = $v;
	            $arr = array_merge($arr, self::mergeCateToOneArray($cate, $v['id'], $le+1, $html));
	        }
	    }
	    return $arr;
	}

	/**
	 * 根据子类 id 获取父类元素
	 * @param  array  原始数据
	 * @param  int    子类id（本身其自增的id），非父id
	 * @return 父类元素
	 */
	public static function getParents($cate, $id) {
	    $arr = array();
	    foreach ( $cate as $v ) {
	        if ( $v['id'] == $id ) {
	            $arr[] = $v;
	            $arr = array_merge($arr, self::getParents($cate, $v['fid']));
	        }
	    }
	    return $arr;
	}


	/**
	 * 根据父类 ID 获取子级ID，非数据
	 * @return [type] [description]
	 */
	public static function getChildsId ($cate, $fid) {
	    $arr = array();
	    foreach ( $cate as $v ) {
	        if ( $v['fid'] == $fid ) {
	            $arr[] = $v['id'];
	            $arr = array_merge($arr, self::getChildsId($cate, $v['id']));
	        }
	    }
	    return $arr;
	}

	/**
	 * 根据父类 ID 获取子级等级level，非数据
	 * @return [type] [description]
	 */
	public static function getChildsLevel ($cate, $fid) {
	    $arr = array();
	    foreach ( $cate as $v ) {
	        if ( $v['fid'] == $fid ) {
	            $arr[] = $v['level'];
	            $arr = array_merge($arr, self::getChildsId($cate, $v['id']));
	        }
	    }
	    return $arr;
	}
}