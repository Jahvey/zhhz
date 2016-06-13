<?php
namespace B\Controller;
use Think\Controller;

/**
 * 前台首页
 */
class IndexController extends CommonController {

    /**
     * 首页面，显示相应信息
     * @return [type] [description]
     */
    public function index(){

      //获取该用户登录时存储的，id，用户编号
      $id = $_SESSION['bid'];
      $num = $_SESSION['busernumber'];

      //获取用户等级信息
      $re = M()->table( C('Mainname') )->where( array( 'id'=>$id) )->field('level')->select();

      //计算升级所需要的升级金额，并将变量注入到模板
      if ( $re[0]['level'] == 0 ) { $shomoney = C('one');
      } elseif ($re[0]['level'] == 1) { $shomoney = C('two'); 
      } elseif ( $re[0]['level'] == 2 ) { $shomoney = C('three'); 
      } else {}      
      $this->assign('shomoney', $shomoney);


      //显示模板信息
    	$this->display();
    }
}