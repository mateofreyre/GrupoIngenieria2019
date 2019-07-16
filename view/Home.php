<?php
class Home extends TwigView {

  public function show($usuario) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("inicio_sesion.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'usuario' => $usuario));
    }

}
?>
