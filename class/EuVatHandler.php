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
// Copyright: (c) 2004, Ashley Kitson
// URL:       http://xoobs.net                                               //
// Project:   The XOOPS Project (https://xoops.org/)                      //
// Module:    EU VAT (EUVAT)                                                 //
// ------------------------------------------------------------------------- //
/**
 * @package       EUVAT
 * @subpackage    EuVat
 * @author        Ashley Kitson http://xoobs.net
 * @copyright (c) 2004 Ashley Kitson, Great Britain
 */


/**
 * Object handler for EuVat
 *
 * @package    EUVAT
 * @subpackage EuVat
 */
class EuVatHandler extends Xbs_CdmCDMCodeHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db Handle to database object
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db); //call ancestor constructor

        $this->classname = 'euvat';

        $this->ins_tagname = 'uevat_ins_code';
    }

    /**
     * Create a new EuVat object
     *
     * @access private
     */
    public function _create()
    {
        return new EuVat();
    }
    //end function _create
} //end class CDMCodeHandler