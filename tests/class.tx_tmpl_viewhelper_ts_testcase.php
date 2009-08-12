<?php

require_once t3lib_extMgm::extPath('tmpl').'interfaces/interface.tx_tmpl_viewhelper.php';
require_once t3lib_extMgm::extPath('tmpl').'classes/viewhelper/class.tx_tmpl_viewhelper_ts.php';

/**
 * tx_tmpl_viewhelper_Nl2br test case.
 */
class tx_tmpl_viewhelper_ts_testcase extends tx_phpunit_testcase {
	private $className;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();

		$this->className = t3lib_div::makeInstanceClassName('tx_tmpl_viewhelper_Ts');
	}

	/**
	 * Tests getting value from TS
	 */
	public function testGetTsValue() {

		$this->simulateFrontendEnviroment();

		$object = new $this->className();

		$GLOBALS['TSFE']->tmpl->setup['plugin.'] = array(
			'tx_tmpl_test.' => array(
				'viewhelper.' => array(
					'ts.' => array(
						'value' => 'viewHelper_Ts'
					)
				)
			)
		);

		$this->assertEquals(
			'viewHelper_Ts',
			$object->execute(array('plugin.tx_tmpl_test.viewhelper.ts.value')),
			'Could get TypoScriptValue'
		);
	}
}
?>