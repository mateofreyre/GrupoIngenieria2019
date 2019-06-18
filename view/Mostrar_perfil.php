<?php
class Mostrar_Perfil extends TwigView {

  public function show($usuario) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("mostrar_perfil.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'usuario' => $usuario));
    }

}
?>
