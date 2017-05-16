<?php
$statusOpt = array(
		'1'=>'<font color="red">未回复</font>',
		'2' =>'<font color="green">已回复</font>',
		'3'=>'<font color="red">订单有误</font>',
		'4' =>'<font color="green">报价中...</font>',
);
$replyOpt = array(
		'1'=>'<font color="red">订单错误回复</font>',
		'2' =>'报价中...',
		'3'=>'<font color="green">报价成功</font>',
);


return array(
	'name' => '订单',
	'bzname' => 'Order',
	'desc' => '订单插件，微信端使用jssk上传图片，后台发送客服信息或模板信息进行回复,错误模板请添加参数{{errInfo.DATA}},有任何问题，个人插件定制要求请+q(微) 1084910400 联系',
	'version' => '1.0',
	'author' => '16',
    'logo' => 'logo.png',
    'install_sql' => 'install.sql',
	'config' => array(
		'respond_rule' => 0,
		'setting' => 1,
		'setting_list' => array(
			'view1' => array(
            'title' => '错误模板id',
            'type' => 'text',
            'group' => 'share'
           ),
			'view2' => array(
            'title' => '成功模板id',
            'type' => 'text',
            'group' => 'share'
           ),
			'xuan1' => array(
            'title' => '首页宣传图1',
            'type' => 'image',
            'group' => 'share'
           ),
			'xuan2' => array(
            'title' => '首页宣传图2',
            'type' => 'image',
            'group' => 'share'
           ),
			'xuan3' => array(
            'title' => '首页宣传图3',
            'type' => 'image',
            'group' => 'share'
           ),
		),
		'setting_list_group' => array(
        'share' => array(
            'title' => '首页设置',
            'is_show' => 1,
        ),
        ),
		'entry' => 1,
		'entry_list' => array(
			'index' => '反馈入口'
		),
		'menu' => 1,
		'menu_list'=>array(
			'lists/model/order_lists' => '留言列表',
		),
	),
	'model'=>array(
		/*留言列表*/
		'order_lists'=>array(
			'name'=>'order_data',
			'meta_title'=>'留言列表',
			 'crumb' => array(
		        array(
		            'title' => '业务导航',
		            'url' => create_addon_url('setting'),
		            'class' => ''
		        ),
		        array(
		            'title' => '留言列表',
		            'url' => '',
		            'class' => 'active'
		        ),
   			),
			'nav' => array(
		        array(
		            'title' => '留言列表',
		            'url' => '',
		            'class' => 'active'
		        ),
   			),
   			
			'lists'=>array(
	          array('name' => 'id','title' => '主键', 'format' => 'hidden' ),
	          array('name' => 'openid','title' => '用户头像', 'format' => 'function','extra' => array(
                    'function_name' => 'get_fans_headimg',
                    'params' => '###'
                ),),
	          array('name' => 'openid','title' => '昵称', 'format' => 'function','extra'=>array('function_name'=>'get_fans_nickname'),'params'=>'###'),
	          array('name' => 'content','title' => '订单详情', 'format' => 'text'),
	         array('name' => 'status','title' => '状态', 'format' => 'enum','extra' => array(
                        'options' => $statusOpt,
                    ) ),
	          array('name' => 'reply_price','title' => '回复金额', 'format' => 'text'),
              array(
                	'name' => 'id',
                	'title' => '操作', 
                	'format' => 'custom' ,
                	'extra'=>array(
                		'options'=>array(
                			'edit'=>array('title' => '查看详情','url'=>create_addon_url('detail',array('id'=>'{id}','model'=>'order_oper')),'class'=>'btn btn-primary btn-sm icon-edit'),
                			'reply'=>array('title' => '回复留言','url'=>create_addon_url('reply',array('uid'=>'{id}','model'=>'reply_oper')),'class'=>'btn btn-primary btn-sm icon-edit'),
                			'price'=>array('title' => '设置金额','url'=>create_addon_url('edit',array('id'=>'{id}','model'=>'price_oper')),'class'=>'btn btn-primary btn-sm icon-edit'),
                		),
                	),
                ),      
			),
			'list_map'=>array('mpid'=>get_mpid(),'identity'=>1),
			'list_order' => 'status asc,create_time desc'
		),
		/*留言操作*/
		'order_oper'=>array(
			'name'=>'order_data',
			'title'=>'留言查看',
			 'crumb' => array(
		        array(
		            'title' => '业务导航',
		            'url' => create_addon_url('setting'),
		            'class' => ''
		        ),
		        array(
		            'title' => '留言查看',
		            'url' => '',
		            'class' => 'active'
		        ),
   			),
			 'nav' => array(
		        array(
		            'title' => '留言列表',
		            'url' => create_addon_url('lists',array('model'=>'order_lists')),
		            'class' => ''
		        ),
		        array(
		            'title' => '留言查看',
		            'url' => '',
		            'class' => 'active'
		        ),
   			),
			'fields'=>array(
				    array('name' => 'truename','title' => '真实姓名', 'type' => 'text','extra'=>array('attr'=>'disabled')),
				    array('name' => 'qqnumber','title' => 'QQ号码', 'type' => 'text','extra'=>array('attr'=>'disabled')),
				    array('name' => 'img1','title' => '上传图片1', 'type' => 'image'),
				    array('name' => 'img2','title' => '上传图片2', 'type' => 'image'),
					array('name' => 'content','title' => '表单详情', 'type' => 'textarea','extra'=>array('attr'=>'disabled')),
					array('name' => 'reply_price','title' => '回复金额', 'type' => 'text','extra'=>array('attr'=>'disabled')),
					array('name' => 'reply_content','title' => '回复内容', 'type' => 'textarea','extra'=>array('attr'=>'disabled')),
			),
			'auto'=>array(
				array('mpid',get_mpid()),
			),
		),
		/*回复信息*/
		'reply_oper'=>array(
			'name'=>'order_data',
			'title'=>'留言查看',
			 'crumb' => array(
		        array(
		            'title' => '业务导航',
		            'url' => create_addon_url('setting'),
		            'class' => ''
		        ),
		        array(
		            'title' => '回复信息',
		            'url' => '',
		            'class' => 'active'
		        ),
   			),
			 'nav' => array(
		        array(
		            'title' => '留言列表',
		            'url' => create_addon_url('lists',array('model'=>'order_lists')),
		            'class' => ''
		        ),
		        array(
		            'title' => '回复信息',
		            'url' => '',
		            'class' => 'active'
		        ),
   			),
			'fields'=>array(
					array('name' => 'status','title' => '状态', 'type' => 'radio','options'=>$replyOpt,'value'=>2),	
					array('name' => 'reply_content','title' => '回复内容', 'type' => 'textarea'),
			),
			'auto'=>array(
				array('mpid',get_mpid()),
			),
		),
		/*设置金额*/
		'price_oper'=>array(
			'name'=>'order_data',
			'title'=>'留言查看',
			 'crumb' => array(
		        array(
		            'title' => '业务导航',
		            'url' => create_addon_url('setting'),
		            'class' => ''
		        ),
		        array(
		            'title' => '回复信息',
		            'url' => '',
		            'class' => 'active'
		        ),
   			),
			 'nav' => array(
		        array(
		            'title' => '留言列表',
		            'url' => create_addon_url('lists',array('model'=>'order_lists')),
		            'class' => ''
		        ),
		        array(
		            'title' => '回复信息',
		            'url' => '',
		            'class' => 'active'
		        ),
   			),
			'fields'=>array(
					array('name' => 'reply_price','title' => '金额', 'type' => 'text'),
			),
			'auto'=>array(
				array('mpid',get_mpid()),
				array('status',2),
			),
		),
	),
);

?>