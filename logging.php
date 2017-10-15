<?php
# author daniel kagemann
# created 14.10.2017
#
# v1.0
#
class Log {
  var $handle;

  function __construct($filename) {
      if ($filename !== 'echo') {
        $this->handle = @fopen($filename, "at+");
      } else {
        $this->handle = -1;
      }
  }

  function write($msg) {
    if ($this->handle === -1) {
      echo date("d.m.Y H:i:s") . " - $msg" . PHP_EOL;
    } else {
      if($this->handle){
        flock($this->handle, LOCK_EX);
        fwrite($this->handle, date("d.m.Y H:i:s") . " - ");
        fwrite($this->handle, $msg . PHP_EOL);
        flock($this->handle, LOCK_UN);
      }
    }
  }

  function __destruct() {
    if($this->handle !== NULL && $this->handle >= 0) {
      @fclose($this->handle);
      $this->handle = NULL;
    }
  }
}
?>
