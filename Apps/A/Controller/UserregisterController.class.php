<?php
namespace A\Controller;
use Think\Controller;

/**
 * 会员注册模块
 */
class UserregisterController extends CommonController {
	/**
	 * 显示用户注册页面，注册子级别新用户
	 * @return [type] [description]
	 */
	public function index() {
		
		//根据用户编号获取等级
		$userlevel = M()->table( C('Mainname') )->field('level')->where(array('usernumber'=>$_SESSION['ausernumber']))->select();

		//如果账户是 0级别，不能注册子类新账户
		if ( $userlevel[0]['level'] == '0' ) {
			$this->error('您的等级为 Lv.0 ，权限不足，请升级为 Lv.1 进行用户添加！', U(C('Mudules') . '/Applyupgrade/index'), 7);
		}

		// 每个用户只能添加三个账户
		//其下子类级别个数
		$child = M()->table(  C('Mainname') )->where(array('fid'=>$_SESSION['aid']))->count();
		if ( $child == 3 )  {
			$this->error('每个父级账号，仅能添加 3 个子级用户！', U(C('Mudules') . '/Mydata/index'), 7);
		}
		
		//生成随机的用户编号
		//实例化字符串类
		$str = new \Lib\Tool\String;
		$this->assign('usernumber', $str::generateNumber( 6 ));


		//显示模板
		$this->display();
	}

	/**
	 * 注册
	 * @return [type] [<description>]
	 */
	public function register() {

		//判断表单中是否有空值
		$this->isNull();

		//判断两次密码是否一致
		if ( $_POST['password'] != $_POST['okpassword'] ) {
			$this->error('两次密码不一致，请重新填写！', 'index.html');
		}

		//判断用户名是否存在
		$whe = array('username' => $_POST['username']);
		if ( M()->table( C('Mainname') )->where($whe)->select() ) {
			$this->error('用户名已经存在，请更换！', 'index.html');
		}

		//格式化数据		
		$data = $this->formatData($_POST, $_SESSION['aid']);

		//注册
		$res = M()->table( C('Mainname') )->data($data)->add();

		//是否注册成功
		if ( $res ) {
			$this->success('注册成功！', U( C('Mudules') . '/Mydata/index'));
		} else {
			$this->error('注册失败，请重试！', 'index.html');
		}
	}

	/**
	 * 判断表单数据中是否有空
	 */
	private function isNull() {
		foreach ($_POST as $key => $value) {
			if ( $value == '' ) {
				$this->error('表单数据不能为空,请重新填写！', 'index.html');
			}
		}
	}

	/**
	 * 整理表单中的数据
	 * @return [type] [<description>]
	 */
	private function formatData( $post, $fid = 0 ) {
		$data['fid'] 			 = $fid;
		$data['username']        = $post['username'];
		$data['password']        = $post['password'];
		$data['usernumber']      = $post['usernumber'];
		$data['phonenumber']     = $post['phonenumber'];
		$data['weixin']          = $post['weixin'];
		$data['zhifubao']        = $post['zhifubao'];
		$data['email']           = $post['email'];	
		$data['qq']              = $post['qq'];
		$data['repersonnumber']  = $post['repersonnumber'];
		$data['createtime']      = time();	
		$data['lasttime']        = time();
		$data['lastip']          = get_client_ip();

		return $data;
	}
}