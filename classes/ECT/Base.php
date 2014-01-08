<?php defined('SYSPATH') OR die('No direct script access.');

class ECT_Base{

    public function set($var, $value){
        $this->$var = $value;
        return $this;
    }

    public function get($var){
        return $this->$var;
    }

}
