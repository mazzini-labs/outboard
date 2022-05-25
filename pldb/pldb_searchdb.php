<?php 
// pldb_searchdb.php

function formSearch_Load(){

// Add items to drop down lists (search and edit)

// database queries
$strSQLTxtLocations = "SELECT location_id, state, region, county, block, field FROM pldb_locations ORDER BY state";
$strSQLTxtStatuses = "SELECT status FROM pldb_lookup_entity_status ORDER BY status";
$strSQLTxtOpStatuses = "SELECT status FROM pldb_lookup_internal_status ORDER BY status";
$strSQLTxtOwnComps = "SELECT company_code FROM pldb_lookup_company_codes ORDER BY company_code";
$strSQLTxtState = "SELECT DISTINCT state FROM pldb_locations ORDER BY state ASC";

// while loops that place data into arrays
// TODO


// export to json
// TODO 


};

function btnSearch_Click(){
    // This sub will perform the search requested by the user.
    $strEQUALSSRCH_TXT = "Equals";
    $strBEGINSWITHSRCH_TXT = "Begins With";
    $strCONTAINSSRCH_TXT = "Contains";


    // $rsSrchResultsCnt As New ADODB.Recordset


    $strStsMsgRet = "";
    $strSrchResCnt = "";
    $strSQLFinalSrch = "";
    $strSQLSelectFields = "SELECT PROP.PropertyID, PROP.Name, LOC.County, LOC.Block ";
    $strSQLFrom = "FROM Properties PROP, Locations LOC ";
    $strSQLWhere = "WHERE PROP.LocationID = LOC.LocationID ";
    $strSQLOrderBy = "ORDER BY PROP.PropertyID";

    // Check for search criteria, otherwise all records in DB are shown.
    // Name area:
    if (Trim($txtSrchName.Value) <> "") {
        if (Trim($cboSrchTypeName.Value) = $strEQUALSSRCH_TXT) {
            // Equals search;
            $strSQLWhere = $strSQLWhere & "AND PROP.Name = // " & FormatString(CStr($txtSrchName.Value), False) & "//  ";
        }
        else if (Trim($cboSrchTypeName.Value) = $strBEGINSWITHSRCH_TXT) {
            // Begins with search;
            $strSQLWhere = $strSQLWhere & "AND PROP.Name LIKE // " & FormatString(CStr($txtSrchName.Value), False) & "*//  ";
        } else {
            // Contains search;
            $strSQLWhere = $strSQLWhere & "AND PROP.Name LIKE // *" & FormatString(CStr($txtSrchName.Value), False) & "*//  ";
        }
    }

    // State area (only allows equals right now):
    if (Trim($cboSrchState.Value) <> "") {
        if (Trim($cboSrchTypeState.Value) = $strEQUALSSRCH_TXT) {
            $strSQLWhere = $strSQLWhere & "AND LOC.State = // " & FormatString(CStr($cboSrchState.Value), False) & "//  ";
        }
    }

    // County area:
    if (Trim($txtSrchCounty.Value) <> "") {
        if (Trim($cboSrchTypeCounty.Value) = $strEQUALSSRCH_TXT) {
            // Equals search;
            $strSQLWhere = $strSQLWhere & "AND LOC.County = // " & FormatString(CStr($txtSrchCounty.Value), False) & "//  ";
        }
        elseif (Trim($cboSrchTypeCounty.Value) = $strBEGINSWITHSRCH_TXT) {
            // Begins with search;
            $strSQLWhere = $strSQLWhere & "AND LOC.County LIKE // " & FormatString(CStr($txtSrchCounty.Value), False) & "*//  ";
        } else {
            // Contains search;
            $strSQLWhere = $strSQLWhere & "AND LOC.County LIKE // *" & FormatString(CStr($txtSrchCounty.Value), False) & "*//  ";
        }
    }

    // Block area:
    if (Trim($txtSrchBlock.Value) <> "") {
        if (Trim($cboSrchTypeBlock.Value) = $strEQUALSSRCH_TXT) {
            // Equals search;
            $strSQLWhere = $strSQLWhere & "AND LOC.Block = // " & FormatString(CStr($txtSrchBlock.Value), False) & "//  ";
        }
        elseif (Trim($cboSrchTypeBlock.Value) = $strBEGINSWITHSRCH_TXT) {
            // Begins with search;
            $strSQLWhere = $strSQLWhere & "AND LOC.Block LIKE // " & FormatString(CStr($txtSrchBlock.Value), False) & "*//  ";
        } else {
            // Contains search;
            $strSQLWhere = $strSQLWhere & "AND LOC.Block LIKE // *" & FormatString(CStr($txtSrchBlock.Value), False) & "*//  ";
        }
    }

    // Owning Company area (only allows equals right now):;
    if (Trim($cboSrchOwnComp.Value) <> "") {
        if (Trim($cboSrchTypeOwnComp.Value) = $strEQUALSSRCH_TXT) {
            $strSQLWhere = $strSQLWhere & "AND PROP.OwningCompany = // " & FormatString(CStr($cboSrchOwnComp.Value), False) & "//  ";
        }
    }

    // Status area (only allows equals right now):;
    if (Trim($cboSrchStatus.Value) <> "") {
        if (Trim($cboSrchTypeStatus.Value) = $strEQUALSSRCH_TXT) {
            $strSQLWhere = $strSQLWhere & "AND PROP.Status = // " & FormatString(CStr($cboSrchStatus.Value), False) & "//  ";
        }
    }

    // Operating Status area (only allows equals right now):;
    if (Trim($cboSrchOpStatus.Value) <> "") {
        if (Trim($cboSrchTypeOpStatus.Value) = $strEQUALSSRCH_TXT) {
            $strSQLWhere = $strSQLWhere & "AND PROP.OperatingStatus = // " & FormatString(CStr($cboSrchOpStatus.Value), False) & "//  ";
        }
    }

    // Create final SQL search $strings and populate results list box;
    $strSQLFinalSrch = $strSQLSelectFields & $strSQLFrom & $strSQLWhere & $strSQLOrderBy;
    lstSearchResults.RowSource = $strSQLFinalSrch;

    // Display count: if no results returned listbox cnt is 0, if one or more is found listbox cnt is 1 too many;
    // as it counts the header row.;
    if ($lstSearchResults.ListCount > 0) {
        $strSrchResCnt = CStr($lstSearchResults.ListCount - 1);
    } else {
        $strSrchResCnt = CStr($lstSearchResults.ListCount);
    }
    $lblSearchResults.Caption = "Search Results: (" & $strSrchResCnt & " records found)";
};

