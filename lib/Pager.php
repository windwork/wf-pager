<?php
/**
 * Windwork
 * 
 * 一个开源的PHP轻量级高效Web开发框架
 * 
 * @copyright   Copyright (c) 2008-2015 Windwork Team. (http://www.windwork.org)
 * @license     http://opensource.org/licenses/MIT	MIT License
 */
namespace wf\pager;


/**
 * 分页类
 * 通过传入总记录数、每页显示记录数来生成分页导航
 * 
 * @package     wf.pager
 * @author      erzh <cmpan@qq.com>
 * @link        http://www.windwork.org/manual/wf.pager.html
 * @since       0.1.0
 */
class Pager {
	/**
	 * 当前页数
	 * 
	 * @var int = 1
	 */
	public $page = 1; 

	/**
	 * 总记录数
	 *
	 * @var int = 100
	 */
	public $totals = 100;
	
	/**
	 * 每页显示记录数
	 *
	 * @var int = 10
	 */
	public $rows = 10;
	
	/**
	 * 最后一页页码，总页数
	 *
	 * @var int
	 */
	public $lastPage;

	/**
	 * 上一页的页码
	 *
	 * @var int
	 */
	public $prePage;

	/**
	 * 下一页的页码
	 *
	 * @var int
	 */
	public $nextPage;

	/**
	 * 分页的url查询变量
	 *
	 * @var string = 'page'
	 */
	public $pageVar = 'page';

	/**
	 * 分页页的uri
	 *
	 * @var string
	 */
	public $uri;
	
	/**
	 * 每页允许最多行数，仅限制通过URL设置每页行数，不限分页类构造函数中的rows参数
	 * @var string = 100
	 */
	public $rowsMax = 100;

	/**
	 * 查询的起始项
	 *
	 * @var int
	 */
	public $offset;

	/**
	 * 每页记录数URL参数
	 * @var string = 'rows
	 */
	public $rowsVar = 'rows';

	/**
	 * 变量分隔符
	 * @var string
	 */
	protected $argSeparator = '/';
	
	/**
	 * 变量和值的分隔符
	 * @var string
	 */
	protected $valSeparator = ':';
	
	/**
	 * 是否允许通过URL设置每页记录数
	 * @var bool
	 */
	protected $rowsAllowCustom = false;
	
	protected $tpl = '';

