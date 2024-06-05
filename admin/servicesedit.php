<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "servicesinfo.php" ?>
<?php include_once "cms_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$services_edit = NULL; // Initialize page object first

class cservices_edit extends cservices {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{8281128E-C7BB-40DA-A1AE-8695DB7283AC}';

	// Table name
	var $TableName = 'services';

	// Page object name
	var $PageObjName = 'services_edit';

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

		// Table object (services)
		if (!isset($GLOBALS["services"]) || get_class($GLOBALS["services"]) == "cservices") {
			$GLOBALS["services"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["services"];
		}

		// Table object (cms_users)
		if (!isset($GLOBALS['cms_users'])) $GLOBALS['cms_users'] = new ccms_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'services', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("serviceslist.php"));
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
		$this->serviceID->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->serviceID->Visible = FALSE;
		$this->serviceTitle->SetVisibility();
		$this->serviceTitle_ar->SetVisibility();
		$this->slug->SetVisibility();
		$this->serviceAmount->SetVisibility();
		$this->image->SetVisibility();
		$this->headerImage->SetVisibility();
		$this->class->SetVisibility();
		$this->largeImage->SetVisibility();
		$this->summary->SetVisibility();
		$this->summary_ar->SetVisibility();
		$this->description->SetVisibility();
		$this->description_ar->SetVisibility();
		$this->so->SetVisibility();
		$this->active->SetVisibility();

