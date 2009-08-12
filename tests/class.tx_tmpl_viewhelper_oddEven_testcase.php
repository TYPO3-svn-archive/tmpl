<?php

require_once t3lib_extMgm::extPath('tmpl').'interfaces/interface.tx_tmpl_viewhelper.php';
require_once t3lib_extMgm::extPath('tmpl').'classes/viewhelper/class.tx_tmpl_viewhelper_oddeven.php';

/**
 * tx_tmpl_viewhelper_Nl2br test case.
 */
class tx_tmpl_viewhelper_oddEven_testcase extends tx_phpunit_testcase {
	private $className;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();

		$this->className = t3lib_div::makeInstanceClassName('tx_tmpl_viewhelper_OddEven');
	}

	/**
	 * Test odd row
	 */
	public function testOdd() {
		$object = new $this->className();

		$this->assertEquals(
			'odd',
			$object->execute(array(5)),
			'Row number was not odd!'
		);
	}

	/**
	 * Test even row
	 */
	public function testEven() {
		$object = new $this->className();

		$this->assertEquals(
			'even',
			$object->execute(array(10)),
			'Row number was not even!'
		);
	}
}
?>