function lstSearchResults_Click(){
    // Set error handling;
    // On Error GoTo Err_Handle;

    // function fires when listbox row is clicked;
    $strPropId;
    $strSQLGetPropInfo;
    $rsEditFields As New ADODB.Recordset;
    $strStsMsgRet;

    // Get property ID to use for querying and getting full, editable results;
    $strPropId = $lstSearchResults.Value;
    $strStsMsgRet = "";

    // Get property information for editing;
    $strSQLGetPropInfo = "SELECT PROP.PropertyID, PROP.LocationID, PROP.Name, PROP.Status, PROP.OperatingStatus, PROP.OwningCompany, PROP.Operator, PROP.WI, PROP.RI, PROP.ORRI, PROP.BIAPO, PROP.WBO, PROP.LegalDescription, PROP.API, PROP.GWIValue, PROP.NRIValue, PROP.ORRIValue, PROP.RIValue, PROP.WPCode, PROP.GrossAcres, PROP.NetAcres, PROP.LeaseNumber FROM Properties PROP, Locations LOC WHERE PROP.LocationID = LOC.LocationID AND PROP.PropertyID = " & $strPropId;
    rsEditFields.Open $strSQLGetPropInfo, CurrentProject.Connection, adOpenStatic, adLockReadOnly, -1;

    Do While Not rsEditFields.EOF;
        if (CStr(rsEditFields(0)) = "") {
            Exit Do;
        } else {
            // Display all data fields from DB;
            $txtEditPropId.Value = TransformNullToEmpty(rsEditFields(0));
            $cboEditLoc.Value = TransformNullToEmpty(rsEditFields(1));
            $txtEditName.Value = TransformNullToEmpty(rsEditFields(2));
            $cboEditStatus.Value = TransformNullToEmpty(rsEditFields(3));
            $cboEditOpStatus.Value = TransformNullToEmpty(rsEditFields(4));
            $cboEditOwnComp.Value = TransformNullToEmpty(rsEditFields(5));
            $txtEditOp.Value = TransformNullToEmpty(rsEditFields(6));
            $cboEditWI.Value = TranDispYesNo(TransformNullToEmpty(rsEditFields(7)));
            $cboEditRI.Value = TranDispYesNo(TransformNullToEmpty(rsEditFields(8)));
            $cboEditORRI.Value = TranDispYesNo(TransformNullToEmpty(rsEditFields(9)));
            $cboEditBIAPO.Value = TranDispYesNo(TransformNullToEmpty(rsEditFields(10)));
            $cboEditWBO.Value = TranDispYesNo(TransformNullToEmpty(rsEditFields(11)));
            $txtEditLegDesc.Value = TransformNullToEmpty(rsEditFields(12));
            $txtEditAPI.Value = TransformNullToEmpty(rsEditFields(13));
            $txtEditGWIVal.Value = TransformNullToEmpty(rsEditFields(14));
            $txtEditNRIVal.Value = TransformNullToEmpty(rsEditFields(15));
            $txtEditORRIVal.Value = TransformNullToEmpty(rsEditFields(16));
            $txtEditRIVal.Value = TransformNullToEmpty(rsEditFields(17));
            $txtEditWPCode.Value = TransformNullToEmpty(rsEditFields(18));
            $txtEditGrossAcres.Value = TransformNullToEmpty(rsEditFields(19));
            $txtEditNetAcres.Value = TransformNullToEmpty(rsEditFields(20));
            $txtEditLeaseNum.Value = TransformNullToEmpty(rsEditFields(21));
        
            rsEditFields.MoveNext;
        }
    Loop;

    // Show Controls;
    SetHiddenFieldsAndForm (True);

    // Exit to prevent running err handle code;
    rsEditFields.Close;
    Set rsEditFields = Nothing;
    Exit function;

Err_Handle:;
    // Display an error message box on error;
    rsEditFields.Close;
    Set rsEditFields = Nothing;
    $strStsMsgRet = MsgBox(Err.Description, vbExclamation, "Edit Values Populate Error");
    Exit function;

};

