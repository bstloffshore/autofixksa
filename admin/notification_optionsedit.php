<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "notification_optionsinfo.php" ?>
<?php include_once "cms_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$notification_options_edit = NULL; // Initialize page object first

class cnotification_options_edit extends cnotification_options {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{8281128E-C7BB-40DA-A1AE-8695DB7283AC}';

	// Table name
	var $TableName = 'notification_options';

	// Page object name
	var $PageObjName = 'notification_options_edit';

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

		// Table object (notification_options)
		if (!isset($GLOBALS["notification_options"]) || get_class($GLOBALS["notification_options"]) == "cnotification_options") {
			$GLOBALS["notification_options"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["notification_options"];
		}

		// Table object (cms_users)
		if (!isset($GLOBALS['cms_users'])) $GLOBALS['cms_users'] = new ccms_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'notification_options', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("notification_optionslist.php"));
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
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->notificationType->SetVisibility();
		$this->emailOutboundName->SetVisibility();
		$this->emailOutbound->SetVisibility();
		$this->autorespondSubject->SetVisibility();
		$this->autorespondMessage->SetVisibility();
		$this->int_notificationSubject->SetVisibility();
		$this->int_notificationMessage->SetVisibility();
		$this->resultPageMessage->SetVisibility();

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
		global $EW_EXPORT, $notification_options;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($notification_options);
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
					if ($pageName == "notification_optionsview.php")
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
			if ($objForm->HasValue("x_id")) {
				$this->id->setFormValue($objForm->GetValue("x_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["id"])) {
				$this->id->setQueryStringValue($_GET["id"]);
				$loadByQuery = TRUE;
			} else {
				$this->id->CurrentValue = NULL;
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
					$this->Page_Terminate("notification_optionslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "notification_optionslist.php")
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
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->notificationType->FldIsDetailKey) {
			$this->notificationType->setFormValue($objForm->GetValue("x_notificationType"));
		}
		if (!$this->emailOutboundName->FldIsDetailKey) {
			$this->emailOutboundName->setFormValue($objForm->GetValue("x_emailOutboundName"));
		}
		if (!$this->emailOutbound->FldIsDetailKey) {
			$this->emailOutbound->setFormValue($objForm->GetValue("x_emailOutbound"));
		}
		if (!$this->autorespondSubject->FldIsDetailKey) {
			$this->autorespondSubject->setFormValue($objForm->GetValue("x_autorespondSubject"));
		}
		if (!$this->autorespondMessage->FldIsDetailKey) {
			$this->autorespondMessage->setFormValue($objForm->GetValue("x_autorespondMessage"));
		}
		if (!$this->int_notificationSubject->FldIsDetailKey) {
			$this->int_notificationSubject->setFormValue($objForm->GetValue("x_int_notificationSubject"));
		}
		if (!$this->int_notificationMessage->FldIsDetailKey) {
			$this->int_notificationMessage->setFormValue($objForm->GetValue("x_int_notificationMessage"));
		}
		if (!$this->resultPageMessage->FldIsDetailKey) {
			$this->resultPageMessage->setFormValue($objForm->GetValue("x_resultPageMessage"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id->CurrentValue = $this->id->FormValue;
		$this->notificationType->CurrentValue = $this->notificationType->FormValue;
		$this->emailOutboundName->CurrentValue = $this->emailOutboundName->FormValue;
		$this->emailOutbound->CurrentValue = $this->emailOutbound->FormValue;
		$this->autorespondSubject->CurrentValue = $this->autorespondSubject->FormValue;
		$this->autorespondMessage->CurrentValue = $this->autorespondMessage->FormValue;
		$this->int_notificationSubject->CurrentValue = $this->int_notificationSubject->FormValue;
		$this->int_notificationMessage->CurrentValue = $this->int_notificationMessage->FormValue;
		$this->resultPageMessage->CurrentValue = $this->resultPageMessage->FormValue;
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
		$this->id->setDbValue($row['id']);
		$this->notificationType->setDbValue($row['notificationType']);
		$this->emailOutboundName->setDbValue($row['emailOutboundName']);
		$this->emailOutbound->setDbValue($row['emailOutbound']);
		$this->autorespondSubject->setDbValue($row['autorespondSubject']);
		$this->autorespondMessage->setDbValue($row['autorespondMessage']);
		$this->int_notificationSubject->setDbValue($row['int_notificationSubject']);
		$this->int_notificationMessage->setDbValue($row['int_notificationMessage']);
		$this->resultPageMessage->setDbValue($row['resultPageMessage']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['notificationType'] = NULL;
		$row['emailOutboundName'] = NULL;
		$row['emailOutbound'] = NULL;
		$row['autorespondSubject'] = NULL;
		$row['autorespondMessage'] = NULL;
		$row['int_notificationSubject'] = NULL;
		$row['int_notificationMessage'] = NULL;
		$row['resultPageMessage'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->notificationType->DbValue = $row['notificationType'];
		$this->emailOutboundName->DbValue = $row['emailOutboundName'];
		$this->emailOutbound->DbValue = $row['emailOutbound'];
		$this->autorespondSubject->DbValue = $row['autorespondSubject'];
		$this->autorespondMessage->DbValue = $row['autorespondMessage'];
		$this->int_notificationSubject->DbValue = $row['int_notificationSubject'];
		$this->int_notificationMessage->DbValue = $row['int_notificationMessage'];
		$this->resultPageMessage->DbValue = $row['resultPageMessage'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
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
		// id
		// notificationType
		// emailOutboundName
		// emailOutbound
		// autorespondSubject
		// autorespondMessage
		// int_notificationSubject
		// int_notificationMessage
		// resultPageMessage

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// notificationType
		$this->notificationType->ViewValue = $this->notificationType->CurrentValue;
		$this->notificationType->ViewCustomAttributes = "";

		// emailOutboundName
		$this->emailOutboundName->ViewValue = $this->emailOutboundName->CurrentValue;
		$this->emailOutboundName->ViewCustomAttributes = "";

		// emailOutbound
		$this->emailOutbound->ViewValue = $this->emailOutbound->CurrentValue;
		$this->emailOutbound->ViewCustomAttributes = "";

		// autorespondSubject
		$this->autorespondSubject->ViewValue = $this->autorespondSubject->CurrentValue;
		$this->autorespondSubject->ViewCustomAttributes = "";

		// autorespondMessage
		$this->autorespondMessage->ViewValue = $this->autorespondMessage->CurrentValue;
		$this->autorespondMessage->ViewCustomAttributes = "";

		// int_notificationSubject
		$this->int_notificationSubject->ViewValue = $this->int_notificationSubject->CurrentValue;
		$this->int_notificationSubject->ViewCustomAttributes = "";

		// int_notificationMessage
		$this->int_notificationMessage->ViewValue = $this->int_notificationMessage->CurrentValue;
		$this->int_notificationMessage->ViewCustomAttributes = "";

		// resultPageMessage
		$this->resultPageMessage->ViewValue = $this->resultPageMessage->CurrentValue;
		$this->resultPageMessage->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// notificationType
			$this->notificationType->LinkCustomAttributes = "";
			$this->notificationType->HrefValue = "";
			$this->notificationType->TooltipValue = "";

			// emailOutboundName
			$this->emailOutboundName->LinkCustomAttributes = "";
			$this->emailOutboundName->HrefValue = "";
			$this->emailOutboundName->TooltipValue = "";

			// emailOutbound
			$this->emailOutbound->LinkCustomAttributes = "";
			$this->emailOutbound->HrefValue = "";
			$this->emailOutbound->TooltipValue = "";

			// autorespondSubject
			$this->autorespondSubject->LinkCustomAttributes = "";
			$this->autorespondSubject->HrefValue = "";
			$this->autorespondSubject->TooltipValue = "";

			// autorespondMessage
			$this->autorespondMessage->LinkCustomAttributes = "";
			$this->autorespondMessage->HrefValue = "";
			$this->autorespondMessage->TooltipValue = "";

			// int_notificationSubject
			$this->int_notificationSubject->LinkCustomAttributes = "";
			$this->int_notificationSubject->HrefValue = "";
			$this->int_notificationSubject->TooltipValue = "";

			// int_notificationMessage
			$this->int_notificationMessage->LinkCustomAttributes = "";
			$this->int_notificationMessage->HrefValue = "";
			$this->int_notificationMessage->TooltipValue = "";

			// resultPageMessage
			$this->resultPageMessage->LinkCustomAttributes = "";
			$this->resultPageMessage->HrefValue = "";
			$this->resultPageMessage->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// notificationType
			$this->notificationType->EditAttrs["class"] = "form-control";
			$this->notificationType->EditCustomAttributes = "";
			$this->notificationType->EditValue = ew_HtmlEncode($this->notificationType->CurrentValue);
			$this->notificationType->PlaceHolder = ew_RemoveHtml($this->notificationType->FldCaption());

			// emailOutboundName
			$this->emailOutboundName->EditAttrs["class"] = "form-control";
			$this->emailOutboundName->EditCustomAttributes = "";
			$this->emailOutboundName->EditValue = ew_HtmlEncode($this->emailOutboundName->CurrentValue);
			$this->emailOutboundName->PlaceHolder = ew_RemoveHtml($this->emailOutboundName->FldCaption());

			// emailOutbound
			$this->emailOutbound->EditAttrs["class"] = "form-control";
			$this->emailOutbound->EditCustomAttributes = "";
			$this->emailOutbound->EditValue = ew_HtmlEncode($this->emailOutbound->CurrentValue);
			$this->emailOutbound->PlaceHolder = ew_RemoveHtml($this->emailOutbound->FldCaption());

			// autorespondSubject
			$this->autorespondSubject->EditAttrs["class"] = "form-control";
			$this->autorespondSubject->EditCustomAttributes = "";
			$this->autorespondSubject->EditValue = ew_HtmlEncode($this->autorespondSubject->CurrentValue);
			$this->autorespondSubject->PlaceHolder = ew_RemoveHtml($this->autorespondSubject->FldCaption());

			// autorespondMessage
			$this->autorespondMessage->EditAttrs["class"] = "form-control";
			$this->autorespondMessage->EditCustomAttributes = "";
			$this->autorespondMessage->EditValue = ew_HtmlEncode($this->autorespondMessage->CurrentValue);
			$this->autorespondMessage->PlaceHolder = ew_RemoveHtml($this->autorespondMessage->FldCaption());

			// int_notificationSubject
			$this->int_notificationSubject->EditAttrs["class"] = "form-control";
			$this->int_notificationSubject->EditCustomAttributes = "";
			$this->int_notificationSubject->EditValue = ew_HtmlEncode($this->int_notificationSubject->CurrentValue);
			$this->int_notificationSubject->PlaceHolder = ew_RemoveHtml($this->int_notificationSubject->FldCaption());

			// int_notificationMessage
			$this->int_notificationMessage->EditAttrs["class"] = "form-control";
			$this->int_notificationMessage->EditCustomAttributes = "";
			$this->int_notificationMessage->EditValue = ew_HtmlEncode($this->int_notificationMessage->CurrentValue);
			$this->int_notificationMessage->PlaceHolder = ew_RemoveHtml($this->int_notificationMessage->FldCaption());

			// resultPageMessage
			$this->resultPageMessage->EditAttrs["class"] = "form-control";
			$this->resultPageMessage->EditCustomAttributes = "";
			$this->resultPageMessage->EditValue = ew_HtmlEncode($this->resultPageMessage->CurrentValue);
			$this->resultPageMessage->PlaceHolder = ew_RemoveHtml($this->resultPageMessage->FldCaption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// notificationType
			$this->notificationType->LinkCustomAttributes = "";
			$this->notificationType->HrefValue = "";

			// emailOutboundName
			$this->emailOutboundName->LinkCustomAttributes = "";
			$this->emailOutboundName->HrefValue = "";

			// emailOutbound
			$this->emailOutbound->LinkCustomAttributes = "";
			$this->emailOutbound->HrefValue = "";

			// autorespondSubject
			$this->autorespondSubject->LinkCustomAttributes = "";
			$this->autorespondSubject->HrefValue = "";

			// autorespondMessage
			$this->autorespondMessage->LinkCustomAttributes = "";
			$this->autorespondMessage->HrefValue = "";

			// int_notificationSubject
			$this->int_notificationSubject->LinkCustomAttributes = "";
			$this->int_notificationSubject->HrefValue = "";

			// int_notificationMessage
			$this->int_notificationMessage->LinkCustomAttributes = "";
			$this->int_notificationMessage->HrefValue = "";

			// resultPageMessage
			$this->resultPageMessage->LinkCustomAttributes = "";
			$this->resultPageMessage->HrefValue = "";
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

			// notificationType
			$this->notificationType->SetDbValueDef($rsnew, $this->notificationType->CurrentValue, NULL, $this->notificationType->ReadOnly);

			// emailOutboundName
			$this->emailOutboundName->SetDbValueDef($rsnew, $this->emailOutboundName->CurrentValue, NULL, $this->emailOutboundName->ReadOnly);

			// emailOutbound
			$this->emailOutbound->SetDbValueDef($rsnew, $this->emailOutbound->CurrentValue, NULL, $this->emailOutbound->ReadOnly);

			// autorespondSubject
			$this->autorespondSubject->SetDbValueDef($rsnew, $this->autorespondSubject->CurrentValue, NULL, $this->autorespondSubject->ReadOnly);

			// autorespondMessage
			$this->autorespondMessage->SetDbValueDef($rsnew, $this->autorespondMessage->CurrentValue, NULL, $this->autorespondMessage->ReadOnly);

			// int_notificationSubject
			$this->int_notificationSubject->SetDbValueDef($rsnew, $this->int_notificationSubject->CurrentValue, NULL, $this->int_notificationSubject->ReadOnly);

			// int_notificationMessage
			$this->int_notificationMessage->SetDbValueDef($rsnew, $this->int_notificationMessage->CurrentValue, NULL, $this->int_notificationMessage->ReadOnly);

			// resultPageMessage
			$this->resultPageMessage->SetDbValueDef($rsnew, $this->resultPageMessage->CurrentValue, NULL, $this->resultPageMessage->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("notification_optionslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($notification_options_edit)) $notification_options_edit = new cnotification_options_edit();

// Page init
$notification_options_edit->Page_Init();

// Page main
$notification_options_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$notification_options_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fnotification_optionsedit = new ew_Form("fnotification_optionsedit", "edit");

// Validate form
fnotification_optionsedit.Validate = function() {
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
fnotification_optionsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fnotification_optionsedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $notification_options_edit->ShowPageHeader(); ?>
<?php
$notification_options_edit->ShowMessage();
?>
<form name="fnotification_optionsedit" id="fnotification_optionsedit" class="<?php echo $notification_options_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($notification_options_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $notification_options_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="notification_options">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($notification_options_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($notification_options->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_notification_options_id" class="<?php echo $notification_options_edit->LeftColumnClass ?>"><?php echo $notification_options->id->FldCaption() ?></label>
		<div class="<?php echo $notification_options_edit->RightColumnClass ?>"><div<?php echo $notification_options->id->CellAttributes() ?>>
<span id="el_notification_options_id">
<span<?php echo $notification_options->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $notification_options->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="notification_options" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($notification_options->id->CurrentValue) ?>">
<?php echo $notification_options->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($notification_options->notificationType->Visible) { // notificationType ?>
	<div id="r_notificationType" class="form-group">
		<label id="elh_notification_options_notificationType" for="x_notificationType" class="<?php echo $notification_options_edit->LeftColumnClass ?>"><?php echo $notification_options->notificationType->FldCaption() ?></label>
		<div class="<?php echo $notification_options_edit->RightColumnClass ?>"><div<?php echo $notification_options->notificationType->CellAttributes() ?>>
<span id="el_notification_options_notificationType">
<input type="text" data-table="notification_options" data-field="x_notificationType" name="x_notificationType" id="x_notificationType" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($notification_options->notificationType->getPlaceHolder()) ?>" value="<?php echo $notification_options->notificationType->EditValue ?>"<?php echo $notification_options->notificationType->EditAttributes() ?>>
</span>
<?php echo $notification_options->notificationType->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($notification_options->emailOutboundName->Visible) { // emailOutboundName ?>
	<div id="r_emailOutboundName" class="form-group">
		<label id="elh_notification_options_emailOutboundName" for="x_emailOutboundName" class="<?php echo $notification_options_edit->LeftColumnClass ?>"><?php echo $notification_options->emailOutboundName->FldCaption() ?></label>
		<div class="<?php echo $notification_options_edit->RightColumnClass ?>"><div<?php echo $notification_options->emailOutboundName->CellAttributes() ?>>
<span id="el_notification_options_emailOutboundName">
<input type="text" data-table="notification_options" data-field="x_emailOutboundName" name="x_emailOutboundName" id="x_emailOutboundName" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($notification_options->emailOutboundName->getPlaceHolder()) ?>" value="<?php echo $notification_options->emailOutboundName->EditValue ?>"<?php echo $notification_options->emailOutboundName->EditAttributes() ?>>
</span>
<?php echo $notification_options->emailOutboundName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($notification_options->emailOutbound->Visible) { // emailOutbound ?>
	<div id="r_emailOutbound" class="form-group">
		<label id="elh_notification_options_emailOutbound" for="x_emailOutbound" class="<?php echo $notification_options_edit->LeftColumnClass ?>"><?php echo $notification_options->emailOutbound->FldCaption() ?></label>
		<div class="<?php echo $notification_options_edit->RightColumnClass ?>"><div<?php echo $notification_options->emailOutbound->CellAttributes() ?>>
<span id="el_notification_options_emailOutbound">
<input type="text" data-table="notification_options" data-field="x_emailOutbound" name="x_emailOutbound" id="x_emailOutbound" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($notification_options->emailOutbound->getPlaceHolder()) ?>" value="<?php echo $notification_options->emailOutbound->EditValue ?>"<?php echo $notification_options->emailOutbound->EditAttributes() ?>>
</span>
<?php echo $notification_options->emailOutbound->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($notification_options->autorespondSubject->Visible) { // autorespondSubject ?>
	<div id="r_autorespondSubject" class="form-group">
		<label id="elh_notification_options_autorespondSubject" for="x_autorespondSubject" class="<?php echo $notification_options_edit->LeftColumnClass ?>"><?php echo $notification_options->autorespondSubject->FldCaption() ?></label>
		<div class="<?php echo $notification_options_edit->RightColumnClass ?>"><div<?php echo $notification_options->autorespondSubject->CellAttributes() ?>>
<span id="el_notification_options_autorespondSubject">
<input type="text" data-table="notification_options" data-field="x_autorespondSubject" name="x_autorespondSubject" id="x_autorespondSubject" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($notification_options->autorespondSubject->getPlaceHolder()) ?>" value="<?php echo $notification_options->autorespondSubject->EditValue ?>"<?php echo $notification_options->autorespondSubject->EditAttributes() ?>>
</span>
<?php echo $notification_options->autorespondSubject->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($notification_options->autorespondMessage->Visible) { // autorespondMessage ?>
	<div id="r_autorespondMessage" class="form-group">
		<label id="elh_notification_options_autorespondMessage" for="x_autorespondMessage" class="<?php echo $notification_options_edit->LeftColumnClass ?>"><?php echo $notification_options->autorespondMessage->FldCaption() ?></label>
		<div class="<?php echo $notification_options_edit->RightColumnClass ?>"><div<?php echo $notification_options->autorespondMessage->CellAttributes() ?>>
<span id="el_notification_options_autorespondMessage">
<textarea data-table="notification_options" data-field="x_autorespondMessage" name="x_autorespondMessage" id="x_autorespondMessage" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($notification_options->autorespondMessage->getPlaceHolder()) ?>"<?php echo $notification_options->autorespondMessage->EditAttributes() ?>><?php echo $notification_options->autorespondMessage->EditValue ?></textarea>
</span>
<?php echo $notification_options->autorespondMessage->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($notification_options->int_notificationSubject->Visible) { // int_notificationSubject ?>
	<div id="r_int_notificationSubject" class="form-group">
		<label id="elh_notification_options_int_notificationSubject" for="x_int_notificationSubject" class="<?php echo $notification_options_edit->LeftColumnClass ?>"><?php echo $notification_options->int_notificationSubject->FldCaption() ?></label>
		<div class="<?php echo $notification_options_edit->RightColumnClass ?>"><div<?php echo $notification_options->int_notificationSubject->CellAttributes() ?>>
<span id="el_notification_options_int_notificationSubject">
<input type="text" data-table="notification_options" data-field="x_int_notificationSubject" name="x_int_notificationSubject" id="x_int_notificationSubject" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($notification_options->int_notificationSubject->getPlaceHolder()) ?>" value="<?php echo $notification_options->int_notificationSubject->EditValue ?>"<?php echo $notification_options->int_notificationSubject->EditAttributes() ?>>
</span>
<?php echo $notification_options->int_notificationSubject->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($notification_options->int_notificationMessage->Visible) { // int_notificationMessage ?>
	<div id="r_int_notificationMessage" class="form-group">
		<label id="elh_notification_options_int_notificationMessage" for="x_int_notificationMessage" class="<?php echo $notification_options_edit->LeftColumnClass ?>"><?php echo $notification_options->int_notificationMessage->FldCaption() ?></label>
		<div class="<?php echo $notification_options_edit->RightColumnClass ?>"><div<?php echo $notification_options->int_notificationMessage->CellAttributes() ?>>
<span id="el_notification_options_int_notificationMessage">
<textarea data-table="notification_options" data-field="x_int_notificationMessage" name="x_int_notificationMessage" id="x_int_notificationMessage" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($notification_options->int_notificationMessage->getPlaceHolder()) ?>"<?php echo $notification_options->int_notificationMessage->EditAttributes() ?>><?php echo $notification_options->int_notificationMessage->EditValue ?></textarea>
</span>
<?php echo $notification_options->int_notificationMessage->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($notification_options->resultPageMessage->Visible) { // resultPageMessage ?>
	<div id="r_resultPageMessage" class="form-group">
		<label id="elh_notification_options_resultPageMessage" for="x_resultPageMessage" class="<?php echo $notification_options_edit->LeftColumnClass ?>"><?php echo $notification_options->resultPageMessage->FldCaption() ?></label>
		<div class="<?php echo $notification_options_edit->RightColumnClass ?>"><div<?php echo $notification_options->resultPageMessage->CellAttributes() ?>>
<span id="el_notification_options_resultPageMessage">
<textarea data-table="notification_options" data-field="x_resultPageMessage" name="x_resultPageMessage" id="x_resultPageMessage" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($notification_options->resultPageMessage->getPlaceHolder()) ?>"<?php echo $notification_options->resultPageMessage->EditAttributes() ?>><?php echo $notification_options->resultPageMessage->EditValue ?></textarea>
</span>
<?php echo $notification_options->resultPageMessage->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$notification_options_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $notification_options_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $notification_options_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fnotification_optionsedit.Init();
</script>
<?php
$notification_options_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$notification_options_edit->Page_Terminate();
?>
