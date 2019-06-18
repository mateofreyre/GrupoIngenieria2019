<?php
class Mostrar_pagina_premium extends TwigView {

  public function show() {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("Mostrar_pagina_premium.html.twig");
      $template->display(array('rol' => $_SESSION['rol']));
    }

}
?>
