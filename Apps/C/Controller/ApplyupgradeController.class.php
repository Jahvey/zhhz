<?php
namespace C\Controller;
use Think\Controller;

/**
 * 申请升级模块
 */
class ApplyupgradeController extends CommonController {
	/**
	 * 显示要给谁捐赠
	 * @return [type] [description]
	 */
	public function index() {

		//获取该用户其下所有数据
		$s  = new \Lib\Data\Fetch();		
		$totalnum = M()->table( C('Mainname') )->field('id, fid, level')->select();
		$zi = $s::mergeCateToTwoArray($totalnum, $_SESSION['cid']);

		//根据用户编号，查询等级
		$userlevel = M()->table( C('Mainname') )->field('level')->where(array('usernumber'=>$_SESSION['cusernumber']))->select();
		$currentUserLevel = $userlevel[0]['level'];

		//判断开始
		if ( $currentUserLevel == 0 ) {
			$this->displayInfo( $currentUserLevel );
			return ;
		} elseif ( $currentUserLevel == 1 ) {
			
			//如果，人数为3，且没有零级，显示数据
			//获取人数与判断零级结果
			$onenumber = $this->caldwoncount( $zi, 1 );
			$isoneadopt = $this->notExistenceZerolevel( $zi, 1 );
			if ( $onenumber == 3 && $isoneadopt == 1 ) {
				$this->displayInfo( $currentUserLevel );
				return;
			} else {
				$this->error('请将3人层的三名用户升级为 Lv.1，之后再进行升级操作！', U( C('Mudules') . '/Mydata/index'), 10);
			}
		} elseif ( $currentUserLevel == 2 ) {
			
			//如果，人数为9，且没有零级，显示数据
			//获取人数与判断零级结果
			$twonumber = $this->caldwoncount( $zi, 2 );
			$istwoadopt = $this->notExistenceZerolevel( $zi, 2 );
			if ( $twonumber == 9 && $istwoadopt == 1 ) {
				$this->displayInfo( $currentUserLevel );
				return;
			} else {
				$this->error('请将9人层的九名用户升级为 Lv.1 ，然后进入B轮游戏。', U(C('Mudules') . '/Mydata/index'), 10);
			}
		} elseif ( $currentUserLevel == 3 ) {
			//如果，人数为27，且没有零级，显示数据
			//获取人数与判断零级结果
			$twonumber = $this->caldwoncount( $zi, 3 );
			$istwoadopt = $this->notExistenceZerolevel( $zi, 3 );
			if ( $twonumber == 27 && $istwoadopt == 1 ) {
				//完成C轮游戏
				$this->success('您已经完成此游戏！', U(C('Mudules') . '/Index/index'));
				return;
			} else {
				$this->error('请将27人层的九名用户升级为 Lv.1 ，才能完成此游戏。', U(C('Mudules') . '/Mydata/index'), 10);
			}
		} else {

			$this->error('操作失败， 请重试！', U(C('Mudules') . '/Mydata/index'));
		}
	}

	/**
	 * 点击我要捐赠，进行数据库操作
	 * @param [type] $[name] [<description>]
	 */
	public function uplevel() {

		//判断是否已经点击过
		if ( $ss = M()->table('c_uprecord')->where(array('usernumber'=>$_SESSION['cusernumber'], 'isrece'=>0))->select() ) {
			$this->error('您在升级过程中已经点击过已付款！', U(C('Mudules') . '/Applyupgrade/index'));
		}


		//查询编号上级id，number，name
		$userunm = M()->table( C('Mainname') )->field('fid, level')->where(array('usernumber'=>$_SESSION['cusernumber']))->select();
		$upuser = M()->table( C('Mainname') )->field('id, usernumber, username')->where(array('id'=>$userunm[0]['fid']))->select();
		
		//获取数据，插入到升级记录表中
		$data['usernumber'] 	= $_SESSION['cusernumber'];
		$data['username'] 		= $_SESSION['cusername'];
		$data['applytime'] 		= time();
		$data['shouldmoney'] 	= C($this->usermoney($userunm[0]['level']));
		$data['currentlevel'] 	= $userunm[0]['level'];
        $data['upid'] 			= $_SESSION['upleveluserid'];//上级用户id
        $data['upnumber'] 		= $_SESSION['uplevelusernumber'];//上级用户编号
        $data['upusername'] 	= $_SESSION['uplevelusername'];//上级用户姓名

		//是否成功
		if ( M()->table('c_uprecord')->data($data)->add() ) {
			$this->success('通知发送成功!', 'index');
		} else {
			$this->error('请重试！', 'index.html'); }
	}

	/**
	 * 根据等级计算需要缴纳的金额
	 * @param [type] $[name] [<description>]
	 */
	private function usermoney($num) {
		$str = '';
		switch ($num) {
			case 0:
				$str = 'one';
				break;
			case 1:
				$str = 'two';
				break;
			case 2:
				$str = 'three';
				break;
			default:
				break;
		}
		return $str;
	}

