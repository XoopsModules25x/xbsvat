<?php declare(strict_types=1);

namespace XoopsModules\Xbsvat;

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
 * @package       EUVAT
 * @subpackage    EuVat
 * @copyright (c) 2004, Ashley Kitson
 * @copyright     XOOPS Project https://xoops.org/
 * @license       GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author        Ashley Kitson http://akitson.bbcb.co.uk
 * @author        XOOPS Development Team
 */

use XoopsModules\Xbscdm;

/**
 * Object handler for EuVat
 *
 * @package    EUVAT
 * @subpackage EuVat
 */
class EuVatHandler extends Xbscdm\CodeHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db Handle to database object
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db); //call ancestor constructor

        $this->classname = EuVat::class;

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
