<?php declare(strict_types=1);

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
define('_MI_XBSVAT_NAME', 'EU VAT');

/**
 *  A brief description of this module
 */
define('_MI_XBSVAT_DESC', 'Provides a method for checking European Union Value Added Tax (VAT) numbers against the EU VIES database');

/**#@+
 * Block naming and descriptions
 */
define('_MI_XBSVAT_BLOCK_CODELOOKUPNAME', 'VAT Number Lookup');
define('_MI_XBSVAT_BLOCK_CODELOOKUPDESC', 'Allows user to check a VAT NUmber for any EU member state');
/**#@-*/

//Menu
define('_MI_XBSVAT_MENU_HOME', 'Home');
define('_MI_XBSVAT_MENU_01', 'Admin');
define('_MI_XBSVAT_MENU_ABOUT', 'About');
define('_MI_XBSVAT_MENU_DOCU', 'Docu');

//Help
define('_MI_XBSVAT_DIRNAME', basename(dirname(__DIR__, 2)));
define('_MI_XBSVAT_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_XBSVAT_BACK_2_ADMIN', 'Back to Administration of ');
define('_MI_XBSVAT_OVERVIEW', 'Overview');

//define('_MI_XBSVAT_HELP_DIR', __DIR__);

//help multi-page
define('_MI_XBSVAT_DISCLAIMER', 'Disclaimer');
define('_MI_XBSVAT_LICENSE', 'License');
define('_MI_XBSVAT_SUPPORT', 'Support');
