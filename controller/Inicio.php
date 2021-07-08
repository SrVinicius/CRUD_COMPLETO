<?php
class Inicio
{
  public function controller()
  {
    $inicio = new Template("view/inicio.html");
    $inicio->set("nome", "Vinícius");
    $retorno["msg"] = $inicio->saida();
    return $retorno;
  }
}
