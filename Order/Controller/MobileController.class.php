<?php

namespace Addons\Order\Controller;
use Mp\Controller\MobileBaseController;

/**
 * 订单移动端控制器
 * @author 16
 */
class MobileController extends MobileBaseController {
	/*首页*/
	public function index(){
		if(IS_POST){
			$content = I('post.content');
			$truename = I('post.truename');
			$qqnumber = I('post.qqnumber');
			$img1 = I('post.serId1');
			$img2 = I('post.serId2');
			if(!$content || !$truename || !$qqnumber || !$img1)	$this->error('参数错误!');
			$wechatObj = get_wechat_obj();
			if($img1){
				$data['img1'] =  $this->uploadImg($img1);
			}
			if($img2){
				$data['img2'] =  $this->uploadImg($img2);
			}
			$data['content']  = $content;
			$data['truename'] = $truename;
			$data['qqnumber']  = $qqnumber;
			$data['openid']   = get_openid();
			$data['mpid']  	  = get_mpid();
			$data['create_time'] = time();
 			if(M('OrderData')->add($data)){
				$this->success('提交成功~',create_mobile_url('lists'));
			}else{
				$this->error('失败，请重新提交');
			}
		}else{
			$config = get_addon_settings('Order');
    	    $this->assign('Xuan',[$config['xuan1'],$config['xuan2'],$config['xuan3']]);
			$this->display();
		}
	}

	/*订单列表*/
	public function lists(){

			//获取当前用户的所有订单
		$data = M('OrderData')->field('id,status,reply_price,content')->where(['mpid'=>get_mpid(),'openid'=>get_openid()])->order('status DESC,create_time')->select();
		$this->assign('data',$data);
		$this->display();
		
	}

	public function uploadOrder(){
		if(IS_POST){
			$content = I('post.content');
			$truename = I('post.truename');
			$qqnumber = I('post.qqnumber');
			$img1 = I('post.serId1');
			$img2 = I('post.serId2');
			if(!$content || !$truename || !$qqnumber  )	$this->error('参数错误!');
			$wechatObj = get_wechat_obj();
			if($img1){
				$data['img1'] =  $this->uploadImg($img1);
			}
			if($img2){
				$data['img2'] =  $this->uploadImg($img2);
			}
			$data['id']        = I('get.id');
			$data['content']   = $content;
			$data['truename']  = $truename;
			$data['qqnumber']  = $qqnumber;
			$data['openid']    = get_openid();
			$data['mpid']  	   = get_mpid();
			$data['status']    = 1;
			$data['reply_price'] = 0;
 			if(M('OrderData')->save($data)){
				$this->success('提交成功~',create_mobile_url('lists'));
			}else{
				$this->error('失败，请重新提交');
			}
		}else{
		$id = I('get.id');
		$data = M('OrderData')->where(['mpid'=>get_mpid(),'id'=>$id])->find();
		if($data['status'] != 3){
			$this->error('错误！');
		}
		$this->assign('data',$data);
		$config = get_addon_settings('Order');
    	$this->assign('Xuan',[$config['xuan1'],$config['xuan2'],$config['xuan3']]);
		$this->display();
		}
	}

	/*回复详情*/
	public function detail(){
		$id = I('get.id');
		$data = M('OrderData')->field('reply_price,reply_content,reply_time')->where(['id'=>$id])->find();
		$this->assign('data',$data);
		$this->display();
	}

	/*下载微信服务器图片*/
	public function uploadImg($mediaId){
		$imgDir   = './Uploads/Pictures/OrderImg';
		if(!is_dir($imgDir)){
			mkdir($imgDir);
		}
		$imgPath  = $imgDir.'/'.$mediaId.'.jpg';
		$wechatObj = get_wechat_obj();
	     $str = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$wechatObj->checkAuth()."&media_id=".$mediaId.""; 
	     $a = file_get_contents($str);  
	     $resource = fopen($imgPath , 'w+');  
	     fwrite($resource, $a);  
	     //关闭资源  
	     fclose($resource);  
	     return $imgPath;
	}

}

?>