<?php
namespace C\Controller;
use Think\Controller;

/**
 * 资料修改模块
 */
class DataupdateController extends CommonController {
	/**
	 * 显示用户信息，以便于用户修改资料
	 * @return [type] [description]
	 */
	public function index() {
		//查询数据，并注入到模板
		$res = M()->table( C('Mainname') )->where(array('id'=>$_SESSION['cid']))->select();
		$this->assign('data', $res);
		
		$this->display();
	}

	/**
	 * 更新数据操作
	 * @return [type] [description]
	 */
	public function updatedata() {
		//数据
		$data['usernumber'] 	= I('post.usernumber');
		$data['username'] 		= I('post.username');
		$data['password'] 		= I('post.password');
		$data['phonenumber'] 	= I('post.phonenumber');
		$data['qq'] 			= I('post.qq');
		$data['weixin'] 		= I('post.weixin');
		$data['zhifubao'] 		= I('post.zhifubao');

		//更新
		if ( M()->table( C('Mainname') )->data($data)->where(array('usernumber'=>$_SESSION['cusernumber']))->save() ) {
			$this->success('更新成功！', U( C('Mudules') . '/Mydata/index'));
		} else {
			$this->error('更新错误！', U( C('Mudules') . '/Dataupdate/index'));
		}
	}
}