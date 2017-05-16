<?php

namespace Addons\Order\Controller;
use Mp\Controller\AddonsController;

/**
 * 订单后台管理控制器
 * @author 16
 */
class WebController extends AddonsController {
/*列表*/
  public function lists(){
        $model_name = I('get.model','user_lists');
        $model = get_addon_model($model_name);
        $this->setModel($model)->setListPer(10);
        $this->setListSearch(array('truename' => '真实姓名'));
        $this->common_lists(); 
  }


  /*编辑*/
  public function detail(){
    if(IS_POST){
     $url = create_addon_url('lists',array('model'=>'order_lists','title'=>I('get.title')));
     $this->success('正在返回',$url);
    }else{
      $model_name = I('get.model');
      $model = get_addon_model($model_name);
      $this->setModel($model)->addAuto('update_time',time())->setEditMap(array('id'=>I('get.id'))) ;
      $this->common_edit();
    }
  }

    /*编辑*/
  public function edit(){
    $model_name = I('get.model');
    $model = get_addon_model($model_name);
    $lists = explode('_', $model_name)[0].'_lists';
    $this->setModel($model);
    $url = create_addon_url('lists',array('model'=>'order_lists'));
    $this->addAuto('update_time',time())->setEditMap(array('id'=>I('get.id')))->setEditSuccessUrl($url) ;
    $this->common_edit();
  }


  public function reply() {
    $model_name = I('get.model');
    $model = get_addon_model($model_name);
    $lists = explode('_', $model_name)[0].'_lists';
    $status = I('post.status');
    if (IS_POST) {
      $id    =   I('get.uid');
      $content = I('post.reply_content');
      if (!$content) {
        $this->error('请填写回复内容');
      }
      if($status == 2){
              $reply = array(
                'touser' => M('OrderData')->where(['id'=>$id])->getField('openid'),
                'msgtype' => 'text',
                'text' => array(
                  'content' => $content
                )
                  );
                $result = send_custom_message($reply);
                 if ($result['errcode'] != 0) {
               $this->error('error:'.$result['errmsg']);
              } else {
                $data['reply_time']    = time();
                $data['status']        = 4;
                $data['id']            = $id;
              }
      }else{
                $config = get_addon_settings('Order');
                if($status == 1){
                  if(!$config['view1']){
                      $this->error('请设置模板id');
                  }
                  $temp_id = $config['view1'];
                  $reply_status = 3;
                  $url = create_mobile_url('uploadOrder',array('id'=>$id));
                }else{
                  if(!$config['view2']){
                      $this->error('请设置模板id');
                  }
                  $temp_id = $config['view2'];
                  $reply_status = 2;
                  $url = create_mobile_url('detail',array('id'=>$id));
                  $data['reply_content'] = $content;
                }
                $arr = array(
                "touser"=>M('OrderData')->where(['id'=>$id])->getField('openid'),
                "template_id"=>$temp_id,
                "url"=>$url,
                "topcolor"=>"#FF0000",
                "data"=>array(
                  'errInfo'=>array(
                    'value'=>$content,
                    "color"=>"#173177"
                  )
                )
              );
              $wechatObj = get_wechat_obj();
              $res =  $wechatObj->sendTemplateMessage($arr);
              if($res){
                 $data['id'] = $id;
                 $data['status'] = $reply_status;
              }
      }
          M('OrderData')->save($data);
          $this->success('回复成功', create_addon_url('lists',array('model'=>'order_lists')));
    } else {
      $this->setModel($model)->common_add();
      }
    }
}

?>
