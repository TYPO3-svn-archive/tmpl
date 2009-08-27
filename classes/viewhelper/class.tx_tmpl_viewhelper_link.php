<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008-2009 Ingo Renner <ingo@typo3.org>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/


/**
 * A viewhelper to create links
 *
 * @author	Ingo Renner <ingo@typo3.org>
 * @package TYPO3
 * @subpackage tmpl
 */
class tx_tmpl_viewhelper_Link implements tx_tmpl_ViewHelper {

	/**
	 * an instance of tslib_cObj
	 *
	 * @var	tslib_cObj
	 */
	protected $contentObject = null;

	/**
	 * constructor for class tx_tmpl_viewhelper_Link
	 */
	public function __construct(array $arguments = array()) {
		if (is_null($this->contentObject)) {
			$this->contentObject = t3lib_div::makeInstance('tslib_cObj');
		}
	}

	/**
	 * arguments[0] := Link Text
	 * arguments[1] := paramenter (TSRef typolink) target of link
	 * arguments[2] := additionalParams (TSRef typolink)
	 * arguments[3] := ATagParams (TSRef typolink)
	 */
	public function execute(array $arguments = array()) {
		$additionalParameters = '';

		if (!empty($arguments[2])) {
			$unprocessedParameters = $arguments[2];

			if (!t3lib_div::isFirstPartOfStr($unprocessedParameters, '&')) {
				$unprocessedParameters = '&' . $unprocessedParameters;
			}

			$additionalParameters = $unprocessedParameters;
		}

			//added by matthias - new default: cache urls, can be disabled by 5th parameter
		if (!isset($arguments[4]))
			$arguments[4] = true;

		$link = $this->contentObject->typoLink(
			$arguments[0],
			array(
				'parameter' => $arguments[1],
				'additionalParams' => $additionalParameters,
				'ATagParams' => $arguments[3],
				//added by matthias: cache-handling for url (cHash)
				'useCacheHash' => $arguments[4],
			)
		);
		return $link;
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tmpl/classes/viewhelper/class.tx_tmpl_viewhelper_link.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tmpl/classes/viewhelper/class.tx_tmpl_viewhelper_link.php']);
}

?>