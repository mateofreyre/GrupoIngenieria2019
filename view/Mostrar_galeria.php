<?php
class Mostrar_galeria extends TwigView {

  public function show($fotos) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("mostrar_galeria.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'fotos' => $fotos));
    }

}
?>
