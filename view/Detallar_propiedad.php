<?php
class Detallar_propiedades extends TwigView {

  public function show($propiedades) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("detallar_propiedades.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'propiedades' => $propiedades));
    }

}
?>