		// Set up multi page object
		$this->SetupMultiPages();

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
		global $EW_EXPORT, $services;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($services);
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
					if ($pageName == "servicesview.php")
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
	var $MultiPages; // Multi pages object

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
			if ($objForm->HasValue("x_serviceID")) {
				$this->serviceID->setFormValue($objForm->GetValue("x_serviceID"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["serviceID"])) {
				$this->serviceID->setQueryStringValue($_GET["serviceID"]);
				$loadByQuery = TRUE;
			} else {
				$this->serviceID->CurrentValue = NULL;
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
					$this->Page_Terminate("serviceslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "serviceslist.php")
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
		$this->image->Upload->Index = $objForm->Index;
		$this->image->Upload->UploadFile();
		$this->image->CurrentValue = $this->image->Upload->FileName;
		$this->headerImage->Upload->Index = $objForm->Index;
		$this->headerImage->Upload->UploadFile();
		$this->headerImage->CurrentValue = $this->headerImage->Upload->FileName;
		$this->largeImage->Upload->Index = $objForm->Index;
		$this->largeImage->Upload->UploadFile();
		$this->largeImage->CurrentValue = $this->largeImage->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->serviceID->FldIsDetailKey)
			$this->serviceID->setFormValue($objForm->GetValue("x_serviceID"));
		if (!$this->serviceTitle->FldIsDetailKey) {
			$this->serviceTitle->setFormValue($objForm->GetValue("x_serviceTitle"));
		}
		if (!$this->serviceTitle_ar->FldIsDetailKey) {
			$this->serviceTitle_ar->setFormValue($objForm->GetValue("x_serviceTitle_ar"));
		}
		if (!$this->slug->FldIsDetailKey) {
			$this->slug->setFormValue($objForm->GetValue("x_slug"));
		}
		if (!$this->serviceAmount->FldIsDetailKey) {
			$this->serviceAmount->setFormValue($objForm->GetValue("x_serviceAmount"));
		}
		if (!$this->class->FldIsDetailKey) {
			$this->class->setFormValue($objForm->GetValue("x_class"));
		}
		if (!$this->summary->FldIsDetailKey) {
			$this->summary->setFormValue($objForm->GetValue("x_summary"));
		}
		if (!$this->summary_ar->FldIsDetailKey) {
			$this->summary_ar->setFormValue($objForm->GetValue("x_summary_ar"));
		}
		if (!$this->description->FldIsDetailKey) {
			$this->description->setFormValue($objForm->GetValue("x_description"));
		}
		if (!$this->description_ar->FldIsDetailKey) {
			$this->description_ar->setFormValue($objForm->GetValue("x_description_ar"));
		}
		if (!$this->so->FldIsDetailKey) {
			$this->so->setFormValue($objForm->GetValue("x_so"));
		}
		if (!$this->active->FldIsDetailKey) {
			$this->active->setFormValue($objForm->GetValue("x_active"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->serviceID->CurrentValue = $this->serviceID->FormValue;
		$this->serviceTitle->CurrentValue = $this->serviceTitle->FormValue;
		$this->serviceTitle_ar->CurrentValue = $this->serviceTitle_ar->FormValue;
		$this->slug->CurrentValue = $this->slug->FormValue;
		$this->serviceAmount->CurrentValue = $this->serviceAmount->FormValue;
		$this->class->CurrentValue = $this->class->FormValue;
		$this->summary->CurrentValue = $this->summary->FormValue;
		$this->summary_ar->CurrentValue = $this->summary_ar->FormValue;
		$this->description->CurrentValue = $this->description->FormValue;
		$this->description_ar->CurrentValue = $this->description_ar->FormValue;
		$this->so->CurrentValue = $this->so->FormValue;
		$this->active->CurrentValue = $this->active->FormValue;
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
		$this->serviceID->setDbValue($row['serviceID']);
		$this->serviceTitle->setDbValue($row['serviceTitle']);
		$this->serviceTitle_ar->setDbValue($row['serviceTitle_ar']);
		$this->slug->setDbValue($row['slug']);
		$this->serviceAmount->setDbValue($row['serviceAmount']);
		$this->image->Upload->DbValue = $row['image'];
		$this->image->setDbValue($this->image->Upload->DbValue);
		$this->headerImage->Upload->DbValue = $row['headerImage'];
		$this->headerImage->setDbValue($this->headerImage->Upload->DbValue);
		$this->class->setDbValue($row['class']);
		$this->largeImage->Upload->DbValue = $row['largeImage'];
		$this->largeImage->setDbValue($this->largeImage->Upload->DbValue);
		$this->summary->setDbValue($row['summary']);
		$this->summary_ar->setDbValue($row['summary_ar']);
		$this->description->setDbValue($row['description']);
		$this->description_ar->setDbValue($row['description_ar']);
		$this->so->setDbValue($row['so']);
		$this->active->setDbValue($row['active']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['serviceID'] = NULL;
		$row['serviceTitle'] = NULL;
		$row['serviceTitle_ar'] = NULL;
		$row['slug'] = NULL;
		$row['serviceAmount'] = NULL;
		$row['image'] = NULL;
		$row['headerImage'] = NULL;
		$row['class'] = NULL;
		$row['largeImage'] = NULL;
		$row['summary'] = NULL;
		$row['summary_ar'] = NULL;
		$row['description'] = NULL;
		$row['description_ar'] = NULL;
		$row['so'] = NULL;
		$row['active'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->serviceID->DbValue = $row['serviceID'];
		$this->serviceTitle->DbValue = $row['serviceTitle'];
		$this->serviceTitle_ar->DbValue = $row['serviceTitle_ar'];
		$this->slug->DbValue = $row['slug'];
		$this->serviceAmount->DbValue = $row['serviceAmount'];
		$this->image->Upload->DbValue = $row['image'];
		$this->headerImage->Upload->DbValue = $row['headerImage'];
		$this->class->DbValue = $row['class'];
		$this->largeImage->Upload->DbValue = $row['largeImage'];
		$this->summary->DbValue = $row['summary'];
		$this->summary_ar->DbValue = $row['summary_ar'];
		$this->description->DbValue = $row['description'];
		$this->description_ar->DbValue = $row['description_ar'];
		$this->so->DbValue = $row['so'];
		$this->active->DbValue = $row['active'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("serviceID")) <> "")
			$this->serviceID->CurrentValue = $this->getKey("serviceID"); // serviceID
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
		// serviceID
		// serviceTitle
		// serviceTitle_ar
		// slug
		// serviceAmount
		// image
		// headerImage
		// class
		// largeImage
		// summary
		// summary_ar
		// description
		// description_ar
		// so
		// active

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// serviceID
		$this->serviceID->ViewValue = $this->serviceID->CurrentValue;
		$this->serviceID->ViewCustomAttributes = "";

		// serviceTitle
		$this->serviceTitle->ViewValue = $this->serviceTitle->CurrentValue;
		$this->serviceTitle->ViewCustomAttributes = "";

		// serviceTitle_ar
		$this->serviceTitle_ar->ViewValue = $this->serviceTitle_ar->CurrentValue;
		$this->serviceTitle_ar->ViewCustomAttributes = "";

		// slug
		$this->slug->ViewValue = $this->slug->CurrentValue;
		$this->slug->ViewCustomAttributes = "";

		// serviceAmount
		$this->serviceAmount->ViewValue = $this->serviceAmount->CurrentValue;
		$this->serviceAmount->ViewCustomAttributes = "";

		// image
		$this->image->UploadPath = 'uploads/services';
		if (!ew_Empty($this->image->Upload->DbValue)) {
			$this->image->ImageWidth = 100;
			$this->image->ImageHeight = 0;
			$this->image->ImageAlt = $this->image->FldAlt();
			$this->image->ViewValue = $this->image->Upload->DbValue;
		} else {
			$this->image->ViewValue = "";
		}
		$this->image->ViewCustomAttributes = "";

		// headerImage
		$this->headerImage->UploadPath = 'uploads/services';
		if (!ew_Empty($this->headerImage->Upload->DbValue)) {
			$this->headerImage->ImageWidth = 100;
			$this->headerImage->ImageHeight = 0;
			$this->headerImage->ImageAlt = $this->headerImage->FldAlt();
			$this->headerImage->ViewValue = $this->headerImage->Upload->DbValue;
		} else {
			$this->headerImage->ViewValue = "";
		}
		$this->headerImage->ViewCustomAttributes = "";

		// class
		$this->class->ViewValue = $this->class->CurrentValue;
		$this->class->ViewCustomAttributes = "";

		// largeImage
		$this->largeImage->UploadPath = 'uploads/services';
		if (!ew_Empty($this->largeImage->Upload->DbValue)) {
			$this->largeImage->ImageWidth = 100;
			$this->largeImage->ImageHeight = 0;
			$this->largeImage->ImageAlt = $this->largeImage->FldAlt();
			$this->largeImage->ViewValue = $this->largeImage->Upload->DbValue;
		} else {
			$this->largeImage->ViewValue = "";
		}
		$this->largeImage->ViewCustomAttributes = "";

		// summary
		$this->summary->ViewValue = $this->summary->CurrentValue;
		$this->summary->ViewCustomAttributes = "";

		// summary_ar
		$this->summary_ar->ViewValue = $this->summary_ar->CurrentValue;
		$this->summary_ar->ViewCustomAttributes = "";

		// description
		$this->description->ViewValue = $this->description->CurrentValue;
		$this->description->ViewCustomAttributes = "";

		// description_ar
		$this->description_ar->ViewValue = $this->description_ar->CurrentValue;
		$this->description_ar->ViewCustomAttributes = "";

		// so
		$this->so->ViewValue = $this->so->CurrentValue;
		$this->so->ViewCustomAttributes = "";

		// active
		if (strval($this->active->CurrentValue) <> "") {
			$this->active->ViewValue = $this->active->OptionCaption($this->active->CurrentValue);
		} else {
			$this->active->ViewValue = NULL;
		}
		$this->active->ViewCustomAttributes = "";

			// serviceID
			$this->serviceID->LinkCustomAttributes = "";
			$this->serviceID->HrefValue = "";
			$this->serviceID->TooltipValue = "";

			// serviceTitle
			$this->serviceTitle->LinkCustomAttributes = "";
			$this->serviceTitle->HrefValue = "";
			$this->serviceTitle->TooltipValue = "";

			// serviceTitle_ar
			$this->serviceTitle_ar->LinkCustomAttributes = "";
			$this->serviceTitle_ar->HrefValue = "";
			$this->serviceTitle_ar->TooltipValue = "";

			// slug
			$this->slug->LinkCustomAttributes = "";
			$this->slug->HrefValue = "";
			$this->slug->TooltipValue = "";

			// serviceAmount
			$this->serviceAmount->LinkCustomAttributes = "";
			$this->serviceAmount->HrefValue = "";
			$this->serviceAmount->TooltipValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->UploadPath = 'uploads/services';
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->HrefValue = ew_GetFileUploadUrl($this->image, $this->image->Upload->DbValue); // Add prefix/suffix
				$this->image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->image->HrefValue = ew_FullUrl($this->image->HrefValue, "href");
			} else {
				$this->image->HrefValue = "";
			}
			$this->image->HrefValue2 = $this->image->UploadPath . $this->image->Upload->DbValue;
			$this->image->TooltipValue = "";
			if ($this->image->UseColorbox) {
				if (ew_Empty($this->image->TooltipValue))
					$this->image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->image->LinkAttrs["data-rel"] = "services_x_image";
				ew_AppendClass($this->image->LinkAttrs["class"], "ewLightbox");
			}

			// headerImage
			$this->headerImage->LinkCustomAttributes = "";
			$this->headerImage->UploadPath = 'uploads/services';
			if (!ew_Empty($this->headerImage->Upload->DbValue)) {
				$this->headerImage->HrefValue = ew_GetFileUploadUrl($this->headerImage, $this->headerImage->Upload->DbValue); // Add prefix/suffix
				$this->headerImage->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->headerImage->HrefValue = ew_FullUrl($this->headerImage->HrefValue, "href");
			} else {
				$this->headerImage->HrefValue = "";
			}
			$this->headerImage->HrefValue2 = $this->headerImage->UploadPath . $this->headerImage->Upload->DbValue;
			$this->headerImage->TooltipValue = "";
			if ($this->headerImage->UseColorbox) {
				if (ew_Empty($this->headerImage->TooltipValue))
					$this->headerImage->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->headerImage->LinkAttrs["data-rel"] = "services_x_headerImage";
				ew_AppendClass($this->headerImage->LinkAttrs["class"], "ewLightbox");
			}

			// class
			$this->class->LinkCustomAttributes = "";
			$this->class->HrefValue = "";
			$this->class->TooltipValue = "";

			// largeImage
			$this->largeImage->LinkCustomAttributes = "";
			$this->largeImage->UploadPath = 'uploads/services';
			if (!ew_Empty($this->largeImage->Upload->DbValue)) {
				$this->largeImage->HrefValue = ew_GetFileUploadUrl($this->largeImage, $this->largeImage->Upload->DbValue); // Add prefix/suffix
				$this->largeImage->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->largeImage->HrefValue = ew_FullUrl($this->largeImage->HrefValue, "href");
			} else {
				$this->largeImage->HrefValue = "";
			}
			$this->largeImage->HrefValue2 = $this->largeImage->UploadPath . $this->largeImage->Upload->DbValue;
			$this->largeImage->TooltipValue = "";
			if ($this->largeImage->UseColorbox) {
				if (ew_Empty($this->largeImage->TooltipValue))
					$this->largeImage->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->largeImage->LinkAttrs["data-rel"] = "services_x_largeImage";
				ew_AppendClass($this->largeImage->LinkAttrs["class"], "ewLightbox");
			}

			// summary
			$this->summary->LinkCustomAttributes = "";
			$this->summary->HrefValue = "";
			$this->summary->TooltipValue = "";

			// summary_ar
			$this->summary_ar->LinkCustomAttributes = "";
			$this->summary_ar->HrefValue = "";
			$this->summary_ar->TooltipValue = "";

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";
			$this->description->TooltipValue = "";

			// description_ar
			$this->description_ar->LinkCustomAttributes = "";
			$this->description_ar->HrefValue = "";
			$this->description_ar->TooltipValue = "";

			// so
			$this->so->LinkCustomAttributes = "";
			$this->so->HrefValue = "";
			$this->so->TooltipValue = "";

			// active
			$this->active->LinkCustomAttributes = "";
			$this->active->HrefValue = "";
			$this->active->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// serviceID
			$this->serviceID->EditAttrs["class"] = "form-control";
			$this->serviceID->EditCustomAttributes = "";
			$this->serviceID->EditValue = $this->serviceID->CurrentValue;
			$this->serviceID->ViewCustomAttributes = "";

			// serviceTitle
			$this->serviceTitle->EditAttrs["class"] = "form-control";
			$this->serviceTitle->EditCustomAttributes = "";
			$this->serviceTitle->EditValue = ew_HtmlEncode($this->serviceTitle->CurrentValue);
			$this->serviceTitle->PlaceHolder = ew_RemoveHtml($this->serviceTitle->FldCaption());

			// serviceTitle_ar
			$this->serviceTitle_ar->EditAttrs["class"] = "form-control";
			$this->serviceTitle_ar->EditCustomAttributes = "";
			$this->serviceTitle_ar->EditValue = ew_HtmlEncode($this->serviceTitle_ar->CurrentValue);
			$this->serviceTitle_ar->PlaceHolder = ew_RemoveHtml($this->serviceTitle_ar->FldCaption());

			// slug
			$this->slug->EditAttrs["class"] = "form-control";
			$this->slug->EditCustomAttributes = "";
			$this->slug->EditValue = ew_HtmlEncode($this->slug->CurrentValue);
			$this->slug->PlaceHolder = ew_RemoveHtml($this->slug->FldCaption());

			// serviceAmount
			$this->serviceAmount->EditAttrs["class"] = "form-control";
			$this->serviceAmount->EditCustomAttributes = "";
			$this->serviceAmount->EditValue = ew_HtmlEncode($this->serviceAmount->CurrentValue);
			$this->serviceAmount->PlaceHolder = ew_RemoveHtml($this->serviceAmount->FldCaption());

			// image
			$this->image->EditAttrs["class"] = "form-control";
			$this->image->EditCustomAttributes = "";
			$this->image->UploadPath = 'uploads/services';
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->ImageWidth = 100;
				$this->image->ImageHeight = 0;
				$this->image->ImageAlt = $this->image->FldAlt();
				$this->image->EditValue = $this->image->Upload->DbValue;
			} else {
				$this->image->EditValue = "";
			}
			if (!ew_Empty($this->image->CurrentValue))
					$this->image->Upload->FileName = $this->image->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->image);

			// headerImage
			$this->headerImage->EditAttrs["class"] = "form-control";
			$this->headerImage->EditCustomAttributes = "";
			$this->headerImage->UploadPath = 'uploads/services';
			if (!ew_Empty($this->headerImage->Upload->DbValue)) {
				$this->headerImage->ImageWidth = 100;
				$this->headerImage->ImageHeight = 0;
				$this->headerImage->ImageAlt = $this->headerImage->FldAlt();
				$this->headerImage->EditValue = $this->headerImage->Upload->DbValue;
			} else {
				$this->headerImage->EditValue = "";
			}
			if (!ew_Empty($this->headerImage->CurrentValue))
					$this->headerImage->Upload->FileName = $this->headerImage->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->headerImage);

			// class
			$this->class->EditAttrs["class"] = "form-control";
			$this->class->EditCustomAttributes = "";
			$this->class->EditValue = ew_HtmlEncode($this->class->CurrentValue);
			$this->class->PlaceHolder = ew_RemoveHtml($this->class->FldCaption());

			// largeImage
			$this->largeImage->EditAttrs["class"] = "form-control";
			$this->largeImage->EditCustomAttributes = "";
			$this->largeImage->UploadPath = 'uploads/services';
			if (!ew_Empty($this->largeImage->Upload->DbValue)) {
				$this->largeImage->ImageWidth = 100;
				$this->largeImage->ImageHeight = 0;
				$this->largeImage->ImageAlt = $this->largeImage->FldAlt();
				$this->largeImage->EditValue = $this->largeImage->Upload->DbValue;
			} else {
				$this->largeImage->EditValue = "";
			}
			if (!ew_Empty($this->largeImage->CurrentValue))
					$this->largeImage->Upload->FileName = $this->largeImage->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->largeImage);

			// summary
			$this->summary->EditAttrs["class"] = "form-control";
			$this->summary->EditCustomAttributes = "";
			$this->summary->EditValue = ew_HtmlEncode($this->summary->CurrentValue);
			$this->summary->PlaceHolder = ew_RemoveHtml($this->summary->FldCaption());

			// summary_ar
			$this->summary_ar->EditAttrs["class"] = "form-control";
			$this->summary_ar->EditCustomAttributes = "";
			$this->summary_ar->EditValue = ew_HtmlEncode($this->summary_ar->CurrentValue);
			$this->summary_ar->PlaceHolder = ew_RemoveHtml($this->summary_ar->FldCaption());

			// description
			$this->description->EditAttrs["class"] = "form-control";
			$this->description->EditCustomAttributes = "";
			$this->description->EditValue = ew_HtmlEncode($this->description->CurrentValue);
			$this->description->PlaceHolder = ew_RemoveHtml($this->description->FldCaption());

			// description_ar
			$this->description_ar->EditAttrs["class"] = "form-control";
			$this->description_ar->EditCustomAttributes = "";
			$this->description_ar->EditValue = ew_HtmlEncode($this->description_ar->CurrentValue);
			$this->description_ar->PlaceHolder = ew_RemoveHtml($this->description_ar->FldCaption());

			// so
			$this->so->EditAttrs["class"] = "form-control";
			$this->so->EditCustomAttributes = "";
			$this->so->EditValue = ew_HtmlEncode($this->so->CurrentValue);
			$this->so->PlaceHolder = ew_RemoveHtml($this->so->FldCaption());

			// active
			$this->active->EditAttrs["class"] = "form-control";
			$this->active->EditCustomAttributes = "";
			$this->active->EditValue = $this->active->Options(TRUE);

			// Edit refer script
			// serviceID

			$this->serviceID->LinkCustomAttributes = "";
			$this->serviceID->HrefValue = "";

			// serviceTitle
			$this->serviceTitle->LinkCustomAttributes = "";
			$this->serviceTitle->HrefValue = "";

			// serviceTitle_ar
			$this->serviceTitle_ar->LinkCustomAttributes = "";
			$this->serviceTitle_ar->HrefValue = "";

			// slug
			$this->slug->LinkCustomAttributes = "";
			$this->slug->HrefValue = "";

			// serviceAmount
			$this->serviceAmount->LinkCustomAttributes = "";
			$this->serviceAmount->HrefValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->UploadPath = 'uploads/services';
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->HrefValue = ew_GetFileUploadUrl($this->image, $this->image->Upload->DbValue); // Add prefix/suffix
				$this->image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->image->HrefValue = ew_FullUrl($this->image->HrefValue, "href");
			} else {
				$this->image->HrefValue = "";
			}
			$this->image->HrefValue2 = $this->image->UploadPath . $this->image->Upload->DbValue;

