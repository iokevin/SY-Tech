<?php

class websetMod extends commonMod{
	public function index(){
		require(CONFIGDIR);
		if($_POST['do']){
			//全局配置
			$mb_cache = in($_POST['mb']);	//模板缓存
			$jt_cache = in($_POST['jt']);	//静态缓存
			$config_arr['sitename'] = in($_POST['name']);
			$config_arr['siteurl'] = in($_POST['domain']);
			$config_arr['seotitle'] = in($_POST['site_title']);
			$config_arr['seokeywords'] = in($_POST['keywords']);
			$config_arr['seodescription'] = in($_POST['description']);
			$config_arr['post'] = in($_POST['post']);
			$config_arr['postapi'] = in($_POST['postapi']);
			$config_arr['lv'] = in($_POST['lv']);
			$config_arr['minmoney'] = in($_POST['minmoney']);
			$config_arr['successdd'] = in($_POST['successdd']);
			$config_arr['errordd'] = in($_POST['errordd']);
			$config_arr['TPL_CACHE_ON']=$mb_cache;//是否开启模板缓存，true开启,false不开启
			$config_arr['HTML_CACHE_ON']=$jt_cache;//是否开启静态页面缓存，true开启.false关闭

			$config_array = array();
        	foreach ($config_arr as $key => $value) {
        	$config_array["config['" . $key . "']"] = $value;
        	}
			
	
			if(set_config($config_array)){
					$this->success("个人信息更新成功",__URL__.'/index');
				}else{
					$this->error('信息更新失败');
				}

		}
		$this->assign('config',$config);
		$this->display();
	}
}