<?php
class WellsController extends BaseController
{
    
    /**
     * "/wells/wells" Endpoint - Get list of wells
     */
    public function fetchWells()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $boardModel = new BoardModel();

                // $apiNo = 10;
                // if (isset($arrQueryStringParams['api']) && $arrQueryStringParams['api']) {
                //     $apiNo = $arrQueryStringParams['api'];
                // }

                $arrWells = $boardModel->getWells();
                $a['data'] = $arrWells;
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
     * "/wells/latest" Endpoint - Get latest production of wells
     */
    public function fetchLatest()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $boardModel = new BoardModel();

                // $apiNo = 10;
                // if (isset($arrQueryStringParams['api']) && $arrQueryStringParams['api']) {
                //     $apiNo = $arrQueryStringParams['api'];
                // }

                $arrWells = $boardModel->getLatestProduction();
                $a['data'] = $arrWells;
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
     * "/wells/shutin" Endpoint - Get list of shutin wells
     */
    public function fetchShutin()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $boardModel = new BoardModel();

                // $apiNo = 10;
                // if (isset($arrQueryStringParams['api']) && $arrQueryStringParams['api']) {
                //     $apiNo = $arrQueryStringParams['api'];
                // }

                $arrWells = $boardModel->getShutInWells();
                $a['data'] = $arrWells;
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
}