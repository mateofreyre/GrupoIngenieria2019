<?php
class Listar_hotSales extends TwigView {

  public function show($hot_sales, $usuario) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("listar_hotSales.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'hot_sales' => $hot_sales, 'usuario' => $usuario));
    }

}
?>
