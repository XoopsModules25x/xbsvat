<?php
// $Id: modinfo.php,v 1.14 2004/09/11 10:37:03 onokazu Exp $
// Module Info

/**
 * Constant definitions that are module specific.
 *
 * Definitions in this file conform to the Xoops standard for the modinfo.php file
 *
 * @package       EUVAT
 * @subpackage    Definitions
 * @version       1.5
 * @access        private
 * @author        Ashley Kitson http://xoobs.net
 * @copyright (c) 2004 Ashley Kitson, Great Britain
 */

/**
 * The name of this module
 */
define('_MI_EUVAT_NAME', 'EU VAT');

/**
 *  A brief description of this module
 */
define('_MI_EUVAT_DESC', 'Provides a method for checking European Union Value Added Tax (VAT) numbers against the EU VIES database');

/**#@+
 * Block naming and descriptions
 */
define('_MI_EUVAT_BLOCK_CODELOOKUPNAME', 'VAT Number Lookup');
define('_MI_EUVAT_BLOCK_CODELOOKUPDESC', 'Allows user to check a VAT NUmber for any EU member state');
/**#@-*/
