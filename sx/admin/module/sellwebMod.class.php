<?php

class sellwebMod extends commonMod{
	public function index(){
		$url = __URL__ . '/index-{page}.html'; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;

        $count = $this->model->table('sellweb')->where($condition)->count(); //总记录数

        $info = $this->model->table('sellweb')->where("1 = 1")->limit($limit)->select();

        $this->assign('info',$info);
        $this->assign('page', $this->page($url, $count, $listRows));
		$this->display();
	}

	public function add(){
		if($_POST['do']){
			$data = array();
			$data['title'] = in($_POST['title']);
			$data['name'] = in($_POST['name']);
			$data['info'] = $this->_text($_POST['info']);

			if(empty($data['name'])){
				$this->error("省份不能为空");
			}
			if(empty($data['info'])){
				$this->error("内容不能为空");
			}

		if (empty($_POST['pinyin'])) {
		$py = new Pinyin();
        $title_pinyin = preg_replace("/[^\x{4e00}-\x{9fa5}\w]/u",'',$data['name']);
        $data['pinyin'] = substr($py->output($title_pinyin, $utf8 = true),0,50);
        }else{
        	$title_pinyin = preg_replace("/[^\w]/u",'',$_POST['pinyin']);
        	$data['pinyin'] = in($title_pinyin); //标题拼音
        }

		if($this->model->table('sellweb')->data($data)->where("1=1")->insert() && $this->_map()){
			$this->success("添加成功",__URL__."/index");
		}else{
			$this->error("添加失败");
		}
		}
		$this->display();
	}

	public function edit(){
		
		if($_POST['do']){
			$data = array();
			$id = intval($_POST['id']);
			$data['title'] = in($_POST['title']);
			$data['name'] = in($_POST['name']);
			$data['info'] = $this->_text(($_POST['info']));

			if(empty($data['name'])){ 
				$this->error("省份不能为空");
			}
			if(empty($data['info'])){
				$this->error("内容不能为空");
			}

			if (empty($_POST['pinyin'])) {
			$py = new Pinyin();
        		$title_pinyin = preg_replace("/[^\x{4e00}-\x{9fa5}\w]/u",'',$data['name']);
       			$data['pinyin'] = substr($py->output($title_pinyin, $utf8 = true),0,50);
        	}else{
        		$title_pinyin = preg_replace("/[^\w]/u",'',$_POST['pinyin']);
        		$data['pinyin'] = in($title_pinyin); //标题拼音
        	}
			if($this->model->table("sellweb")->data($data)->where("id = ".$id)->update() && $this->_map()){
				$this->success("修改成功",__URL__."/index");
			}else{
				$this->error("修改失败");
			}
		}

		$id = intval($_GET[0]);
		if(empty($id)){
			$this->error("参数传递错误");
		}
		$info = $this->model->table('sellweb')->where("id = ".$id)->find();
		$this->assign('info',$info);
		$this->display();
	}

	public function del(){
        $id = intval($_GET[0]);
        if(empty($id)){
            $this->error("参数传递错误！");
        }
        $condition['id'] = $id;
        if($this->model->table('sellweb')->where($condition)->delete()){
            $this->success("删除销售网络成功",__APP__.'/sellweb');
        }else{
            $this->error("删除销售网络失败");
        }
    }

    public function dels(){
        $ids = $_POST['ids'];
        if(empty($ids)){
            $this->error("参数传递错误！");
        }
        foreach($ids as $id){
            $this->model->table('sellweb')->where("id=$id")->delete();
        }
        $this->success("删除成功");
    }

	//操作map数据文件
	private function _map(){
		$map_data_file = ROOTDIR."/public/map/data/d.xml";

		//取数据
		$info = $this->model->table('sellweb')->where("1 = 1")->select();

		$str .= "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$str .= "<data>\n";
		foreach($info as $vo){
			$in = htmlspecialchars($vo['info']);
			$str .= "<area id=\"{$vo['pinyin']}\" title=\"{$vo['name']}\" value=\"{$in}\" />\n";
		}
		$str .= "</data>";

		$data = file_put_contents($map_data_file, $str);
		// $handle = @fopen($map_data_file,"wb");
		// @fwrite($handle,$str);
		// $data = fclose($handle);
		if($data){
			return true;
		}else{
			return false;
		}

	}
	//过滤字符
	function _text($str){
	$str = str_replace(" ", "&nbsp;", $str);
	$str = str_replace("\r\n", "<br>", $str);	
	$str=strip_tags($str,'<br>');
	if(!get_magic_quotes_gpc()) {
  	  $str = addslashes($str);
	}
	return $str;
}
}