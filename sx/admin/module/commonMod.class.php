<?php
class commonMod{
	protected $model = NULL; //数据库模型
	protected $layout = NULL; //布局视图
	protected $config = array();
	static $global;//静态变量，用来实现单例模式
	private $_data = array();
	
	protected function init(){}
	
	public function __construct(){
		session_start();//开启session
		global $config;
		$this->config = $config;
		$this->model = self::initModel($this->config);
		$this->init();
		
		//权限验证
		//登录页面地址
		$config['AUTH_LOGIN_URL']=__APP__.'/index/login.html';
		//不需要登录的模块或操作，比如登录页面和验证码显示页面
		$config['AUTH_LOGIN_NO']=array('index'=> array('login','verify'));
		//是否缓存权限信息，设置false,每次从数据库读取，开发时建议设置为false
		$config['AUTH_POWER_CACHE']=false;
		//自动创建数据库表，自动插入模块数据，发布时，可以去掉
		Auth::getModule($this->model,$config);
		Auth::check($this->model,$config);//检查是否登录	
	}
	
	//初始化模型
	static public function initModel($config){
		static $model = NULL;
		if( empty($model) ){
			$model = new cpModel($config);
		}
		return $model;
	}
	
	public function __get($name){
		return isset( $this->_data[$name] ) ? $this->_data[$name] : NULL;
	}

	public function __set($name, $value){
		$this->_data[$name] = $value;
	}

	//获取模板对象
	public function view(){
		static $view = NULL;
		if( empty($view) ){
			$view = new cpTemplate( $this->config );
		}
		return $view;
	}
	
	//模板赋值
	protected function assign($name, $value){
		return $this->view()->assign($name, $value);
	}
	
	//模板显示
	protected function display($tpl = '', $return = false, $is_tpl = true ){
		if( $is_tpl ){
			$tpl = empty($tpl) ? $_GET['_module'] . '/'. $_GET['_action'] : $tpl;
			if( $is_tpl && $this->layout ){
				$this->__template_file = $tpl;
				$tpl = $this->layout;
			}
		}
		$this->view()->assign( $this->_data );
		return $this->view()->display($tpl, $return, $is_tpl);
	}
	
	//判断是否是数据提交	
	protected function isPost(){
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}
	
	//直接跳转
	protected function redirect( $url, $code=302) {
		header('location:' . $url, true, $code);
		exit;
	}
	
	//弹出信息
	protected function alert($msg, $url = NULL){
		header("Content-type: text/html; charset=utf-8"); 
		$alert_msg="alert('$msg');";
		if( empty($url) ) {
			$gourl = 'history.go(-1);';
		}else{
			$gourl = "window.location.href = '{$url}'";
		}
		echo "<script>$alert_msg $gourl</script>";
		exit;
	}
	//操作成功之后跳转,默认三秒钟跳转
	protected   function success($msg,$url=NULL,$waitSecond=3)
	{
		if($url==NULL)
			$url=__URL__;
		$this->assign('message',$msg);
		$this->assign('url',$url);
		$this->assign('waitSecond',$waitSecond);
		$this->display('success');
		exit;
	}
	//出错之后跳转，后退到前一页
	protected   function error($msg)
	{
		header("Content-type: text/html; charset=utf-8"); 
		$msg="alert('$msg');";
		echo "<script>$msg history.go(-1);</script>";
		exit;
	}

	//检查是否登录,如果还没有登录，且当前操作不是登录或者验证码生成操作，则跳到登录页面
	protected  function checkLogin()
	{
		if(empty($_SESSION['admin_uid'])||empty($_SESSION['admin_username'])||empty($_SESSION['admin_groupid']))
		{
			//如果当前操作是登录或者验证码生成，则放行
			if($_GET['_module']=='index'&&in_array($_GET['_action'],array('login','verify')))
			{
				return false;
			}
			//跳转到登录页面
			$this->redirect(__APP__.'/index/login.html');
		}
		return true;
	}
	//分页 $url:基准网址，$totalRows: $listRows列表每页显示行数$rollPage 分页栏每页显示的页数
	protected  function  page($url,$totalRows,$listRows=10,$rollPage=5)
	{
		require_once(CP_PATH.'lib/Page.class.php');
		$page=new page();
		return $page->show($url,$totalRows,$listRows,$rollPage);
	}
}
?>