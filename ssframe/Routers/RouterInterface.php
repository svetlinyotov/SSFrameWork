<?php

/**
 *
 * All routers interface
 *
 * PHP version 5.6
 *
 * @package   SSFrame
 * @file      Routes/Route.php
 * @version   Release: 0.5
 * @author    Svetlin Yotov <svetlin.yotov@gmail.com>
 * @copyright 2015 SiSDevelop
 * @link      http://sisdevelop.com
 */

namespace SSFrame\Routers;


interface RouterInterface {
    public function getURI();

    public function getPost();

}