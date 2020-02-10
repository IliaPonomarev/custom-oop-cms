<?php

namespace modules\core;

use modules\DB\DB;

/**
 * Class MModel
 * @package modules\core
 */
class MModel
{
    protected $DB;

    public function __construct()
    {
        $this->DB = new DB();
    }
}