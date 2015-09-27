<?php
/**
 * Created by PhpStorm.
 * User: Svetlin
 * Date: 9/27/2015
 * Time: 11:52 PM
 */

namespace SSFrame\Facades;


class Redirect
{
    /**
     * @param $path
     * @return $this
     * @var \SSFrame\Redirect
     */
    public static function to($path)
    {
        return \SSFrame\Redirect::getInstance()->to($path);
    }

}