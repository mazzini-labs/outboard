<?php
class UserController extends BaseController
{
    
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
                $userModel = new UserModel();

                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }

                $arrUsers = $userModel->getUsers($intLimit);
                $a['data'] = $arrUsers;
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
     * "/user/change" Endpoint - Gets the isChangeable method for all users
     * based on which user initiated the change
     */
    public function changeAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel();
                $authModel = new AuthModel();
                $cookie_time_seconds = $userModel->getConfig('cookie_time_seconds');
                $session = $authModel->getSessionCookie();
                if ($userModel->getConfig('authtype') == "internal") {
                    $BasicAuthInUse = false;
                    if ($username = getPostValue('username') and $password = getPostValue('password')) {
                        $session = $userModel->checkPassword($username,$password);
                    }
                } else {
                    $BasicAuthInUse = true;
                    if (! $session) {
                        $username = $authModel->checkBasic();
                        if ($userModel->isBoardMember($username)) {
                            $userModel->setOperatingUser($username);
                            $session = $userModel->setSession();
                        }
                    }
                }
                $authModel->setSessionCookie($session,$cookie_time_seconds);
                $username = $userModel->getSession($session);
                // Get the owner of the dot we want to change (might be someone else's dot)
                $userid = getGetValue('userid');
                // The user wants to move the dot to the Out column
                if ($out = getGetValue('out')) { $userModel->setDotOut($userid); }

                // The user wants to move the dot to the In column
                if ($in = getGetValue('in')) { $userModel->setDotIn($userid); }

                // if ($rw = getGetValue('rw')) { $userModel->setDotRW($userid); }

                // The user wants to move the dot to the specified "will return by" column. The
                // return variable contains the hour in the day that the user will return.
                if ($return = getGetValue('return')) { $userModel->setDotTime($userid,$return); }

                // The user wants to change the remarks. We have to use isset() here first
                // to allow for empty remarks.
                if (isset($_GET['remarks'])) {
                $remarks = getGetValue('remarks');
                $userModel->setRemarks($userid,$remarks);
                }
                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }
                // $userModel->dotMove(getGetValue('status'));
                if (getGetValue('noupdate') == 0) 
                {
                    $update = 0;
                } else {
                    $update = 1;
                }
                $rowcount = 0;
                $current = getdate();
                $userModel->getData();
                while($row = $userModel->getRow()) {
                // while($row = $userModel->getUsers($intLimit)){
                    $isChangeable = $this->isChangeable($row['userid']);
                    $row['userid'] = urlencode($row['userid']);
                    if (! preg_match("/<READONLY>/",$row['options'])) 
                    {
                        $datetime = getdate($row['back']);
                        if ($row['last_change'] != "") 
                        {
                            list($uname,$ip) = explode(",",$row['last_change']);
                            $lastup = "Last updated by $uname from $ip on " .  $row['timestamp'] . "";
                        }
                        if (getGetValue('in') == 1) 
                        {
                            $in = "in";
                            $rw= "empty";
                        }
                        elseif (getGetValue('rw') == 1) 
                        {
                            $rw = "rw";
                            $in = "empty";
                        }
                        else 
                        {
                            $in = "in";
                            $rw = "empty";
                        }
                        if ($datetime['year'] > $current['year']) 
                        {
                            $out= "out";
                            # so now this checks for if the user
                            # a) is attempting to update their status.
                            # b) is either the user or an admin. if they're not an admin, then 
                            # is changeable (and the code) always returns false for other users
                            if ($update && $isChangeable) 
                            {
                                $in= "empty";
                                $rw= "empty";
                            } 
                            else 
                            {
                                $in= "empty";
                                $rw= "empty";
                            }
                        } 
                        elseif ($datetime['seconds'] == 1) // Remote uses an "in" time that's 1 second lower
                        {
                            $rw= "rw";
                            if ($update && $isChangeable) 
                            {
                                $out= "empty";
                                $in ="empty";
                                
                            } 
                            else 
                            {
                                $out= "empty";
                                $in= "empty";
                            }
                        }
                        else
                        {
                            if ($update && $isChangeable) 
                            {
                                $out= "empty";
                                $rw= "empty";
                            } 
                            else 
                            {
                                $out= "empty";
                                $rw= "empty";
                            }
                        }
                        if ($row['userid'] == $username && $update && $isChangeable) { $user_bg = "class=user "; }
                        if ($update && $isChangeable) 
                        {
                            $change = "true";
                            $hours = $row["hours"];
                        } 
                        elseif(isset($_GET['']))
                        {
                            $change = "true";
                            $hours = $row["hours"];
                        }
                        else 
                        {
                            $change = "false";
                            $hours = $row["hours"];
                        }
                        $a['data'][] = array(
                            'lastup'    => $lastup,
                            'name'   => "" . $row["name"],
                            'hours'   => "" . $hours,
                            'in'   => "" . $in,
                            'out'   => "" . $out,
                            'remarks'   => "" . $row["remarks"],
                            'user_bg'   => "" . $user_bg,
                            'change'    => "" . $change,
                            'uname'     => "" . $row["userid"],
                            'user'      => "" . $username,
                            'rw'        => "" . $rw,
                            'back'      => "" . $row["back"],
                            'udate'     => "" . $update
                            
                        );
                        
                        $rowcount++;
                    }
                }

                $a['data'] = $row;
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
    public function getUsers($update, $status)
    {
        
        
        
            

        
    }
}