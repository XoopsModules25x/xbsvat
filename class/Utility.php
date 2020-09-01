<?php declare(strict_types=1);

namespace XoopsModules\Xbsvat;

/*
 Utility Class Definition

 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 *
 * @license      https://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2000-2020 &copy; XOOPS Project
 * @author       Mamba <mambax7@gmail.com>
 */

use XoopsModules\Xbsvat\{
    Helper,
    Common
};
//use XoopsModules\Xbsvat\Constants;

/**
 * Class Utility
 */
class Utility extends Common\SysUtility
{
    //--------------- Custom module methods -----------------------------

    /**
     * Return an EUVAT object
     *
     * @param string $cntryCd EU VAT Country code
     * @param string $lang    Language set for code set
     * @return void (CDMCode) object
     */
    public static function getCodeObj($cntryCd, $lang = CDM_DEF_LANG)
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
    public static function checkNumber($cntryCd, $vnum, $lang = CDM_DEF_LANG)
    {
        $vat = self::getCodeObj($cntryCd);

        if ($vat) {
            return $vat->check($cntryCd . $vnum);
        }

        return false;
    }

}
