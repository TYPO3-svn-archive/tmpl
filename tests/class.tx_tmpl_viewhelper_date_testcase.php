<?php
// added for ViewHelper
require_once t3lib_extMgm::extPath('cms').'tslib/class.tslib_content.php';

require_once t3lib_extMgm::extPath('tmpl').'interfaces/interface.tx_tmpl_viewhelper.php';
require_once t3lib_extMgm::extPath('tmpl').'classes/viewhelper/class.tx_tmpl_viewhelper_date.php';

/**
 * tx_tmpl_viewhelper_Nl2br test case.
 */
class tx_tmpl_viewhelper_date_testcase extends tx_phpunit_testcase {
	private $className;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();

		$this->className = t3lib_div::makeInstanceClassName('tx_tmpl_viewhelper_Date');
	}

	/**
	 * Tests getting date value with parameter
	 */
	public function testDateParameter() {
		$this->simulateFrontendEnviroment();

		$object = new $this->className();

		$GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tmpl.']['general.']['dateFormat.']['date'] = 'd.m.Y \u\m H:i:s';
		$this->assertEquals(
			'19:08:53 am 10.08.2009', //1249924133
			$object->execute(array('1249924133', 'H:i:s \a\m d.m.Y')),
			'Could not get correct Date with parameter'
		);
	}

	/**
	 * Tests getting date value with default
	 */
	public function testDateDefault() {
		$this->simulateFrontendEnviroment();

		$object = new $this->className();

		$GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tmpl.']['general.']['dateFormat.']['date'] = 'd.m.Y \u\m H:i:s';
		$this->assertEquals(
			'10.08.2009 um 19:08:53', //1249924133
			$object->execute(array('1249924133')),
			'Could get correct Date (funzt von der Implementierung noch nicht)'
		);
	}
}
?>