function btnSubmitEdit_Click(){
    // Set error handling;
    On Error GoTo Err_Handle;

    $strVBYes = "6";
    $strEDITACTION_TXT = "Edit";

    $cnnEdtProp As New ADODB.Connection;
    $strEdtSQLTxt;
    $strEdtSQLUpdHistTxt;
    $strEdtPropIdTxt;
    $strEdtLocIdTxt;
    $strEdtNameTxt;
    $strEdtStatusTxt;
    $strEdtOpStatusTxt;
    $strEdtOwnCompTxt;
    $strEdtOpTxt;
    $strEdtWITxt;
    $strEdtRITxt;
    $strEdtORRITxt;
    $strEdtBIAPOTxt;
    $strEdtWBOTxt;
    $strEdtLegDescTxt;
    $strEdtAPITxt;
    $strEdtGWIValTxt;
    $strEdtNRIValTxt;
    $strEdtORRIValTxt;
    $strEdtRIValTxt;
    $strEdtWPCodeTxt;
    $strEdtGrossAcresTxt;
    $strEdtNetAcresTxt;
    $strEdtLeaseNumTxt;

    $strEdtConfrmValue;
    $strEdtPropRetValue;
    $strEdtStsMsgRetValue;
    $strUpdUsername;

    // Get current username for history update;
    // $strUpdUsername = Trim(CStr(Environ("USERNAME")));
    $strUpdUsername = FindUserName();

    // Init all variables;
    Set cnnEdtProp = CurrentProject.Connection;
    $strEdtSQLTxt = "";
    $strEdtSQLUpdHistTxt = "";
    $strEdtPropIdTxt = "";
    $strEdtLocIdTxt = "";
    $strEdtNameTxt = "";
    $strEdtStatusTxt = "";
    $strEdtOpStatusTxt = "";
    $strEdtOwnCompTxt = "";
    $strEdtOpTxt = "";
    $strEdtWITxt = "";
    $strEdtRITxt = "";
    $strEdtORRITxt = "";
    $strEdtBIAPOTxt = "";
    $strEdtWBOTxt = "";
    $strEdtLegDescTxt = "";
    $strEdtAPITxt = "";
    $strEdtGWIValTxt = "";
    $strEdtNRIValTxt = "";
    $strEdtORRIValTxt = "";
    $strEdtRIValTxt = "";
    $strEdtWPCodeTxt = "";
    $strEdtGrossAcresTxt = "";
    $strEdtNetAcresTxt = "";
    $strEdtLeaseNumTxt = "";
    $strEdtConfrmValue = "";
    $strEdtPropRetValue = "";
    $strEdtStsMsgRetValue = "";

    // Check to be sure user wishes to add the property before proceeding;
    $strEdtConfrmValue = MsgBox("Are you sure you wish to edit this property? Changes cannot be undone!", vbYesNo, "Confirm Edit");
    if ($strEdtConfrmValue <> $strVBYes) {
        Exit function;
    }

    // Get all field vals;
    $strEdtPropIdTxt = TransformNullToEmpty($txtEditPropId);
    $strEdtLocIdTxt = TransformNullToEmpty($cboEditLoc);
    $strEdtNameTxt = TransformNullToEmpty($txtEditName);
    $strEdtStatusTxt = TransformNullToEmpty($cboEditStatus);
    $strEdtOpStatusTxt = TransformNullToEmpty($cboEditOpStatus);
    $strEdtOwnCompTxt = TransformNullToEmpty($cboEditOwnComp);
    $strEdtOpTxt = TransformNullToEmpty($txtEditOp);
    $strEdtWITxt = TransformNullToEmpty($cboEditWI);
    $strEdtRITxt = TransformNullToEmpty($cboEditRI);
    $strEdtORRITxt = TransformNullToEmpty($cboEditORRI);
    $strEdtBIAPOTxt = TransformNullToEmpty($cboEditBIAPO);
    $strEdtWBOTxt = TransformNullToEmpty($cboEditWBO);
    $strEdtLegDescTxt = TransformNullToEmpty($txtEditLegDesc);
    $strEdtAPITxt = TransformNullToEmpty($txtEditAPI);
    $strEdtGWIValTxt = TransformNullToEmpty($txtEditGWIVal);
    $strEdtNRIValTxt = TransformNullToEmpty($txtEditNRIVal);
    $strEdtORRIValTxt = TransformNullToEmpty($txtEditORRIVal);
    $strEdtRIValTxt = TransformNullToEmpty($txtEditRIVal);
    $strEdtWPCodeTxt = TransformNullToEmpty($txtEditWPCode);
    $strEdtGrossAcresTxt = TransformNullToEmpty($txtEditGrossAcres);
    $strEdtNetAcresTxt = TransformNullToEmpty($txtEditNetAcres);
    $strEdtLeaseNumTxt = TransformNullToEmpty($txtEditLeaseNum);

    // Check required data entry fields;
    $strEdtPropRetValue = CheckPropEditData($strEdtNameTxt, $strEdtOpTxt, $strEdtGWIValTxt, $strEdtNRIValTxt, $strEdtORRIValTxt, $strEdtRIValTxt, $strEdtGrossAcresTxt, $strEdtNetAcresTxt);

    // Update DB with new location data;
    if ($strEdtPropRetValue = "") {
        // Begin transaction;
        cnnEdtProp.BeginTrans;

        // Execute update in transaction;
        $strEdtSQLTxt = "UPDATE Properties SET LocationID = " & FormatString($strEdtLocIdTxt, False) & ", Name = // " & FormatString($strEdtNameTxt, False) & "// , Status = // " & FormatString($strEdtStatusTxt, False) & "// , OperatingStatus = // " & FormatString($strEdtOpStatusTxt, False) & "// , OwningCompany = // " & FormatString($strEdtOwnCompTxt, False) & "// , Operator = // " & FormatString($strEdtOpTxt, False) & "// , WI = // " & FormatString($strEdtWITxt, True) & "// , RI = // " & FormatString($strEdtRITxt, True) & "// , ORRI = // " & FormatString($strEdtORRITxt, True) & "// , BIAPO = // " & FormatString($strEdtBIAPOTxt, True) & "// , WBO = // " & FormatString($strEdtWBOTxt, True) & "// , LegalDescription = // " & FormatString($strEdtLegDescTxt, False) & "// , API = // " & FormatString($strEdtAPITxt, False) & "// , GWIValue = " & FormatString($strEdtGWIValTxt, False) & _;
            ", NRIValue = " & FormatString($strEdtNRIValTxt, False) & ", ORRIValue = " & FormatString($strEdtORRIValTxt, False) & ", RIValue = " & FormatString($strEdtRIValTxt, False) & ", WPCode = // " & FormatString($strEdtWPCodeTxt, False) & "// , GrossAcres = " & FormatString($strEdtGrossAcresTxt, False) & ", NetAcres = " & FormatString($strEdtNetAcresTxt, False) & ", LeaseNumber = // " & FormatString($strEdtLeaseNumTxt, False) & "//  WHERE PropertyID = " & $strEdtPropIdTxt;
        cnnEdtProp.Execute $strEdtSQLTxt;
    
        // Add history item in transaction;
        $strEdtSQLUpdHistTxt = "INSERT INTO UpdateHistory (PropertyID,$strUpdHistUser,$strUpdHistActionType,dtUpdHistDateTime) VALUES (" & FormatString($strEdtPropIdTxt, False) & ",// " & FormatString($strUpdUsername, False) & "// ,// " & FormatString($strEDITACTION_TXT, False) & "// ,Now())";
        cnnEdtProp.Execute $strEdtSQLUpdHistTxt;
    
        // Commit transaction;
        cnnEdtProp.CommitTrans;
    
        // Display message box;
        $strEdtStsMsgRetValue = MsgBox("Property edited succesfully!", vbOKOnly, "Success");

        // Resize the form;
        SetHiddenFieldsAndForm (False);
    
        // Refresh search results;
        btnSearch_Click;
    }

    // Close DB conn object;
    cnnEdtProp.Close;
    Set cnnEdtProp = Nothing;

    // Exit the sub to prevent running error handler;
    Exit function;

Err_Handle:;
    // Rollback transaction and close conn;
    cnnEdtProp.RollbackTrans;
    cnnEdtProp.Close;
    Set cnnEdtProp = Nothing;

    // Display error message;
    $strEdtStsMsgRetValue = MsgBox(Err.Description, vbExclamation, "Edit Error");
    Exit function;
};

