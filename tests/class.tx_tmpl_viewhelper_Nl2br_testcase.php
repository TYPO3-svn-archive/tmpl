<?php

require_once t3lib_extMgm::extPath('tmpl').'interfaces/interface.tx_tmpl_viewhelper.php';
require_once t3lib_extMgm::extPath('tmpl').'classes/viewhelper/class.tx_tmpl_viewhelper_nl2br.php';

/**
 * tx_tmpl_viewhelper_Nl2br test case.
 */
class tx_tmpl_viewhelper_Nl2br_testcase extends tx_phpunit_testcase {
	private $className;
	private $object1;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();

		$this->className = t3lib_div::makeInstanceClassName('tx_tmpl_viewhelper_Nl2br');
		$this->object1 = new $this->className();
	}

	/**
	 * Tests tx_tmpl_viewhelper_Nl2br->__construct()
	 */
	public function test__construct() {
		// Test that constructing without params works
		$object = new $this->className();
		$this->assertTrue($object instanceof tx_tmpl_viewhelper_Nl2br, '__create() without parameters failed:');
		$this->assertTrue($object instanceof tx_tmpl_ViewHelper, '__create without parameters failed:');

		// Test that constructing with params does no harm
		$object = new $this->className(array('sdaa'));
		$this->assertTrue($object instanceof tx_tmpl_viewhelper_Nl2br, '__create() with parameters failed:');
		$this->assertTrue($object instanceof tx_tmpl_ViewHelper, '__create() with parameters failed:');
	}

	/**
	 * Tests tx_tmpl_viewhelper_Nl2br->execute()
	 */
	public function testExecute() {
		$this->assertEquals(
			'Hallo Welt',
			$this->object1->execute(array('Hallo Welt')),
			'Parsing a string without newlines failed:'
		);
		$this->assertEquals(
			"Hallo Welt<br />\n",
			$this->object1->execute(array("Hallo Welt\n")),
			'Parsing a string with newline at the end failed:'
		);
		$this->assertEquals(
			"H<br />\nal<br />\n<br />\nlo<br />\n W<br />\nel<br />\nt<br />\n<br />\n",
			$this->object1->execute(array("H\nal\n\nlo\n W\nel\nt\n\n")),
			'Parsing a string with many newlines failed:'
		);
		$this->assertEquals(
			"<br />\n<br />\n",
			$this->object1->execute(array("\n\n")),
			'Parsing a string with only newlines failed:'
		);
		$this->assertEquals(
			"",
			$this->object1->execute(array("")),
			'Parsing an empty string failed:'
		);
	}
}
?>