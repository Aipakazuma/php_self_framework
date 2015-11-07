<?php

/**
 * Description of ClassLoader
 *
 * @author aipa
 */
class ClassLoader {

  protected $dirs;

  /**
   * PHPにオートローダクラスを登録する
   */
  public function register() {
    spl_autoload_register(array($this, 'loadClass'));
  }

  /**
   * オートロードするディレクトリを登録する
   * @param type $dir
   */
  public function registerDir($dir) {
    $this->dirs[] = $dir;
  } 

  /**
   * クラスの読み込み
   * @param type $class
   * @return type
   */
  public function loadClass($class) {
    foreach($this->dirs as $dir) {
      $file = $dir . '/' . $class . '.php';
      if (is_readable($file)) {
        require $file;
        return;
      }
    }
  }
}