function btnCancelEdit_Click(){
    // This sub will cancel the edit, clear the fields, and shrink the form;
    $txtEditPropId.Value = "";
    $cboEditLoc.Value = "";
    $txtEditName.Value = "";
    $cboEditStatus.Value = "";
    $cboEditOpStatus.Value = "";
    $cboEditOwnComp.Value = "";
    $txtEditOp.Value = "";
    $cboEditWI.Value = "";
    $cboEditRI.Value = "";
    $cboEditORRI.Value = "";
    $cboEditBIAPO.Value = "";
    $cboEditWBO.Value = "";
    $txtEditLegDesc.Value = "";
    $txtEditAPI.Value = "";
    $txtEditGWIVal.Value = "";
    $txtEditNRIVal.Value = "";
    $txtEditORRIVal.Value = "";
    $txtEditRIVal.Value = "";
    $txtEditWPCode.Value = "";
    $txtEditGrossAcres.Value = "";
    $txtEditNetAcres.Value = "";
    $txtEditLeaseNum.Value = "";

    SetHiddenFieldsAndForm (False);

};

function btnResetSearch_Click(){
    // Reset the search form and then reset the edit form if open.;

    // Clear search form and set to default values;
    cboSrchTypeName.SetFocus;
    cboSrchTypeName.ListIndex = 0;
    $txtSrchName.Value = "";
    cboSrchTypeCounty.SetFocus;
    cboSrchTypeCounty.ListIndex = 0;
    $txtSrchCounty.Value = "";
    cboSrchTypeBlock.SetFocus;
    cboSrchTypeBlock.ListIndex = 0;
    $txtSrchBlock.Value = "";
    cboSrchTypeOwnComp.SetFocus;
    cboSrchTypeOwnComp.ListIndex = 0;
    cboSrchOwnComp.SetFocus;
    cboSrchOwnComp.SelText = "";
    cboSrchTypeStatus.SetFocus;
    cboSrchTypeStatus.ListIndex = 0;
    cboSrchStatus.SetFocus;
    cboSrchStatus.SelText = "";
    cboSrchTypeOpStatus.SetFocus;
    cboSrchTypeOpStatus.ListIndex = 0;
    cboSrchOpStatus.SetFocus;
    cboSrchOpStatus.SelText = "";

    // Clear search result listbox;
    $lstSearchResults.RowSource = "";
    $lblSearchResults.Caption = "Search Results:";

    // Reset the edit form;
    SetHiddenFieldsAndForm (False);

    // Set focus to top;
    $txtSrchName.SetFocus;
};

