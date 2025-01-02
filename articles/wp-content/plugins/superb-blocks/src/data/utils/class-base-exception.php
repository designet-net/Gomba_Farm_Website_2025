<?php

namespace SuperbAddons\Data\Utils;

defined('ABSPATH') || exit();

use Exception;
use SuperbAddons\Data\Controllers\LogController;

class BaseException extends Exception
{
    public function __construct($message, $ignore_log = false, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        if ($ignore_log) return;

        LogController::HandleException($this);
    }
}
