<?php
// ===================================================================
// | FileName: 		IndexController.class.php
// ===================================================================
// | Discription：	IndexController 默认控制器
//		<命名规范：>
// ===================================================================
// +------------------------------------------------------------------
// | 云印南开
// +------------------------------------------------------------------
// | Copyright (c) 2014 云印南开团队 All rights reserved.
// +------------------------------------------------------------------
/**
* Class and Function List:
* Function list:
* - index()
* Classes list:
* - IndexController extends Controller
*/
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller
{
	//首页
	public function index() 
	{
		if(use_id())
		{
			$this->redirect('File/add');
		}else{
			  $this->display();
		}
	 
	}
}
