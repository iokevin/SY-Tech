<?php

class scrapMod extends commonMod{
	//碎片显示
    public function out($sign)
    {
        $sign=in($sign);
        $info = $this->model->table('scrap')->where('sign="' .$sign . '"')->find();
        return  $this->display(html_out($info['content']),true,false);
    }
}