<?php
namespace B\Controller;
use Think\Controller;

class OtherController extends CommonController {

	/**
	 * 显示公告信息
	 * @return [type] [description]
	 */
	public function notice() {		
		$this->display();
	}

	/**
	 * 显示使用规则
	 * @return [type] [description]
	 */
	public function rule() {
		$this->display();
	}
}