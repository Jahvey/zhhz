<?php
namespace C\Controller;
use Think\Controller;

class MydataController extends CommonController {

	/**
	 * 显示我的资料
	 * @return [type] [description]
	 */
	public function index() {
		//引用类库
		$str = new \Lib\Data\Fetch();

		//我的信息
		$mydata = M()->table( C('Mainname') )->where(array('usernumber'=>$_SESSION['cusernumber']))->select();
		$this->assign('mydata', $mydata);
		
		//上一级信息
		$upleveldata = M()->table( C('Mainname') )->where(array('id'=>$mydata[0]['fid']))->select();
		$this->assign('upleveldata', $upleveldata);

		//下级别所有信息
		$totalinfo = M()->table( C('Mainname') )->field('id, fid, usernumber, username, level')->select();
		$dwonLevelTotalInfo = $str::mergeCateToOneArray($totalinfo, $_SESSION['cid']);
		$this->assign('dwonLevelTotalInfo', $dwonLevelTotalInfo);
      	
		//显示模板信息
		$this->display();
	}
}