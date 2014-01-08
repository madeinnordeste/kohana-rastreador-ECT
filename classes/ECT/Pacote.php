<?php defined('SYSPATH') OR die('No direct script access.');

class ECT_Pacote extends ECT_Base{

    protected $numero;
    protected $json;
    protected $json_md5;
    protected $eventos;

    public function __construct($numero=NULL){
        $this->numero = $numero;
    }

    public function numero(){
        return $this->numero;
    }

    public function md5(){
        return $this->json_md5;
    }

    public function importar_json_eventos($json){
        $this->json = $json;
        $this->json_md5 = md5($json);
        $this->eventos = json_decode($json);
    }

    public function eventos(){
        return $this->eventos;
    }

    public function evento($index=0){
        return isset($this->eventos[$index]) ? $this->eventos[$index] : NULL;
    }

    public function ultimo_evento(){
        return $this->evento(0);
    }

    public function primeiro_evento(){
        return $this->evento( (sizeof($this->eventos) - 1) );

    }

}
