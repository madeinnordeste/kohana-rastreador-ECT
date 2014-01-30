# kohana-rastreador-ECT

Módulo Kohana para rastreamento de pacotes nos Correios (ECT)

**Autor:** Luiz Alberto

**URL:** https://github.com/madeinnordeste/kohana-rastreador-ECT


	Kohana version: 3.3.1

Mais informacoes sobre o Webservice dos Correios em docs/Guia-Tecnico-Rastreamento-XML-Cliente-Versão-e-commerce-v-1-5.pdf


##Limites

* O usuario ECT e senha SRO limitam-se a dois objetos por cosulta, outros usuários podem ser obtidos através de contratocom os Correios;
* O número máximo de pacotes por consulta é 50.

##Classes

### ECT_Pacote

Objeto pacote, usado pelo rastreador para realizar a consulta dos eventos. 

####- __construct($numero)

	$pacote = new ECT_Pacote('SW614400906BR');

####- numero()

Retorna o numero do pacote
	
	$pacote = new ECT_Pacote('SW614400906BR');
	echo $pacote->numero(); //SW614400906BR

#### -md5()

Retorna o hash md5 dos eventos do pacote
	
	$pacote = new ECT_Pacote('SW614400906BR');
	echo $pacote->md5(); //d5ea9cd04fe80f8fb778ad06fabefc5e



####- eventos()

Retorna um array com a lista de eventos do objeto, se existir

Exemplo de retorno:
	
	array(2) (
	    0 => object stdClass(13) {
	        public tipo => string(3) "BDE"
	        public status => string(2) "01"
	        public data => string(10) "24/12/2013"
	        public hora => string(5) "14:51"
	        public descricao => string(8) "Entregue"
	        public recebedor => object stdClass(0) {
	        }
	        public documento => object stdClass(0) {
	        }
	        public comentario => object stdClass(0) {
	        }
	        public local => string(23) "CEE VILA SANTA CATARINA"
	        public codigo => string(8) "04368970"
	        public cidade => string(9) "SAO PAULO"
	        public uf => string(2) "SP"
	        public sto => string(8) "72651300"
	    }
	    1 => object stdClass(10) {
	        public tipo => string(3) "OEC"
	        public status => string(2) "01"
	        public data => string(10) "24/12/2013"
	        public hora => string(5) "09:51"
	        public descricao => string(34) "Saiu para entrega ao destinatário"
	        public local => string(23) "CEE VILA SANTA CATARINA"
	        public codigo => string(8) "04368970"
	        public cidade => string(9) "SAO PAULO"
	        public uf => string(2) "SP"
	        public sto => string(8) "72651300"
	    }
    )

####- evento($index=0)

Retorna o evento com $index do objeto, se existir

Exemplo de retorno:
	
	object stdClass(13) {
	    public tipo => string(3) "BDE"
	    public status => string(2) "01"
	    public data => string(10) "24/12/2013"
	    public hora => string(5) "14:51"
	    public descricao => string(8) "Entregue"
	    public recebedor => object stdClass(0) {}
	    public documento => object stdClass(0) {}
	    public comentario => object stdClass(0) {}
	    public local => string(23) "CEE VILA SANTA CATARINA"
	    public codigo => string(8) "04368970"
	    public cidade => string(9) "SAO PAULO"
	    public uf => string(2) "SP"
	    public sto => string(8) "72651300"
	}

####- ultimo_evento()

Retorna o último evento do pacote, se existir

####- primeiro_evento()

Retorna o primeiro evento do pacote, se existir

### ECT_Rastreador

Objeto rastreador de pacotes

####- __counstruct($pacotes)

Adicionar um pacote através do construtor:

	$pacote1 = new ECT_Pacote('SW614400906BR');
	$rastreador = new ECT_Rastreador($pacote1);

Adicionar uma lista de pacotes através do construtor:

	$pacote1 = new ECT_Pacote('SW614400906BR');
	$pacote2 = new ECT_Pacote('SW624400906BR');
	$pacote3 = new ECT_Pacote('SW634400906BR');
	$pacotes = array($pacote1, $pacote2, $pacote3);
	$rastreador = new ECT_Rastreador($pacotes);


####- add_pacote($pacotes = array())

Adiciona um objeto ECT_Pacote ao rastreador ou um array contendo objetos ECT_Pacotes

