<?php

class singlepageMod extends commonMod{
	public function add(){
		if (empty($_POST['do'])) {
			$mid = intval($_GET[0]); //模型ID获取

			$this->assign('mid', $mid); //模型ID
            $this->assign('cat', $this->getCat()); //获取格式化后的分类树
            $this->display();
            return;
        }
        $data = array();
        $data['pid'] = intval($_POST['pid']);
        $data['mid'] = intval($_POST['mid']);
        $data['name']= in($_POST['name']);
        $data['keywords'] = in($_POST['keywords']);
        $data['description'] = in($_POST['description']);
        $data['pinyin'] = in($_POST['pinyin']);
        $data['pic'] = in($_POST['pic']);
        $data['ord'] = intval($_POST['ord']);
        $data['tpl_list'] = in($_POST['tpl_list']);

        if (empty($_POST['pinyin'])) {
        $py = new Pinyin();
        $title_pinyin = preg_replace("/[^\x{4e00}-\x{9fa5}\w]/u",'',$data['name']);
        $data['pinyin'] = substr($py->output($title_pinyin, $utf8 = true),0,50);
        }else
        {
        $title_pinyin = preg_replace("/[^\w]/u",'',$_POST['pinyin']);
        $data['pinyin'] = in($title_pinyin); //标题拼音
        }

        $condition['pinyin'] = $data['pinyin'];
        $clannel_info = $this->model->table('channel')->where($condition)->find();
        
        if ($clannel_info['pinyin'] == $data['pinyin']) {
            $data['pinyin']=$data['pinyin'].substr(cp_uniqid(),1,10);//如果名称重复随机生成
        }

        // 验证数据
        if (empty($data['name'])) {
            $this->error('栏目名称不能为空！');
            return;
        }
        if (empty($data['mid'])) {
            $this->error('模型ID错误！');
            return;
        }
        // 数据库操作
        $data2['cid'] = $id;
        $data2['content'] = html_in($_POST['content']);

        if ($id=$this->model->table('channel')->data($data)->insert()) //插入数据
        {
        	$data2['cid'] = $id;
        	$data2['content'] = html_in($_POST['content']); 
            if($this->model->table('channel_data')->data($data2)->insert())
            {
            $this->success('栏目添加成功！',__APP__.'/channel');
            }
    	} else {
            $this->error('栏目添加失败！');
        }
	}

	public function edit(){
		if(empty($_POST['do'])){
        $id = intval($_GET[0]);
        if(empty($id)){
        $this->error("参数传递错误！");
        }
        $condition['id'] = $id;
        $info = $this->model->table('channel')->where($condition)->find(); //获取当前分类信息
        if(empty($info)){
            $this->error("当前单页已经不存在或已删除！");
        }
        $condition2['cid'] = $id;
        $info_content = $this->model->table('channel_data')->where($condition2)->find(); //获取单页内容
        $content = $info_content['content'];
        $cat = $this->getCat(); //获取格式化后的分类树


        $this->assign('cat', $cat); //分类
        $this->assign('info', $info); //分类信息
        $this->assign('content',$content); //内容

        $this->display();
        return;
		}
        $data = array();
        $data['id'] = intval($_POST['id']);
        $data['pid'] = intval($_POST['pid']);
        $data['name']= in($_POST['name']);
        $data['keywords'] = in($_POST['keywords']);
        $data['description'] = in($_POST['description']);
        $data['pinyin'] = in($_POST['pinyin']);
        $data['pic'] = in($_POST['pic']);
        $data['ord'] = intval($_POST['ord']);
        $data['tpl_list'] = in($_POST['tpl_list']);

        if (empty($_POST['pinyin'])) {
        $py = new Pinyin();
        $title_pinyin = preg_replace("/[^\x{4e00}-\x{9fa5}\w]/u",'',$data['name']);
        $data['pinyin'] = substr($py->output($title_pinyin, $utf8 = true),0,50);
        }else
        {
        $title_pinyin = preg_replace("/[^\w]/u",'',$_POST['pinyin']);
        $data['pinyin'] = in($title_pinyin); //标题拼音
        }

        // 验证数据
        if (empty($data['name'])) {
            $this->error('栏目名称不能为空！');
            return;
        }
        if ($data['pid'] == $data['id']) {
            $this->error('不可以将当前栏目设置为上一级栏目');
            return;
        }
        // 不能将自己的上一级分类，移动到自己的子栏目中
        $cat = $this->getCat($data['id']); //获取$data['id']的所有下级栏目
        if (!empty($cat)) {
            foreach ($cat as $vo) {
                if ($data['pid'] == $vo['id']) {
                    $this->error('不可以将上一级栏目移动到子栏目');
                    return;
                }
            }
        }

        // 数据库操作
        $condition['id'] = $data['id'];

        if ($id=$this->model->table('channel')->data($data)->where($condition)->update()) //插入数据
        {
            $condition2['cid'] = $data['id'];
            $data2['content'] = html_in($_POST['content']); 
            if($this->model->table('channel_data')->data($data2)->where($condition2)->update())
            {
            $this->success('栏目修改成功！',__APP__.'/channel');
            }
        } else {
            $this->error('栏目修改失败！');
        }
	}

	public function del(){
        $id = intval($_GET[0]); //获取传递信息
        if (empty($id)) {
            $this->error('参数传递错误！');
            return;
        }
        $condition = array();
        $condition['pid'] = $id;
        if ($this->model->table('channel')->where($condition)->count()) {
            $this->error("请先删除该栏目下面的子栏目");
        }
        unset($condition); //将上一次查询条件清空
        unset($condition2); //将上一次查询条件清空
        $condition['id'] = $id;
        $condition2['cid'] = $id;
        if($this->model->table('channel')->where($condition)->delete() && $this->model->table('channel_data')->where($condition2)->delete()){
            $this->success("删除该栏目成功",__APP__.'/channel');
        }else{
            $this->error("删除该栏目失败");
        }
    }

	// 获取分类树，$id，分类id,$id=0，获取所有分类结构树
    public function getCat($id = 0)
    {
        require (CP_PATH . 'lib/Category.class.php'); //导入Category.class.php无限分类
        $data = $this->model->field('id,pid,name')->table('channel')->select();
        // array('id','pid','name','cname'),字段映射，格式化后的分类名次问cname
        $cat = new Category(array('id', 'pid', 'name', 'cname')); //初始化无限分类
        return $cat->getTree($data, $id); //获取分类数据树结构
    }
}