	/**
	 * 判断此用户下级子类中是否存在零级
	 * 一级升二级，判断其下一级是否都是大于零级的。
	 * 二级升B轮，判断其下下级是否都是大于零级的。
	 * B轮升C轮，判断其下是否都是大于零级别的
	 * true：不存在，false：存在
	 * @param [type] $[name] [<description>]
	 */
	private function notExistenceZerolevel( $data, $floor ) {
		switch ($floor) {
			case 1: 
					//判断是否存在
					foreach ($data as $key => $value) {
						if ( $value['level'] == 0 || $value['level'] == -1 ) {
							return false;break;
						}
					}
					break;
			case 2: 
					foreach ($data as $key => $value) {
						if ( empty($value['child']) ) {
							return false;break;
						}
						//是否都是大于零级的。
						foreach ($value['child'] as $k => $v) {
							if ( $v['level'] == 0 || $value['level'] == -1 ) {
								return false;break;
							}
						}
					}
					break;
			case 3: 
					//下一层的三个人，进行判断。下一层三个人。
					foreach ($data as $key => $value) {
						if ( empty($value['child']) ) {
							return false;break;
						}
						foreach ($value['child'] as $k => $v) {
							if ( empty($v['child']) ) {
								return false;break;
							}
							foreach ($v['child'] as $kk => $vv) {
								if ( $vv['level'] == 0 || $value['level'] == -1 ) {
									return false;break;
								}
							}
						}
					}
				 break;
				 default: {} break;
		}
		return true;
	}

	/**
	 * 根据等级计算下级用户个数
	 * 一级升二级，计算其下是否有三个会员
	 * 二级升B轮，计算其下下一级是否有九个会员
	 * B轮升C轮，计算是否有27个会员
	 * 返回子级个数
	 * @param [type] $[name] [<description>]
	 */
	private function caldwoncount( $data, $floor ) {
		switch ($floor) {
			case 1: 
					return count($data);
					break;
			case 2: 
					//下一层的三个人，进行判断。下一层三个人。
					foreach ($data as $key => $value) {
						//下层三个人中，每个人的所属三人个人进行判断，下一层九个人。
						foreach ($value['child'] as $k => $v) {
							if ( empty( $v ) ) {
								$c = 0;	
							} else {
								$c += 1;
							}
						}
					}
					return $c;
					break;
			case 3: 
					//下一层的三个人，进行判断。下一层三个人。
					foreach ($data as $key => $value) {
						//下层三个人中，每个人的所属三人个人进行判断，下一层九个人。
						foreach ($value['child'] as $k => $v) {
							//下层三个人中，每个人的所属三人个人进行判断，下一层12个人。这是在B轮中使用
							foreach ($v['child'] as $kk => $vv) {
								if ( empty( $vv ) ) {
									$cc = 0;
								} else {
									$cc += 1;
								}
							}
						}
					}
					return $cc;
				 break;
				 default: {} break;
		}
	}

	/**
	 * 查询该登录用户，应该给谁捐款
	 * 如果是0级别，就是其上一级
	 * 如果是1级别，就是其上上一级
	 * 如果是2级，直接进入B轮游戏
	 * 如果其上一级用户的等级，小于该用户的等级，则递归查询其上级
	 * @param [type] $[name] [<description>]
	 */
	private function upLevelUserInfo( $ulevel ) {
		//返回要捐赠的对象信息,$data
		//根据登录用户id，查询其父元素
		$str = new \Lib\Data\Fetch();
		//获取用户表中的数据
		$map['id'] = array('LT', $_SESSION['cid']);
		$res = M()->table(C('Mainname'))->where($map)->field('id, fid, level,username, usernumber, phonenumber, qq, weixin, zhifubao,email')->select();
		$res[] = M()->table(C('Mainname'))->where(array('id'=>$_SESSION['cid']))->find();
		
		//根据子类id，获取其上所有父类元素
		$result = $str::getParents($res, $_SESSION['cid']);

		if ( $ulevel == '0' ) { 
			$resdata = $result[1]; 
		} else {
			if ( $ulevel == '1' &&  $ulevel < $result[2]['level'] ) { 
				$resdata = $result[2]; 
			} else {
				if ( $ulevel == '2' && $ulevel < $result[3]['level'] ) {
					$resdata = $result[3];
				} else {
					array_splice($result,0,1);
					array_splice($result,0,1);
					array_splice($result,0,1);  
					array_splice($result,0,1);  
					foreach ($result as $key => $value) {
						if ( $ulevel < $value['level'] ) {
							$resdata = $value;break;    
						}
					}
				}
			}
		}	
		return $resdata;
	}

	/**
	 * 如果符合条件，显示申请信息
	 * @return [type] [description]
	 */
	private function displayInfo( $ulevel ) {
		//捐款金额
		$le = $ulevel;

		$this->assign('shouldmoney', C($this->usermoney($le)));
		
		//我的用户基本信息
        $mydata = M()->table(C('Mainname'))->where( array( 'id'=>$_SESSION['cid']) )->select();
       	$this->assign('mydata', $mydata);

        //存储上级用户名称，上级用户编号，上级用户id
        //以便于点击升级时使用
        //要捐献的上级用户信息
        $data = $this->upLevelUserInfo( $ulevel );
        $_SESSION['upleveluserid'] = $data['id'];//上级id
        $_SESSION['uplevelusername'] = $data['username'];//上级用户名
        $_SESSION['uplevelusernumber'] = $data['usernumber'];//上级用户编号
		$this->assign('data', $data);

		//判断是否已经提交
		$istijiao = null;
		$ress = M()->table('c_uprecord')->where(array('usernumber'=>$_SESSION['cusernumber'], 'isrece'=>0))->select();
		if ( $ress ) { $istijiao = 1;  } else { $istijiao = 0; }
		$this->assign('istijiao', $istijiao);

		//显示模板信息
		$this->display();
	}
}