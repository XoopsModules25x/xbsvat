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
 * API Functions
 *
 * @package       EUVAT
 * @subpackage    API_Functions
 * @copyright     Ashley Kitson
 * @copyright     XOOPS Project https://xoops.org/
 * @license       GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author        Ashley Kitson http://akitson.bbcb.co.uk
 * @author        XOOPS Development Team
 */

use XoopsModules\Xbsvat\Helper;

/**
 * Return an EUVAT object
 *
 * @param string $cntryCd EU VAT Country code
 * @param string $lang    Language set for code set
 * @return void (CDMCode) object
 */
function EUVATGetCodeObj($cntryCd, $lang = CDM_DEF_LANG)
{
    $vatHandler = Helper::getInstance()->getHandler('EuVat');

    $id = $vatHandler->getKey($cntryCd, 'EUVAT', $lang);

    return $vatHandler->get($id);
}

/**
 * Check a VAT number against VIES database
 *
 * @param        $cntryCd
 * @param string $vnum VAT Number (no country code prefix)
 * @param string $lang Language set to use [optional]
 *
 * @return bool True if Code is valid else false
 * @internal param string $CntryCd VAT Country Code
 */
function EUVATCheckNumber($cntryCd, $vnum, $lang = CDM_DEF_LANG)
{
    $vat = EUVATGetCodeObj($cntryCd);

    if ($vat) {
        return $vat->check($cntryCd . $vnum);
    }

    return false;
}