function TranDispYesNo($strCurrVal);
    // This function will transform data coming from DB to correct text to be;
    // selected for user in cbo on form.  This should probably be updated to;
    // better generic code - maybe even implement a class.;
    $strYESText = "Yes";
    $strTRUEText = "True";
    $strNOText = "No";
    $strFALSEText = "False";

    $strRetTxt;

    // Initialize var;
    $strRetTxt = "";

    // Do proper txt correlation and return proper text so it is selected;
    // properly.;
    if ($strCurrVal = $strTRUEText) {
        $strRetTxt = $strYESText;
    } else {
        $strRetTxt = $strNOText;
    }

    // Return text;
    TranDispYesNo = $strRetTxt;
};

function TransformNullToEmpty($objOrigVal);
    // This function will take an object and check for NULL, if it is NULL it will;
    // replace the NULL with an empty $string.;

    $strRetVal = "";

    if IsNull($objOrigVal) = True {
        // Is NULL so transform to empty $string;
        $strRetVal = "";
    } else {
        // Is not NULL so keep current value;
        $strRetVal = CStr($objOrigVal);
    }

    // Return $string;
    TransformNullToEmpty = $strRetVal;
};

function SetHiddenFieldsAndForm(blnShow);
    // This sub will look through all of the edit fields and display them;
    // based upon the field tag of editCtrl;
    $ctrlGenObj;

    // Set focus to prevent hide error;
    lstSearchResults.SetFocus;

    For Each ctrlGenObj In $Controls;
        if ctrlGenObj.Tag = "editCtrl" {
            if (blnShow = True) {
                // Show edit section and controls;
                $InsideHeight = "11000";
                $InsideWidth = "14200";
                ctrlGenObj.Visible = True;
            } else {
                // Hide edit section and controls;
                $InsideHeight = "6000";
                $InsideWidth = "14200";
                ctrlGenObj.Visible = False;
            }
        }
    Next ctrlGenObj;
};

