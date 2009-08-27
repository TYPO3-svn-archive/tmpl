<?php

require_once t3lib_extMgm::extPath('tmpl').'classes/class.tx_tmpl_template.php';
require_once t3lib_extMgm::extPath('tmpl').'classes/viewhelper/class.tx_tmpl_viewhelper_date.php';
require_once t3lib_extMgm::extPath('cms').'tslib/class.tslib_content.php';
/**
 * tx_tmpl_tmpl test case.
 */
class tx_tmpl_testcase extends tx_phpunit_testcase {
	private $className;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();

		$this->className = t3lib_div::makeInstanceClassName('tx_tmpl_Template');
	}

	/**
	 * Workaround to load templateFile
	 * Problems with filesize through working direcory and manual set of $GLOBALS['TSFE']->tmpl->getFileName_backPath = PATH_site
	 * @param tx_tmpl_Template $templateEngine
	 * @param string $templateFile
	 * @param string $subpart
	 */
	protected function loadTemplate(tx_tmpl_Template &$templateEngine, $templateFile, $subpart) {
		$fileName = t3lib_div::getFileAbsFileName($templateFile);
		if (file_exists($fileName)) {
			$templateEngine->setWorkingTemplateContent(file_get_contents($fileName));
			$templateEngine->workOnSubpart($subpart);
		}
	}

	/**
	 * Tests loading of ViewHelper
	 */
	public function testaddViewHelper() {
		$this->simulateFrontendEnviroment();

		$cObj = t3lib_div::makeInstance('tslib_cObj');
		$templateClass = t3lib_div::makeInstanceClassName('tx_tmpl_Template');
		$tmpl_engine = new $templateClass($cObj, 'EXT:tmpl/tests/fixtures/template01.html', 'test_clean_marker');

		$tmpl_engine->addViewHelperIncludePath('tmpl','classes/viewhelper/');

		$this->assertTrue($tmpl_engine->addViewHelper('date', array('1249924133', 'H:i:s \a\m d.m.Y')));
	}

	/**
	 * Tests adding of ViewHelperObject
	 */
	public function testAddViewHelperObject() {
		$this->simulateFrontendEnviroment();

		$cObj = t3lib_div::makeInstance('tslib_cObj');
		$templateClass = t3lib_div::makeInstanceClassName('tx_tmpl_Template');
		$tmpl_engine = new $templateClass($cObj, 'EXT:tmpl/tests/fixtures/template.html', 'test_clean_marker');
		$viewHelperDate = new tx_tmpl_viewhelper_Date();

		$this->assertTrue($tmpl_engine->addViewHelperObject('tx_tmpl_viewhelper_Date', $viewHelperDate));
	}

	/**
	 * Tests cleaning Template
	 */
	public function testCleaningTemplate() {
		$this->simulateFrontendEnviroment();

		$cObj = t3lib_div::makeInstance('tslib_cObj');
		$templateClass = t3lib_div::makeInstanceClassName('tx_tmpl_Template');
		//filesize in tslib_content->fileResource did not find file
		$tmpl_engine = new $templateClass($cObj, 'EXT:tmpl/tests/fixtures/template.html', 'test_clean_marker');

		$this->loadTemplate($tmpl_engine, 'EXT:tmpl/tests/fixtures/template.html', 'test_clean_marker');
		//Cleaning will be invoked at end of rendering
		$this->assertEquals('Test', trim($tmpl_engine->render()));

		$this->loadTemplate($tmpl_engine, 'EXT:tmpl/tests/fixtures/template.html', 'test_clean_subpart');
		$this->assertEquals('Subpart', trim($tmpl_engine->render()));
	}

	/**
	 * Tests marker substitution
	 */
	public function testMarkerSubstitution() {
		$this->simulateFrontendEnviroment();

		$cObj = t3lib_div::makeInstance('tslib_cObj');
		$templateClass = t3lib_div::makeInstanceClassName('tx_tmpl_Template');
		$tmpl_engine = new $templateClass($cObj, 'EXT:tmpl/tests/fixtures/template.html', 'test_clean_marker');

		// add markers seperatly
		$this->loadTemplate($tmpl_engine, 'EXT:tmpl/tests/fixtures/template.html', 'test_marker');

		$tmpl_engine->addMarker('marker01', '01');
		$tmpl_engine->addMarker('marker02', '02');
		$tmpl_engine->addMarker('marker03', '03');

		$this->assertEquals('01 02 03', trim($tmpl_engine->render()));

		unset($tmpl_engine);

		// add markers as array
		$tmpl_engine = new $templateClass($cObj, 'EXT:tmpl/tests/fixtures/template.html', 'test_clean_marker');
		$this->loadTemplate($tmpl_engine, 'EXT:tmpl/tests/fixtures/template.html', 'test_marker');

		$tmpl_engine->addMarkerArray(
			array(
				'marker01' => '01',
				'marker02' => '02',
				'marker03' => '03',
			)
		);

		$this->assertEquals('01 02 03', trim($tmpl_engine->render()));
	}

	/**
	 * Tests variable substitution
	 */
	public function testVariableSubstitution() {
		$this->simulateFrontendEnviroment();

		$cObj = t3lib_div::makeInstance('tslib_cObj');
		$templateClass = t3lib_div::makeInstanceClassName('tx_tmpl_Template');
		$tmpl_engine = new $templateClass($cObj, 'EXT:tmpl/tests/fixtures/template.html', 'test_clean_marker');

		// add markers seperatly
		$this->loadTemplate($tmpl_engine, 'EXT:tmpl/tests/fixtures/template.html', 'test_var');

		$tmpl_engine->addVariable('var01', array('01' => '01'));
		$tmpl_engine->addVariable('var02', array('02' => '02'));
		$tmpl_engine->addVariable('var03', array('03' => '03'));

		$this->assertEquals('01 02 03', trim($tmpl_engine->render()));
	}

	/**
	 * Tests Subpart substitution
	 */
	public function testSubpartSubstitution() {
		$this->simulateFrontendEnviroment();

		$cObj = t3lib_div::makeInstance('tslib_cObj');
		$templateClass = t3lib_div::makeInstanceClassName('tx_tmpl_Template');
		$tmpl_engine = new $templateClass($cObj, 'EXT:tmpl/tests/fixtures/template.html', 'test_subpart');

		// add markers seperatly
		$this->loadTemplate($tmpl_engine, 'EXT:tmpl/tests/fixtures/template.html', 'test_subpart');

		$tmpl_engine->addSubpart('subpart01', ' Hoch auf die ');

		$this->assertEquals('Ein Hoch auf die Briten!', trim($tmpl_engine->render()));
	}

	/**
	 * Tests viewhelper substitution
	 */
	public function testViewhelperSubstitution() {
		$this->simulateFrontendEnviroment();

		$cObj = t3lib_div::makeInstance('tslib_cObj');
		$templateClass = t3lib_div::makeInstanceClassName('tx_tmpl_Template');
		$tmpl_engine = new $templateClass($cObj, 'EXT:tmpl/tests/fixtures/template.html', 'test_viewhelper');

		$this->loadTemplate($tmpl_engine, 'EXT:tmpl/tests/fixtures/template.html', 'TEST_VIEWHELPER_WITH_DATEFORMAT');

		$tmpl_engine->addViewHelperIncludePath('tmpl','classes/viewhelper/');
		$tmpl_engine->addViewHelper('date');

		$this->assertEquals('10.08.2009 um 19:08:53', trim($tmpl_engine->render()));
	}

	/**
	 * Tests viewhelper substitution with marker and ts
	 */
	public function testViewhelperSubstitutionWithMarkerAndTs() {
		$this->simulateFrontendEnviroment();
		$GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tmpl.']['tests.']['dateFormat.']['date'] = 'd.m.Y \u\m H:i:s';

		$cObj = t3lib_div::makeInstance('tslib_cObj');
		$templateClass = t3lib_div::makeInstanceClassName('tx_tmpl_Template');
		$tmpl_engine = new $templateClass($cObj, 'EXT:tmpl/tests/fixtures/template.html', 'test_viewhelper');

		$this->loadTemplate($tmpl_engine, 'EXT:tmpl/tests/fixtures/template.html', 'TEST_VIEWHELPER_WITH_MARKER_AND_TS');

		$tmpl_engine->addViewHelperIncludePath('tmpl','classes/viewhelper/');

		$tmpl_engine->addViewHelper('ts');
		$tmpl_engine->addViewHelper('date');

		$tmpl_engine->addMarker('TIMESTAMP', '1249924133');

		$content=trim($tmpl_engine->render());//debug($content);
		$this->assertEquals('10.08.2009 um 19:08:53', $content);
	}

	/**
	 * Tests loop
	 */
	public function testLoop() {
		$this->simulateFrontendEnviroment();

		$cObj = t3lib_div::makeInstance('tslib_cObj');
		$templateClass = t3lib_div::makeInstanceClassName('tx_tmpl_Template');
		$tmpl_engine = new $templateClass($cObj, 'EXT:tmpl/tests/fixtures/template.html', 'test_loop');

		$this->loadTemplate($tmpl_engine, 'EXT:tmpl/tests/fixtures/template.html', 'TEST_LOOP');

		$tmpl_engine->addLoop('products', 'product',
			array(
				array('title'=>'Apples', 'price'=>'$1.45', 'unit'=>'kg'),
				array('title'=>'Oranges', 'price'=>'$1.89', 'unit'=>'kg'),
				array('title'=>'Watermelons', 'price'=>'$1.99', 'unit'=>'piece'),
			)
		);

		$this->assertEquals(
			'<table><tr><th>Product</tr><th>Price</tr><th>Unit</tr></tr><tr><td>Apples</td><td>$1.45</td><td>kg</td></tr><tr><td>Oranges</td><td>$1.89</td><td>kg</td></tr><tr><td>Watermelons</td><td>$1.99</td><td>piece</td></tr></table>',
			trim($tmpl_engine->render())
		);
	}

	/**
	 * Test underscored word to upper camel case
	 */
	public function testUnderScoredToUpperCamelCase() {
		$this->assertEquals(
			'IchBinEinVerdammtKomplizierterSatz',
			tx_tmpl_Template::underscoredToUpperCamelCase('Ich_Bin_Ein_Verdammt_Komplizierter_Satz'),
			'Could not camelize word with underscores'
		);
		$this->assertEquals(
			'IchBinEinVerdammtKomplizierterSatz',
			tx_tmpl_Template::underscoredToUpperCamelCase('ich_bin_Ein_verdammt_Komplizierter_satz'),
			'Could not camelize word with underscores und different beginnings'
		);
	}

	/**
	 * Test camilizing underscored word
	 */
	public function testCamelizeUnderScoreReplace() {
		$this->assertEquals(
			'IchBinEinVerdammtKomplizierterSatz',
			tx_tmpl_Template::camelize('Ich_Bin_Ein_Verdammt_Komplizierter_Satz'),
			'Could not camelize word with underscores'
		);
		$this->assertEquals(
			'IchBinEinVerdammtKomplizierterSatz',
			tx_tmpl_Template::camelize('ich_bin_Ein_verdammt_Komplizierter_satz'),
			'Could not camelize word with underscores und different beginnings'
		);
	}
}
?>
