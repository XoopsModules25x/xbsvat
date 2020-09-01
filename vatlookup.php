<?php declare(strict_types=1);

//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://xoops.org>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author:    Ashley Kitson                                                  //
// Copyright: (c) 2005, Ashley Kitson                                        //
// URL:       http://xoobs.net                                               //
// Project:   The XOOPS Project (https://xoops.org/)                      //
// Module:    EU VAT (EUVAT)                                                 //
//-------------------------------------------------------------------------- //
/**
 * Check the VAT number and return result to user
 *
 * This file is called by blocks/euvat_block_lookup.php.
 * It cannot be placed in the blocks directory as the Xoops 2.2
 * security will not allow access!!!
 *
 * @author     Ashley Kitson http://xoobs.net
 * @copyright  2005 Ashley Kitson, UK
 * @package    EUVAT
 * @subpackage Blocks
 * @version    1
 * @access     private
 */

use Xmf\Request;
use XoopsModules\Xbsvat\{
    Helper,
    Utility
};
/** @var Helper $helper */

/**
 * Xoops mainfile
 */
require_once dirname(__DIR__, 2) . '/mainfile.php'; //Xoops 2.2
//include_once('../../../mainfile.php'); //Xoops 2.0 if this script is in blocks directory
/**
 * Xoops header
 */
require_once XOOPS_ROOT_PATH . '/header.php';
/**
 * CDM Defines
 */
require_once XOOPS_ROOT_PATH . '/modules/xbscdm/include/defines.php';

$helper = Helper::getInstance();
$helper->loadLanguage('blocks');

/**
 * Session values
 */
global $_SESSION;
/**
 * Form get variables
 */
//global $_GET;
/**
 * Server variables
 */
global $_SERVER;

//Check VAT number
$ret = false;
if (isset($_GET['cntry'])) {
    if (isset($_GET['vatnum'])) {
        $ret = Utility::checkNumber(Request::getString('cntry', '', 'GET'), Request::getInt('vatnum', 0, 'GET'));
    }
}
//save the data to display when form next shows
$_SESSION['euvat_blookup_cntry']  = Request::getString('cntry', '', 'GET');
$_SESSION['euvat_blookup_vatnum'] = Request::getInt('vatnum', 0, 'GET');
//and go back to the page we were on
if ($ret) {
    $_SESSION['euvat_blookup_msg'] = _MB_XBSVAT_BLOOK_SUCCESS;
} else {
    $_SESSION['euvat_blookup_msg'] = _MB_XBSVAT_BLOOK_FAIL;
}
//Redisplay page - 1st method is Xoops and slow
//  Other methods are more direct but may not work in
//  some situations
//redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'),0);
//echo '<meta http-equiv="refresh" content="0";url='.Request::getString('HTTP_REFERER', '', 'SERVER').'">';
header('Location: ' . Request::getString('HTTP_REFERER', '', 'SERVER'));
