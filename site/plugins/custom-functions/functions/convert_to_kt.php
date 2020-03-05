<?php

// Kirbytags
function convert_to_kt($array) {
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $array[$key] = convert_to_kt($value);
        } else {
            $array[$key] = kirbytags($value);
        }
    }
    return $array;
};
