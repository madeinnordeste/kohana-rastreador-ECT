<?php defined('SYSPATH') OR die('No direct script access.');

class ECT_Rastreador extends ECT_Base{

    protected $pacotes = array();//max 50

     /**
     * Adiciona pacotes ao rastreador
     * @param  $pacotes  Array com objetos ECT_Pacote ou um só objeto ECT_Pacote
     * @return $this
     **/
    public function __construct($pacotes = array()){

        if(!is_array($pacotes)){
            $pacotes = array($pacotes);
        }

        $this->add_pacote($pacotes);

        return $this;
    }

    /**
     * Adiciona pacotes ao rastreador
     * @param  $pacotes  Array com objetos ECT_Pacote ou um só objeto ECT_Pacote
     * @return $this
     **/
    public function add_pacote($pacotes = array()){

        if(!is_array($pacotes)){
            $pacotes = array($packages->get('numero') => $pacotes);
        }else{
            $lista = array();
            foreach($pacotes as $pacote){
                $lista[$pacote->get('numero')] = $pacote;
            }
            $pacotes = $lista;
        }

        $this->pacotes = Arr::merge($this->pacotes, $pacotes);

        return $this;

    }


    /**
     * Consulta os eventos dos pacotes
     *
     * @return void
     * @author
     * Tipo:
     *     L: lista de objetos. O servidor fara a consulta individual
     *        de cada identificador informado;
     *     F: intervalo de objetos. O servidor fara a consulta sequencial
     *        do primeiro ao ultimo objeto informado, nao sendo necessario
     *        informar os valores intermediarios.
     *
     * Resultado:
     *    T: serão retornados todos os eventos do objeto;
     *    U: será retornado apenas o último evento do objeto.
     **/
    public function consultar(){

        $numeros = array_keys($this->pacotes);
        $numeros = implode('', $numeros);

        //faz a consulta no webservice dos Correios
        $config = $config = Kohana::$config->load('rastreadorect');
        $url = $config->webservice;

        $request = Request::factory($url)
            ->method('POST')
            ->post('Usuario', $config->usuario)
            ->post('Senha', $config->senha)
            ->post('Tipo', 'L')
            ->post('Resultado', 'T')
            ->post('Objetos', $numeros);

        $response = $request->execute();

        if( 200 == $response->status() ){
            $xml = $response->body();
            $this->processar($xml);
        }

    }


    /**
     * Processa o XML retornado pelo webservice
     *
     * @return void
     * @author
     **/
    private function processar($xml){

        $data = (array)simplexml_load_string($xml);

        //se houverem objetos
        if( isset($data['objeto']) ){

            //percorre os objetos
            foreach ($data['objeto'] as $pacote){

                $pacote = (array)$pacote;

                $pacote_atual = $this->pacotes[(string)$pacote['numero']];

                //se houverem eventos
                if( isset($pacote['evento']) ){

                    $pacote_atual->importar_json_eventos( json_encode($pacote['evento']) );

                }


            }

        }

    }


    /**
     * Retorna a lista de pacotes do  rastreador
     *
     * @return array
     **/
    public function pacotes(){

        return $this->pacotes;

    }



}
