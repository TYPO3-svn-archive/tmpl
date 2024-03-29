<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Ingo Renner <ingo@typo3.org>
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
 * Crop viewhelper to to shorten strings
 * Replaces viewhelpers ###CROP:string|length|cropIndicator###
 *
 * @author	Ingo Renner <ingo@typo3.org>
 * @package TYPO3
 * @subpackage tmpl
 */
class tx_tmpl_viewhelper_Crop implements tx_tmpl_ViewHelper {

		// defaults if neather is given trough the view helper marker, nor through TS
	protected $maxLength = 30;
	protected $cropIndicator = '...';

	/**
	 * constructor for class tx_tmpl_viewhelper_Crop
	 */
	public function __construct(array $arguments = array()) {
		$this->maxLength = $arguments['maxLength'];
		if(array_key_exists('cropIndicator', $arguments)) {
			$this->cropIndicator = $arguments['cropIndicator'];
		}
	}

	/**
	 * returns the given string shortened to a max length of optionaly set chars.
	 * If no maxLength and/or cropIndicator parameters are set, default values apply
	 *
	 * @param array $arguments
	 * @return	string
	 */
	public function execute(array $arguments = array()) {
		$croppedString = $stringToCrop = $arguments[0];

		$maxLength = $this->maxLength;
		if (isset($arguments[1])) {
			$maxLength = (int) $arguments[1];
		}

		$cropIndicator = $this->cropIndicator;
		if (isset($arguments[2])) {
			$cropIndicator = $arguments[2];
		} 

		$croppedString = t3lib_div::fixed_lgd_cs($stringToCrop, $maxLength, $cropIndicator);

		return $croppedString;
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tmpl/classes/viewhelper/class.tx_tmpl_viewhelper_crop.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tmpl/classes/viewhelper/class.tx_tmpl_viewhelper_crop.php']);
}

?>
