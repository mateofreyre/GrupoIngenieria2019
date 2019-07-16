<?php
class Listar_subastas extends TwigView {

  public function show($subastas, $usuario) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("listar_subastas.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'subastas' => $subastas, 'usuario' => $usuario));
    }

}
?>
