<?php 
namespace C\Controller;
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

		//判断表单中是否有空值
		$this->isNull();
	}

	/**
	 * 判断表单数据中是否有空
	 */
	private function isNull() {
		foreach ($_POST as $key => $value) {
			if ( $value == '' ) {
				$this->error('表单数据不能为空，请重新填写！', 'index.html');
			}
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
	
	/**
	 * Delete the 48 hours not upgrade the user.
	 * @return This function does not return.
	 */
	private function timingDel() {
		// test.
		// die( 'The test Information.' );

		//Will delete the timestamp.
		$cle = time() - (C('timingDel') * 3600);
		//Decision condition.
		$map['level'] = array('eq', 0);
		$map['createtime'] = array('LT', $cle);
		//Set up the data.
		$data = array('level'=> -1, 'password'=>'noregister');
		//Executing
		M()->table('b_user')->where($map)->data($data)->save();
	}
}