	/**
	 * 分页设置
	 * 
	 * 当页面URL中存在 ? 时，分页链接附加上的页码、页记录数、POST请求变量使用 &$k=$v风格，否则使用 /$k:$v 风格
	 *
	 * @param int $totals 总记录数
	 * @param int $rows = 10 每页显示记录数
	 * @param string $tpl = '' 导航模板，mobile）手机分页, simple）简单分页, complex）复杂分页
	 * @param string $uri = '' URL中除了分页变量和每页行数变量以外的部分
	 * @param bool $rowsAllowCustom = false 是否允许在URL中设置每页显示记录数
	 * @param string $pageVar = 'page' URL中页码的变量
	 * @param string $rowsVar = 'rows' URL中每页行数的变量
	 * @param string $argSeparator = '/'  变量分隔符
	 * @param string $valSeparator = ':'  变量和值的分隔符
	 */
	public function __construct($totals, $rows = 10, $tpl = 'default', $uri= '', 
			$rowsAllowCustom = true, $pageVar = 'page', $rowsVar = 'rows', 
			$argSeparator = '/', $valSeparator = ':') {
		$this->totals  = $totals;
		$this->pageVar = $pageVar;
		$this->rowsVar = $rowsVar;
		$this->rowsAllowCustom = $rowsAllowCustom;
		$this->rowsVar = $rowsVar;
		$this->argSeparator = $argSeparator;
		$this->valSeparator = $valSeparator;
		
		if (!in_array($tpl, ['mobile', 'simple', 'complex'])) {
			$tpl = 'simple';
		}
		$this->tpl = $tpl;
				
		// uri预处理
		if(!$uri) {
			$uri = $_SERVER['REQUEST_URI'];
		}

		// 请求参数
		$postArgs = $_POST;
		
		// 提取当前页码
		if(!empty($postArgs[$pageVar])) {
			$this->page = $postArgs[$pageVar];
		} elseif(preg_match("/[\\?\\{$this->argSeparator}]{$pageVar}\\{$this->valSeparator}(\\d+)/i", $uri, $pageMatch)) {
		    $this->page = $pageMatch[1];
		}
		$this->page <= 0 && $this->page = 1;
		
		// 提取每页行数
		if ($rowsAllowCustom) {
			// 允许地址栏传入每页记录数参数
			if(!empty($postArgs[$rowsVar])) {
				$this->rows = $postArgs[$rowsVar];
			} elseif(preg_match("/[\\{$this->argSeparator}\\?]{$rowsVar}\\{$this->valSeparator}(\\d+)/i", $uri, $rowsMatch)) {
				$this->rows = $rowsMatch[1];
			} else {
				$this->rows = $rows;
			}
			// 最多记录数限制
			$this->rows > $this->rowsMax && $this->rows = $this->rowsMax;
		} else {
			$this->rows = $rows;
		}
		
		// 请求变量合并入URL
		if ($postArgs) {
			$uri = rtrim($uri, '/') . '/';
			$argStr = http_build_query($postArgs, 'arg_', $this->argSeparator);
			if ($this->valSeparator != '=') {
				$argStr = str_replace('=', $this->valSeparator, $argStr);
			}
			
			$uri .= $this->argSeparator . $argStr;
		}
		
		// 去掉分页、每页行数参数
	    $uri = preg_replace("/(\\{$this->argSeparator}({$pageVar}|{$rowsVar})\\{$this->valSeparator}\\d+)/", '', $uri);
	    $uri = preg_replace("/([\\?]({$pageVar}|{$rowsVar}){$this->valSeparator}\\d+)/", '?', $uri);
	    $uri = str_replace("?&", '?', $uri);
	    
	    $this->uri = $uri;
		
		/* 页码计算 */
		
		// 最后页，也是总页数
		$this->lastPage = ceil($this->totals / $this->rows);
		
		// 当前页，page值超过最大值时取最大值做page值
		$this->page = min($this->lastPage, $this->page);
		
		// 上一页
		$this->prePage = max($this->page - 1, 1);
		
		// 下一页
		$this->nextPage = min($this->lastPage, $this->page + 1);
		
		// 起始记录，当前页在数据库查询符合结果中的起始记录
		$this->offset = max(($this->page - 1) * $this->rows, 0);
	}
	
	/**
	 * 根据参数生成URL
	 * @param int $page 页码
	 * @param int $rows = null 为null时使用$this->rows的值
	 * @return string
	 */
	public function getPageUrl($page, $rows = null) {
		$rows || $rows = $this->rows;
		$url = $this->uri;
		
	    if ($rows && $this->rowsAllowCustom) {
	    	$url .= "{$this->argSeparator}{$this->rowsVar}{$this->valSeparator}{$rows}";
	    }
		
		if ($page > 1) {
	    	$url .= "{$this->argSeparator}{$this->pageVar}{$this->valSeparator}{$page}";
		}
		
		return $url;
	}
	
	/**
	 * 提供给js调用的分页信息，需使用json_encode() 编码返回的对象实例
	 * 返回 (object) array(
	 *      'totals' => '',
	 *      'pages'  => '',
	 *      'page'   => '',
	 *      'rows'   => '',
	 *      'offset' => ''
	 *  );
	 *  
	 * @return object
	 */
	public function getObj4Json() {
		$r = array(
		    'totals' => $this->totals,
	        'pages'  => $this->lastPage,
	        'page'   => $this->page,
	        'rows'   => $this->rows,
	        'offset' => $this->offset
		);
		
		return (object)$r;
	}
	
	/**
	 * 获取导航条html
	 * @param string $tpl = '' 选择使用导航条模板
	 */
	public function getHtml($tpl = '') {
		$tpl = $tpl ? $tpl : $this->tpl;
		$view = __DIR__ . "/view/{$tpl}.php";
		ob_start();
		include $view;
		return ob_get_clean();
	}
}

