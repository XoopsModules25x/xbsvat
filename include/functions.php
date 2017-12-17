<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://xoops.org/>                             //
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
// Copyright: (c) 2004, Ashley Kitson                                        //
// URL:       http://xoobs.net                                               //
// Project:   The XOOPS Project (https://xoops.org/)                      //
// Module:    EU VAT (EUVAT)                                                 //
// SubModule: Common functions                                               //
// ------------------------------------------------------------------------- //

/**
 * API Functions
 *
 * @package       EUVAT
 * @subpackage    API_Functions
 * @author        Ashley Kitson http://xoobs.net
 * @copyright (c) 2006 Ashley Kitson, Great Britain
 */

/**
 * VAT base class
 */
include_once XOOPS_ROOT_PATH . '/modules/xbs_vat/class/class.vat.base.php';

/**
 * Return an EUVAT object
 *
 * @param string $cntryCd EU VAT Country code
 * @param string $lang    Language set for code set
 * @return EUVAT (CDMCode) object
 */
function EUVATGetCodeObj($cntryCd, $lang = CDM_DEF_LANG)
{
    $vatHandler = xoops_getModuleHandler('EUVat', 'xbs_vat');
    $id         = $vatHandler->getKey($cntryCd, 'EUVAT', $lang);
    $vat        =& $vatHandler->get($id);
    return $vat;
}

/**
 * Check a VAT number against VIES database
 *
 * @param        $cntryCd
 * @param string $vnum VAT Number (no country code prefix)
 * @param string $lang Language set to use [optional]
 *
 * @internal param string $CntryCd VAT Country Code
 * @return boolean True if Code is valid else false
 */
function EUVATCheckNumber($cntryCd, $vnum, $lang = CDM_DEF_LANG)
{
    $vat =& EUVATGetCodeObj($cntryCd);
    if ($vat) {
        return $vat->check($cntryCd . $vnum);
    } else {
        return false;
    }
}
