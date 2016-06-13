<?php
namespace Lib\Data;

/**
 * 对b_模块进行数据库操作
 */
class Insert {
	/**
	 * 将 a轮中用户的数据，添加入b轮
	 * @return [type] [description]
	 */
	public function insertUser( $data , $id , $fid, $usernumber ) {
		$resultData['id'] = $id;
		$resultData['fid'] = $fid;
		$resultData['repersonnumber'] = $usernumber['usernumber'];

		$resultData['usernumber'] = $data[0]['usernumber'];
		$resultData['username'] = $data[0]['username'];
		$resultData['password'] = $data[0]['password'];
		$resultData['phonenumber'] = $data[0]['phonenumber'];
		$resultData['weixin'] = $data[0]['weixin'];
		$resultData['zhifubao'] = $data[0]['zhifubao'];
		$resultData['email'] = $data[0]['email'];
		$resultData['qq'] = $data[0]['qq'];
		
		$resultData['level'] = 0;
		$resultData['createtime'] = time();	
		$resultData['lasttime'] = time();	
		$resultData['lastip'] = get_client_ip();	

		return $resultData;
	}
}