<?php
class NotesController extends BaseController
{
    
    /**
     * "/notes/prod" Endpoint - Inserts Latest Production
     */
    public function putLatest()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'POST') {
            try {
                $boardModel = new BoardModel();
                // $apiNo = getGetValue('api');
                // $a['data'] =
                $a = $boardModel->insertLatestProduction(
                    getPostValue('api'),
                    getPostValue('del'),
                    getPostValue('gp'),
                    getPostValue('op'),
                    getPostValue('wp'),
                    getPostValue('deb')
                );
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
     * "/notes/ddr" Endpoint - insert ddr entry
     */
    public function putDdr()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'POST') {
            try {
                error_log(print_r("Hello!",true));
                $boardModel = new BoardModel();
                // $arrWells = $boardModel->getLatestProduction();
                // $a['data'] = $arrWells;
                $d = getPostVariable('d');
                $api = getPostVariable('api');
                $t = getPostVariable('t');
                $de = getPostVariable('de');
                $ts = getPostVariable('ts');
                $te = getPostVariable('te');
                $deb = getPostVariable('deb');
                $cvn = getPostVariable('cvn');
                $cin = getPostVariable('cin');
                $drn = getPostVariable('drn');
                $ec = getPostVariable('ec');
                $edc = getPostVariable('edc');
                $ecc = getPostVariable('ecc');
                $eb = getPostVariable('eb');
                
                if($id = getPostVariable('id')){ 
                    error_log(print_r("id set", true)); 
                    switch($d){
                        case 'a':
                            $ai = getPostVariable('ai');
                            $ad = getPostVariable('ad');
                            $ts = '23:59:59';
                            $te = '23:59:59';
                            break;
                        case 'v':
                            $tt = getPostVariable('tt');
                            $dt = getPostVariable('dt');
                            $dc = getPostVariable('dc');
                            $at = getPostVariable('at');
                            $ac = getPostVariable('ac');
                            $et = getPostVariable('et');
                            break;
                        case 'f':
                            
                            break;
                        default:
                            $ps = getPostVariable('ps');
                            $ft = getPostVariable('ft');
                            $ftp = getPostVariable('ftp');
                            $fcp = getPostVariable('fcp');
                            $sitp = getPostVariable('sitp');
                            $sicp = getPostVariable('sicp');
                            $chlr = getPostVariable('chlr');
                            $pmp = getPostVariable('pmp');
                            $fl = getPostVariable('fl');
                            $pms = getPostVariable('pms');
                            $ct = getPostVariable('ct');
                            $pus = getPostVariable('pus');
                            $rsi = getPostVariable('rsi');
                            $pusl = getPostVariable('pusl');
                            $csi = getPostVariable('csi');
                            $rpj = getPostVariable('rpj');
                            $pmpa = getPostVariable('pmpa');
                            $pmsa = getPostVariable('pmsa');
                            $puon = getPostVariable('puon');
                            $puoff = getPostVariable('puoff');
                            $injp = getPostVariable('injp');
                            if($na = getPostVariable('notes-addition')){ $boardModel->notesAppend($na, $api, $drn, $ps, $ts, $de); }
                            $vitals = $boardModel->checkVitals($fl,$ct,$ftp,$fcp,$csi,$rpj,
                                    $pmp,$pms,$pus,$rsi,$pusl,$pmpa,$pmsa,$sitp,$sicp,
                                    $chlr,$injp,$puon,$puoff);
                            if($wsbcat = getPostVariable('wsbcat')){
                                $wsbslug = Slug($wsbcat);
                                $boardModel->newCategory($wsbcat,$wsbslug);
                                $boardModel->uploadFile($id,$api,$wsbslug,$de,$ft);
                            }
                                    
                                    
                            if($vitals > 0){
                                $boardModel->insertVitals($api, $id, $de,$fl,$ct,$ftp,$fcp,$csi,$rpj,
                                $pmp,$pms,$pus,$rsi,$pusl,$pmpa,$pmsa,$sitp,$sicp,
                                $chlr,$injp,$puon,$puoff);
                            }
                        
                    }
                } else {
                    switch($d){
                        default:
                        $ps = getPostVariable('ps');
                        $ft = getPostVariable('ft');
                        $ftp = getPostVariable('ftp');
                        $fcp = getPostVariable('fcp');
                        $sitp = getPostVariable('sitp');
                        $sicp = getPostVariable('sicp');
                        $chlr = getPostVariable('chlr');
                        $pmp = getPostVariable('pmp');
                        $fl = getPostVariable('fl');
                        $pms = getPostVariable('pms');
                        $ct = getPostVariable('ct');
                        $pus = getPostVariable('pus');
                        $rsi = getPostVariable('rsi');
                        $pusl = getPostVariable('pusl');
                        $csi = getPostVariable('csi');
                        $rpj = getPostVariable('rpj');
                        $pmpa = getPostVariable('pmpa');
                        $pmsa = getPostVariable('pmsa');
                        $puon = getPostVariable('puon');
                        $puoff = getPostVariable('puoff');
                        $injp = getPostVariable('injp');
                        error_log(print_r("Breakpoint 1",true));
                        // error_log(print_r("na: ".$na,true));
                        if($na = getPostVariable('notes-addition')){ $boardModel->notesAppend($na, $api, $drn, $ps, $ts, $de); }
                        error_log(print_r("Breakpoint 2",true));
                        $vitals = $boardModel->checkVitals($fl,$ct,$ftp,$fcp,$csi,$rpj,
                                $pmp,$pms,$pus,$rsi,$pusl,$pmpa,$pmsa,$sitp,$sicp,
                                $chlr,$injp,$puon,$puoff);
                                error_log(print_r("Breakpoint 3",true));
                        $a = $boardModel->insertDDRe($d, $t, $de, $ts, $te, $deb, $api, $cvn, $cin, $drn, $eb, $ec, $edc, $ecc, $vitals, $ps);
                        error_log(print_r("Breakpoint 4",true));
                                
                        if($vitals > 0){
                            $boardModel->insertVitals($api, $id, $de,$fl,$ct,$ftp,$fcp,$csi,$rpj,
                            $pmp,$pms,$pus,$rsi,$pusl,$pmpa,$pmsa,$sitp,$sicp,
                            $chlr,$injp,$puon,$puoff);
                        }
                        error_log(print_r("Breakpoint 5",true));
                        if($wsbcat = getPostVariable('wsbcat')){
                            $wsbslug = Slug($wsbcat);
                            $boardModel->newCategory($wsbcat,$wsbslug);
                            $boardModel->uploadFile($id,$api,$wsbslug,$de,$ft);
                        }
                        error_log(print_r("Breakpoint 6",true));
                        break;
                    }
                }
                




                
                // $a = $boardModel->insertDDR(
                //     getPostVariable('id'),
                //     getPostVariable('na'),
                //     getPostVariable('api'),
                //     getPostVariable('d'),
                //     getPostVariable('t'),
                //     getPostVariable('de'),
                //     getPostVariable('ts'),
                //     getPostVariable('te'),
                //     getPostVariable('deb'),
                //     getPostVariable('cvn'),
                //     getPostVariable('cin'),
                //     getPostVariable('drn'),
                //     getPostVariable('ai'),
                //     getPostVariable('ad'),
                //     getPostVariable('ec'),
                //     getPostVariable('edc'),
                //     getPostVariable('ecc'),
                //     getPostVariable('tt'),
                //     getPostVariable('dt'),
                //     getPostVariable('dc'),
                //     getPostVariable('at'),
                //     getPostVariable('ac'),
                //     getPostVariable('et'),
                //     getPostVariable('ps'),
                //     getPostVariable('ft'),
                //     getPostVariable('eb'),
                //     getPostVariable('ftp'),
                //     getPostVariable('fcp'),
                //     getPostVariable('sitp'),
                //     getPostVariable('sicp'),
                //     getPostVariable('chlr'),
                //     getPostVariable('pmp'),
                //     getPostVariable('fl'),
                //     getPostVariable('pms'),
                //     getPostVariable('ct'),
                //     getPostVariable('pus'),
                //     getPostVariable('rsi'),
                //     getPostVariable('pusl'),
                //     getPostVariable('csi'),
                //     getPostVariable('rpj'),
                //     getPostVariable('pmpa'),
                //     getPostVariable('pmsa'),
                //     getPostVariable('puon'),
                //     getPostVariable('puoff'),
                //     getPostVariable('injp'),
                //     getPostVariable('wsbcat')
                // );
                // $a = $boardModel->insertDDR(
                //     $id,
                // $na,
                // $api,
                // $d,
                // $t,
                // $de,
                // $ts,
                // $te,
                // $deb,
                // $cvn,
                // $cin,
                // $drn,
                // $ai,
                // $ad,
                // $ec,
                // $edc,
                // $ecc,
                // $tt,
                // $dt,
                // $dc,
                // $at,
                // $ac,
                // $et,
                // $ps,
                // $ft,
                // $eb,
                // $ftp,
                // $fcp,
                // $sitp,
                // $sicp,
                // $chlr,
                // $pmp,
                // $fl,
                // $pms,
                // $ct,
                // $pus,
                // $rsi,
                // $pusl,
                // $csi,
                // $rpj,
                // $pmpa,
                // $pmsa,
                // $puon,
                // $puoff,
                // $injp,
                // $wsbcat
                // );
                // $a = $boardModel->insertDDR($arrQueryStringParams);
                error_log(print_r("Breakpoint Last",true));
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