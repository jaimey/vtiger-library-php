<?php
class vtiger
{
    public $serveraddress;
    public $userName;
    public $userAccessKey;
    public $sessionName;

    public function __construct($serveraddress, $userName, $userAccessKey)
    {
        $this->serveraddress = $serveraddress;
        $this->userName = $userName;
        $this->userAccessKey = $userAccessKey;
        $this->login();
    }

    private function getToken()
    {
        $data = [
            'operation' => 'getchallenge',
            'username'  => $this->userName
        ];

        $token_data = $this->sendHttpRequest($data, 'GET');
        return $token_data->result->token;
    }

    private function login()
    {
        $token = $this->getToken();
        $data = array(
            'operation' => 'login',
            'username'  => $this->userName,
            'accessKey' => md5($token . $this->userAccessKey),
        );
        $result = $this->sendHttpRequest($data, 'POST');
        $this->sessionName = $result->result->sessionName;
    }

    public function create($params, $module)
    {
        $element = json_encode($params);
        $data = array(
            'operation'   => 'create',
            'sessionName' => $this->sessionName,
            'element'     => $element,
            'elementType' => $module
        );
        return $this->sendHttpRequest($data, 'POST');
    }

    public function update($params)
    {
        $element = json_encode($params);
        $data = array(
            'operation'   => 'update',
            'sessionName' => $this->sessionName,
            'element'     => $element
        );
        return $this->sendHttpRequest($data, 'POST');
    }

    public function retrieve($id)
    {
        $data = array(
            'operation'     => 'retrieve',
            'sessionName'   => $this->sessionName,
            'id'            => $id
        );
        return $this->sendHttpRequest($data, 'GET');
    }

    public function revise($params)
    {
        $element = json_encode($params);

        $data = array(
            'operation'     => 'revise',
            'sessionName'   => $this->sessionName,
            'element'       => $element
        );
        return $this->sendHttpRequest($data, 'POST');
    }

    public function describe($module)
    {
        $data = array(
            'operation'     => 'describe',
            'sessionName'   => $this->sessionName,
            'elementType'   => $module
        );
        return $this->sendHttpRequest($data, 'GET');
    }

    public function listTypes()
    {
        $data = array(
            'operation'     => 'listtypes',
            'sessionName'   => $this->sessionName
        );
        return $this->sendHttpRequest($data, 'GET');
    }

    public function retrieveRelated($id, $targetLabel, $targetModule)
    {
        $data = array(
            'operation'     => 'retrieve_related',
            'sessionName'   => $this->sessionName,
            'id'            => $id,
            'relatedLabel'  => $targetLabel,
            'relatedType'   => $targetModule,
        );
        return $this->sendHttpRequest($data, 'GET');
    }
    public function sendHttpRequest($data, $method)
    {
        $service_url    = $this->serveraddress . "/webservice.php";
        $curl           = curl_init($service_url);

        switch ($method) {
            case 'GET':
                $query_data = http_build_query($data);
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $service_url . "?" . $query_data,
                ));
                break;
            case 'POST':
                curl_setopt($curl, 19913, true);
                curl_setopt($curl, 47, true);
                curl_setopt($curl, 10015, $data);
                break;
        }
        $result = json_decode(curl_exec($curl));
        return $result;
    }
}
