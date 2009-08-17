<?php
// added for ViewHelper
require_once t3lib_extMgm::extPath('cms').'tslib/class.tslib_content.php';

require_once t3lib_extMgm::extPath('tmpl').'interfaces/interface.tx_tmpl_viewhelper.php';
require_once t3lib_extMgm::extPath('tmpl').'classes/viewhelper/class.tx_tmpl_viewhelper_getcobj.php';

/**
 * tx_tmpl_viewhelper_Nl2br test case.
 */
class tx_tmpl_viewhelper_getcobj_testcase extends tx_phpunit_testcase {
	private $className;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();

		$this->className = t3lib_div::makeInstanceClassName('tx_tmpl_viewhelper_GetCObj');
	}

	/**
	 * Tests getting stripped cropped Text with cObj
	 */
	public function testgetStrippedCroppedText() {
		$this->simulateFrontendEnviroment();

		$object = new $this->className();

		$GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tmpl.']['general.']['object'] = 'TEXT';
		$GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tmpl.']['general.']['object.'] = array(
			'value' => '<bold>Test Test Test Test Test Test Test Test Test</bold>',
			'stripHtml' => '1',
			'crop' => '19'
		);

		$this->assertEquals(
			'Test Test Test Test', //1249924133
			$object->execute(array('plugin.tx_tmpl.general.object')),
			'Could not get correct compressed image'
		);
	}
}
?>
