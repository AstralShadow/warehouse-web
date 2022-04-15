<?php
namespace Extend;

function isValidString(&$input, $minLen = 0) : bool
{
    return isset($input)
        && is_string($input)
        && mb_strlen(trim($input)) >= $minLen;
}

