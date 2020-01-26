<?php


namespace OCA\OCCWeb\Controller;


use OC\AppFramework\Http\Request;

class FakeRequest extends Request {
  public $server = array(
    'argv' => ["occ"],
  );

  /**
   * FakeRequest constructor.
   */
  public function __construct() {
  }

}
