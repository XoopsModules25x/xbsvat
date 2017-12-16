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
// Copyright: (c) 2005, Ashley Kitson										 //
// URL:       http://xoobs.net                                               //
// Project:   The XOOPS Project (http://www.xoops.org/)                      //
// Module:    EU VAT (EUVAT)                                                 //
// ------------------------------------------------------------------------- //

/**
* Installation callback functions 
*
* Functions called during the module installation, update or delete process
*
* @author Ashley Kitson http://xoobs.net
* @copyright 2005 Ashley Kitson, UK
* @package EUVAT
* @subpackage Installation
* @access private
* @version 1
*/

/**
* Function: Module Update callback 
*
* Called during update process to alter data table structure or values in tables	
*
* @version 1
* @param xoopsModule &$module handle to the module object being updated
* @param int $oldVersion version * 100 prior to update
* @return boolean True if successful else False 
*/
function xoops_module_update_xbs_vat(&$module,$oldVersion) {
  global $xoopsDB;
  return true;
}//end function

/**
* Function: Module Install callback 
*
* The basic SQL install is done via the SQL script but we also need to check that CDM is installed.
* This really needs to be called before the main module install but
* as at Xoops 2.0.10 this is not possible.  This will not be called
* until Xoops allows a pre process install script.  IF CDM is not
* present the main install process will fall over because cdm tables
* are not available.
*
* @version 1
* @param xoopsModule &$module Handle to module object being installed
* @return boolean True if successful else False 
*/
function xoops_module_install_xbs_vat(&$module) {
//The basic SQL install is done via the SQL script
// but we also need to check that CDM is installed
// This really needs to be called before the main module install but
// as at Xoops 2.0.10 this is not possible.  This will not be called
// until Xoops allows a pre process install script.  IF CDM is not
// present the main install process will fall over because cdm tables
// are not available.
  global $xoopsDB;
  $sql = "select 1 from ".$xoopsDB->prefix('modules')." where dirname = 'xbs_cdm' and isactive = 1";
  return ($result = $xoopsDB->queryF($sql));
}//end function

/**
* Function: Module deletion callback 
*
* SACC tables are deleted via the Xoops uninstaller
* but we need to remove SACC entries in the CDM tables
*
* @version 1
* @param xoopsModule &$module Handle to module object being installed
* @return boolean True if successful else False 
*/
function xoops_module_uninstall_xbs_vat(&$module) {
  global $xoopsDB;
  $sql1 = "delete from ".$xoopsDB->prefix(cdm_code)." where cd_set = 'EUVAT'";
  $sql2 = "delete from ".$xoopsDB->prefix(cdm_meta)." where cd_set = 'EUVAT'";
  $ret1 = ($result = $xoopsDB->queryF($sql1));
  $ret2 = ($result = $xoopsDB->queryF($sql2));
  if (!($ret1 && $ret2)) {
    $module->setErrors('Unable to remove EUVAT data from CDM tables whilst uninstalling EU VAT module');
    return false;
  }
return true;
}//end function




?>