<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "campaign_reportinfo.php" ?>
<?php include_once "cms_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$campaign_report_delete = NULL; // Initialize page object first

class ccampaign_report_delete extends ccampaign_report {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{8281128E-C7BB-40DA-A1AE-8695DB7283AC}';

	// Table name
	var $TableName = 'campaign_report';

	// Page object name
	var $PageObjName = 'campaign_report_delete';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (campaign_report)
		if (!isset($GLOBALS["campaign_report"]) || get_class($GLOBALS["campaign_report"]) == "ccampaign_report") {
			$GLOBALS["campaign_report"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["campaign_report"];
		}

		// Table object (cms_users)
		if (!isset($GLOBALS['cms_users'])) $GLOBALS['cms_users'] = new ccms_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'campaign_report', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

		// User table object (cms_users)
		if (!isset($UserTable)) {
			$UserTable = new ccms_users();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("campaign_reportlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->campaignReportID->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->campaignReportID->Visible = FALSE;
		$this->campaignID->SetVisibility();
		$this->campaignLanguage->SetVisibility();
		$this->fullName->SetVisibility();
		$this->_email->SetVisibility();
		$this->phone->SetVisibility();
		$this->dateCreated->SetVisibility();
		$this->status->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $campaign_report;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($campaign_report);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		// Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("campaign_reportlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in campaign_report class, campaign_reportinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("campaign_reportlist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->campaignReportID->setDbValue($row['campaignReportID']);
		$this->campaignID->setDbValue($row['campaignID']);
		$this->campaignLanguage->setDbValue($row['campaignLanguage']);
		$this->fullName->setDbValue($row['fullName']);
		$this->_email->setDbValue($row['email']);
		$this->phone->setDbValue($row['phone']);
		$this->message->setDbValue($row['message']);
		$this->dateCreated->setDbValue($row['dateCreated']);
		$this->status->setDbValue($row['status']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['campaignReportID'] = NULL;
		$row['campaignID'] = NULL;
		$row['campaignLanguage'] = NULL;
		$row['fullName'] = NULL;
		$row['email'] = NULL;
		$row['phone'] = NULL;
		$row['message'] = NULL;
		$row['dateCreated'] = NULL;
		$row['status'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->campaignReportID->DbValue = $row['campaignReportID'];
		$this->campaignID->DbValue = $row['campaignID'];
		$this->campaignLanguage->DbValue = $row['campaignLanguage'];
		$this->fullName->DbValue = $row['fullName'];
		$this->_email->DbValue = $row['email'];
		$this->phone->DbValue = $row['phone'];
		$this->message->DbValue = $row['message'];
		$this->dateCreated->DbValue = $row['dateCreated'];
		$this->status->DbValue = $row['status'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// campaignReportID
		// campaignID
		// campaignLanguage
		// fullName
		// email
		// phone
		// message
		// dateCreated
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// campaignReportID
		$this->campaignReportID->ViewValue = $this->campaignReportID->CurrentValue;
		$this->campaignReportID->ViewCustomAttributes = "";

		// campaignID
		if (strval($this->campaignID->CurrentValue) <> "") {
			$sFilterWrk = "`campaignID`" . ew_SearchString("=", $this->campaignID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `campaignID`, `title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `campaign_master`";
		$sWhereWrk = "";
		$this->campaignID->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->campaignID, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->campaignID->ViewValue = $this->campaignID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->campaignID->ViewValue = $this->campaignID->CurrentValue;
			}
		} else {
			$this->campaignID->ViewValue = NULL;
		}
		$this->campaignID->ViewCustomAttributes = "";

		// campaignLanguage
		if (strval($this->campaignLanguage->CurrentValue) <> "") {
			$this->campaignLanguage->ViewValue = $this->campaignLanguage->OptionCaption($this->campaignLanguage->CurrentValue);
		} else {
			$this->campaignLanguage->ViewValue = NULL;
		}
		$this->campaignLanguage->ViewCustomAttributes = "";

		// fullName
		$this->fullName->ViewValue = $this->fullName->CurrentValue;
		$this->fullName->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// phone
		$this->phone->ViewValue = $this->phone->CurrentValue;
		$this->phone->ViewCustomAttributes = "";

		// dateCreated
		$this->dateCreated->ViewValue = $this->dateCreated->CurrentValue;
		$this->dateCreated->ViewValue = ew_FormatDateTime($this->dateCreated->ViewValue, 7);
		$this->dateCreated->ViewCustomAttributes = "";

		// status
		if (strval($this->status->CurrentValue) <> "") {
			$this->status->ViewValue = $this->status->OptionCaption($this->status->CurrentValue);
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

			// campaignReportID
			$this->campaignReportID->LinkCustomAttributes = "";
			$this->campaignReportID->HrefValue = "";
			$this->campaignReportID->TooltipValue = "";

			// campaignID
			$this->campaignID->LinkCustomAttributes = "";
			$this->campaignID->HrefValue = "";
			$this->campaignID->TooltipValue = "";

			// campaignLanguage
			$this->campaignLanguage->LinkCustomAttributes = "";
			$this->campaignLanguage->HrefValue = "";
			$this->campaignLanguage->TooltipValue = "";

			// fullName
			$this->fullName->LinkCustomAttributes = "";
			$this->fullName->HrefValue = "";
			$this->fullName->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";
			$this->phone->TooltipValue = "";

			// dateCreated
			$this->dateCreated->LinkCustomAttributes = "";
			$this->dateCreated->HrefValue = "";
			$this->dateCreated->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['campaignReportID'];

				// Delete old files
				$this->LoadDbValues($row);
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("campaign_reportlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($campaign_report_delete)) $campaign_report_delete = new ccampaign_report_delete();

// Page init
$campaign_report_delete->Page_Init();

// Page main
$campaign_report_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$campaign_report_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fcampaign_reportdelete = new ew_Form("fcampaign_reportdelete", "delete");

// Form_CustomValidate event
fcampaign_reportdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcampaign_reportdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcampaign_reportdelete.Lists["x_campaignID"] = {"LinkField":"x_campaignID","Ajax":true,"AutoFill":false,"DisplayFields":["x_title","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"campaign_master"};
fcampaign_reportdelete.Lists["x_campaignID"].Data = "<?php echo $campaign_report_delete->campaignID->LookupFilterQuery(FALSE, "delete") ?>";
fcampaign_reportdelete.Lists["x_campaignLanguage"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcampaign_reportdelete.Lists["x_campaignLanguage"].Options = <?php echo json_encode($campaign_report_delete->campaignLanguage->Options()) ?>;
fcampaign_reportdelete.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcampaign_reportdelete.Lists["x_status"].Options = <?php echo json_encode($campaign_report_delete->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $campaign_report_delete->ShowPageHeader(); ?>
<?php
$campaign_report_delete->ShowMessage();
?>
<form name="fcampaign_reportdelete" id="fcampaign_reportdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($campaign_report_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $campaign_report_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="campaign_report">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($campaign_report_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($campaign_report->campaignReportID->Visible) { // campaignReportID ?>
		<th class="<?php echo $campaign_report->campaignReportID->HeaderCellClass() ?>"><span id="elh_campaign_report_campaignReportID" class="campaign_report_campaignReportID"><?php echo $campaign_report->campaignReportID->FldCaption() ?></span></th>
<?php } ?>
<?php if ($campaign_report->campaignID->Visible) { // campaignID ?>
		<th class="<?php echo $campaign_report->campaignID->HeaderCellClass() ?>"><span id="elh_campaign_report_campaignID" class="campaign_report_campaignID"><?php echo $campaign_report->campaignID->FldCaption() ?></span></th>
<?php } ?>
<?php if ($campaign_report->campaignLanguage->Visible) { // campaignLanguage ?>
		<th class="<?php echo $campaign_report->campaignLanguage->HeaderCellClass() ?>"><span id="elh_campaign_report_campaignLanguage" class="campaign_report_campaignLanguage"><?php echo $campaign_report->campaignLanguage->FldCaption() ?></span></th>
<?php } ?>
<?php if ($campaign_report->fullName->Visible) { // fullName ?>
		<th class="<?php echo $campaign_report->fullName->HeaderCellClass() ?>"><span id="elh_campaign_report_fullName" class="campaign_report_fullName"><?php echo $campaign_report->fullName->FldCaption() ?></span></th>
<?php } ?>
<?php if ($campaign_report->_email->Visible) { // email ?>
		<th class="<?php echo $campaign_report->_email->HeaderCellClass() ?>"><span id="elh_campaign_report__email" class="campaign_report__email"><?php echo $campaign_report->_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($campaign_report->phone->Visible) { // phone ?>
		<th class="<?php echo $campaign_report->phone->HeaderCellClass() ?>"><span id="elh_campaign_report_phone" class="campaign_report_phone"><?php echo $campaign_report->phone->FldCaption() ?></span></th>
<?php } ?>
<?php if ($campaign_report->dateCreated->Visible) { // dateCreated ?>
		<th class="<?php echo $campaign_report->dateCreated->HeaderCellClass() ?>"><span id="elh_campaign_report_dateCreated" class="campaign_report_dateCreated"><?php echo $campaign_report->dateCreated->FldCaption() ?></span></th>
<?php } ?>
<?php if ($campaign_report->status->Visible) { // status ?>
		<th class="<?php echo $campaign_report->status->HeaderCellClass() ?>"><span id="elh_campaign_report_status" class="campaign_report_status"><?php echo $campaign_report->status->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$campaign_report_delete->RecCnt = 0;
$i = 0;
while (!$campaign_report_delete->Recordset->EOF) {
	$campaign_report_delete->RecCnt++;
	$campaign_report_delete->RowCnt++;

	// Set row properties
	$campaign_report->ResetAttrs();
	$campaign_report->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$campaign_report_delete->LoadRowValues($campaign_report_delete->Recordset);

	// Render row
	$campaign_report_delete->RenderRow();
?>
	<tr<?php echo $campaign_report->RowAttributes() ?>>
<?php if ($campaign_report->campaignReportID->Visible) { // campaignReportID ?>
		<td<?php echo $campaign_report->campaignReportID->CellAttributes() ?>>
<span id="el<?php echo $campaign_report_delete->RowCnt ?>_campaign_report_campaignReportID" class="campaign_report_campaignReportID">
<span<?php echo $campaign_report->campaignReportID->ViewAttributes() ?>>
<?php echo $campaign_report->campaignReportID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($campaign_report->campaignID->Visible) { // campaignID ?>
		<td<?php echo $campaign_report->campaignID->CellAttributes() ?>>
<span id="el<?php echo $campaign_report_delete->RowCnt ?>_campaign_report_campaignID" class="campaign_report_campaignID">
<span<?php echo $campaign_report->campaignID->ViewAttributes() ?>>
<?php echo $campaign_report->campaignID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($campaign_report->campaignLanguage->Visible) { // campaignLanguage ?>
		<td<?php echo $campaign_report->campaignLanguage->CellAttributes() ?>>
<span id="el<?php echo $campaign_report_delete->RowCnt ?>_campaign_report_campaignLanguage" class="campaign_report_campaignLanguage">
<span<?php echo $campaign_report->campaignLanguage->ViewAttributes() ?>>
<?php echo $campaign_report->campaignLanguage->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($campaign_report->fullName->Visible) { // fullName ?>
		<td<?php echo $campaign_report->fullName->CellAttributes() ?>>
<span id="el<?php echo $campaign_report_delete->RowCnt ?>_campaign_report_fullName" class="campaign_report_fullName">
<span<?php echo $campaign_report->fullName->ViewAttributes() ?>>
<?php echo $campaign_report->fullName->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($campaign_report->_email->Visible) { // email ?>
		<td<?php echo $campaign_report->_email->CellAttributes() ?>>
<span id="el<?php echo $campaign_report_delete->RowCnt ?>_campaign_report__email" class="campaign_report__email">
<span<?php echo $campaign_report->_email->ViewAttributes() ?>>
<?php echo $campaign_report->_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($campaign_report->phone->Visible) { // phone ?>
		<td<?php echo $campaign_report->phone->CellAttributes() ?>>
<span id="el<?php echo $campaign_report_delete->RowCnt ?>_campaign_report_phone" class="campaign_report_phone">
<span<?php echo $campaign_report->phone->ViewAttributes() ?>>
<?php echo $campaign_report->phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($campaign_report->dateCreated->Visible) { // dateCreated ?>
		<td<?php echo $campaign_report->dateCreated->CellAttributes() ?>>
<span id="el<?php echo $campaign_report_delete->RowCnt ?>_campaign_report_dateCreated" class="campaign_report_dateCreated">
<span<?php echo $campaign_report->dateCreated->ViewAttributes() ?>>
<?php echo $campaign_report->dateCreated->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($campaign_report->status->Visible) { // status ?>
		<td<?php echo $campaign_report->status->CellAttributes() ?>>
<span id="el<?php echo $campaign_report_delete->RowCnt ?>_campaign_report_status" class="campaign_report_status">
<span<?php echo $campaign_report->status->ViewAttributes() ?>>
<?php echo $campaign_report->status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$campaign_report_delete->Recordset->MoveNext();
}
$campaign_report_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $campaign_report_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fcampaign_reportdelete.Init();
</script>
<?php
$campaign_report_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$campaign_report_delete->Page_Terminate();
?>
