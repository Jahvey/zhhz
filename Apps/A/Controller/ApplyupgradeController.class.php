<?php
namespace A\Controller;
use Think\Controller;

/**
 * 申请升级模块
 */
class ApplyupgradeController extends CommonController {

	/**
	 * 显示相应信息
     * 我的信息
     * 对方信息[转给谁]
	 */
	public function index() {

		//获取登录用户下所有数据
		$s  = new \Lib\Data\Fetch();		
		$totalnum = M()->table( C('Mainname') )->field('id, fid, level')->select();
		$zi = $s::mergeCateToTwoArray($totalnum, $_SESSION['aid']);

		//根据用户编号，查询等级
		$userlevel = M()->table( C('Mainname') )->field('level')->where(array('usernumber'=>$_SESSION['ausernumber']))->select();
		$currentUserLevel = $userlevel[0]['level'];

		//判断开始
		if ( $currentUserLevel == 0 ) {
			$this->displayInfo( $currentUserLevel );
			return;
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
			//$twonumber = $this->caldwoncount( $zi, 2 );
			//$istwoadopt = $this->notExistenceZerolevel( $zi, 2 );

			//if ( $twonumber == 9 && $istwoadopt == 1 ) {
				
				//进入B轮游戏
				$this->intoBHierarchy();

			//} else {
			//	$this->error('请将9人层的九名用户升级为 Lv.1 ，然后进入B轮游戏。', U(C('Mudules') . '/Mydata/index'), 10);
			//}
		} else {
			$this->error('操作失败， 请重试！', U(C('Mudules') . '/Mydata/index'));
		}
	}

	/**
	 * 点击我要捐赠，进行数据库操作
	 */
	public function uplevel() {

		//判断是否已经点击过付款
		if ( $ss = M()->table('a_uprecord')->where(array('usernumber'=>$_SESSION['ausernumber'], 'isrece'=>0))->select() ) {
			$this->error('您在升中级过程已经点击过已付款！', U(C('Mudules') . '/Applyupgrade/index'));
		}

        //查找登录用户等级
        $userunm = M()->table( C('Mainname') )->field('level')->where(array('usernumber'=>$_SESSION['ausernumber']))->select();

		//获取数据，插入到升级记录表中
		$data['usernumber'] 	= $_SESSION['ausernumber'];//申请人编号
		$data['username'] 		= $_SESSION['ausername'];//申请人用户名
		$data['applytime'] 		= time();//当前申请时间
		$data['shouldmoney'] 	= C($this->usermoney($userunm[0]['level']));//申请人此时等级所应捐款的额数
		$data['currentlevel'] 	= $userunm[0]['level'];//申请人当前等级
		$data['upid'] 			= $_SESSION['upleveluserid'];//上级用户id
		$data['upnumber'] 		= $_SESSION['uplevelusernumber'];//上级用户编号
		$data['upusername'] 	= $_SESSION['uplevelusername'];//上级用户姓名

		//是否成功
		if ( M()->table('a_uprecord')->data($data)->add() ) {
			$this->success('通知发送成功!', 'index');
		} else {
			$this->error('请重试！', 'index.html'); }
	}

