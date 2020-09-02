<?php declare(strict_types=1);

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
 * Code Lookup Block show and edit functions
 *
 * @copyright (c) 2004, Ashley Kitson
 * @copyright     XOOPS Project https://xoops.org/
 * @license       GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author        Ashley Kitson http://akitson.bbcb.co.uk
 * @author        XOOPS Development Team
 * @package       EUVAT
 * @subpackage    Blocks
 * @version       1
 * @access        private
 */

use XoopsModules\Xbsvat\{Form\FormSelectCountry
};

//avoid declaring the functions repeatedly
//if(defined('EUVAT_BLOOKUP_DEFINED')) return;
/**
 * Flag to tell script it is already parsed.  If set then script is exited
 */
define('EUVAT_BLOOKUP_DEFINED', true);

/**
 * CDM constant definitions
 */
require_once XOOPS_ROOT_PATH . '/modules/xbscdm/include/defines.php';
/**
 * CDM form element class
 */
//include_once(CDM_PATH."/class/class.cdm.form.php");
/**
 * EU VAT form elements
 */
//require_once XOOPS_ROOT_PATH . '/modules/xbsvat/class/class.vat.form.php';

/**
 * Function: Create display data for block
 *
 * Retrieve block configuration data and format block output
 *
 * @param array $options block config options
 *                       [0] = Default EU VAT Country Code
 * @return array output parameters for smarty template
 * @version 1
 */
function b_euvat_lookup_show($options)
{
    //see if user has changed the country code

    // This will happen if form has been used by user

    global $_SESSION;

    if (isset($_SESSION['euvat_blookup_cntry'])) {
        $cntry = $_SESSION['euvat_blookup_cntry'];

        $vatnum = $_SESSION['euvat_blookup_vatnum'];

        $msg = $_SESSION['euvat_blookup_msg'];
    } else {
        $cntry = $options[0];

        $vatnum = '';

        $msg = '';
    }

    $block = [];

    //Form action

    $block['action'] = XOOPS_URL . '/modules/xbsvat/vatlookup.php';

    //country code selector

    $fcntry = new FormSelectCountry('', 'cntry', $cntry);

    $block['cntry'] = $fcntry->render();

    $block['cntryname'] = _MB_XBSVAT_BLOOK_COUNTRY;

    //VAT number input

    $fvnum = new \XoopsFormText('', 'vatnum', 0, 20, $vatnum);

    $block['vnum'] = $fvnum->render();

    $block['vnumname'] = _MB_XBSVAT_BLOOK_NUMBER;

    //Message

    $block['msg'] = $msg;

    //buttons

    $submit = new \XoopsFormButton('', 'submit', _MB_XBSVAT_BLOOK_SUBMIT, 'submit');

    $block['submit'] = $submit->render();

    $reset = new \XoopsFormButton('', 'reset', _MB_XBSVAT_BLOOK_RESET, 'reset');

    $block['reset'] = $reset->render();

    /*
    //set up the javascript for the form
    $js = 'function showCode() {
        document.lookup_form.cvalue.value = document.lookup_form.cd.value;
    }';
    $block['javascript'] = $js;
    */

    return $block;
}

/**
 * Function: Create additional data items for block admin edit form
 *
 * Format a mini table for block options to be included in the
 * main block admin edit form.  All data field names must be 'options[]'
 * and declared in the form in the order of the parameter to this function.
 *
 * @param array $options block config options
 *                       [0] = Default EU VAT Country Code
 * @return string Output html for smarty template
 * @version 1
 */
function b_euvat_lookup_edit($options)
{
    /*create input fields using XoopsForm objects
    * It is clearer to use XoopsForm object->render() to create the form elements
    * rather than hand coding the html.
    */

    $s = new FormSelectCountry('', 'options[]', $options[0]);

    $s->setValue($options[0]);

    $fld = $s->render();

    unset($s);

    //construct the table that will be placed into the admin form

    $form = '<table>';

    $form .= '<tr><td>' . _MB_XBSVAT_BLOOK_COUNTRY . '</td><td>' . $fld . '</td></tr>';

    $form .= '</table>';

    return $form;
}
