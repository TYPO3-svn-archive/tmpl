<?php

require_once t3lib_extMgm::extPath('tmpl').'interfaces/interface.tx_tmpl_viewhelper.php';
require_once t3lib_extMgm::extPath('tmpl').'classes/viewhelper/class.tx_tmpl_viewhelper_lll.php';

/**
 * tx_tmpl_viewhelper_Lll test case.
 */
class tx_tmpl_viewhelper_Lll_testcase extends tx_phpunit_testcase {
	private $className;
	private $object1;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();

		$this->className = t3lib_div::makeInstanceClassName('tx_tmpl_viewhelper_Lll');
		$this->object1 = new $this->className(array('languageFile'=>'EXT:tmpl/tests/fixtures/locallang.xml', 'llKey'=>'de'));
	}

	/**
	 * Tests the constructor
	 */
	public function test__construct() {
		// Test that constructing without params works
		$this->object1 = new $this->className(array('languageFile'=>'EXT:tmpl/tests/fixtures/locallang.xml', 'llKey'=>'de'));
		$object = new $this->className(array('languageFile'=>'EXT:tmpl/tests/fixtures/locallang.xml'));
		$this->assertTrue($object instanceof tx_tmpl_ViewHelper, '__create without parameters failed:');
		
		try {
			$this->object1 = new $this->className();
			$this->assertTrue(false, 'No exception thrown when calling the constructor w/o args:');
		} catch (tx_tmpl_LanguageFileUnavailableException $e) {
			//This is what we assert, so everything is fine
		}
	}

	/**
	 * Tests fetching a label
	 */
	public function testGetLabel() {
		$this->assertEquals(
			'Hallo Welt',
			$this->object1->execute(array('hw')),
			'Parsing a string without newlines failed:'
		);
	}

	/**
	 * Tests fetching an nonexistant label (should get default)
	 */
	public function testGetLabelExistingInDefault() {
		$this->assertEquals(
			'Goodbye World',
			$this->object1->execute(array('gw')),
			'Parsing a string without newlines failed:'
		);
	}
	
	/**
	 * Tests fetching an nonexistant label (should get nothing)
	 */
	public function testGetLabelNotExisting() {
		$this->assertEquals(
			'',
			$this->object1->execute(array('fsd')),
			'Parsing a string without newlines failed:'
		);
	}
}
?>
