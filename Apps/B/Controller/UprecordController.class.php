<?php
namespace B\Controller;
use Think\Controller;

/**
 * 下级会员请求升级记录模块
 */
class UprecordController extends CommonController {

	/**
	 * 升级记录模块
	 * @return [type] [<description>]
	 */
	public function index() {
		//显示收款记录
		$this->assign('data', $this->selectData( $_SESSION['busernumber'] ));
      	
		$this->display();
	}

	/**
	 * 根据id更新数据
	 * @return [type] [<description>]
	 */
	Public function updateData() {

		//存储用户编号
		$unumber = I('get.usernumber');

		//判断是否已经点击过，防止多次点击
		if ( $_SESSION['bbc'] == $unumber ) { $this->error('已经点击过了！', U(C('Mudules') . '/Uprecord/index')); }
		$_SESSION['bbc'] = $unumber;

		//根据要升级会员编号，使其等级加 1
		$res = M()->table(C('Mainname'))->where(array('usernumber' => $unumber))->setInc('level'); 
		//判断结果
		if ( $res ) {

			//如果成功，根据用户编号，将其收款状态改为 1
			$data = array('isrece'=>1, 'postime'=>time());
			$result = M()->table('b_uprecord')->where(array('usernumber'=>$unumber))->data($data)->save();

			//判断收款状态是否更新
			if ( $result ) {
				$this->redirect(C('Mudules') . '/Uprecord/index');
			} else {
				//收款状态修改失败，回滚数据。
				//将用户表中已经修改过的级别，重新修改回来
				if ( ( M()->table(C('Mainname'))->where(array('usernumber' => $unumber))->setDec('level') ) ) {

					//如果回滚数据失败， (╯°Д°)╯︵ ┻━┻
					$this->error('用户数据出错，为保证游戏能正常进行，请联系管理员排查错误，错误代码：OX443322');	
				}
				$this->error('请重试！', 'index.html');
			}
		} else {
			$this->error('请重试！', 'index.html');
		}
	}

	/**
	 * 获取此用户编号下的所有升级信息
	 * @return [type] [description]
	 */
	Public function selectData( $usernumber ) {

		//倒叙获取所有升级数据
		$whe = array('upnumber'=>$usernumber);
		return M()->table('b_uprecord')->where($whe)->order('applytime DESC')->select();
	}
}