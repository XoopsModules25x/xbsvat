<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
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
// Project:   The XOOPS Project (http://www.xoops.org/)                      //
// Module:    EU VAT (EUVAT)                                                 //
// Credits:	  Benjamin Boigienman (boigien at free.fr)                       //
//            For supplying the original code on which this module is based  //
//            The original code can be found at http://www.phpclasses.org    //
// ------------------------------------------------------------------------- //
/** 
 * Base classes used by EU VAT system
 * 
 * Credits:	  Benjamin Boigienman (boigien at free.fr) For supplying the 
 * original code on which this module is based. The original code can be 
 * found at http://www.phpclasses.org
 *
 * @package EUVAT
 * @subpackage EUVATBase
 * @author Ashley Kitson http://xoobs.net. 
 * @copyright (c) 2005 Parts - Ashley Kitson, Great Britain.  Parts - Benjamin Boigienman, France
 * @tutorial EUVAT/EUVat/EUVAT.pkg
*/

/**
* Base VAT handling objects are derived from Code Data Management base objects
*/
require_once XOOPS_ROOT_PATH."/modules/xbs_cdm/class/class.cdm.base.php";


/**
 * VAT object
 *
 * @package  EUVAT
 * @subpackage EUVat
 * @version 1
 */
class EUVat extends CDMCode {
	
	/**
	 * Check that the VAT number is in the correct format
	 *
	 * @param string $vatno EU VAT number in full format with country prefix
	 * @return boolean. True if OK else False
	 * @access private
	 */
	function checkStructure($vatno){
		//check to see that first two characters are ALPHA and that they match
		//the cd field of this code
		if((ereg("^([A-Z]{2})", $vatno, $regs)) && ($regs[1]==$this->getVar('cd'))) {
			//strip out first two characters
			$vatno = substr($vatno, 2);
			//Get the format masks for the VAT code
			$vmask = $this->getVar('cd_param');
			$vatmask = explode('~',$vmask);
			foreach($vatmask as $mask){
				if(ereg($mask, $vatno))
					return true;
			}	
		}
		return false;
	}//end function

	/**
	 * Support function to check VAT number against VIES database
	 *
	 * @param URLString $url
	 * @return mixed. Returned data if success else False
	 * @access private
	 */
	function loadData($url){
		$url = parse_url($url);
	
		if(!in_array($url['scheme'],array('','http')))
		return false;
	
		$fp = fsockopen ($url['host'], ($url['port'] > 0 ? $url['port'] : 80), $errno, $errstr, 2);
		if (!$fp){
			return False;
		}
		else{
			fputs ($fp, "GET ".$url['path']. (isSet($url['query']) ? '?'.$url['query'] : '')." HTTP/1.0\r\n");
			fputs ($fp, "Host: ".$url['host']."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");   			
	
			$data = "";
			stream_set_blocking($fp,false);
			stream_set_timeout($fp, 4);			
			$status = socket_get_status($fp);
			while(!feof($fp) && !$status['timed_out']) {
	   			$data .= fgets($fp, 1000);
	   			$status = socket_get_status($fp);       			
			}
	
			if ( $status['timed_out'] ) 
				return false;
	   		fclose ($fp);
	   		return $data;
		}
	}//end function

	/**
	 * Check the VAT number against the VIES database
	 *
	 * @param string $vatno EU VAT number in full format with country prefix
	 * @return boolean. True if OK else False
	 * @access private
	 */
	function checkMSVAT($vatno){
		$ViesMS = strtoupper(substr($vatno, 0, 2));
		$vatno = substr($vatno, 2);		
		$ViesURL = "http://www.europa.eu.int:80/comm/taxation_customs/vies/cgi-bin/viesquer/?VAT=%s&MS=%s&Lang=EN";
		$urlVies = sprintf($ViesURL,$vatno,$ViesMS);
		$DataHTML = $this->loadData($urlVies);
		$ViesOk	= 'YES, VALID VAT NUMBER';
		$ViesEr	= 'NO, INVALID VAT NUMBER';
	
		if (!$DataHTML)
			return false;
		else{
			$DataHTML = '#' . strToUpper($DataHTML);
			return ((strPos($DataHTML,'REQUEST TIME-OUT') > 0) OR (strPos($DataHTML,$ViesOk) > 0)) ? true : false;
		} 
	}//end function
	
	/**
	 * Check a VAT number against the VIES database
	 *
	 * @param string $vatno Full VAT number to check including country prefix
	 * @return boolean. True if VAT number is OK else False
	 */
	function check($vatno){
		$vatno = str_replace(" ", "", strtoupper($vatno));
		if($this->checkStructure($vatno)){
			return $this->checkMSVAT($vatno);
		}
		return false;
	}
	
}//end class EUVat


?>