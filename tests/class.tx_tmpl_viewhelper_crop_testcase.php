<?php

require_once t3lib_extMgm::extPath('tmpl').'interfaces/interface.tx_tmpl_viewhelper.php';
require_once t3lib_extMgm::extPath('tmpl').'classes/viewhelper/class.tx_tmpl_viewhelper_crop.php';

/**
 * tx_tmpl_viewhelper_Nl2br test case.
 */
class tx_tmpl_viewhelper_crop_testcase extends tx_phpunit_testcase {
	private $className;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();

		$this->className = t3lib_div::makeInstanceClassName('tx_tmpl_viewhelper_Crop');
	}

	/**
	 * Tests positiv maxLenght argument of execute
	 */
	public function testCropPositivMaxLength() {
		$object = new $this->className();

		$this->assertEquals(
			"Hallo Welt. Hallo Welt. Hallo ...",
			$object->execute(array('Hallo Welt. Hallo Welt. Hallo Welt. Hallo Welt.', 30)),
			'Cropping string (47 chars) with maxLength=30 failed.'
		);
	}

	/**
	 * Tests AppendString
	 */
	public function testAppendString() {
		$object = new $this->className();

		$this->assertEquals(
			"Hallo Welt. Hallo Welt. Hallo Sch",
			$object->execute(array('Hallo Welt. Hallo Welt. Hallo Welt. Hallo Welt.', 30, 'Sch')),
			'Cropping string (47 chars) with maxLength=30 and appending "Sch" failed. Fails with Typo3 Verions lower than 4.3'
		);
	}

	/**
	 * Tests negativ maxLenght argument of execute
	 */
	public function testCropNegativMaxLength() {
		$object = new $this->className();

		$this->assertEquals(
			"... Welt. Hallo Welt. Hallo Welt.",
			$object->execute(array('Hallo Welt. Hallo Welt. Hallo Welt. Hallo Welt.', -30)),
			'Backward cropping string (47 chars) with maxLength=-30 failed.'
		);
	}

	/**
	 * Tests PrependString
	 */
	public function testPrependString() {
		$object = new $this->className();

		$this->assertEquals(
			"Sch Welt. Hallo Welt. Hallo Welt.",
			$object->execute(array('Hallo Welt. Hallo Welt. Hallo Welt. Hallo Welt.', -30, 'Sch')),
			'Backward cropping string (47 chars) with maxLength=-30 failed. Fails with Typo3 Verions lower than 4.3'
		);
	}
}
?>