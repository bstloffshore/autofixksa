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

$campaign_report_edit = NULL; // Initialize page object first

class ccampaign_report_edit extends ccampaign_report {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{8281128E-C7BB-40DA-A1AE-8695DB7283AC}';

	// Table name
	var $TableName = 'campaign_report';

	// Page object name
	var $PageObjName = 'campaign_report_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanEdit()) {
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
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->campaignReportID->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->campaignReportID->Visible = FALSE;
		$this->campaignID->SetVisibility();
		$this->campaignLanguage->SetVisibility();
		$this->fullName->SetVisibility();
		$this->_email->SetVisibility();
		$this->phone->SetVisibility();
		$this->message->SetVisibility();
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "campaign_reportview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_campaignReportID")) {
				$this->campaignReportID->setFormValue($objForm->GetValue("x_campaignReportID"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["campaignReportID"])) {
				$this->campaignReportID->setQueryStringValue($_GET["campaignReportID"]);
				$loadByQuery = TRUE;
			} else {
				$this->campaignReportID->CurrentValue = NULL;
			}
		}

		// Load current record
		$loaded = $this->LoadRow();

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("campaign_reportlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "campaign_reportlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->campaignReportID->FldIsDetailKey)
			$this->campaignReportID->setFormValue($objForm->GetValue("x_campaignReportID"));
		if (!$this->campaignID->FldIsDetailKey) {
			$this->campaignID->setFormValue($objForm->GetValue("x_campaignID"));
		}
		if (!$this->campaignLanguage->FldIsDetailKey) {
			$this->campaignLanguage->setFormValue($objForm->GetValue("x_campaignLanguage"));
		}
		if (!$this->fullName->FldIsDetailKey) {
			$this->fullName->setFormValue($objForm->GetValue("x_fullName"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->phone->FldIsDetailKey) {
			$this->phone->setFormValue($objForm->GetValue("x_phone"));
		}
		if (!$this->message->FldIsDetailKey) {
			$this->message->setFormValue($objForm->GetValue("x_message"));
		}
		if (!$this->dateCreated->FldIsDetailKey) {
			$this->dateCreated->setFormValue($objForm->GetValue("x_dateCreated"));
			$this->dateCreated->CurrentValue = ew_UnFormatDateTime($this->dateCreated->CurrentValue, 7);
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->campaignReportID->CurrentValue = $this->campaignReportID->FormValue;
		$this->campaignID->CurrentValue = $this->campaignID->FormValue;
		$this->campaignLanguage->CurrentValue = $this->campaignLanguage->FormValue;
		$this->fullName->CurrentValue = $this->fullName->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->phone->CurrentValue = $this->phone->FormValue;
		$this->message->CurrentValue = $this->message->FormValue;
		$this->dateCreated->CurrentValue = $this->dateCreated->FormValue;
		$this->dateCreated->CurrentValue = ew_UnFormatDateTime($this->dateCreated->CurrentValue, 7);
		$this->status->CurrentValue = $this->status->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("campaignReportID")) <> "")
			$this->campaignReportID->CurrentValue = $this->getKey("campaignReportID"); // campaignReportID
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
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

		// message
		$this->message->ViewValue = $this->message->CurrentValue;
		$this->message->ViewCustomAttributes = "";

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

			// message
			$this->message->LinkCustomAttributes = "";
			$this->message->HrefValue = "";
			$this->message->TooltipValue = "";

			// dateCreated
			$this->dateCreated->LinkCustomAttributes = "";
			$this->dateCreated->HrefValue = "";
			$this->dateCreated->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// campaignReportID
			$this->campaignReportID->EditAttrs["class"] = "form-control";
			$this->campaignReportID->EditCustomAttributes = "";
			$this->campaignReportID->EditValue = $this->campaignReportID->CurrentValue;
			$this->campaignReportID->ViewCustomAttributes = "";

			// campaignID
			$this->campaignID->EditAttrs["class"] = "form-control";
			$this->campaignID->EditCustomAttributes = "";
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
					$this->campaignID->EditValue = $this->campaignID->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->campaignID->EditValue = $this->campaignID->CurrentValue;
				}
			} else {
				$this->campaignID->EditValue = NULL;
			}
			$this->campaignID->ViewCustomAttributes = "";

			// campaignLanguage
			$this->campaignLanguage->EditAttrs["class"] = "form-control";
			$this->campaignLanguage->EditCustomAttributes = "";
			if (strval($this->campaignLanguage->CurrentValue) <> "") {
				$this->campaignLanguage->EditValue = $this->campaignLanguage->OptionCaption($this->campaignLanguage->CurrentValue);
			} else {
				$this->campaignLanguage->EditValue = NULL;
			}
			$this->campaignLanguage->ViewCustomAttributes = "";

			// fullName
			$this->fullName->EditAttrs["class"] = "form-control";
			$this->fullName->EditCustomAttributes = "";
			$this->fullName->EditValue = $this->fullName->CurrentValue;
			$this->fullName->ViewCustomAttributes = "";

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// phone
			$this->phone->EditAttrs["class"] = "form-control";
			$this->phone->EditCustomAttributes = "";
			$this->phone->EditValue = $this->phone->CurrentValue;
			$this->phone->ViewCustomAttributes = "";

			// message
			$this->message->EditAttrs["class"] = "form-control";
			$this->message->EditCustomAttributes = "";
			$this->message->EditValue = $this->message->CurrentValue;
			$this->message->ViewCustomAttributes = "";

			// dateCreated
			$this->dateCreated->EditAttrs["class"] = "form-control";
			$this->dateCreated->EditCustomAttributes = "";
			$this->dateCreated->EditValue = $this->dateCreated->CurrentValue;
			$this->dateCreated->EditValue = ew_FormatDateTime($this->dateCreated->EditValue, 7);
			$this->dateCreated->ViewCustomAttributes = "";

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(TRUE);

			// Edit refer script
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

			// message
			$this->message->LinkCustomAttributes = "";
			$this->message->HrefValue = "";
			$this->message->TooltipValue = "";

			// dateCreated
			$this->dateCreated->LinkCustomAttributes = "";
			$this->dateCreated->HrefValue = "";
			$this->dateCreated->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, NULL, $this->status->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("campaign_reportlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($campaign_report_edit)) $campaign_report_edit = new ccampaign_report_edit();

// Page init
$campaign_report_edit->Page_Init();

// Page main
$campaign_report_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$campaign_report_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fcampaign_reportedit = new ew_Form("fcampaign_reportedit", "edit");

// Validate form
fcampaign_reportedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fcampaign_reportedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcampaign_reportedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcampaign_reportedit.Lists["x_campaignID"] = {"LinkField":"x_campaignID","Ajax":true,"AutoFill":false,"DisplayFields":["x_title","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"campaign_master"};
fcampaign_reportedit.Lists["x_campaignID"].Data = "<?php echo $campaign_report_edit->campaignID->LookupFilterQuery(FALSE, "edit") ?>";
fcampaign_reportedit.Lists["x_campaignLanguage"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcampaign_reportedit.Lists["x_campaignLanguage"].Options = <?php echo json_encode($campaign_report_edit->campaignLanguage->Options()) ?>;
fcampaign_reportedit.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcampaign_reportedit.Lists["x_status"].Options = <?php echo json_encode($campaign_report_edit->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $campaign_report_edit->ShowPageHeader(); ?>
<?php
$campaign_report_edit->ShowMessage();
?>
<form name="fcampaign_reportedit" id="fcampaign_reportedit" class="<?php echo $campaign_report_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($campaign_report_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $campaign_report_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="campaign_report">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($campaign_report_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($campaign_report->campaignReportID->Visible) { // campaignReportID ?>
	<div id="r_campaignReportID" class="form-group">
		<label id="elh_campaign_report_campaignReportID" class="<?php echo $campaign_report_edit->LeftColumnClass ?>"><?php echo $campaign_report->campaignReportID->FldCaption() ?></label>
		<div class="<?php echo $campaign_report_edit->RightColumnClass ?>"><div<?php echo $campaign_report->campaignReportID->CellAttributes() ?>>
<span id="el_campaign_report_campaignReportID">
<span<?php echo $campaign_report->campaignReportID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $campaign_report->campaignReportID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="campaign_report" data-field="x_campaignReportID" name="x_campaignReportID" id="x_campaignReportID" value="<?php echo ew_HtmlEncode($campaign_report->campaignReportID->CurrentValue) ?>">
<?php echo $campaign_report->campaignReportID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_report->campaignID->Visible) { // campaignID ?>
	<div id="r_campaignID" class="form-group">
		<label id="elh_campaign_report_campaignID" for="x_campaignID" class="<?php echo $campaign_report_edit->LeftColumnClass ?>"><?php echo $campaign_report->campaignID->FldCaption() ?></label>
		<div class="<?php echo $campaign_report_edit->RightColumnClass ?>"><div<?php echo $campaign_report->campaignID->CellAttributes() ?>>
<span id="el_campaign_report_campaignID">
<span<?php echo $campaign_report->campaignID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $campaign_report->campaignID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="campaign_report" data-field="x_campaignID" name="x_campaignID" id="x_campaignID" value="<?php echo ew_HtmlEncode($campaign_report->campaignID->CurrentValue) ?>">
<?php echo $campaign_report->campaignID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_report->campaignLanguage->Visible) { // campaignLanguage ?>
	<div id="r_campaignLanguage" class="form-group">
		<label id="elh_campaign_report_campaignLanguage" for="x_campaignLanguage" class="<?php echo $campaign_report_edit->LeftColumnClass ?>"><?php echo $campaign_report->campaignLanguage->FldCaption() ?></label>
		<div class="<?php echo $campaign_report_edit->RightColumnClass ?>"><div<?php echo $campaign_report->campaignLanguage->CellAttributes() ?>>
<span id="el_campaign_report_campaignLanguage">
<span<?php echo $campaign_report->campaignLanguage->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $campaign_report->campaignLanguage->EditValue ?></p></span>
</span>
<input type="hidden" data-table="campaign_report" data-field="x_campaignLanguage" name="x_campaignLanguage" id="x_campaignLanguage" value="<?php echo ew_HtmlEncode($campaign_report->campaignLanguage->CurrentValue) ?>">
<?php echo $campaign_report->campaignLanguage->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_report->fullName->Visible) { // fullName ?>
	<div id="r_fullName" class="form-group">
		<label id="elh_campaign_report_fullName" for="x_fullName" class="<?php echo $campaign_report_edit->LeftColumnClass ?>"><?php echo $campaign_report->fullName->FldCaption() ?></label>
		<div class="<?php echo $campaign_report_edit->RightColumnClass ?>"><div<?php echo $campaign_report->fullName->CellAttributes() ?>>
<span id="el_campaign_report_fullName">
<span<?php echo $campaign_report->fullName->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $campaign_report->fullName->EditValue ?></p></span>
</span>
<input type="hidden" data-table="campaign_report" data-field="x_fullName" name="x_fullName" id="x_fullName" value="<?php echo ew_HtmlEncode($campaign_report->fullName->CurrentValue) ?>">
<?php echo $campaign_report->fullName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_report->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_campaign_report__email" for="x__email" class="<?php echo $campaign_report_edit->LeftColumnClass ?>"><?php echo $campaign_report->_email->FldCaption() ?></label>
		<div class="<?php echo $campaign_report_edit->RightColumnClass ?>"><div<?php echo $campaign_report->_email->CellAttributes() ?>>
<span id="el_campaign_report__email">
<span<?php echo $campaign_report->_email->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $campaign_report->_email->EditValue ?></p></span>
</span>
<input type="hidden" data-table="campaign_report" data-field="x__email" name="x__email" id="x__email" value="<?php echo ew_HtmlEncode($campaign_report->_email->CurrentValue) ?>">
<?php echo $campaign_report->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_report->phone->Visible) { // phone ?>
	<div id="r_phone" class="form-group">
		<label id="elh_campaign_report_phone" for="x_phone" class="<?php echo $campaign_report_edit->LeftColumnClass ?>"><?php echo $campaign_report->phone->FldCaption() ?></label>
		<div class="<?php echo $campaign_report_edit->RightColumnClass ?>"><div<?php echo $campaign_report->phone->CellAttributes() ?>>
<span id="el_campaign_report_phone">
<span<?php echo $campaign_report->phone->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $campaign_report->phone->EditValue ?></p></span>
</span>
<input type="hidden" data-table="campaign_report" data-field="x_phone" name="x_phone" id="x_phone" value="<?php echo ew_HtmlEncode($campaign_report->phone->CurrentValue) ?>">
<?php echo $campaign_report->phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_report->message->Visible) { // message ?>
	<div id="r_message" class="form-group">
		<label id="elh_campaign_report_message" class="<?php echo $campaign_report_edit->LeftColumnClass ?>"><?php echo $campaign_report->message->FldCaption() ?></label>
		<div class="<?php echo $campaign_report_edit->RightColumnClass ?>"><div<?php echo $campaign_report->message->CellAttributes() ?>>
<span id="el_campaign_report_message">
<?php ew_AppendClass($campaign_report->message->EditAttrs["class"], "editor"); ?>
<textarea data-table="campaign_report" data-field="x_message" name="x_message" id="x_message" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($campaign_report->message->getPlaceHolder()) ?>"<?php echo $campaign_report->message->EditAttributes() ?>><?php echo $campaign_report->message->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fcampaign_reportedit", "x_message", 35, 4, <?php echo ($campaign_report->message->ReadOnly || TRUE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $campaign_report->message->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_report->dateCreated->Visible) { // dateCreated ?>
	<div id="r_dateCreated" class="form-group">
		<label id="elh_campaign_report_dateCreated" for="x_dateCreated" class="<?php echo $campaign_report_edit->LeftColumnClass ?>"><?php echo $campaign_report->dateCreated->FldCaption() ?></label>
		<div class="<?php echo $campaign_report_edit->RightColumnClass ?>"><div<?php echo $campaign_report->dateCreated->CellAttributes() ?>>
<span id="el_campaign_report_dateCreated">
<span<?php echo $campaign_report->dateCreated->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $campaign_report->dateCreated->EditValue ?></p></span>
</span>
<input type="hidden" data-table="campaign_report" data-field="x_dateCreated" name="x_dateCreated" id="x_dateCreated" value="<?php echo ew_HtmlEncode($campaign_report->dateCreated->CurrentValue) ?>">
<?php echo $campaign_report->dateCreated->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_report->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_campaign_report_status" for="x_status" class="<?php echo $campaign_report_edit->LeftColumnClass ?>"><?php echo $campaign_report->status->FldCaption() ?></label>
		<div class="<?php echo $campaign_report_edit->RightColumnClass ?>"><div<?php echo $campaign_report->status->CellAttributes() ?>>
<span id="el_campaign_report_status">
<select data-table="campaign_report" data-field="x_status" data-value-separator="<?php echo $campaign_report->status->DisplayValueSeparatorAttribute() ?>" id="x_status" name="x_status"<?php echo $campaign_report->status->EditAttributes() ?>>
<?php echo $campaign_report->status->SelectOptionListHtml("x_status") ?>
</select>
</span>
<?php echo $campaign_report->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$campaign_report_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $campaign_report_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $campaign_report_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcampaign_reportedit.Init();
</script>
<?php
$campaign_report_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$campaign_report_edit->Page_Terminate();
?>