			// headerImage
			$this->headerImage->LinkCustomAttributes = "";
			$this->headerImage->UploadPath = 'uploads/services';
			if (!ew_Empty($this->headerImage->Upload->DbValue)) {
				$this->headerImage->HrefValue = ew_GetFileUploadUrl($this->headerImage, $this->headerImage->Upload->DbValue); // Add prefix/suffix
				$this->headerImage->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->headerImage->HrefValue = ew_FullUrl($this->headerImage->HrefValue, "href");
			} else {
				$this->headerImage->HrefValue = "";
			}
			$this->headerImage->HrefValue2 = $this->headerImage->UploadPath . $this->headerImage->Upload->DbValue;

			// class
			$this->class->LinkCustomAttributes = "";
			$this->class->HrefValue = "";

			// largeImage
			$this->largeImage->LinkCustomAttributes = "";
			$this->largeImage->UploadPath = 'uploads/services';
			if (!ew_Empty($this->largeImage->Upload->DbValue)) {
				$this->largeImage->HrefValue = ew_GetFileUploadUrl($this->largeImage, $this->largeImage->Upload->DbValue); // Add prefix/suffix
				$this->largeImage->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->largeImage->HrefValue = ew_FullUrl($this->largeImage->HrefValue, "href");
			} else {
				$this->largeImage->HrefValue = "";
			}
			$this->largeImage->HrefValue2 = $this->largeImage->UploadPath . $this->largeImage->Upload->DbValue;