function CheckPropEditData($strName, $strOperator, $strGWIValue, $strNRIValue, $strORRIValue, $strRIValue, $strGrossAcreage, $strNetAcreage);
    // This function will check the passed data to see if it is valid to continue;
    // processing the supplied data for insert.  Blank is returned if valid, otherwise OK num code.;
    $strEdtPropRetVal;

    // Init var;
    $strEdtPropRetVal = "";

    // Check the supplied fields;
    if (($strName = "" Or $strOperator = "" Or $strGWIValue = "" Or $strNRIValue = "" Or $strORRIValue = "" Or $strRIValue = "" Or $strGrossAcreage = "" Or $strNetAcreage = "") Or (IsNumeric($strGWIValue) = False Or IsNumeric($strNRIValue) = False Or IsNumeric($strORRIValue) = False Or IsNumeric($strRIValue) = False Or IsNumeric($strGrossAcreage) = False Or IsNumeric($strNetAcreage) = False)) {
        $strEdtPropRetVal = MsgBox("The Name, Operator, Value, and Acreage fields must have values and value fields must be numeric!", vbOKOnly, "Insufficient Data");
    }

    CheckPropEditData = $strEdtPropRetVal;
};

function FormatString($strTransTxt, $strTranYesNo);
    // This function will take a $string and transform it to remove leading or trailing;
    // spaces. -- only called when creating SQL;
    $strYESText = "Yes";
    $strYesCode = "-1";
    $strNOText = "No";
    $strNoCode = "0";

    $strTempTxt;

    $strTempTxt = "";

    // Get passed text and transform if necessary;
    $strTempTxt = $strTransTxt;
    if ($strTempTxt <> "") {
        $strTempTxt = Trim($strTempTxt);
        $strTempTxt = RepSglWithDbl($strTempTxt);
        // if transforming a YN field check and perform transform;
        if ($strTranYesNo = True And $strTempTxt = $strYESText) {
            $strTempTxt = $strYesCode;
        elseif ($strTranYesNo = True And $strTempTxt = $strNOText) {
            $strTempTxt = $strNoCode;
        }
    }

    FormatString = $strTempTxt;
};

