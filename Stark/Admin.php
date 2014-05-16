<?php

namespace Stark;

class Admin {
  private $request;
  private $response;
  private $service;

  function __construct($request, $response, $service) {
    $this->request = $request;
    $this->response = $response;
    $this->service = $service;
  }

  function process() {
    return "happy!";
  }
}