			// summary
			$this->summary->LinkCustomAttributes = "";
			$this->summary->HrefValue = "";

			// summary_ar
			$this->summary_ar->LinkCustomAttributes = "";
			$this->summary_ar->HrefValue = "";

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";

			// description_ar
			$this->description_ar->LinkCustomAttributes = "";
			$this->description_ar->HrefValue = "";

			// so
			$this->so->LinkCustomAttributes = "";
			$this->so->HrefValue = "";

			// active
			$this->active->LinkCustomAttributes = "";
			$this->active->HrefValue = "";
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
		if (!ew_CheckInteger($this->so->FormValue)) {
			ew_AddMessage($gsFormError, $this->so->FldErrMsg());
		}

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
			$this->image->OldUploadPath = 'uploads/services';
			$this->image->UploadPath = $this->image->OldUploadPath;
			$this->headerImage->OldUploadPath = 'uploads/services';
			$this->headerImage->UploadPath = $this->headerImage->OldUploadPath;
			$this->largeImage->OldUploadPath = 'uploads/services';
			$this->largeImage->UploadPath = $this->largeImage->OldUploadPath;
			$rsnew = array();

			// serviceTitle
			$this->serviceTitle->SetDbValueDef($rsnew, $this->serviceTitle->CurrentValue, NULL, $this->serviceTitle->ReadOnly);

			// serviceTitle_ar
			$this->serviceTitle_ar->SetDbValueDef($rsnew, $this->serviceTitle_ar->CurrentValue, NULL, $this->serviceTitle_ar->ReadOnly);

			// slug
			$this->slug->SetDbValueDef($rsnew, $this->slug->CurrentValue, NULL, $this->slug->ReadOnly);

			// serviceAmount
			$this->serviceAmount->SetDbValueDef($rsnew, $this->serviceAmount->CurrentValue, NULL, $this->serviceAmount->ReadOnly);