function RepSglWithDbl($strOrigTxt);
    // This function will replace any single quotes with double ticks to allow;
    // $string to work properly in SQL command.;
    $strWorkingTxt;

    $strWorkingTxt = "";

    // Get passed text and transform it.;
    $strWorkingTxt = Replace($strOrigTxt, "// ", "// // ");

    // Return new $string;
    RepSglWithDbl = $strWorkingTxt;
};

function ResetAllEditFields(){
    // This sub will reset all edit fields to blank or unselected;

    cboEditLoc.SetFocus;
    cboEditLoc.ListIndex = 0;
    $txtEditName.Value = "";
    cboEditStatus.SetFocus;
    cboEditStatus.ListIndex = 0;
    cboEditOpStatus.SetFocus;
    cboEditOpStatus.ListIndex = 0;
    cboEditOwnComp.SetFocus;
    cboEditOwnComp.ListIndex = 0;
    $txtEditOp.Value = "";
    cboEditWI.SetFocus;
    cboEditWI.ListIndex = 0;
    cboEditRI.SetFocus;
    cboEditRI.ListIndex = 0;
    cboEditORRI.SetFocus;
    cboEditORRI.ListIndex = 0;
    cboEditBIAPO.SetFocus;
    cboEditBIAPO.ListIndex = 0;
    cboEditWBO.SetFocus;
    cboEditWBO.ListIndex = 0;
    $txtEditLegDesc.Value = "";
    $txtEditAPI.Value = "";
    $txtEditGWIVal.Value = "";
    $txtEditNRIVal.Value = "";
    $txtEditORRIVal.Value = "";
    $txtEditRIVal.Value = "";
    $txtEditWPCode.Value = "";
    $txtEditGrossAcres.Value = "";
    $txtEditNetAcres.Value = "";
    $txtEditLeaseNum.Value = "";

    // Set focus to search at top;
    txtSrchName.SetFocus;
};

function FindUserName(){
    //  This procedure uses the Win32API function GetUserName;
    //  to return the name of the user currently logged on to;
    //  this machine. The Declare statement for the API function;
    //  is located in the Declarations section of this module.;
   ;
    $strBuffer;
    $lngSize;
    $strCurrUser;

    $strCurrUser = "";
    $strBuffer = String(100, " ");
    lngSize = Len($strBuffer);

    // May need to remove NULL character returned from included DLL library;
    if GetUserName($strBuffer, lngSize) = 1 {
         $strCurrUser = Replace(Left($strBuffer, lngSize), Chr(0), "");
    } else {
        $strCurrUser = "(Not Available)";
    }

    FindUserName = Trim($strCurrUser);

 };
