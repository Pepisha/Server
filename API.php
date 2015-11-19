<?php
require_once("Rest.inc.php");
require_once("dbManager/DbManager.php");
require_once("models/User.php");

class API extends REST {

    public $data = "";

    public function __construct() {
        parent::__construct();
    }

    public function processApi() {
        $func = strtolower(trim(str_replace("/","", $_REQUEST['rquest'])));     // Vérifier le nom de la variable

        if ((int)method_exists($this, $func) > 0) {
            $this->$func();
        }
        else {
            $this->response('', 404);
        }
    }

    private function json($data) {
        if (is_array($data)) {
            return json_encode($data);
        }
    }

    private function login() {
        $this->checkIfPostRequest();

        $nickname = $this->_request['nickname'];
        $password = $this->_request['password'];

        if (!empty($nickname) && !empty($password)) {
            $connectionResult = User::canUserLogin($nickname, $password);
            $this->response($this->json(array("success" => $connectionResult)), 200);
        }

        $error = array("success" => false);
        $this->response($this->json($error), 400);
    }


    private function register() {
      $this->checkIfPostRequest();

      $user = User::registerIfPossible($this->_request['nickname'],$this->_request['password1'],$this->_request['password2'],
                       $this->_request['mail'], $this->_request['phone'], $this->_request['firstname'],
                       $this->_request['lastname']);

      if($user.gettype()==="string"){ //Il y a eu une erreur à la création
        $response = ['success' => false, 'error' => $user];
      }
      else{
        $response = ['success' => true];
      }
      $this->response($this->json($response),200);
    }

    private function checkIfPostRequest(){
      if ($this->get_request_method() != "POST") {
          $this->response('', 406);
      }
    }
}

$api = new API;
$api->processApi();

?>
