<?php
class ProductionController extends BaseController
{
    /**
     * "/production/prod" Endpoint - Get list of production for a specific well
     */
    public function fetchProd()
    {
        // error_log(print_r($api,true));
        // $boardModel = new BoardModel();
        // $a['data'] = $boardModel->getWellProduction(($api));
        // $responseData = json_encode($a);
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = array();
        $arrQueryStringParams = $this->getQueryStringParams();
        // error_log(print_r($arrQueryStringParams,true));
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $boardModel = new BoardModel();
                // var_dump($arrQueryStringParams);
                $apiNo = "00-000-00000";
                // if (isset($arrQueryStringParams['api']) && $arrQueryStringParams['api']) {
                //     $apiNo = $arrQueryStringParams['api'];
                // }
                // elseif(isset($arrQueryStringParams['api']))
                // {
                //     echo "2";
                // }
                // else 
                // {
                //     echo "false";
                // }
                $apiNo = $arrQueryStringParams['api'];
                // $arrUsers = $boardModel->getUsers($apiNo);
                // $a['data'] = $arrUsers;
                $data = $boardModel->getWellProduction(($apiNo));
                $a['data'] = $data;
                // $a['data'] = $boardModel->getWellProduction($apiNo);
                $responseData = json_encode($a);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
           $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    /**
     * "/production/ddr" Endpoint - Get DDR-D for a specific well
     */
    public function fetchDdr()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $boardModel = new BoardModel();

                // $apiNo = 10;
                if (isset($arrQueryStringParams['api']) && $arrQueryStringParams['api']) {
                    $apiNo = $arrQueryStringParams['api'];
                }

                // $arrUsers = $boardModel->getUsers($apiNo);
                // $a['data'] = $arrUsers;
                $a['data'] = $boardModel->getDDR($apiNo);
                $responseData = json_encode($a);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    /**
     * "/production/dsr" Endpoint - Get DSR-D for a specific well
     */
    public function fetchDsr()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $boardModel = new BoardModel();

                // $apiNo = 10;
                if (isset($arrQueryStringParams['api']) && $arrQueryStringParams['api']) {
                    $apiNo = $arrQueryStringParams['api'];
                }

                // $arrUsers = $boardModel->getUsers($apiNo);
                // $a['data'] = $arrUsers;
                $a['data'] = $boardModel->getDSR($apiNo);
                $responseData = json_encode($a);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    /**
     * "/production/excel" Endpoint - Get 2015-2020 DDR for a specific well
     */
    public function fetchExcel()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $boardModel = new BoardModel();

                // $apiNo = 10;
                if (isset($arrQueryStringParams['api']) && $arrQueryStringParams['api']) {
                    $apiNo = $arrQueryStringParams['api'];
                }

                // $arrUsers = $boardModel->getUsers($apiNo);
                // $a['data'] = $arrUsers;
                $a['data'] = $boardModel->getExcelDDR($apiNo);
                $responseData = json_encode($a);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    /**
     * "/production/vitals" Endpoint - Get vitals for a specific well
     */
    public function fetchVitals()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $boardModel = new BoardModel();

                // $apiNo = 10;
                if (isset($arrQueryStringParams['api']) && $arrQueryStringParams['api']) {
                    $apiNo = $arrQueryStringParams['api'];
                }

                // $arrUsers = $boardModel->getUsers($apiNo);
                // $a['data'] = $arrUsers;
                $a['data'] = $boardModel->getVitals($apiNo);
                $responseData = json_encode($a);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    /**
     * "/production/old" Endpoint - Get list of pre-2015 notes or dsr 2015-2020 for a specific well
     */
    public function fetchOld()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $boardModel = new BoardModel();

                // $apiNo = 10;
                if (isset($arrQueryStringParams['api']) && $arrQueryStringParams['api']) {
                    $apiNo = $arrQueryStringParams['api'];
                }
                if (isset($arrQueryStringParams['sheet']) && $arrQueryStringParams['sheet']) {
                    $sheet = $arrQueryStringParams['sheet'];
                }

                // $arrUsers = $boardModel->getUsers($apiNo);
                // $a['data'] = $arrUsers;
                $a['data'] = $boardModel->getOldExcel($apiNo,$sheet);
                $responseData = json_encode($a);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    /**
     * "/production/info" Endpoint - Fetch well info
     */
    public function fetchInfo()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $boardModel = new BoardModel();

                // $apiNo = 10;
                if (isset($arrQueryStringParams['api']) && $arrQueryStringParams['api']) {
                    $apiNo = $arrQueryStringParams['api'];
                }

                // $arrUsers = $boardModel->getUsers($apiNo);
                // $a['data'] = $arrUsers;
                $a['data'] = $boardModel->getWellInfo($apiNo);
                $responseData = json_encode($a);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    /**
     * "/user/list" Endpoint - Get list of users
     */
    public function listAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new BoardModel();
                var_dump($arrQueryStringParams);
                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                    print_r("hello!");
                }

                $arrUsers = $userModel->getUsers($intLimit);
                $responseData = json_encode($arrUsers);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

}

