<?php declare(strict_types=1);

namespace XoopsModules\Xbsvat;

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
// Copyright: (c) 2004, Ashley Kitson                                        //
// URL:       http://xoobs.net                                               //
// Project:   The XOOPS Project (https://xoops.org/)                      //
// Module:    EU VAT (EUVAT)                                                 //
// Credits:   Benjamin Boigienman (boigien at free.fr)                       //
//            For supplying the original code on which this module is based  //
//            The original code can be found at http://www.phpclasses.org    //
// ------------------------------------------------------------------------- //
/**
 * Base classes used by EU VAT system
 *
 * Credits:   Benjamin Boigienman (boigien at free.fr) For supplying the
 * original code on which this module is based. The original code can be
 * found at http://www.phpclasses.org
 *
 * @package       EUVAT
 * @subpackage    EUVATBase
 * @author        Ashley Kitson http://xoobs.net.
 * @copyright (c) 2005 Parts - Ashley Kitson, Great Britain.  Parts - Benjamin Boigienman, France
 * @tutorial      EUVAT/EuVat/EUVAT.pkg
 */

/**
 * Base VAT handling objects are derived from Code Data Management base objects
 */
//require_once XOOPS_ROOT_PATH . '/modules/xbscdm/class/class.cdm.base.php';

use XoopsModules\Xbscdm;

/**
 * VAT object
 *
 * @package    EUVAT
 * @subpackage EuVat
 * @version    1
 */
class EuVat extends Xbscdm\Code
{
    /**
     * Check that the VAT number is in the correct format
     *
     * @param string $vatno EU VAT number in full format with country prefix
     * @return bool. True if OK else False
     * @access private
     */
    public function checkStructure($vatno)
    {
        //check to see that first two characters are ALPHA and that they match

        //the cd field of this code

        if (preg_match('/^([A-Z]{2})/', $vatno, $regs) && ($regs[1] == $this->getVar('cd'))) {
            //strip out first two characters

            $vatno = mb_substr($vatno, 2);

            //Get the format masks for the VAT code

            $vmask = $this->getVar('cd_param');

            $vatmask = explode('~', $vmask);

            foreach ($vatmask as $mask) {
                if (preg_match('/$mask/', $vatno)) {
                    return true;
                }
            }
        }

        return false;
    }

    //end function

    /**
     * Support function to check VAT number against VIES database
     *
     * @param URLString $url
     * @return mixed. Returned data if success else False
     * @access private
     */
    public function loadData($url)
    {
        $url = parse_url($url);

        if (!in_array($url['scheme'], ['', 'http'])) {
            return false;
        }

        $fp = fsockopen($url['host'], ($url['port'] > 0 ? $url['port'] : 80), $errno, $errstr, 2);

        if (!$fp) {
            return false;
        }

        fwrite($fp, 'GET ' . $url['path'] . (isset($url['query']) ? '?' . $url['query'] : '') . " HTTP/1.0\r\n");

        fwrite($fp, 'Host: ' . $url['host'] . "\r\n");

        fwrite($fp, "Connection: close\r\n\r\n");

        $data = '';

        stream_set_blocking($fp, false);

        stream_set_timeout($fp, 4);

        $status = stream_get_meta_data($fp);

        while (!feof($fp) && !$status['timed_out']) {
            $data .= fgets($fp, 1000);

            $status = stream_get_meta_data($fp);
        }

        if ($status['timed_out']) {
            return false;
        }

        fclose($fp);

        return $data;
    }

    //end function

    /**
     * Check the VAT number against the VIES database
     *
     * @param string $vatno EU VAT number in full format with country prefix
     * @return bool. True if OK else False
     * @access private
     */
    public function checkMSVAT($vatno)
    {
        $ViesMS = mb_strtoupper(mb_substr($vatno, 0, 2));

        $vatno = mb_substr($vatno, 2);

        $ViesURL = 'http://www.europa.eu.int:80/comm/taxation_customs/vies/cgi-bin/viesquer/?VAT=%s&MS=%s&Lang=EN';

        $urlVies = sprintf($ViesURL, $vatno, $ViesMS);

        $DataHTML = $this->loadData($urlVies);

        $ViesOk = 'YES, VALID VAT NUMBER';

        $ViesEr = 'NO, INVALID VAT NUMBER';

        if (!$DataHTML) {
            return false;
        }

        $DataHTML = '#' . mb_strtoupper($DataHTML);

        return ((mb_strpos($DataHTML, 'REQUEST TIME-OUT') > 0) or (mb_strpos($DataHTML, $ViesOk) > 0)) ? true : false;
    }

    //end function

    /**
     * Check a VAT number against the VIES database
     *
     * @param string $vatno Full VAT number to check including country prefix
     * @return bool. True if VAT number is OK else False
     */
    public function check($vatno)
    {
        $vatno = str_replace(' ', '', mb_strtoupper($vatno));

        if ($this->checkStructure($vatno)) {
            return $this->checkMSVAT($vatno);
        }

        return false;
    }
}//end class EuVat
