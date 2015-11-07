<?php

class Request {

  /**
   * HTTP MethodがPostか判定する
   * @return boolean
   */
  public function isPost() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      return true;
    }
    return false;
  }

  /**
   * Getの値を取得する 
   * @param type $name
   * @param type $default
   * @return type
   */
  public function getGet($name, $default = null) {
    if (isset($_GET[$name])) {
      return $_GET[$name];
    }
    return $default;
  }

  /**
   * Postの値を取得する
   * @param type $name
   * @param type $default
   * @return type
   */
  public function getPost($name, $default = null) {
    if (isset($_POST[$name])) {
      return $_POST[$name];
    }
    return $default;
  }

  /**
   * サーバのホスト名を取得する
   * @return type
   */
  public function getHost() {
    if (!empty($_SERVER['HTTP_HOST'])) {
      return $_SERVER['HTTP_HOST'];
    }
    return $_SERVER['SERVER_NAME'];
  }

  /**
   * HTTPSのアクセスか判定
   * @return boolean
   */
  public function isSsl() {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
      return true;
    }
  }

  /**
   * URIを取得
   * @return type
   */
  public function getRequestUri() {
    return $_SERVER['REQUEST_URI'];
  }

  /**
   * ベースURLを取得
   * @return string
   */
  public function getBaseUrl() {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $requestUri = $this->getRequestUri();

    if (0 === strpos($requestUri, $scriptName)) {
      return $scriptName;
    } else if (0 === strpos($requestUri, dirname($scriptName))) {
      return rtrim(dirname($scriptName));
    }
    return '';
  }

  /**
   * Path Infoを取得
   * @return type
   */
  public function getPathInfo() {
    $baseUrl    = $this->getBaseUrl();
    $requestUri = $this->getRequestUri();

    if (false !== ($pos = strpos($requestUri, '?'))) {
      $requestUri = substr($requestUri, 0, $pos);
    }

    $pathInfo = (string) substr($requestUri, strlen($baseUrl));
    return $pathInfo;
  }
}