			// image
			if ($this->image->Visible && !$this->image->ReadOnly && !$this->image->Upload->KeepFile) {
				$this->image->Upload->DbValue = $rsold['image']; // Get original value
				if ($this->image->Upload->FileName == "") {
					$rsnew['image'] = NULL;
				} else {
					$rsnew['image'] = $this->image->Upload->FileName;
				}
			}

			// headerImage
			if ($this->headerImage->Visible && !$this->headerImage->ReadOnly && !$this->headerImage->Upload->KeepFile) {
				$this->headerImage->Upload->DbValue = $rsold['headerImage']; // Get original value
				if ($this->headerImage->Upload->FileName == "") {
					$rsnew['headerImage'] = NULL;
				} else {
					$rsnew['headerImage'] = $this->headerImage->Upload->FileName;
				}
			}

			// class
			$this->class->SetDbValueDef($rsnew, $this->class->CurrentValue, NULL, $this->class->ReadOnly);

			// largeImage
			if ($this->largeImage->Visible && !$this->largeImage->ReadOnly && !$this->largeImage->Upload->KeepFile) {
				$this->largeImage->Upload->DbValue = $rsold['largeImage']; // Get original value
				if ($this->largeImage->Upload->FileName == "") {
					$rsnew['largeImage'] = NULL;
				} else {
					$rsnew['largeImage'] = $this->largeImage->Upload->FileName;
				}
			}

			// summary
			$this->summary->SetDbValueDef($rsnew, $this->summary->CurrentValue, NULL, $this->summary->ReadOnly);

			// summary_ar
			$this->summary_ar->SetDbValueDef($rsnew, $this->summary_ar->CurrentValue, NULL, $this->summary_ar->ReadOnly);

			// description
			$this->description->SetDbValueDef($rsnew, $this->description->CurrentValue, NULL, $this->description->ReadOnly);

			// description_ar
			$this->description_ar->SetDbValueDef($rsnew, $this->description_ar->CurrentValue, NULL, $this->description_ar->ReadOnly);

			// so
			$this->so->SetDbValueDef($rsnew, $this->so->CurrentValue, NULL, $this->so->ReadOnly);

