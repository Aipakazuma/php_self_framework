<?php

/**
 * Description of Router
 *
 * @author aipa
 */
class Router {

  protected $routes;

  public function __construct($definitions) {
    $this->routes = $this->compileRoutes($definitions);
  }

  /**
   * routing定義配列を取得
   * @param type $definitions
   * @return type
   */
  public function compileRoutes($definitions) {
    $routes = array();
    foreach($definitions as $url => $params) {
      $tokens = explode('/', ltrim($url, '/'));
      foreach($tokens as $i => $token) {
        if (0 === strpos($token, ':')) {
          $name  = substr($token, 1);
          $token = '(?P<' . $name . '>[^/]+)';
        }
        $tokens[$i] = $token;
      }
      $pattern = '/' . implode('/', $tokens);
      $routes[$pattern] = $params;
    }
    return $routes;
  }

  /**
   * マッチングを行う
   * @param string $pathInfo
   * @return boolean
   */
  public function resolve($pathInfo) {
    if ('/' !== substr($pathInfo, 0, 1)) {
      $pathInfo = '/' . $pathInfo;
    }

    foreach($this->routes as $pattern => $params) {
      if (preg_match('#^' . $pattern . '$#', $pathInfo, $matches)) {
        $params = array_merge($params, $matches);
        return $params;
      }
    }
    return false;
  }
}