	/**
	 * 计算登录用户升级时候所要捐献的钱数
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
     * 一级升二级，判断其下级是否都是大于0级的。
     * 二级升B轮，判断其下下级是否都是大于0级的。
     * B轮升C轮，判断其下下下级是否都是大于0级的。
     *
     * @param $data   登录用户下级所有用户
     * @param $floor  此时要判断的等级
     * @return bool   true：不存在，false：存在
     */
	private function notExistenceZerolevel( $data, $floor ) {
		switch ($floor) {
			case 1: 
					//判断是否存在
					foreach ($data as $key => $value) {
						if ( $value['level'] == 0 ) {
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
							if ( $v['level'] == 0 ) {
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
								if ( $vv['level'] == 0 ) {
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
     * 一级升二级，计算其下级是否有3个会员
     * 二级升B轮，计算其下下级是否有9个会员
     * B轮升C轮，计算其下下下级否有27个会员
     *
     * @param $data   登录用户下级所有用户
     * @param $floor  此时要判断等级
     * @return int    返回子级个数
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
     * 查询登录用户应捐款人(给谁捐款)信息
     * 如果是0级别，就是其上一级
     * 如果是1级别，就是其上上一级
     * 如果是2级别，直接进入B轮游戏
     * 如果其上一级用户的等级，小于该用户的等级，则递归查询其上级
     *
     * @param $ulevel  登录用户当前等级
     * @return mixed   返回被捐款人信息（接收捐款的那个人）
     */
	private function upLevelUserInfo( $ulevel ) {

		//返回要捐赠的对象信息,$data
		//根据登录用户id，查询其父元素
		$str = new \Lib\Data\Fetch();
		//获取用户表中的数据
		$map['id'] = array('LT', $_SESSION['aid']);
		$res = M()->table(C('Mainname'))->where($map)->field('id, fid, level,username, usernumber, phonenumber, qq, weixin, zhifubao,email')->select();
		$res[] = M()->table(C('Mainname'))->where(array('id'=>$_SESSION['aid']))->find();
		
		//根据子类id，获取其上所有父类元素
		$result = $str::getParents($res, $_SESSION['aid']);

		if ( $ulevel == '0' ) { 
			$resdata = $result[1]; 
		} else {
			if ( $ulevel == '1' &&  $ulevel < $result[2]['level'] ) { 
				$resdata = $result[2]; 
			} else {
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
		return $resdata;
	}

    /**
     * 如果符合条件，显示相应信息
     *
     * @param $ulevel  当前用户等级
     */
	private function displayInfo( $ulevel ) {

		//显示应捐款金额
		$this->assign('shouldmoney', C($this->usermoney($ulevel)));
		
		//显示登录用户基本信息
        $mydata = M()->table(C('Mainname'))->where( array( 'id'=>$_SESSION['aid']) )->select();
       	$this->assign('mydata', $mydata);

        //存储上级用户名称，上级用户编号，上级用户id
        //以便于点击升级时使用
        //要捐献的上级用户信息
		$data = $this->upLevelUserInfo( $ulevel );
        $_SESSION['upleveluserid'] = $data['id'];//上级id
        $_SESSION['uplevelusername'] = $data['username'];//上级用户名
        $_SESSION['uplevelusernumber'] = $data['usernumber'];//上级用户编号
        //显示其上级用户编号
		$this->assign('data', $data);

		//判断是否已经提交
		$istijiao = null;
		$ress = M()->table('a_uprecord')->where(array('usernumber'=>$_SESSION['ausernumber'], 'isrece'=>0))->select();
		if ( $ress ) { $istijiao = 1;  } else { $istijiao = 0; }
		$this->assign('istijiao', $istijiao);

		//显示模板信息
		$this->display();
	}

    /**
     * 进入B轮操作操作
     * 将A的数据写入B的数据表中
     */
	private function intoBHierarchy() {

        //引入操作类
        $math = new \Lib\Tool\Math();
        $insert = new \Lib\Data\Insert();

		//判断是否已在B轮中注册信息
		$da = M()->table('b_user')->where(array('usernumber'=>$_SESSION['ausernumber']))->select();
		if ( $da[0]['id'] ) { $this->error('您已经进入了 B轮游戏，请登录！', U('B/Login/index'), 10); }

		//根据时间倒序，查询数据库最后一个数据的id，以便于计算新一条数据的id与fid
		$lastId = M()->table('b_user')->field('id')->order('createtime DESC')->find();
		$userid = $this->calId( $lastId['id'] );

		// B轮新用户的 id
		$id = $userid;
		// B轮新用户的 fid
		$fid = $math::calculationFid( $userid );
		// B轮新用户的 上级编号 upnumber
		$uplevelnum = M()->table('b_user')->where(array('id'=>$fid))->field('usernumber')->find();
		// 获取A轮用户的数据，写入B轮中
		$userdata = M()->table(C('Mainname'))->where(array('id'=>$_SESSION['aid']))->select();

        //使用 insertUser() 方法进行数据格式化后，返回可插入数据。
        //写入数据：id，fid，上级编号，其他相关数据。
        $da = $insert::insertUser( $userdata, $id, $fid, $uplevelnum);


		//判断是否添加成功
		if ( $res = M()->table('b_user')->data($da)->add() ) {
			//成功
			$this->success('注册B轮用户成功，正在迁移数据，请稍等......', U('B/Login/index'), 5);
		} else {
			$this->error('进入 B轮失败，请返回 A轮重新进入！', U(C('Mudules') . '/Login/index'));
		}
	}

	/**
	 * 根据数据库最后一条数据的Id，计算出新进入数据的Id
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	private function calId( $id ) {

	    //最终结果
	    $result = null;

	    //每层最大节点的ID
	    $maxNodeNum = array(1, 4, 13, 40, 121, 364, 1093, 3280, 9841, 29524);

	    //判断是否在数组中，意为最大ID
	    if ( in_array( $id, $maxNodeNum ) ) {

	        //直接返回id
	        $result = $id + 1;
	    } else {

	        //不在数组中
	        //如果所在层最大ID，减去此id，德值为2，则返回上一层最大ID加2
	        //计算所在层，与所在层的最大id
	        $layerIdAndMaxId = $this->layerId( $id, $maxNodeNum, 1 );

	        if ( ( $layerIdAndMaxId['maxnodeid'] - $id ) == 2 ) {
	            
	            //返回上一层最大id加2
	            //计算上一层最大id
	            $upLayerMaxIdOne = $this->layerId( $id, $maxNodeNum, 0 );
	            $result = $upLayerMaxIdOne['maxnodeid'] + 2;
	        } elseif ( ( $layerIdAndMaxId['maxnodeid'] - $id ) == 1 ) {

	            //返回上一层最大id加3
	            //计算上一层最大id
	            $upLayerMaxIdTwo = $this->layerId( $id, $maxNodeNum, 0 );
	            $result = $upLayerMaxIdTwo['maxnodeid'] + 3;
	        } else {

	            //直接返回id加3
	            $result = $id + 3;
	        }
	    }
	    return $result;
	}
    //根据id，返回所在层最大id，以及所在层
	private function layerId( $id, $maxNodeNum, $type ) {
	    //存储最终结果
	    $result = null;
	    //计算最大数组的个数
	    $count = count( $maxNodeNum );
	    //循环判断
	    for ($i=0; $i < $count - 1 ; $i++) { 
	        if ( $maxNodeNum[$i] < $id && $id < $maxNodeNum[$i+1] ) {

	            //判断获取当前层，还是上一层,当前层为 1， 上一层为 0
	            if ( $type == 0 ) {
	                $result = array( 'maxnodeid' => $maxNodeNum[$i], 'layernum' => $i );break;
	            } elseif ( $type == 1 ) {
	                $result = array( 'maxnodeid' => $maxNodeNum[$i+1], 'layernum' => $i+1 );break;
	            } else {
	                $result = null;break;
	            }
	        }   
	    }
	    //返回数据
	    return $result;
	}
}