<?php

namespace SSFrame;


class Hash
{
    public static function make($password)
    {
        $cost = (int)config("auth.password_hash_cost");
        if($cost < 1 || $cost > 12){
            $cost = 10;
        }

        return password_hash($password, PASSWORD_BCRYPT, ['cost' => $cost]);
    }

    public static function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }

}