<?php

namespace App\Utils;

require 'rb.php';

use R;

class Database {

    public static function setup() {
        R::setup('sqlite:../database.db');
    }

    public static function deleteAll($key) {
        R::wipe($key);
    }

    public static function destroy() {
        R::nuke();
    }

    public static function get($key) {
        $item = R::find($key);

        if(!count($item)) {
            return NULL;
        }

        return (array) json_decode($item[1]->data, TRUE);
    }

    public static function save($key, $value) {
        $data = R::load($key, 1);
        $data->data = json_encode($value);
        R::store($data);
    }

}