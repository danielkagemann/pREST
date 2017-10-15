<?php
# author daniel kagemann
# created 14.10.2017
#
# v1.0
class QueryParameter {
  var $name;
  var $dynamic;

  function __construct($value) {

    if (empty($value)) {
      throw new Exception("Empty parameter");
    }
    if ($value[0] == ":") {
      $this->dynamic = true;
      $this->name = substr($value, 1);
    } else {
      $this->dynamic = false;
      $this->name = $value;
    }
  }
}

?>