			// active
			$this->active->SetDbValueDef($rsnew, $this->active->CurrentValue, NULL, $this->active->ReadOnly);
			if ($this->image->Visible && !$this->image->Upload->KeepFile) {
				$this->image->UploadPath = 'uploads/services';
				$OldFiles = ew_Empty($this->image->Upload->DbValue) ? array() : array($this->image->Upload->DbValue);
				if (!ew_Empty($this->image->Upload->FileName)) {
					$NewFiles = array($this->image->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->image->Upload->Index < 0) ? $this->image->FldVar : substr($this->image->FldVar, 0, 1) . $this->image->Upload->Index . substr($this->image->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->image->TblVar) . $file)) {
								$OldFileFound = FALSE;
								$OldFileCount = count($OldFiles);
								for ($j = 0; $j < $OldFileCount; $j++) {
									$file1 = $OldFiles[$j];
									if ($file1 == $file) { // Old file found, no need to delete anymore
										unset($OldFiles[$j]);
										$OldFileFound = TRUE;
										break;
									}
								}
								if ($OldFileFound) // No need to check if file exists further
									continue;
								$file1 = ew_UploadFileNameEx($this->image->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->image->TblVar) . $file1) || file_exists($this->image->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->image->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->image->TblVar) . $file, ew_UploadTempPath($fldvar, $this->image->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->image->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->image->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->image->SetDbValueDef($rsnew, $this->image->Upload->FileName, NULL, $this->image->ReadOnly);
				}
			}
			if ($this->headerImage->Visible && !$this->headerImage->Upload->KeepFile) {
				$this->headerImage->UploadPath = 'uploads/services';
				$OldFiles = ew_Empty($this->headerImage->Upload->DbValue) ? array() : array($this->headerImage->Upload->DbValue);
				if (!ew_Empty($this->headerImage->Upload->FileName)) {
					$NewFiles = array($this->headerImage->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->headerImage->Upload->Index < 0) ? $this->headerImage->FldVar : substr($this->headerImage->FldVar, 0, 1) . $this->headerImage->Upload->Index . substr($this->headerImage->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->headerImage->TblVar) . $file)) {
								$OldFileFound = FALSE;
								$OldFileCount = count($OldFiles);
								for ($j = 0; $j < $OldFileCount; $j++) {
									$file1 = $OldFiles[$j];
									if ($file1 == $file) { // Old file found, no need to delete anymore
										unset($OldFiles[$j]);
										$OldFileFound = TRUE;
										break;
									}
								}
								if ($OldFileFound) // No need to check if file exists further
									continue;
								$file1 = ew_UploadFileNameEx($this->headerImage->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->headerImage->TblVar) . $file1) || file_exists($this->headerImage->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->headerImage->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->headerImage->TblVar) . $file, ew_UploadTempPath($fldvar, $this->headerImage->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->headerImage->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->headerImage->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->headerImage->SetDbValueDef($rsnew, $this->headerImage->Upload->FileName, NULL, $this->headerImage->ReadOnly);
				}
			}
			if ($this->largeImage->Visible && !$this->largeImage->Upload->KeepFile) {
				$this->largeImage->UploadPath = 'uploads/services';
				$OldFiles = ew_Empty($this->largeImage->Upload->DbValue) ? array() : array($this->largeImage->Upload->DbValue);
				if (!ew_Empty($this->largeImage->Upload->FileName)) {
					$NewFiles = array($this->largeImage->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->largeImage->Upload->Index < 0) ? $this->largeImage->FldVar : substr($this->largeImage->FldVar, 0, 1) . $this->largeImage->Upload->Index . substr($this->largeImage->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->largeImage->TblVar) . $file)) {
								$OldFileFound = FALSE;
								$OldFileCount = count($OldFiles);
								for ($j = 0; $j < $OldFileCount; $j++) {
									$file1 = $OldFiles[$j];
									if ($file1 == $file) { // Old file found, no need to delete anymore
										unset($OldFiles[$j]);
										$OldFileFound = TRUE;
										break;
									}
								}
								if ($OldFileFound) // No need to check if file exists further
									continue;
								$file1 = ew_UploadFileNameEx($this->largeImage->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->largeImage->TblVar) . $file1) || file_exists($this->largeImage->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->largeImage->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->largeImage->TblVar) . $file, ew_UploadTempPath($fldvar, $this->largeImage->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->largeImage->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->largeImage->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->largeImage->SetDbValueDef($rsnew, $this->largeImage->Upload->FileName, NULL, $this->largeImage->ReadOnly);
				}
			}

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
					if ($this->image->Visible && !$this->image->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->image->Upload->DbValue) ? array() : array($this->image->Upload->DbValue);
						if (!ew_Empty($this->image->Upload->FileName)) {
							$NewFiles = array($this->image->Upload->FileName);
							$NewFiles2 = array($rsnew['image']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->image->Upload->Index < 0) ? $this->image->FldVar : substr($this->image->FldVar, 0, 1) . $this->image->Upload->Index . substr($this->image->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->image->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->image->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
											$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
											return FALSE;
										}
									}
								}
							}
						} else {
							$NewFiles = array();
						}
						$OldFileCount = count($OldFiles);
						for ($i = 0; $i < $OldFileCount; $i++) {
							if ($OldFiles[$i] <> "" && !in_array($OldFiles[$i], $NewFiles))
								@unlink($this->image->OldPhysicalUploadPath() . $OldFiles[$i]);
						}
					}
					if ($this->headerImage->Visible && !$this->headerImage->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->headerImage->Upload->DbValue) ? array() : array($this->headerImage->Upload->DbValue);
						if (!ew_Empty($this->headerImage->Upload->FileName)) {
							$NewFiles = array($this->headerImage->Upload->FileName);
							$NewFiles2 = array($rsnew['headerImage']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->headerImage->Upload->Index < 0) ? $this->headerImage->FldVar : substr($this->headerImage->FldVar, 0, 1) . $this->headerImage->Upload->Index . substr($this->headerImage->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->headerImage->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->headerImage->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
											$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
											return FALSE;
										}
									}
								}
							}
						} else {
							$NewFiles = array();
						}
						$OldFileCount = count($OldFiles);
						for ($i = 0; $i < $OldFileCount; $i++) {
							if ($OldFiles[$i] <> "" && !in_array($OldFiles[$i], $NewFiles))
								@unlink($this->headerImage->OldPhysicalUploadPath() . $OldFiles[$i]);
						}
					}
					if ($this->largeImage->Visible && !$this->largeImage->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->largeImage->Upload->DbValue) ? array() : array($this->largeImage->Upload->DbValue);
						if (!ew_Empty($this->largeImage->Upload->FileName)) {
							$NewFiles = array($this->largeImage->Upload->FileName);
							$NewFiles2 = array($rsnew['largeImage']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->largeImage->Upload->Index < 0) ? $this->largeImage->FldVar : substr($this->largeImage->FldVar, 0, 1) . $this->largeImage->Upload->Index . substr($this->largeImage->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->largeImage->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->largeImage->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
											$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
											return FALSE;
										}
									}
								}
							}
						} else {
							$NewFiles = array();
						}
						$OldFileCount = count($OldFiles);
						for ($i = 0; $i < $OldFileCount; $i++) {
							if ($OldFiles[$i] <> "" && !in_array($OldFiles[$i], $NewFiles))
								@unlink($this->largeImage->OldPhysicalUploadPath() . $OldFiles[$i]);
						}
					}
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

		// image
		ew_CleanUploadTempPath($this->image, $this->image->Upload->Index);

		// headerImage
		ew_CleanUploadTempPath($this->headerImage, $this->headerImage->Upload->Index);

		// largeImage
		ew_CleanUploadTempPath($this->largeImage, $this->largeImage->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("serviceslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Set up multi pages
	function SetupMultiPages() {
		$pages = new cSubPages();
		$pages->Style = "tabs";
		$pages->Add(0);
		$pages->Add(1);
		$pages->Add(2);
		$pages->Add(3);
		$this->MultiPages = $pages;
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
if (!isset($services_edit)) $services_edit = new cservices_edit();

// Page init
$services_edit->Page_Init();

// Page main
$services_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$services_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fservicesedit = new ew_Form("fservicesedit", "edit");

// Validate form
fservicesedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_so");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($services->so->FldErrMsg()) ?>");

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
fservicesedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fservicesedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Multi-Page
fservicesedit.MultiPage = new ew_MultiPage("fservicesedit");

// Dynamic selection lists
fservicesedit.Lists["x_active"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fservicesedit.Lists["x_active"].Options = <?php echo json_encode($services_edit->active->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $services_edit->ShowPageHeader(); ?>
<?php
$services_edit->ShowMessage();
?>
<form name="fservicesedit" id="fservicesedit" class="<?php echo $services_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($services_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $services_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="services">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($services_edit->IsModal) ?>">
<div class="ewMultiPage"><!-- multi-page -->
<div class="nav-tabs-custom" id="services_edit"><!-- multi-page .nav-tabs-custom -->
	<ul class="nav<?php echo $services_edit->MultiPages->NavStyle() ?>">
		<li<?php echo $services_edit->MultiPages->TabStyle("1") ?>><a href="#tab_services1" data-toggle="tab"><?php echo $services->PageCaption(1) ?></a></li>
		<li<?php echo $services_edit->MultiPages->TabStyle("2") ?>><a href="#tab_services2" data-toggle="tab"><?php echo $services->PageCaption(2) ?></a></li>
		<li<?php echo $services_edit->MultiPages->TabStyle("3") ?>><a href="#tab_services3" data-toggle="tab"><?php echo $services->PageCaption(3) ?></a></li>
	</ul>
	<div class="tab-content"><!-- multi-page .nav-tabs-custom .tab-content -->
		<div class="tab-pane<?php echo $services_edit->MultiPages->PageStyle("1") ?>" id="tab_services1"><!-- multi-page .tab-pane -->
<div class="ewEditDiv"><!-- page* -->
<?php if ($services->serviceID->Visible) { // serviceID ?>
	<div id="r_serviceID" class="form-group">
		<label id="elh_services_serviceID" class="<?php echo $services_edit->LeftColumnClass ?>"><?php echo $services->serviceID->FldCaption() ?></label>
		<div class="<?php echo $services_edit->RightColumnClass ?>"><div<?php echo $services->serviceID->CellAttributes() ?>>
<span id="el_services_serviceID">
<span<?php echo $services->serviceID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $services->serviceID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="services" data-field="x_serviceID" data-page="1" name="x_serviceID" id="x_serviceID" value="<?php echo ew_HtmlEncode($services->serviceID->CurrentValue) ?>">
<?php echo $services->serviceID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->serviceTitle->Visible) { // serviceTitle ?>
	<div id="r_serviceTitle" class="form-group">
		<label id="elh_services_serviceTitle" for="x_serviceTitle" class="<?php echo $services_edit->LeftColumnClass ?>"><?php echo $services->serviceTitle->FldCaption() ?></label>
		<div class="<?php echo $services_edit->RightColumnClass ?>"><div<?php echo $services->serviceTitle->CellAttributes() ?>>
<span id="el_services_serviceTitle">
<input type="text" data-table="services" data-field="x_serviceTitle" data-page="1" name="x_serviceTitle" id="x_serviceTitle" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($services->serviceTitle->getPlaceHolder()) ?>" value="<?php echo $services->serviceTitle->EditValue ?>"<?php echo $services->serviceTitle->EditAttributes() ?>>
</span>
<?php echo $services->serviceTitle->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->serviceTitle_ar->Visible) { // serviceTitle_ar ?>
	<div id="r_serviceTitle_ar" class="form-group">
		<label id="elh_services_serviceTitle_ar" for="x_serviceTitle_ar" class="<?php echo $services_edit->LeftColumnClass ?>"><?php echo $services->serviceTitle_ar->FldCaption() ?></label>
		<div class="<?php echo $services_edit->RightColumnClass ?>"><div<?php echo $services->serviceTitle_ar->CellAttributes() ?>>
<span id="el_services_serviceTitle_ar">
<input type="text" data-table="services" data-field="x_serviceTitle_ar" data-page="1" name="x_serviceTitle_ar" id="x_serviceTitle_ar" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($services->serviceTitle_ar->getPlaceHolder()) ?>" value="<?php echo $services->serviceTitle_ar->EditValue ?>"<?php echo $services->serviceTitle_ar->EditAttributes() ?>>
</span>
<?php echo $services->serviceTitle_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->slug->Visible) { // slug ?>
	<div id="r_slug" class="form-group">
		<label id="elh_services_slug" for="x_slug" class="<?php echo $services_edit->LeftColumnClass ?>"><?php echo $services->slug->FldCaption() ?></label>
		<div class="<?php echo $services_edit->RightColumnClass ?>"><div<?php echo $services->slug->CellAttributes() ?>>
<span id="el_services_slug">
<input type="text" data-table="services" data-field="x_slug" data-page="1" name="x_slug" id="x_slug" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($services->slug->getPlaceHolder()) ?>" value="<?php echo $services->slug->EditValue ?>"<?php echo $services->slug->EditAttributes() ?>>
</span>
<?php echo $services->slug->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->serviceAmount->Visible) { // serviceAmount ?>
	<div id="r_serviceAmount" class="form-group">
		<label id="elh_services_serviceAmount" for="x_serviceAmount" class="<?php echo $services_edit->LeftColumnClass ?>"><?php echo $services->serviceAmount->FldCaption() ?></label>
		<div class="<?php echo $services_edit->RightColumnClass ?>"><div<?php echo $services->serviceAmount->CellAttributes() ?>>
<span id="el_services_serviceAmount">
<input type="text" data-table="services" data-field="x_serviceAmount" data-page="1" name="x_serviceAmount" id="x_serviceAmount" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($services->serviceAmount->getPlaceHolder()) ?>" value="<?php echo $services->serviceAmount->EditValue ?>"<?php echo $services->serviceAmount->EditAttributes() ?>>
</span>
<?php echo $services->serviceAmount->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->class->Visible) { // class ?>
	<div id="r_class" class="form-group">
		<label id="elh_services_class" for="x_class" class="<?php echo $services_edit->LeftColumnClass ?>"><?php echo $services->class->FldCaption() ?></label>
		<div class="<?php echo $services_edit->RightColumnClass ?>"><div<?php echo $services->class->CellAttributes() ?>>
<span id="el_services_class">
<input type="text" data-table="services" data-field="x_class" data-page="1" name="x_class" id="x_class" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($services->class->getPlaceHolder()) ?>" value="<?php echo $services->class->EditValue ?>"<?php echo $services->class->EditAttributes() ?>>
</span>
<?php echo $services->class->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->so->Visible) { // so ?>
	<div id="r_so" class="form-group">
		<label id="elh_services_so" for="x_so" class="<?php echo $services_edit->LeftColumnClass ?>"><?php echo $services->so->FldCaption() ?></label>
		<div class="<?php echo $services_edit->RightColumnClass ?>"><div<?php echo $services->so->CellAttributes() ?>>
<span id="el_services_so">
<input type="text" data-table="services" data-field="x_so" data-page="1" name="x_so" id="x_so" size="30" placeholder="<?php echo ew_HtmlEncode($services->so->getPlaceHolder()) ?>" value="<?php echo $services->so->EditValue ?>"<?php echo $services->so->EditAttributes() ?>>
</span>
<?php echo $services->so->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->active->Visible) { // active ?>
	<div id="r_active" class="form-group">
		<label id="elh_services_active" for="x_active" class="<?php echo $services_edit->LeftColumnClass ?>"><?php echo $services->active->FldCaption() ?></label>
		<div class="<?php echo $services_edit->RightColumnClass ?>"><div<?php echo $services->active->CellAttributes() ?>>
<span id="el_services_active">
<select data-table="services" data-field="x_active" data-page="1" data-value-separator="<?php echo $services->active->DisplayValueSeparatorAttribute() ?>" id="x_active" name="x_active"<?php echo $services->active->EditAttributes() ?>>
<?php echo $services->active->SelectOptionListHtml("x_active") ?>
</select>
</span>
<?php echo $services->active->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
		<div class="tab-pane<?php echo $services_edit->MultiPages->PageStyle("2") ?>" id="tab_services2"><!-- multi-page .tab-pane -->
<div class="ewEditDiv"><!-- page* -->
<?php if ($services->image->Visible) { // image ?>
	<div id="r_image" class="form-group">
		<label id="elh_services_image" class="<?php echo $services_edit->LeftColumnClass ?>"><?php echo $services->image->FldCaption() ?></label>
		<div class="<?php echo $services_edit->RightColumnClass ?>"><div<?php echo $services->image->CellAttributes() ?>>
<span id="el_services_image">
<div id="fd_x_image">
<span title="<?php echo $services->image->FldTitle() ? $services->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($services->image->ReadOnly || $services->image->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="services" data-field="x_image" data-page="2" name="x_image" id="x_image"<?php echo $services->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_image" id= "fn_x_image" value="<?php echo $services->image->Upload->FileName ?>">
<?php if (@$_POST["fa_x_image"] == "0") { ?>
<input type="hidden" name="fa_x_image" id= "fa_x_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_image" id= "fa_x_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x_image" id= "fs_x_image" value="255">
<input type="hidden" name="fx_x_image" id= "fx_x_image" value="<?php echo $services->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_image" id= "fm_x_image" value="<?php echo $services->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $services->image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->headerImage->Visible) { // headerImage ?>
	<div id="r_headerImage" class="form-group">
		<label id="elh_services_headerImage" class="<?php echo $services_edit->LeftColumnClass ?>"><?php echo $services->headerImage->FldCaption() ?></label>
		<div class="<?php echo $services_edit->RightColumnClass ?>"><div<?php echo $services->headerImage->CellAttributes() ?>>
<span id="el_services_headerImage">
<div id="fd_x_headerImage">
<span title="<?php echo $services->headerImage->FldTitle() ? $services->headerImage->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($services->headerImage->ReadOnly || $services->headerImage->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="services" data-field="x_headerImage" data-page="2" name="x_headerImage" id="x_headerImage"<?php echo $services->headerImage->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_headerImage" id= "fn_x_headerImage" value="<?php echo $services->headerImage->Upload->FileName ?>">
<?php if (@$_POST["fa_x_headerImage"] == "0") { ?>
<input type="hidden" name="fa_x_headerImage" id= "fa_x_headerImage" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_headerImage" id= "fa_x_headerImage" value="1">
<?php } ?>
<input type="hidden" name="fs_x_headerImage" id= "fs_x_headerImage" value="255">
<input type="hidden" name="fx_x_headerImage" id= "fx_x_headerImage" value="<?php echo $services->headerImage->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_headerImage" id= "fm_x_headerImage" value="<?php echo $services->headerImage->UploadMaxFileSize ?>">
</div>
<table id="ft_x_headerImage" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $services->headerImage->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->largeImage->Visible) { // largeImage ?>
	<div id="r_largeImage" class="form-group">
		<label id="elh_services_largeImage" class="<?php echo $services_edit->LeftColumnClass ?>"><?php echo $services->largeImage->FldCaption() ?></label>
		<div class="<?php echo $services_edit->RightColumnClass ?>"><div<?php echo $services->largeImage->CellAttributes() ?>>
<span id="el_services_largeImage">
<div id="fd_x_largeImage">
<span title="<?php echo $services->largeImage->FldTitle() ? $services->largeImage->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($services->largeImage->ReadOnly || $services->largeImage->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="services" data-field="x_largeImage" data-page="2" name="x_largeImage" id="x_largeImage"<?php echo $services->largeImage->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_largeImage" id= "fn_x_largeImage" value="<?php echo $services->largeImage->Upload->FileName ?>">
<?php if (@$_POST["fa_x_largeImage"] == "0") { ?>
<input type="hidden" name="fa_x_largeImage" id= "fa_x_largeImage" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_largeImage" id= "fa_x_largeImage" value="1">
<?php } ?>
<input type="hidden" name="fs_x_largeImage" id= "fs_x_largeImage" value="255">
<input type="hidden" name="fx_x_largeImage" id= "fx_x_largeImage" value="<?php echo $services->largeImage->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_largeImage" id= "fm_x_largeImage" value="<?php echo $services->largeImage->UploadMaxFileSize ?>">
</div>
<table id="ft_x_largeImage" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $services->largeImage->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
		<div class="tab-pane<?php echo $services_edit->MultiPages->PageStyle("3") ?>" id="tab_services3"><!-- multi-page .tab-pane -->
<div class="ewEditDiv"><!-- page* -->
<?php if ($services->summary->Visible) { // summary ?>
	<div id="r_summary" class="form-group">
		<label id="elh_services_summary" for="x_summary" class="<?php echo $services_edit->LeftColumnClass ?>"><?php echo $services->summary->FldCaption() ?></label>
		<div class="<?php echo $services_edit->RightColumnClass ?>"><div<?php echo $services->summary->CellAttributes() ?>>
<span id="el_services_summary">
<textarea data-table="services" data-field="x_summary" data-page="3" name="x_summary" id="x_summary" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($services->summary->getPlaceHolder()) ?>"<?php echo $services->summary->EditAttributes() ?>><?php echo $services->summary->EditValue ?></textarea>
</span>
<?php echo $services->summary->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->summary_ar->Visible) { // summary_ar ?>
	<div id="r_summary_ar" class="form-group">
		<label id="elh_services_summary_ar" for="x_summary_ar" class="<?php echo $services_edit->LeftColumnClass ?>"><?php echo $services->summary_ar->FldCaption() ?></label>
		<div class="<?php echo $services_edit->RightColumnClass ?>"><div<?php echo $services->summary_ar->CellAttributes() ?>>
<span id="el_services_summary_ar">
<textarea data-table="services" data-field="x_summary_ar" data-page="3" name="x_summary_ar" id="x_summary_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($services->summary_ar->getPlaceHolder()) ?>"<?php echo $services->summary_ar->EditAttributes() ?>><?php echo $services->summary_ar->EditValue ?></textarea>
</span>
<?php echo $services->summary_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->description->Visible) { // description ?>
	<div id="r_description" class="form-group">
		<label id="elh_services_description" class="<?php echo $services_edit->LeftColumnClass ?>"><?php echo $services->description->FldCaption() ?></label>
		<div class="<?php echo $services_edit->RightColumnClass ?>"><div<?php echo $services->description->CellAttributes() ?>>
<span id="el_services_description">
<?php ew_AppendClass($services->description->EditAttrs["class"], "editor"); ?>
<textarea data-table="services" data-field="x_description" data-page="3" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($services->description->getPlaceHolder()) ?>"<?php echo $services->description->EditAttributes() ?>><?php echo $services->description->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fservicesedit", "x_description", 35, 4, <?php echo ($services->description->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $services->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->description_ar->Visible) { // description_ar ?>
	<div id="r_description_ar" class="form-group">
		<label id="elh_services_description_ar" class="<?php echo $services_edit->LeftColumnClass ?>"><?php echo $services->description_ar->FldCaption() ?></label>
		<div class="<?php echo $services_edit->RightColumnClass ?>"><div<?php echo $services->description_ar->CellAttributes() ?>>
<span id="el_services_description_ar">
<?php ew_AppendClass($services->description_ar->EditAttrs["class"], "editor"); ?>
<textarea data-table="services" data-field="x_description_ar" data-page="3" name="x_description_ar" id="x_description_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($services->description_ar->getPlaceHolder()) ?>"<?php echo $services->description_ar->EditAttributes() ?>><?php echo $services->description_ar->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fservicesedit", "x_description_ar", 35, 4, <?php echo ($services->description_ar->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $services->description_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
	</div><!-- /multi-page .nav-tabs-custom .tab-content -->
</div><!-- /multi-page .nav-tabs-custom -->
</div><!-- /multi-page -->
<?php if (!$services_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $services_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $services_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fservicesedit.Init();
</script>
<?php
$services_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$services_edit->Page_Terminate();
?>
