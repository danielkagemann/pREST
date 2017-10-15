<?php
# author daniel kagemann
# created 14.10.2017
#
# v1.0
#
# todos:
# - check allowed method types via REQUEST_METHOD
# - analytics REQUEST_TIME

require_once("queryparameter.php");
require_once("logging.php");

class Controller {
  var $req;
  var $log;
  var $handleError;

  /**
   * default error handler writing to logfile
   */
  function defaultError($err) {
    $this->log->write($err);
  }

  function __construct() {
      $this->req = [];
      $this->log = new Log('./logs/output.log');
      $this->handleError = function($err) {
       $this->defaultError($err);
      };
    }

  /**
   * define own errorhandler
   * default handler just writes to logging
   */
  function customErrorHandler($func) {
    $this->handleError = $func;
  }

  /**
   * parse given string and check routes
   */
  function parse() {
    # store and remove leading slash
    $query = $_SERVER['REQUEST_URI'];
    if ($query[0] == "/") {
      $query = substr($query, 1);
    }

    $this->log->write("parsing {$query}");
    $q = explode('/', $query);

    if (count($q) == 0) {
      call_user_func($this->handleError, "empty route");
      return;
    }

    $handled = false;
    foreach ($this->req as $request) {

      # before iterating check the number of parts
      $args = [];
      if (count($q) == count($request["params"])) {
        $match = true;
        for ($i = 0; $i < count($request["params"]); $i++) {
          $arg = $request["params"][$i];
          $src = $q[$i];

          # statics will be checked
          if (!$arg->dynamic) {
              if ($src !== $arg->name) {
                # no match
                $match = false;
                break;
              }
          }
          # non static will be stored with their name
          else {
            $args[$arg->name] = $src;
          }
        }

        if ($match) {
          $this->log->write("found a match. calling function");
          $request["func"]($args);
          $handled = true;
          break;
        }
      }
    }
    if (!$handled) {
      call_user_func($this->handleError, "could not find a matching route");
    }
  }

  function route($uri, $callback) {

    $this->log->write("adding $uri");

    if ($uri[0] == "/") {
      throw new Exception("route should not start with a slash");
    }
    $t = explode('/', $uri);
    $params = [];

    for ($i = 0; $i < count($t); $i++) {
      try {
        $params[] = new QueryParameter($t[$i]);
      } catch(Exception $e) {
        throw new Exception("Parameter $i: " . $e->getMessage());
      }
    }
    $this->req[] = ['params'=>$params, 'func'=>$callback];
  }

}
 ?>
