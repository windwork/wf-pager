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
		// TODO Auto-generated PagerTest->testGetPageUrl()
		$this->markTestIncomplete ( "getPageUrl test not implemented" );
		
		$this->pager->getPageUrl(/* parameters */);
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

