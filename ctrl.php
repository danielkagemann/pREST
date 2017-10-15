<?php

require_once("controller.php");

// define the supported routes
echo "<pre>";

try {
  // echo is a special logging mode
  $ctrl = new Controller("echo");
  $ctrl->route('~danielkagemann/pREST/book', function($res) {
    echo "here we are in book";
  });

  $ctrl->route('~danielkagemann/pREST/book/:id', function($res) {
    echo "here we are in book/id with id {$res["id"]}";
  });

  $ctrl->parse();
} catch (Exception $e) {
  echo "calling errorhandler " . $e->getMessage() . "\n";
}

echo "</pre>";
?>
