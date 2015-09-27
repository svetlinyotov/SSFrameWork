<?php

namespace SSFrame;


class Form
{
    public static function open($action, $method = "GET", Array $params=[], $file = false)
    {
        $params_list = self::parseAttributes($params);
        $action = self::normalize($action);
        $method = self::normalize($method);

        if($file == true){
            $params_list .= " enctype=\"multipart/form-data\"";
        }

        echo "<form action=\"$action\" method=\"".$method."\" $params_list>\n";
    }

    public static function label($for, $value, Array $params=[])
    {
        $for = self::normalize($for);
        $value = self::normalize($value);
        $params_list = self::parseAttributes($params);
        echo "<label for=\"$for\" $params_list>$value</label>\n";
    }

    public static function text($name, $value=null, Array $params=[])
    {
        $name = self::normalize($name);
        $value = self::normalize($value);
        $params_list = self::parseAttributes($params);
        echo "<input type=\"text\" name=\"$name\" $params_list value=\"$value\">\n";
    }

    public static function hidden($name, $value=null, Array $params=[])
    {
        $name = self::normalize($name);
        $value = self::normalize($value);
        $params_list = self::parseAttributes($params);
        echo "<input type=\"hidden\" name=\"$name\" $params_list value=\"$value\">\n";
    }

    public static function textarea($name, $value=null, Array $params=[])
    {
        $name = self::normalize($name);
        $value = self::normalize($value);
        $params_list = self::parseAttributes($params);
        echo "<textarea name=\"$name\" $params_list>$value</textarea>\n";
    }

    public static function password($name, Array $params=[])
    {
        $name = self::normalize($name);
        $params_list = self::parseAttributes($params);
        echo "<input type=\"password\" name=\"$name\" $params_list>\n";
    }

    public static function email($name, $value=null, Array $params=[])
    {
        $name = self::normalize($name);
        $value = self::normalize($value);
        $params_list = self::parseAttributes($params);
        echo "<input type=\"email\" name=\"$name\" $params_list value=\"$value\">\n";
    }

    public static function number($name, $value=null, $min=null, $max=null, Array $params=[])
    {
        $name = self::normalize($name);
        $value = self::normalize($value);
        $min = self::normalize($min);
        $max = self::normalize($max);
        $params_list = self::parseAttributes($params);
        echo "<input type=\"number\" name=\"$name\" min=\"$min\" max=\"$max\" $params_list value=\"$value\">\n";
    }

    public static function date($name, $value="today", Array $params=[])
    {
        $name = self::normalize($name);
        $value = self::normalize($value);
        if($value=="today"){
            $value = date("Y-m-d");
        }

        $params_list = self::parseAttributes($params);
        echo "<input type=\"date\" name=\"$name\" $params_list value=\"$value\">\n";
    }


    public static function file($name, Array $attributes=[])
    {
        $name = self::normalize($name);
        $params_list = self::parseAttributes($attributes);
        echo "<input type=\"file\" name=\"$name\" $params_list>\n";
    }

    public static function checkbox($name, $value, $isChecked = false, Array $params=[])
    {
        $name = self::normalize($name);
        $value = self::normalize($value);
        $checked = $isChecked == true?"checked":"";

        $params_list = self::parseAttributes($params);
        echo "<input type=\"checkbox\" name=\"$name\" $params_list value=\"$value\" $checked>\n";
    }

    public static function radio($name, $value, $isChecked = false, Array $params=[])
    {
        $name = self::normalize($name);
        $value = self::normalize($value);
        $checked = $isChecked == true?"checked":"";

        $params_list = self::parseAttributes($params);
        echo "<input type=\"radio\" name=\"$name\" $params_list value=\"$value\" $checked>\n";
    }

    public static function select($name, Array $options = [], $defaultOption = null, Array $params=[])
    {
        $name = self::normalize($name);
        $params_list = self::parseAttributes($params);

        echo "<select name=\"$name\" $params_list>\n";
        foreach ($options as $value=>$option) {
            $value = self::normalize($value);

            if(!is_array($option)) {
                $option = self::normalize($option);
                $selected = $defaultOption == $value ? "selected" : "";

                echo "\t<option value=\"$value\" $selected>$option</option>\n";
            }else{
                echo "\t<optgroup label=\"$value\">\n";
                foreach ($option as $_value => $_option) {
                    $_value = self::normalize($_value);
                    $_option = self::normalize($_option);
                    $_selected = $defaultOption == $_value ? "selected" : "";
                    echo "\t\t<option value=\"$_value\" $_selected>$_option</option>\n";
                }
                echo "\t</optgroup>\n";
            }
        }

        echo "</select>\n";
    }

    public static function selectRange($name, $min, $max, $defaultOption = null, $step = null, Array $params=[])
    {
        $name = self::normalize($name);
        $min = (int)self::normalize($min);
        $max = (int)self::normalize($max);
        if($step != null){
            $step = (int)self::normalize($step);
        }else{
            $step = 1;
        }
        $params_list = self::parseAttributes($params);

        echo "<select name=\"$name\" $params_list>\n";
        for ($i = $min;$i <= $max; $i+=$step) {
            $selected = $defaultOption == $i ? "selected" : "";

            echo "\t<option value=\"$i\" $selected>$i</option>\n";
        }

        echo "</select>\n";
    }

    public static function selectMonth($name, $defaultOption = null, Array $params=[])
    {
        $name = self::normalize($name);
        $monthsArr = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        $monthsArr = array_combine(range(1, count($monthsArr)), array_values($monthsArr));

        $params_list = self::parseAttributes($params);

        echo "<select name=\"$name\" $params_list>\n";
        foreach ($monthsArr as $key => $month) {
            $selected = $defaultOption == $key ? "selected" : "";

            echo "\t<option value=\"$key\" $selected>$month</option>\n";
        }

        echo "</select>\n";
    }

    public static function submit($name, $value=null, Array $params=[])
    {
        $name = self::normalize($name);
        $value = self::normalize($value);
        $params_list = self::parseAttributes($params);

        echo "<input type=\"submit\" name=\"$name\" $params_list value=\"$value\">\n";
    }

    public static function button($name, $value=null, Array $params=[])
    {
        $name = self::normalize($name);
        $value = self::normalize($value);
        $params_list = self::parseAttributes($params);

        echo "<button name=\"$name\" $params_list>$value</button>\n";
    }

    public static function close()
    {
        echo "</form>\n";
    }

    private static function normalize($var){
        return trim(stripcslashes(htmlspecialchars($var)));
    }
    private static function parseAttributes(Array $params)
    {
        $params_list = "";

        foreach ($params as $param => $value) {
            $param = trim(stripcslashes(htmlspecialchars($param)));
            $value = trim(stripcslashes(htmlspecialchars($value)));
            $params_list .= " $param=\"$value\"";
        }

        return $params_list;
    }
}