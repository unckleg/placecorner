<?php

namespace App\CoreBundle\Service\Validator;


interface Constants
{
    const NOT_VALID   = 'Provided data is not type of %s.';
    const VALID       = 'valid';
    const IS_STRING   = 'is_string';
	const IS_ARRAY    = 'is_array';
	const IS_NUMERIC  = 'is_numeric';
	const IS_BOOLEAN  = 'is_boolean';
	const IS_FILE     = 'is_file';
	const IS_DIR      = 'is_dir';
}