Adicionar um pacote:
	
	$pacote = new ECT_Pacote('SW614400906BR');
	$rastreador = new ECT_Rastreador;
	$rastreador->add_pacote($pacote);

Adicionar uma lista de pacotes:
	
	$pacote = new ECT_Pacote('SW614400906BR');
	$pacote2 = new ECT_Pacote('SW624400906BR');
	$pacote3 = new ECT_Pacote('SW634400906BR');
	$pacotes = array($pacote1, $pacote2, $pacote3);
	$rastreador = new ECT_Rastreador;
	$rastreador->add_pacote($pacotes);


####- consultar()

Realiza a consulta dos eventos do(s) pacotes contidos no rastreador. Insere esses eventos em cada pacote.

	$pacote = new ECT_Pacote('SW614400906BR');
	$rastreador = new ECT_Rastreador($pacote);	
	$rastreador->consultar();

####- pacotes()

Retorna uma lista (Array) com os pacotes contidos no  rastreador

	$pacote = new ECT_Pacote('SW614400906BR');
	$rastreador = new ECT_Rastreador($pacote);	
	$rastreador->consultar();
	$pacotes = $rastreador->pacotes();

Exemplo de retorno:

	array(2) (
	    "SW914400906BR" => object ECT_Pacote(4) {
	        protected numero => string(13) "SW914400906BR"
	        protected json => string(1547) "[{"tipo":"BDE",…"
	        protected json_md5 => string(32) "d5ea9cd04fe80f8fb778ad06fabefc5e"
	        protected eventos => array(6) (
	            0 => object stdClass(13) {
	                public tipo => string(3) "BDE"
	                public status => string(2) "01"
	                public data => string(10) "24/12/2013"
	                public hora => string(5) "14:51"
	                public descricao => string(8) "Entregue"
	                public recebedor => object stdClass(0) {
	                }
	                public documento => object stdClass(0) {
	                }
	                public comentario => object stdClass(0) {
	                }
	                public local => string(23) "CEE VILA SANTA CATARINA"
	                public codigo => string(8) "04368970"
	                public cidade => string(9) "SAO PAULO"
	                public uf => string(2) "SP"
	                public sto => string(8) "72651300"
	            }
	        )
	    }
	    "SW914401331BR" => object ECT_Pacote(4) {
	        protected numero => string(13) "SW914401331BR"
	        protected json => string(1548) "[{"tipo":"BDE" …"
	        protected json_md5 => string(32) "7173e94c3f23bb80fb95ed9a14778f11"
	        protected eventos => array(6) (
	            0 => object stdClass(13) {
	                public tipo => string(3) "BDE"
	                public status => string(2) "01"
	                public data => string(10) "24/12/2013"
	                public hora => string(5) "17:28"
	                public descricao => string(8) "Entregue"
	                public recebedor => object stdClass(0) {
	                }
	                public documento => object stdClass(0) {
	                }
	                public comentario => object stdClass(0) {
	                }
	                public local => string(12) "CDD BARREIRO"
	                public codigo => string(8) "30647970"
	                public cidade => string(14) "BELO HORIZONTE"
	                public uf => string(2) "MG"
	                public sto => string(8) "20420005"
	            }
	        )
	    }
	)



##Exemplo completo

Realizar a consulta de dois pacotes:

	$pacote1 = new ECT_Pacote('SW614400906BR');
    $pacote2 = new ECT_Pacote('SW614401331BR');
    $pacotes = array($pacote, $pacote2);
    
    $rastreador = new ECT_Rastreador($pacotes);
    
    $rastreador->consultar();
    
    $lista_de_pacotes = $rastreador->pacotes();
    
    //percorre todos os pacotes
    foreach($lista_de_pacotes as $pacote){
    	
    	//numero do pacote
    	echo Debug::vars($pacote->numero());
    	
    	//hash md5 dos eventos do pacote
    	echo Debug::vars($pacote->numero());
    	
    	//ultimo evento do pacote
    	echo Debug::vars($pacote->ultimo_evento());
    	
    	//primeiro evento do pacote
    	echo Debug::vars($pacote->primeiro_evento());
    	
    	//eventos do pacote
    	echo Debug::vars($pacote->eventos());
    	
    	//penultimo evento do pacote
    	echo Debug::vars($pacote->evento(1));
    
    }
    


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/madeinnordeste/kohana-rastreador-ect/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

