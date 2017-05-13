<?php

namespace App\CoreBundle\Model;

interface Constants
{
    const DEFAULT_LOCALE = 'en';
    const DELETE_STRING  = 'delete';
    const TYPE_JSON      = 'json';
    const TYPE_ARRAY     = 'array';

    const PLACE_FEATURED = 1;
    const PLACE_NOT_FEAT = 0;

    const CITY_POPULAR   = 1;

    const IS_DELETED     = 1;
    const IS_ACTIVE      = 0;
    const STATUS_ACTIVE  = 1;
    const STATUS_HIDDEN  = 0;
    const PARENT         = 0;
    const CHILD          = 1;
}