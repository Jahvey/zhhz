<?php
namespace A\Controller;
use Think\Controller;

class CommonController extends Controller {

	/**
	 * 初始化函数
	 * @return [type] [description]
	 */
	public function _initialize() {
		//判断是否存在session
		if ( ! isset($_SESSION['ausername']) ) {
			$this->redirect(C('Mudules') . '/Login/index');	
		}

		//计算用户等级，并注入到模板
		$level = M()->table( C('Mainname') )->where(array('usernumber'=>$_SESSION['ausernumber']))->field('level')->select();
		$this->assign('level', $level[0]['level']);

		//查看是否存在要处理的订单
		$order = M()->table('a_uprecord')->where(array('upnumber'=>$_SESSION['ausernumber'], 'isrece'=>0))->count();
		$this->assign('order', $order);
	}
}