<?php
require_once '../lib/Pager.php';

use wf\pager\Pager;

/**
 * Pager test case.
 */
class PagerTest extends PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var Pager
	 */
	private $pager;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated PagerTest::tearDown()
		$this->pager = null;
		
		parent::tearDown ();
	}
	
	
	/**
	 * Tests Pager->getPageUrl()
	 */
	public function testGetPageUrl() {
		$args = [
			'arg_separator'   => '/',  // 参数分隔符号
			'val_separator'   => ':', // 变量和值的分隔符
			'page_var'        => 'page', // 分页的url请求变量
			'rows_var'        => 'rows', // 每页行数url请求变量
		];
		
		// /demo/path/to/arg1:val1?rows=10&page=2
		$pager = new Pager(200, 20, '', $args);
		$pager->uri = '/demo/path/to/arg1:val1?page=1&rows=10';
		
		$url = $pager->getPageUrl(2);		
		$this->assertEquals('/demo/path/to/arg1:val1?rows=10&page=2', $url);

		$url = $pager->getPageUrl(1);
		$this->assertEquals('/demo/path/to/arg1:val1?rows=10', $url);
		
		$url = $pager->getPageUrl(2321);
		$this->assertEquals('/demo/path/to/arg1:val1?rows=10&page=2321', $url);
		
		// /test/xx?my=test&rows=20&page=55
		$pager = new Pager(200, 20, '', $args);
		$pager->uri = '/test/xx?my=test';
		
		$url = $pager->getPageUrl(55);
		$this->assertEquals('/test/xx?my=test&rows=20&page=55', $url);

		
		// /test/xx/rows:20/page:2
		$pager = new Pager(200, 20, '', $args);
		$pager->uri = '/test/xx';
		
		$url = $pager->getPageUrl(2);
		$this->assertEquals("{$pager->uri}/rows:20/page:2", $url);
		
		
		// /test/xx/page:2
		$pager = new Pager(200, 20, '', $args);
		$pager->uri = '/test/xx';
		$pager->allowCustomRows = false;
		
		$url = $pager->getPageUrl(2);
		$this->assertEquals("{$pager->uri}/page:2", $url);
		
		// 有POST数据
		$_POST = [
			'arr' => [
				'a1' => 123,
				'a2' => "d中文sf\"xs\'xs",
			],
			'str' => 'jdsoi',
		];

		$pager = new Pager(200, 20, 'simple', $args);
		$pager->uri = '/test/xx';
		
		$url = $pager->getPageUrl(2);
		$this->assertEquals("/test/xx/arr%5Ba1%5D:123/arr%5Ba2%5D:d%E4%B8%AD%E6%96%87sf%22xs%5C%27xs/str:jdsoi/rows:20/page:2", $url);

		$pager = new Pager(200, 20, 'simple', $args);
		$pager->uri = '/test/xx?q=1';
		
		$url = $pager->getPageUrl(2);
		$this->assertEquals("/test/xx?q=1&arr%5Ba1%5D=123&arr%5Ba2%5D=d%E4%B8%AD%E6%96%87sf%22xs%5C%27xs&str=jdsoi&rows=20&page=2", $url);
		
		$parseArr = [];
		parse_str(substr($url, 13), $parseArr);

		$this->assertEquals($_POST['arr'], $parseArr['arr']);
		$this->assertEquals($_POST['str'], $parseArr['str']);
		
		$_POST = [];
		// END 有POST数据

		// /test/xx/r/每页行数/p/页码
		$args = [
			'arg_separator'   => '/',  // 参数分隔符号
			'val_separator'   => '/', // 变量和值的分隔符
			'page_var'        => 'p', // 分页的url请求变量
			'rows_var'        => 'r', // 每页行数url请求变量
		];
		$pager = new Pager(200, 20, '', $args);
		$pager->uri = '/test/xx';
		
		$url = $pager->getPageUrl(2);
		$this->assertEquals("/test/xx/r/20/p/2", $url);
		

		$pager = new Pager(200, 20, '', $args);
		$pager->uri = '/test/xx/r/8/p/15';
		
		$url = $pager->getPageUrl(12);
		$this->assertEquals('/test/xx/r/8/p/12', $url);
		
		$url = $pager->getPageUrl($pager->lastPage);
		$this->assertEquals('/test/xx/r/8/p/25', $url);
		
	}
	
	/**
	 * Tests Pager->getObj4Json()
	 */
	public function testGetObj4Json() {
		// TODO Auto-generated PagerTest->testGetObj4Json()
		$this->markTestIncomplete ( "getObj4Json test not implemented" );
		
		$this->pager->getObj4Json(/* parameters */);
	}
	
	/**
	 * Tests Pager->getHtml()
	 */
	public function testGetHtml() {
		$this->pager = new Pager(100, 12);
		$html = $this->pager->getHtml('simple');
	}
}

