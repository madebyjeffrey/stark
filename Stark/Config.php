<?php

namespace Stark;
class Config {

static function update_request($config, $logger) {
    if (array_key_exists("general", $config) &&
        array_key_exists("install_path", $config["general"]) &&
        array_key_exists('REQUEST_URI', $_SERVER)) {

          $logger->addInfo("request: " . $_SERVER['REQUEST_URI']);
          $logger->addInfo("install_path: " . $config["general"]["install_path"]);

          $request_path = explode('/', $_SERVER['REQUEST_URI']);
          $install_path = explode('/', $config["general"]["install_path"]);

          $logger->addInfo(var_export($request_path, TRUE));
          $logger->addInfo(var_export($install_path, TRUE));

          $good = TRUE;

          for ($i = 0; $i < count($install_path) && $good; ++$i) {
            if ($request_path[0] === '') {
              array_shift($request_path);
            }

            if ($install_path[0] === '') {
              array_shift($install_path);
            }

            if ($request_path[0] === $install_path[0]) {
              array_shift($request_path);
              array_shift($install_path);
            } else {
              $good = FALSE;
              break;
            }
          }

          if ($good) {
            $request_path = "/" . implode('/', $request_path);
            $logger->addInfo("New path: " . $request_path);
            $_SERVER['REQUEST_URI'] = $request_path;
          }
    }
}
}
