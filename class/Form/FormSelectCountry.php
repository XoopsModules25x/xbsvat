<?php declare(strict_types=1);

namespace XoopsModules\Xbsvat\Form;

use \XoopsModules\Xbscdm\Form\FormSelect;

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Classes used by EU VAT to present form data
 *
 * @package       EUVAT
 * @subpackage    Form_Handling
 * @copyright (c) 2004, Ashley Kitson
 * @copyright     XOOPS Project https://xoops.org/
 * @license       GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author        Ashley Kitson http://akitson.bbcb.co.uk
 * @author        XOOPS Development Team
 */

require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

/**
 * Xoops form objects
 */
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
/**
 * CDM Definitions
 */
require_once XOOPS_ROOT_PATH . '/modules/xbscdm/include/defines.php';

/**
 * CDM functions
 */
//require_once CDM_PATH."/include/functions.php";

/**
 * Create a VAT Country Code selector
 *
 * @package    EUVAT
 * @subpackage Form_Handling
 * @version    1
 */
class FormSelectCountry extends FormSelect
{
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name    "name" attribute
     * @param mixed  $value   Pre-selected value (or array of them).
     * @param int    $size    Number of rows. "1" makes a drop-down-list
     * @param string $lang    The language set for the returned codes, defaults to CDM_DEF_LANG (normally EN)
     */
    public function __construct($caption, $name, $value = null, $size = 1, $lang = CDM_DEF_LANG)
    {
        parent::__construct('EUVAT', $caption, $name, $value, $size, $lang, 'cd_desc');
    }
}
