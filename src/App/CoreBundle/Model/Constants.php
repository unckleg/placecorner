<?php

namespace App\CoreBundle\Model;

interface Constants
{
    const DEFAULT_LOCALE = 'en';
    const DELETE_STRING  = 'delete';
    const IS_DELETED     = 1;
    const IS_ACTIVE      = 0;
    const STATUS_ACTIVE  = 1;
    const STATUS_HIDDEN  = 0;

    /**
     * Child/Parent constants user for Category/Subcategory Module
     */
    const PARENT         = 0;
    const CHILD          = 1;
}