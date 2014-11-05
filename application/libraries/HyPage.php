<?php
/*
==========================================
* HyPage分页类 v1.0.1
==========================================
* Copyright (c) 2012 伯仁网络 All rights reserved.
* Author: YinHailin
* $Id: HyPage.class.php 30 2014-01-06 01:17:27Z YinHailin $
==========================================
*/

class HyPage {
	/* 当前页面前后最多显示分页数 */
	protected $ListHalfPage = 2;
	/* 每页显示的数据行数 */
	public $ListRow = 20;
	/* 起始显示行数 */
	public $FirstRow = null;
	/* 总数据行数 */
	protected $TotalRow = null;
	/* 总页数 */
	protected $TotalPage = null;
	/* 当前页数 */
	protected $NowPage = null;
	/* URL分页变量名 */
	protected $VarPage = null;
    /* 分页样式 */
    protected $ConfigPage  =	array('header'=>'条记录', 'prev'=>'上一页', 'next'=>'下一页', 'first'=>'首页', 'last'=>'末页', 'theme'=>' <span class="pageInfo">%totalRow% %header% %nowPage%/%totalPage% 页</span> %first% %prevPage% %linkPage% %nextPage% %last%');


  /**
   * @param $totalRow
   * @param string $listRow
   */
  public function init($totalRow, $listRow = '') {
    $this->TotalRow = intval($totalRow);
    $this->VarPage = 'p';
    if (!empty($listRow)) { $this->ListRow = intval($listRow);}
    $this->TotalPage = ceil($this->TotalRow / $this->ListRow);
    $this->NowPage = intval($_GET[$this->VarPage]) > 0 ? intval($_GET[$this->VarPage]) : 1;
    if ($this->TotalPage < $this->NowPage) { $this->NowPage = $this->TotalPage;}
    $this->FirstRow = $this->ListRow * ($this->NowPage - 1);
    if ($this->FirstRow < 0) { $this->FirstRow = 0;}
  }
	/*
	 * 分页样式配置方法
	 * @param string $totalRow 配置名称
	 * @param $value $listRow 配置值
	 */
	public function SetConfig($name, $value) {
		if (isset($this->ConfigPage[$name])) {
			$this->ConfigPage[$name] = $value;
		}
	}

	/*
	 * 分页显示方法
	 * @return string
	 */
	public function Show($base_url) {
		if ($this->TotalPage == 0) { return '';}
		$p = $this->VarPage;
		//URL处理
		$url = $base_url ? $base_url : $_SERVER['REQUEST_URI'];
		$parse = parse_url($url);
		if (isset($parse['query'])) {
			parse_str($parse['query'], $param);
			if (isset($param[$p])) { unset($param[$p]);}
			$query = http_build_query($param);
			$query = empty($query) ? '?' : '?'.$query.'&';
			$url = $parse['path'].$query;
		} else {
			$url .= '?';
		}
		//上一页、下一页处理
		$prev = $this->NowPage - 1;  //上一页
		$next = $this->NowPage + 1;  //下一页
		if ($prev < 1) { $prev = 1;};
		if ($next > $this->TotalPage) { $next = $this->TotalPage;}
		//显示页码处理 eg:1 2 3 4 5
		$first = $this->NowPage - $this->ListHalfPage;  //最小页
		$last = $this->NowPage + $this->ListHalfPage;  //最大页
		if (($this->ListHalfPage * 2 + 1) >= $this->TotalPage) {
			//总页数小于要显示的页数
			$first = 1;
			$last = $this->TotalPage;
		} else {
			if ($first < 1) {
				//最小页数处理
				$first = 1;
				$last = $this->ListHalfPage * 2 + 1;
			}
			if ($last > $this->TotalPage) {
				//最大页数处理
				$first = $this->TotalPage - ($this->ListHalfPage * 2 + 1);
				$last = $this->TotalPage;
			}
		}
		$prevPage = '<a href="'.$url.$p.'='.$prev.'" title="">'.$this->ConfigPage['prev'].'</a>';
		$nextPage = '<a href="'.$url.$p.'='.$next.'" title="">'.$this->ConfigPage['next'].'</a>';
		$firstPage = '<a href="'.$url.$p.'='.$first.'" title="">'.$this->ConfigPage['first'].'</a>';
		$lastPage = '<a href="'.$url.$p.'='.$last.'" title="">'.$this->ConfigPage['last'].'</a>';
		$linkPage = '';
		for ($i = $first; $i <= $last; $i++) {
			if ($this->NowPage == $i) {
				$linkPage .= '<span class="current">'.$i.'</span>';
			} else {
				$linkPage .= '<a href="'.$url.$p.'='.$i.'" title="">'.$i.'</a>';
			}
		}
		 $parseStr = str_replace(array('%header%', '%prevPage%', '%nextPage%', '%nowPage%', '%totalPage%', '%totalRow%', '%first%', '%last%', '%linkPage%'), array($this->ConfigPage['header'],
$prevPage, $nextPage, $this->NowPage, $this->TotalPage, $this->TotalRow, $firstPage, $lastPage, $linkPage), $this->ConfigPage['theme']);
		 return $parseStr;
	 }
}