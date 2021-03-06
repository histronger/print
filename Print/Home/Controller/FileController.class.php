<?php
// ===================================================================
// | FileName: 		FileController.class.php
// ===================================================================
// | Discription：	FileController 文件管理控制器
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
class FileController extends Controller
{

	public function index(){
		$uid=use_id(U('Index/index'));
	    if($uid)
	    {
            $File = M('File');
            $this->data = $File->where("use_id=".session('use_id'))->order('id desc')->select();
            // $this->assign('title','File list');
            $this->display();
        }
        else
        {
            $this->redirect('Home/Index/index');
        }
    }
    
    public function add()
    {
        $uid=use_id(U('Index/index'));
	    if($uid)
	    {
	        $this->assign('title','Upload page');
            $this->display();
        }
        else
        {
            $this->redirect('Home/Index/index');
        }
    }
    
    public function upload()
    {
        $uid=use_id(U('Index/index'));
        if($uid)
	    {
            $upload = new \Think\Upload();
            $upload->maxSize = 3145728;//3Mb
            $upload->exts = array('doc','docx','pdf','txt');
            $upload->rootPath = './Uploads/';
            $upload->savePath = '';
            $info = $upload->upload();
            if(!$info)
            {
//                $this->error('Error when upload to /Uploads');
            }
            else
            {
                foreach($info as $file)
                {
                    $data['name'] = $file['name'];
                    $data['pri_id'] = I('post.pri_id');
                    $data['time'] = date("Y-m-d H:i:s",time());//This is the upload time...not the specify time
                    $data['requirements'] = "It's OK";//I('post.requirements');
                    $data['url'] = $file['savepath'].$file['savename'];
                    $data['status'] = 0;//status = 0 means sended ,not downloaded yet
                    $data['use_id'] = session('use_id');
                    $data['copies'] = I('post.copies'); 
                    $data['double_side'] = I('post.double_side'); 
                    
                    $File   =   M('File');
                    if($File->create($data)) {
                        $result =   $File->add();
                        if($result) {
                            $Notification = M();
                            $Notification->query("INSERT INTO notification VALUES(NULL,{$result},0,{$data['use_id']},1)");
                            $this->success();
                        }else{
                            $this->error("SQL: Can not insert info into File table");
                        }
                    }else{
                        $this->error('Can not create File Model');
                    }
                }
            }
        }
        else
        {
            $this->redirect('Home/Index/index');
        }
    }
}
