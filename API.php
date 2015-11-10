<?php
require_once("Rest.inc.php");
require_once("dbManager/DbManager.php");

class API extends REST {

    public $data = "";

    private $db = NULL;

    public function __construct() {
        parent::__construct();
        $db = DbManager::getPDO();
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
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $nickname = $this->_request['nickname'];
        $password = $this->_request['password'];

        if (!empty($nickname) && !empty($password)) {
            $query = "SELECT login FROM User WHERE nickaname='".$nickname."' AND password='".$password."';";
            $res = $db->query($query);

            $this->response($this->json(array("connectionResult" => $res->fetch())), 200);
        }

        $error = array("status" => "Failed", "msg" => "Invalid nickname or password");
        $this->response($this->json($error), 400);
    }
}

$api = new API;
$api->processApi();

?>
