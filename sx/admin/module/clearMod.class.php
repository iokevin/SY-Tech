<?php 

class clearMod extends commonMod{
	public function index(){
		require CP_PATH . 'ext/fire_size.php';
        $all_cache = dir_size(ROOTDIR . "/data", 3); //所有缓存大小
        $html_cache = dir_size(ROOTDIR . "/data/html_cache", 3); //清除html缓存
        $tpl_cache = dir_size(ROOTDIR . "/data/tpl_cache", 3); //清除模板缓存
        $this->assign('all_cache', $all_cache);
        $this->assign('html_cache', $html_cache);
        $this->assign('tpl_cache', $tpl_cache);
        $this->display();
	}

	public function clearcache()
    {
        
        $dir2 = ROOTDIR . "/data/html_cache/"; //清除html缓存
        del_dir($dir2);
        $dir3 = ROOTDIR . "/data/tpl_cache/"; //清除模板缓存
        del_dir($dir3);
		$this->success('网站缓存清除成功！',__URL__);
    }

    public function cleartpl()
    { 
        $dir = ROOTDIR . "/data/tpl_cache/"; //清除模板缓存
        del_dir($dir);
		$this->success('模板缓存清除成功！',__URL__);
    }

    public function clearhtml()
    { 
        $dir = ROOTDIR . "/data/html_cache/"; //清除html缓存
        del_dir($dir);
        $this->success('HTML缓存清除成功！',__URL__);
    }
}