<?php
return array(
	//配置标签定界符
	'TMPL_L_DELIM' => '<{',
	'TMPL_R_DELIM' => '}>',

	//关闭缓存
	'APP_DEBUG'=>true,
	'DB_FIELD_CACHE'=>false,
	'HTML_CACHE_ON'=>false,
	'TMPL_CACHE_ON' => false,

	//错误页面
	// 'TMPL_EXCEPTION_FILE' => './Public/error/error.tpl',
	
	//路径模式
	// 'URL_MODEL' => 3,

	//默认模块
	'DEFAULT_MODULE' =>  'A',
	
	'APP_GROUP_LIST' => 'A,B,C,orz',
	
	// 显示页面Trace信息
	// 'SHOW_PAGE_TRACE' =>true, 

	//数据库连接
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'zhhz', // 数据库名
    'DB_USER'   => 'zhhz', // 用户名
    'DB_PWD'    => 'zhhz1234', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'r_', // 数据库表前缀 


	//模板替换变量
    'TMPL_PARSE_STRING'  =>array(
    	 '__ADMINCSS__'     => __ROOT__ . '/Public/admin/css', // 后台CSS
	     '__HOMECSS__'     => __ROOT__ . '/Public/home/css', // 前台CSS

	     '__ADMINJS__'     =>  __ROOT__ . '/Public/admin/js', // 后台JS
	     '__HOMEJS__'     => __ROOT__ . '/Public/home/js', // 前台JS

	     '__ADMINFONTS__'     => __ROOT__ . '/Public/admin/fonts', // 后台fonts
	     '__HOMEFONTS__'     => __ROOT__ . '/Public/home/fonts', // 前台fonts

	     '__ADMINIMAGES__'     => __ROOT__ . '/Public/admin/images', // 后台images
	     '__HOMEIMAGES__'     => __ROOT__ . '/Public/home/images', // 前台images
    ),

	//扩展类库
	'AUTOLOAD_NAMESPACE' => array(
        'Lib'     => './Lib',
    )
);