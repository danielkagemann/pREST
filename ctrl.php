<?php

require_once("controller.php");

// define the supported routes
echo "<pre>";

try {
  $ctrl = new Controller();
  $ctrl->route('~danielkagemann/book', function($res) {
    echo "here we are in book";
  });

  $ctrl->route('~danielkagemann/book/:id', function($res) {
    echo "here we are in book/id with id {$res["id"]}";
  });

  $ctrl->parse();
} catch (Exception $e) {
  echo "calling errorhandler " . $e->getMessage() . "\n";
}

echo "</pre>";
?>
