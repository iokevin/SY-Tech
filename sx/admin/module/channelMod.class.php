<?php

class channelMod extends commonMod{
	public function index(){
		$model_list = $this->model->table('adm_model',true)->order('id asc')->select(); //模型列表
        $this->assign('model_list', $model_list);
        $this->assign('cat', $this->getCat());
        $this->display();
	}

	// 获取分类树，$id，分类id,$id=0，获取所有分类结构树
    public function getCat($id = 0)
    {
        require (CP_PATH . 'lib/Category.class.php'); //导入Category.class.php无限分类
        $sql = "SELECT A.id,A.pid,A.name,A.ord,B.add_name,B.add_url,B.edit_name,B.edit_url,B.del_url,B.add_content_name,B.add_content_url,B.edit_content_name,B.edit_content_url,B.id as model_id,B.name as model_name FROM {$this->model->pre}channel A LEFT JOIN adm_model B ON A.mid = B.id ORDER BY A.ord DESC";
        // $this->model->pre,数据表前缀
        $data = $this->model->query($sql); //执行查询
        // array('id','pid','name','cname'),字段映射，格式化后的分类名次问cname
        $cat = new Category(array('id', 'pid', 'name', 'cname')); //初始化无限分类
        return $cat->getTree($data, $id); //获取分类数据树结构
    }
}