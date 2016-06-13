<?php 
namespace A\Controller;
use Think\Controller;

/**
 * 前台登录模块
 */
class LoginController extends Controller {
	
	/**
	 * 显示登录页面
	 * @return [type] [description]
	 */
	public function index() {
		//登录时清空原始session
		session_destroy();

		//显示模板
		$this->display();
	}

	/**
	 * 验证登录数据
	 * @return [type] [<description>]
	 */
	public function fromLogin() {

		//账号密码不为空
		if ( I('post.username') == '' || I('post.password') == '' ) {
			$this->error('账号和密码不能为空！', U( C('Mudules') .  '/Login/index'));	
		}

		//取用户名密码进行验证
		$username = I('post.username');
		$password = I('post.password');
		$whe = array('username'=>$username, 'password'=>$password);
		$res = M()->table( C('Mainname') )->where($whe)->field('id, fid, username, usernumber, createtime,repersonnumber, lasttime, lastip')->find();
	
		//判断结果
		if ( $res != '' ) {

			//更新登录数据
			$data['lasttime']  = time();
			$data['lastip']	   = get_client_ip();
			$whe		       = array('id'=>$res['id']);
			$update = M()->table( C('Mainname') )->where($whe)->data($data)->save();

			//如果更新成功
			if ( $update ) {
				//向 session 中写入数据
				$_SESSION['aid'] 			 = $res['id'];
				$_SESSION['afid'] 			 = $res['fid'];
				$_SESSION['ausername'] 		 = $res['username'];
				$_SESSION['ausernumber'] 	 = $res['usernumber'];
				$_SESSION['arepersonnumber'] = $res['repersonnumber'];
				$_SESSION['acreatetime']     = $res['createtime'];
 				$_SESSION['alasttime'] 		 = $res['lasttime'];
				$_SESSION['alastip'] 		 = $res['lastip'];

				$this->redirect(C('Mudules') . '/Index/index');	
			} else {

			}
		} else {
			$this->error('登录失败，请重试！', U(C('Mudules') . '/Login/index'));
		}
	}

	/**
	 * 验证码
	 * @return [type] [<description>]
	 */
	public function verify() {
		$config =    array(
		    'fontSize'    =>    14,    // 验证码字体大小
		    'length'      =>    4,     // 验证码位数
		    'useNoise'    =>    false, // 关闭验证码杂点
		    'imageW'	  =>    100,
		    'imageH'	  =>    35,
		);

		$Verify = new \Think\Verify($config);
		// 设置验证码字符为纯数字
		$Verify->codeSet = '0123456789'; 
		$Verify->entry();
	}

	/**
	 * 检测输入的验证码是否正确
	 * $code为用户输入的验证码字符串
	 * @return [type] [<description>]
	 */
	private function check_verify($code, $id = ''){
	    $verify = new \Think\Verify();
	    return $verify->check($code, $id);
	}

	/**
	 * 退出登录
	 * @return [type] [<description>]
	 */
	public function logout() {
		session_unset();
		session_destroy();
		$this->redirect(C('Mudules') . '/Login/index');
	}
}