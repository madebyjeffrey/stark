<?php
  require_once("vendor/autoload.php");

  // $connector = PhpConsole\Connector::getInstance();
  // $connector->setSourcesBasePath('/home/drakej/domains/334.drakej.myweb.cs.uwindsor.ca/public_html/stark');
  //
  // $handler = PhpConsole\Handler::getInstance();
  // $handler->start();
  // $handler->debug("calling debug", "me!");

  $MIMES = array();
  $MIMES['css'] = 'text/css';

  $PAGES_DIR = 'pages';
  $STATUS = 404;
  $FILE = null;
  $FILE_MIME = null;

  if (array_key_exists('PATH_INFO', $_SERVER)) {
    $FILE = realpath($PAGES_DIR . DIRECTORY_SEPARATOR . $_SERVER['PATH_INFO']);
    if ($FILE !== FALSE) {
      $ext = pathinfo($FILE, PATHINFO_EXTENSION);
      if ($ext !== FALSE) {
        if (array_key_exists($ext, $MIMES)) {
          $FILE_MIME = $MIMES[$ext];
          $STATUS = 200;
        } else {
          $fi = new finfo(FILEINFO_MIME);
          $result = $fi->file($FILE);

          if ($result !== FALSE) {
            $STATUS = 200;
            $FILE_MIME = $result;
          }
        }
      } else {
        $fi = new finfo(FILEINFO_MIME);
        $result = $fi->file($FILE);

        if ($result !== FALSE) {
          $STATUS = 200;
          $FILE_MIME = $result;
        }
      }
    }
  }

  if ($STATUS == 200) {
    header('Content-Type: ' . $FILE_MIME);
    @readfile($FILE);
    exit(0);
  } else {
    http_response_code($STATUS);
?><!DOCTYPE html><html><head><title><?=$STATUS?></title></head><body>
  <p>Status Code: <?=$STATUS?></p>
  <p>Expected path: <?=$FILE?></p>
  <p>Mime: <?=$FILE_MIME?></p>
  </body></html>
  <?php } ?>
