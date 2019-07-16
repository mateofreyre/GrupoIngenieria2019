<?php
class Detalle_hotSale extends TwigView {

  public function show($hot_sale, $usuario) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("detalle_hotSales.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'hot_sale' => $hot_sale, 'usuario' => $usuario));
    }

}
?>
