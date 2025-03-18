<?php

class Cabecera {
  private $titulo;

  public function __construct($texto1) {
    $this->titulo = $texto1;
  }

  public function graficar(){
    echo '<h1 style="color: red; text-align:center">"'.$this->titulo.'"</h1>';
  }
}

class Cuerpo {
  private $lineas = array();

  public function insertar_parrafo($texto) {
    $this->lineas[] = $texto;
  }

  public function graficar() {
    for ($i = 0; $i < count($this->lineas); $i++) {
        echo '<p style="text-align:center">"' . $this->lineas[$i] . '"</p>';
        echo '<br>'; 
    }
  }

}

class Pie {
  private $mensaje;

  public function __construct($texto2) {
    $this->mensaje = $texto2;
  }

  public function graficar() {
    echo '<h4 style="color: blue; text-align:center">"'.$this->mensaje.'"</h4>';
  }
}

class Pagina {
  private $cabecera;
  private $cuerpo;
  private $pie;

  public function __construct($texto1, $texto2) {
    $this->cabecera = new Cabecera($texto1);
    $this->cuerpo = new Cuerpo;
    $this->pie = new Pie($texto2);
  }

  public function insertar_cuerpo($texto) {
    $this->cuerpo->insertar_parrafo($texto);
  }

  public function graficar() {
    $this->cabecera->graficar();
    $this->cuerpo->graficar();
    $this->pie->graficar();
  }
}


/*
* Implementar las clases Cabecera, Cuerpo y Pie

* 1. La clase Cabecera tiene las siguientes características
    > Tiene un constructor que recibe un texto e inicializa    un atributo de nombre
*/
?>