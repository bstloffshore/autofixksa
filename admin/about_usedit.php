<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "about_usinfo.php" ?>
<?php include_once "cms_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$about_us_edit = NULL; // Initialize page object first

class cabout_us_edit extends cabout_us {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{8281128E-C7BB-40DA-A1AE-8695DB7283AC}';

	// Table name
	var $TableName = 'about_us';

	// Page object name
	var $PageObjName = 'about_us_edit';

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

		// Table object (about_us)
		if (!isset($GLOBALS["about_us"]) || get_class($GLOBALS["about_us"]) == "cabout_us") {
			$GLOBALS["about_us"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["about_us"];
		}

		// Table object (cms_users)
		if (!isset($GLOBALS['cms_users'])) $GLOBALS['cms_users'] = new ccms_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'about_us', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("about_uslist.php"));
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
		$this->section_01_title->SetVisibility();
		$this->section_01_title_ar->SetVisibility();
		$this->section_01_image->SetVisibility();
		$this->section_01_summary->SetVisibility();
		$this->section_01_summary_ar->SetVisibility();
		$this->section_01_description->SetVisibility();
		$this->section_01_description_ar->SetVisibility();
		$this->section_02_summary->SetVisibility();
		$this->section_02_summary_ar->SetVisibility();
		$this->section_02_description_01->SetVisibility();
		$this->section_02_description_01_ar->SetVisibility();
		$this->section_02_description_02->SetVisibility();
		$this->section_02_description_02_ar->SetVisibility();

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
		global $EW_EXPORT, $about_us;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($about_us);
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
					if ($pageName == "about_usview.php")
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
					$this->Page_Terminate("about_uslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "about_uslist.php")
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
		$this->section_01_image->Upload->Index = $objForm->Index;
		$this->section_01_image->Upload->UploadFile();
		$this->section_01_image->CurrentValue = $this->section_01_image->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->section_01_title->FldIsDetailKey) {
			$this->section_01_title->setFormValue($objForm->GetValue("x_section_01_title"));
		}
		if (!$this->section_01_title_ar->FldIsDetailKey) {
			$this->section_01_title_ar->setFormValue($objForm->GetValue("x_section_01_title_ar"));
		}
		if (!$this->section_01_summary->FldIsDetailKey) {
			$this->section_01_summary->setFormValue($objForm->GetValue("x_section_01_summary"));
		}
		if (!$this->section_01_summary_ar->FldIsDetailKey) {
			$this->section_01_summary_ar->setFormValue($objForm->GetValue("x_section_01_summary_ar"));
		}
		if (!$this->section_01_description->FldIsDetailKey) {
			$this->section_01_description->setFormValue($objForm->GetValue("x_section_01_description"));
		}
		if (!$this->section_01_description_ar->FldIsDetailKey) {
			$this->section_01_description_ar->setFormValue($objForm->GetValue("x_section_01_description_ar"));
		}
		if (!$this->section_02_summary->FldIsDetailKey) {
			$this->section_02_summary->setFormValue($objForm->GetValue("x_section_02_summary"));
		}
		if (!$this->section_02_summary_ar->FldIsDetailKey) {
			$this->section_02_summary_ar->setFormValue($objForm->GetValue("x_section_02_summary_ar"));
		}
		if (!$this->section_02_description_01->FldIsDetailKey) {
			$this->section_02_description_01->setFormValue($objForm->GetValue("x_section_02_description_01"));
		}
		if (!$this->section_02_description_01_ar->FldIsDetailKey) {
			$this->section_02_description_01_ar->setFormValue($objForm->GetValue("x_section_02_description_01_ar"));
		}
		if (!$this->section_02_description_02->FldIsDetailKey) {
			$this->section_02_description_02->setFormValue($objForm->GetValue("x_section_02_description_02"));
		}
		if (!$this->section_02_description_02_ar->FldIsDetailKey) {
			$this->section_02_description_02_ar->setFormValue($objForm->GetValue("x_section_02_description_02_ar"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id->CurrentValue = $this->id->FormValue;
		$this->section_01_title->CurrentValue = $this->section_01_title->FormValue;
		$this->section_01_title_ar->CurrentValue = $this->section_01_title_ar->FormValue;
		$this->section_01_summary->CurrentValue = $this->section_01_summary->FormValue;
		$this->section_01_summary_ar->CurrentValue = $this->section_01_summary_ar->FormValue;
		$this->section_01_description->CurrentValue = $this->section_01_description->FormValue;
		$this->section_01_description_ar->CurrentValue = $this->section_01_description_ar->FormValue;
		$this->section_02_summary->CurrentValue = $this->section_02_summary->FormValue;
		$this->section_02_summary_ar->CurrentValue = $this->section_02_summary_ar->FormValue;
		$this->section_02_description_01->CurrentValue = $this->section_02_description_01->FormValue;
		$this->section_02_description_01_ar->CurrentValue = $this->section_02_description_01_ar->FormValue;
		$this->section_02_description_02->CurrentValue = $this->section_02_description_02->FormValue;
		$this->section_02_description_02_ar->CurrentValue = $this->section_02_description_02_ar->FormValue;
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
		$this->section_01_title->setDbValue($row['section_01_title']);
		$this->section_01_title_ar->setDbValue($row['section_01_title_ar']);
		$this->section_01_image->Upload->DbValue = $row['section_01_image'];
		$this->section_01_image->setDbValue($this->section_01_image->Upload->DbValue);
		$this->section_01_summary->setDbValue($row['section_01_summary']);
		$this->section_01_summary_ar->setDbValue($row['section_01_summary_ar']);
		$this->section_01_description->setDbValue($row['section_01_description']);
		$this->section_01_description_ar->setDbValue($row['section_01_description_ar']);
		$this->section_02_summary->setDbValue($row['section_02_summary']);
		$this->section_02_summary_ar->setDbValue($row['section_02_summary_ar']);
		$this->section_02_description_01->setDbValue($row['section_02_description_01']);
		$this->section_02_description_01_ar->setDbValue($row['section_02_description_01_ar']);
		$this->section_02_description_02->setDbValue($row['section_02_description_02']);
		$this->section_02_description_02_ar->setDbValue($row['section_02_description_02_ar']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['section_01_title'] = NULL;
		$row['section_01_title_ar'] = NULL;
		$row['section_01_image'] = NULL;
		$row['section_01_summary'] = NULL;
		$row['section_01_summary_ar'] = NULL;
		$row['section_01_description'] = NULL;
		$row['section_01_description_ar'] = NULL;
		$row['section_02_summary'] = NULL;
		$row['section_02_summary_ar'] = NULL;
		$row['section_02_description_01'] = NULL;
		$row['section_02_description_01_ar'] = NULL;
		$row['section_02_description_02'] = NULL;
		$row['section_02_description_02_ar'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->section_01_title->DbValue = $row['section_01_title'];
		$this->section_01_title_ar->DbValue = $row['section_01_title_ar'];
		$this->section_01_image->Upload->DbValue = $row['section_01_image'];
		$this->section_01_summary->DbValue = $row['section_01_summary'];
		$this->section_01_summary_ar->DbValue = $row['section_01_summary_ar'];
		$this->section_01_description->DbValue = $row['section_01_description'];
		$this->section_01_description_ar->DbValue = $row['section_01_description_ar'];
		$this->section_02_summary->DbValue = $row['section_02_summary'];
		$this->section_02_summary_ar->DbValue = $row['section_02_summary_ar'];
		$this->section_02_description_01->DbValue = $row['section_02_description_01'];
		$this->section_02_description_01_ar->DbValue = $row['section_02_description_01_ar'];
		$this->section_02_description_02->DbValue = $row['section_02_description_02'];
		$this->section_02_description_02_ar->DbValue = $row['section_02_description_02_ar'];
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
		// section_01_title
		// section_01_title_ar
		// section_01_image
		// section_01_summary
		// section_01_summary_ar
		// section_01_description
		// section_01_description_ar
		// section_02_summary
		// section_02_summary_ar
		// section_02_description_01
		// section_02_description_01_ar
		// section_02_description_02
		// section_02_description_02_ar

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// section_01_title
		$this->section_01_title->ViewValue = $this->section_01_title->CurrentValue;
		$this->section_01_title->ViewCustomAttributes = "";

		// section_01_title_ar
		$this->section_01_title_ar->ViewValue = $this->section_01_title_ar->CurrentValue;
		$this->section_01_title_ar->ViewCustomAttributes = "";

		// section_01_image
		$this->section_01_image->UploadPath = 'uploads/pages';
		if (!ew_Empty($this->section_01_image->Upload->DbValue)) {
			$this->section_01_image->ImageWidth = 100;
			$this->section_01_image->ImageHeight = 0;
			$this->section_01_image->ImageAlt = $this->section_01_image->FldAlt();
			$this->section_01_image->ViewValue = $this->section_01_image->Upload->DbValue;
		} else {
			$this->section_01_image->ViewValue = "";
		}
		$this->section_01_image->ViewCustomAttributes = "";

		// section_01_summary
		$this->section_01_summary->ViewValue = $this->section_01_summary->CurrentValue;
		$this->section_01_summary->ViewCustomAttributes = "";

		// section_01_summary_ar
		$this->section_01_summary_ar->ViewValue = $this->section_01_summary_ar->CurrentValue;
		$this->section_01_summary_ar->ViewCustomAttributes = "";

		// section_01_description
		$this->section_01_description->ViewValue = $this->section_01_description->CurrentValue;
		$this->section_01_description->ViewCustomAttributes = "";

		// section_01_description_ar
		$this->section_01_description_ar->ViewValue = $this->section_01_description_ar->CurrentValue;
		$this->section_01_description_ar->ViewCustomAttributes = "";

		// section_02_summary
		$this->section_02_summary->ViewValue = $this->section_02_summary->CurrentValue;
		$this->section_02_summary->ViewCustomAttributes = "";

		// section_02_summary_ar
		$this->section_02_summary_ar->ViewValue = $this->section_02_summary_ar->CurrentValue;
		$this->section_02_summary_ar->ViewCustomAttributes = "";

		// section_02_description_01
		$this->section_02_description_01->ViewValue = $this->section_02_description_01->CurrentValue;
		$this->section_02_description_01->ViewCustomAttributes = "";

		// section_02_description_01_ar
		$this->section_02_description_01_ar->ViewValue = $this->section_02_description_01_ar->CurrentValue;
		$this->section_02_description_01_ar->ViewCustomAttributes = "";

		// section_02_description_02
		$this->section_02_description_02->ViewValue = $this->section_02_description_02->CurrentValue;
		$this->section_02_description_02->ViewCustomAttributes = "";

		// section_02_description_02_ar
		$this->section_02_description_02_ar->ViewValue = $this->section_02_description_02_ar->CurrentValue;
		$this->section_02_description_02_ar->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// section_01_title
			$this->section_01_title->LinkCustomAttributes = "";
			$this->section_01_title->HrefValue = "";
			$this->section_01_title->TooltipValue = "";

			// section_01_title_ar
			$this->section_01_title_ar->LinkCustomAttributes = "";
			$this->section_01_title_ar->HrefValue = "";
			$this->section_01_title_ar->TooltipValue = "";

			// section_01_image
			$this->section_01_image->LinkCustomAttributes = "";
			$this->section_01_image->UploadPath = 'uploads/pages';
			if (!ew_Empty($this->section_01_image->Upload->DbValue)) {
				$this->section_01_image->HrefValue = ew_GetFileUploadUrl($this->section_01_image, $this->section_01_image->Upload->DbValue); // Add prefix/suffix
				$this->section_01_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->section_01_image->HrefValue = ew_FullUrl($this->section_01_image->HrefValue, "href");
			} else {
				$this->section_01_image->HrefValue = "";
			}
			$this->section_01_image->HrefValue2 = $this->section_01_image->UploadPath . $this->section_01_image->Upload->DbValue;
			$this->section_01_image->TooltipValue = "";
			if ($this->section_01_image->UseColorbox) {
				if (ew_Empty($this->section_01_image->TooltipValue))
					$this->section_01_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->section_01_image->LinkAttrs["data-rel"] = "about_us_x_section_01_image";
				ew_AppendClass($this->section_01_image->LinkAttrs["class"], "ewLightbox");
			}

			// section_01_summary
			$this->section_01_summary->LinkCustomAttributes = "";
			$this->section_01_summary->HrefValue = "";
			$this->section_01_summary->TooltipValue = "";

			// section_01_summary_ar
			$this->section_01_summary_ar->LinkCustomAttributes = "";
			$this->section_01_summary_ar->HrefValue = "";
			$this->section_01_summary_ar->TooltipValue = "";

			// section_01_description
			$this->section_01_description->LinkCustomAttributes = "";
			$this->section_01_description->HrefValue = "";
			$this->section_01_description->TooltipValue = "";

			// section_01_description_ar
			$this->section_01_description_ar->LinkCustomAttributes = "";
			$this->section_01_description_ar->HrefValue = "";
			$this->section_01_description_ar->TooltipValue = "";

			// section_02_summary
			$this->section_02_summary->LinkCustomAttributes = "";
			$this->section_02_summary->HrefValue = "";
			$this->section_02_summary->TooltipValue = "";

			// section_02_summary_ar
			$this->section_02_summary_ar->LinkCustomAttributes = "";
			$this->section_02_summary_ar->HrefValue = "";
			$this->section_02_summary_ar->TooltipValue = "";

			// section_02_description_01
			$this->section_02_description_01->LinkCustomAttributes = "";
			$this->section_02_description_01->HrefValue = "";
			$this->section_02_description_01->TooltipValue = "";

			// section_02_description_01_ar
			$this->section_02_description_01_ar->LinkCustomAttributes = "";
			$this->section_02_description_01_ar->HrefValue = "";
			$this->section_02_description_01_ar->TooltipValue = "";

			// section_02_description_02
			$this->section_02_description_02->LinkCustomAttributes = "";
			$this->section_02_description_02->HrefValue = "";
			$this->section_02_description_02->TooltipValue = "";

			// section_02_description_02_ar
			$this->section_02_description_02_ar->LinkCustomAttributes = "";
			$this->section_02_description_02_ar->HrefValue = "";
			$this->section_02_description_02_ar->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// section_01_title
			$this->section_01_title->EditAttrs["class"] = "form-control";
			$this->section_01_title->EditCustomAttributes = "";
			$this->section_01_title->EditValue = ew_HtmlEncode($this->section_01_title->CurrentValue);
			$this->section_01_title->PlaceHolder = ew_RemoveHtml($this->section_01_title->FldCaption());

			// section_01_title_ar
			$this->section_01_title_ar->EditAttrs["class"] = "form-control";
			$this->section_01_title_ar->EditCustomAttributes = "";
			$this->section_01_title_ar->EditValue = ew_HtmlEncode($this->section_01_title_ar->CurrentValue);
			$this->section_01_title_ar->PlaceHolder = ew_RemoveHtml($this->section_01_title_ar->FldCaption());

			// section_01_image
			$this->section_01_image->EditAttrs["class"] = "form-control";
			$this->section_01_image->EditCustomAttributes = "";
			$this->section_01_image->UploadPath = 'uploads/pages';
			if (!ew_Empty($this->section_01_image->Upload->DbValue)) {
				$this->section_01_image->ImageWidth = 100;
				$this->section_01_image->ImageHeight = 0;
				$this->section_01_image->ImageAlt = $this->section_01_image->FldAlt();
				$this->section_01_image->EditValue = $this->section_01_image->Upload->DbValue;
			} else {
				$this->section_01_image->EditValue = "";
			}
			if (!ew_Empty($this->section_01_image->CurrentValue))
					$this->section_01_image->Upload->FileName = $this->section_01_image->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->section_01_image);

			// section_01_summary
			$this->section_01_summary->EditAttrs["class"] = "form-control";
			$this->section_01_summary->EditCustomAttributes = "";
			$this->section_01_summary->EditValue = ew_HtmlEncode($this->section_01_summary->CurrentValue);
			$this->section_01_summary->PlaceHolder = ew_RemoveHtml($this->section_01_summary->FldCaption());

			// section_01_summary_ar
			$this->section_01_summary_ar->EditAttrs["class"] = "form-control";
			$this->section_01_summary_ar->EditCustomAttributes = "";
			$this->section_01_summary_ar->EditValue = ew_HtmlEncode($this->section_01_summary_ar->CurrentValue);
			$this->section_01_summary_ar->PlaceHolder = ew_RemoveHtml($this->section_01_summary_ar->FldCaption());

			// section_01_description
			$this->section_01_description->EditAttrs["class"] = "form-control";
			$this->section_01_description->EditCustomAttributes = "";
			$this->section_01_description->EditValue = ew_HtmlEncode($this->section_01_description->CurrentValue);
			$this->section_01_description->PlaceHolder = ew_RemoveHtml($this->section_01_description->FldCaption());

			// section_01_description_ar
			$this->section_01_description_ar->EditAttrs["class"] = "form-control";
			$this->section_01_description_ar->EditCustomAttributes = "";
			$this->section_01_description_ar->EditValue = ew_HtmlEncode($this->section_01_description_ar->CurrentValue);
			$this->section_01_description_ar->PlaceHolder = ew_RemoveHtml($this->section_01_description_ar->FldCaption());

			// section_02_summary
			$this->section_02_summary->EditAttrs["class"] = "form-control";
			$this->section_02_summary->EditCustomAttributes = "";
			$this->section_02_summary->EditValue = ew_HtmlEncode($this->section_02_summary->CurrentValue);
			$this->section_02_summary->PlaceHolder = ew_RemoveHtml($this->section_02_summary->FldCaption());

			// section_02_summary_ar
			$this->section_02_summary_ar->EditAttrs["class"] = "form-control";
			$this->section_02_summary_ar->EditCustomAttributes = "";
			$this->section_02_summary_ar->EditValue = ew_HtmlEncode($this->section_02_summary_ar->CurrentValue);
			$this->section_02_summary_ar->PlaceHolder = ew_RemoveHtml($this->section_02_summary_ar->FldCaption());

			// section_02_description_01
			$this->section_02_description_01->EditAttrs["class"] = "form-control";
			$this->section_02_description_01->EditCustomAttributes = "";
			$this->section_02_description_01->EditValue = ew_HtmlEncode($this->section_02_description_01->CurrentValue);
			$this->section_02_description_01->PlaceHolder = ew_RemoveHtml($this->section_02_description_01->FldCaption());

			// section_02_description_01_ar
			$this->section_02_description_01_ar->EditAttrs["class"] = "form-control";
			$this->section_02_description_01_ar->EditCustomAttributes = "";
			$this->section_02_description_01_ar->EditValue = ew_HtmlEncode($this->section_02_description_01_ar->CurrentValue);
			$this->section_02_description_01_ar->PlaceHolder = ew_RemoveHtml($this->section_02_description_01_ar->FldCaption());

			// section_02_description_02
			$this->section_02_description_02->EditAttrs["class"] = "form-control";
			$this->section_02_description_02->EditCustomAttributes = "";
			$this->section_02_description_02->EditValue = ew_HtmlEncode($this->section_02_description_02->CurrentValue);
			$this->section_02_description_02->PlaceHolder = ew_RemoveHtml($this->section_02_description_02->FldCaption());

			// section_02_description_02_ar
			$this->section_02_description_02_ar->EditAttrs["class"] = "form-control";
			$this->section_02_description_02_ar->EditCustomAttributes = "";
			$this->section_02_description_02_ar->EditValue = ew_HtmlEncode($this->section_02_description_02_ar->CurrentValue);
			$this->section_02_description_02_ar->PlaceHolder = ew_RemoveHtml($this->section_02_description_02_ar->FldCaption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// section_01_title
			$this->section_01_title->LinkCustomAttributes = "";
			$this->section_01_title->HrefValue = "";

			// section_01_title_ar
			$this->section_01_title_ar->LinkCustomAttributes = "";
			$this->section_01_title_ar->HrefValue = "";

			// section_01_image
			$this->section_01_image->LinkCustomAttributes = "";
			$this->section_01_image->UploadPath = 'uploads/pages';
			if (!ew_Empty($this->section_01_image->Upload->DbValue)) {
				$this->section_01_image->HrefValue = ew_GetFileUploadUrl($this->section_01_image, $this->section_01_image->Upload->DbValue); // Add prefix/suffix
				$this->section_01_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->section_01_image->HrefValue = ew_FullUrl($this->section_01_image->HrefValue, "href");
			} else {
				$this->section_01_image->HrefValue = "";
			}
			$this->section_01_image->HrefValue2 = $this->section_01_image->UploadPath . $this->section_01_image->Upload->DbValue;

			// section_01_summary
			$this->section_01_summary->LinkCustomAttributes = "";
			$this->section_01_summary->HrefValue = "";

			// section_01_summary_ar
			$this->section_01_summary_ar->LinkCustomAttributes = "";
			$this->section_01_summary_ar->HrefValue = "";

			// section_01_description
			$this->section_01_description->LinkCustomAttributes = "";
			$this->section_01_description->HrefValue = "";

			// section_01_description_ar
			$this->section_01_description_ar->LinkCustomAttributes = "";
			$this->section_01_description_ar->HrefValue = "";

			// section_02_summary
			$this->section_02_summary->LinkCustomAttributes = "";
			$this->section_02_summary->HrefValue = "";

			// section_02_summary_ar
			$this->section_02_summary_ar->LinkCustomAttributes = "";
			$this->section_02_summary_ar->HrefValue = "";

			// section_02_description_01
			$this->section_02_description_01->LinkCustomAttributes = "";
			$this->section_02_description_01->HrefValue = "";

			// section_02_description_01_ar
			$this->section_02_description_01_ar->LinkCustomAttributes = "";
			$this->section_02_description_01_ar->HrefValue = "";

			// section_02_description_02
			$this->section_02_description_02->LinkCustomAttributes = "";
			$this->section_02_description_02->HrefValue = "";

			// section_02_description_02_ar
			$this->section_02_description_02_ar->LinkCustomAttributes = "";
			$this->section_02_description_02_ar->HrefValue = "";
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
			$this->section_01_image->OldUploadPath = 'uploads/pages';
			$this->section_01_image->UploadPath = $this->section_01_image->OldUploadPath;
			$rsnew = array();

			// section_01_title
			$this->section_01_title->SetDbValueDef($rsnew, $this->section_01_title->CurrentValue, NULL, $this->section_01_title->ReadOnly);

			// section_01_title_ar
			$this->section_01_title_ar->SetDbValueDef($rsnew, $this->section_01_title_ar->CurrentValue, NULL, $this->section_01_title_ar->ReadOnly);

			// section_01_image
			if ($this->section_01_image->Visible && !$this->section_01_image->ReadOnly && !$this->section_01_image->Upload->KeepFile) {
				$this->section_01_image->Upload->DbValue = $rsold['section_01_image']; // Get original value
				if ($this->section_01_image->Upload->FileName == "") {
					$rsnew['section_01_image'] = NULL;
				} else {
					$rsnew['section_01_image'] = $this->section_01_image->Upload->FileName;
				}
			}

			// section_01_summary
			$this->section_01_summary->SetDbValueDef($rsnew, $this->section_01_summary->CurrentValue, NULL, $this->section_01_summary->ReadOnly);

			// section_01_summary_ar
			$this->section_01_summary_ar->SetDbValueDef($rsnew, $this->section_01_summary_ar->CurrentValue, NULL, $this->section_01_summary_ar->ReadOnly);

			// section_01_description
			$this->section_01_description->SetDbValueDef($rsnew, $this->section_01_description->CurrentValue, NULL, $this->section_01_description->ReadOnly);

			// section_01_description_ar
			$this->section_01_description_ar->SetDbValueDef($rsnew, $this->section_01_description_ar->CurrentValue, NULL, $this->section_01_description_ar->ReadOnly);

			// section_02_summary
			$this->section_02_summary->SetDbValueDef($rsnew, $this->section_02_summary->CurrentValue, NULL, $this->section_02_summary->ReadOnly);

			// section_02_summary_ar
			$this->section_02_summary_ar->SetDbValueDef($rsnew, $this->section_02_summary_ar->CurrentValue, NULL, $this->section_02_summary_ar->ReadOnly);

			// section_02_description_01
			$this->section_02_description_01->SetDbValueDef($rsnew, $this->section_02_description_01->CurrentValue, NULL, $this->section_02_description_01->ReadOnly);

			// section_02_description_01_ar
			$this->section_02_description_01_ar->SetDbValueDef($rsnew, $this->section_02_description_01_ar->CurrentValue, NULL, $this->section_02_description_01_ar->ReadOnly);

			// section_02_description_02
			$this->section_02_description_02->SetDbValueDef($rsnew, $this->section_02_description_02->CurrentValue, NULL, $this->section_02_description_02->ReadOnly);

			// section_02_description_02_ar
			$this->section_02_description_02_ar->SetDbValueDef($rsnew, $this->section_02_description_02_ar->CurrentValue, NULL, $this->section_02_description_02_ar->ReadOnly);
			if ($this->section_01_image->Visible && !$this->section_01_image->Upload->KeepFile) {
				$this->section_01_image->UploadPath = 'uploads/pages';
				$OldFiles = ew_Empty($this->section_01_image->Upload->DbValue) ? array() : array($this->section_01_image->Upload->DbValue);
				if (!ew_Empty($this->section_01_image->Upload->FileName)) {
					$NewFiles = array($this->section_01_image->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->section_01_image->Upload->Index < 0) ? $this->section_01_image->FldVar : substr($this->section_01_image->FldVar, 0, 1) . $this->section_01_image->Upload->Index . substr($this->section_01_image->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->section_01_image->TblVar) . $file)) {
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
								$file1 = ew_UploadFileNameEx($this->section_01_image->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->section_01_image->TblVar) . $file1) || file_exists($this->section_01_image->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->section_01_image->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->section_01_image->TblVar) . $file, ew_UploadTempPath($fldvar, $this->section_01_image->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->section_01_image->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->section_01_image->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->section_01_image->SetDbValueDef($rsnew, $this->section_01_image->Upload->FileName, NULL, $this->section_01_image->ReadOnly);
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
					if ($this->section_01_image->Visible && !$this->section_01_image->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->section_01_image->Upload->DbValue) ? array() : array($this->section_01_image->Upload->DbValue);
						if (!ew_Empty($this->section_01_image->Upload->FileName)) {
							$NewFiles = array($this->section_01_image->Upload->FileName);
							$NewFiles2 = array($rsnew['section_01_image']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->section_01_image->Upload->Index < 0) ? $this->section_01_image->FldVar : substr($this->section_01_image->FldVar, 0, 1) . $this->section_01_image->Upload->Index . substr($this->section_01_image->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->section_01_image->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->section_01_image->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
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
								@unlink($this->section_01_image->OldPhysicalUploadPath() . $OldFiles[$i]);
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

		// section_01_image
		ew_CleanUploadTempPath($this->section_01_image, $this->section_01_image->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("about_uslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($about_us_edit)) $about_us_edit = new cabout_us_edit();

// Page init
$about_us_edit->Page_Init();

// Page main
$about_us_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$about_us_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fabout_usedit = new ew_Form("fabout_usedit", "edit");

// Validate form
fabout_usedit.Validate = function() {
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
fabout_usedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fabout_usedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Multi-Page
fabout_usedit.MultiPage = new ew_MultiPage("fabout_usedit");

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $about_us_edit->ShowPageHeader(); ?>
<?php
$about_us_edit->ShowMessage();
?>
<form name="fabout_usedit" id="fabout_usedit" class="<?php echo $about_us_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($about_us_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $about_us_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="about_us">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($about_us_edit->IsModal) ?>">
<div class="ewMultiPage"><!-- multi-page -->
<div class="nav-tabs-custom" id="about_us_edit"><!-- multi-page .nav-tabs-custom -->
	<ul class="nav<?php echo $about_us_edit->MultiPages->NavStyle() ?>">
		<li<?php echo $about_us_edit->MultiPages->TabStyle("1") ?>><a href="#tab_about_us1" data-toggle="tab"><?php echo $about_us->PageCaption(1) ?></a></li>
		<li<?php echo $about_us_edit->MultiPages->TabStyle("2") ?>><a href="#tab_about_us2" data-toggle="tab"><?php echo $about_us->PageCaption(2) ?></a></li>
	</ul>
	<div class="tab-content"><!-- multi-page .nav-tabs-custom .tab-content -->
		<div class="tab-pane<?php echo $about_us_edit->MultiPages->PageStyle("1") ?>" id="tab_about_us1"><!-- multi-page .tab-pane -->
<div class="ewEditDiv"><!-- page* -->
<?php if ($about_us->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_about_us_id" class="<?php echo $about_us_edit->LeftColumnClass ?>"><?php echo $about_us->id->FldCaption() ?></label>
		<div class="<?php echo $about_us_edit->RightColumnClass ?>"><div<?php echo $about_us->id->CellAttributes() ?>>
<span id="el_about_us_id">
<span<?php echo $about_us->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $about_us->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="about_us" data-field="x_id" data-page="1" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($about_us->id->CurrentValue) ?>">
<?php echo $about_us->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($about_us->section_01_title->Visible) { // section_01_title ?>
	<div id="r_section_01_title" class="form-group">
		<label id="elh_about_us_section_01_title" for="x_section_01_title" class="<?php echo $about_us_edit->LeftColumnClass ?>"><?php echo $about_us->section_01_title->FldCaption() ?></label>
		<div class="<?php echo $about_us_edit->RightColumnClass ?>"><div<?php echo $about_us->section_01_title->CellAttributes() ?>>
<span id="el_about_us_section_01_title">
<input type="text" data-table="about_us" data-field="x_section_01_title" data-page="1" name="x_section_01_title" id="x_section_01_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($about_us->section_01_title->getPlaceHolder()) ?>" value="<?php echo $about_us->section_01_title->EditValue ?>"<?php echo $about_us->section_01_title->EditAttributes() ?>>
</span>
<?php echo $about_us->section_01_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($about_us->section_01_title_ar->Visible) { // section_01_title_ar ?>
	<div id="r_section_01_title_ar" class="form-group">
		<label id="elh_about_us_section_01_title_ar" for="x_section_01_title_ar" class="<?php echo $about_us_edit->LeftColumnClass ?>"><?php echo $about_us->section_01_title_ar->FldCaption() ?></label>
		<div class="<?php echo $about_us_edit->RightColumnClass ?>"><div<?php echo $about_us->section_01_title_ar->CellAttributes() ?>>
<span id="el_about_us_section_01_title_ar">
<input type="text" data-table="about_us" data-field="x_section_01_title_ar" data-page="1" name="x_section_01_title_ar" id="x_section_01_title_ar" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($about_us->section_01_title_ar->getPlaceHolder()) ?>" value="<?php echo $about_us->section_01_title_ar->EditValue ?>"<?php echo $about_us->section_01_title_ar->EditAttributes() ?>>
</span>
<?php echo $about_us->section_01_title_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($about_us->section_01_image->Visible) { // section_01_image ?>
	<div id="r_section_01_image" class="form-group">
		<label id="elh_about_us_section_01_image" class="<?php echo $about_us_edit->LeftColumnClass ?>"><?php echo $about_us->section_01_image->FldCaption() ?></label>
		<div class="<?php echo $about_us_edit->RightColumnClass ?>"><div<?php echo $about_us->section_01_image->CellAttributes() ?>>
<span id="el_about_us_section_01_image">
<div id="fd_x_section_01_image">
<span title="<?php echo $about_us->section_01_image->FldTitle() ? $about_us->section_01_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($about_us->section_01_image->ReadOnly || $about_us->section_01_image->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="about_us" data-field="x_section_01_image" data-page="1" name="x_section_01_image" id="x_section_01_image"<?php echo $about_us->section_01_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_section_01_image" id= "fn_x_section_01_image" value="<?php echo $about_us->section_01_image->Upload->FileName ?>">
<?php if (@$_POST["fa_x_section_01_image"] == "0") { ?>
<input type="hidden" name="fa_x_section_01_image" id= "fa_x_section_01_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_section_01_image" id= "fa_x_section_01_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x_section_01_image" id= "fs_x_section_01_image" value="255">
<input type="hidden" name="fx_x_section_01_image" id= "fx_x_section_01_image" value="<?php echo $about_us->section_01_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_section_01_image" id= "fm_x_section_01_image" value="<?php echo $about_us->section_01_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_section_01_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $about_us->section_01_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($about_us->section_01_summary->Visible) { // section_01_summary ?>
	<div id="r_section_01_summary" class="form-group">
		<label id="elh_about_us_section_01_summary" for="x_section_01_summary" class="<?php echo $about_us_edit->LeftColumnClass ?>"><?php echo $about_us->section_01_summary->FldCaption() ?></label>
		<div class="<?php echo $about_us_edit->RightColumnClass ?>"><div<?php echo $about_us->section_01_summary->CellAttributes() ?>>
<span id="el_about_us_section_01_summary">
<input type="text" data-table="about_us" data-field="x_section_01_summary" data-page="1" name="x_section_01_summary" id="x_section_01_summary" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($about_us->section_01_summary->getPlaceHolder()) ?>" value="<?php echo $about_us->section_01_summary->EditValue ?>"<?php echo $about_us->section_01_summary->EditAttributes() ?>>
</span>
<?php echo $about_us->section_01_summary->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($about_us->section_01_summary_ar->Visible) { // section_01_summary_ar ?>
	<div id="r_section_01_summary_ar" class="form-group">
		<label id="elh_about_us_section_01_summary_ar" for="x_section_01_summary_ar" class="<?php echo $about_us_edit->LeftColumnClass ?>"><?php echo $about_us->section_01_summary_ar->FldCaption() ?></label>
		<div class="<?php echo $about_us_edit->RightColumnClass ?>"><div<?php echo $about_us->section_01_summary_ar->CellAttributes() ?>>
<span id="el_about_us_section_01_summary_ar">
<input type="text" data-table="about_us" data-field="x_section_01_summary_ar" data-page="1" name="x_section_01_summary_ar" id="x_section_01_summary_ar" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($about_us->section_01_summary_ar->getPlaceHolder()) ?>" value="<?php echo $about_us->section_01_summary_ar->EditValue ?>"<?php echo $about_us->section_01_summary_ar->EditAttributes() ?>>
</span>
<?php echo $about_us->section_01_summary_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($about_us->section_01_description->Visible) { // section_01_description ?>
	<div id="r_section_01_description" class="form-group">
		<label id="elh_about_us_section_01_description" class="<?php echo $about_us_edit->LeftColumnClass ?>"><?php echo $about_us->section_01_description->FldCaption() ?></label>
		<div class="<?php echo $about_us_edit->RightColumnClass ?>"><div<?php echo $about_us->section_01_description->CellAttributes() ?>>
<span id="el_about_us_section_01_description">
<?php ew_AppendClass($about_us->section_01_description->EditAttrs["class"], "editor"); ?>
<textarea data-table="about_us" data-field="x_section_01_description" data-page="1" name="x_section_01_description" id="x_section_01_description" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($about_us->section_01_description->getPlaceHolder()) ?>"<?php echo $about_us->section_01_description->EditAttributes() ?>><?php echo $about_us->section_01_description->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fabout_usedit", "x_section_01_description", 35, 4, <?php echo ($about_us->section_01_description->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $about_us->section_01_description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($about_us->section_01_description_ar->Visible) { // section_01_description_ar ?>
	<div id="r_section_01_description_ar" class="form-group">
		<label id="elh_about_us_section_01_description_ar" class="<?php echo $about_us_edit->LeftColumnClass ?>"><?php echo $about_us->section_01_description_ar->FldCaption() ?></label>
		<div class="<?php echo $about_us_edit->RightColumnClass ?>"><div<?php echo $about_us->section_01_description_ar->CellAttributes() ?>>
<span id="el_about_us_section_01_description_ar">
<?php ew_AppendClass($about_us->section_01_description_ar->EditAttrs["class"], "editor"); ?>
<textarea data-table="about_us" data-field="x_section_01_description_ar" data-page="1" name="x_section_01_description_ar" id="x_section_01_description_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($about_us->section_01_description_ar->getPlaceHolder()) ?>"<?php echo $about_us->section_01_description_ar->EditAttributes() ?>><?php echo $about_us->section_01_description_ar->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fabout_usedit", "x_section_01_description_ar", 35, 4, <?php echo ($about_us->section_01_description_ar->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $about_us->section_01_description_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
		<div class="tab-pane<?php echo $about_us_edit->MultiPages->PageStyle("2") ?>" id="tab_about_us2"><!-- multi-page .tab-pane -->
<div class="ewEditDiv"><!-- page* -->
<?php if ($about_us->section_02_summary->Visible) { // section_02_summary ?>
	<div id="r_section_02_summary" class="form-group">
		<label id="elh_about_us_section_02_summary" for="x_section_02_summary" class="<?php echo $about_us_edit->LeftColumnClass ?>"><?php echo $about_us->section_02_summary->FldCaption() ?></label>
		<div class="<?php echo $about_us_edit->RightColumnClass ?>"><div<?php echo $about_us->section_02_summary->CellAttributes() ?>>
<span id="el_about_us_section_02_summary">
<input type="text" data-table="about_us" data-field="x_section_02_summary" data-page="2" name="x_section_02_summary" id="x_section_02_summary" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($about_us->section_02_summary->getPlaceHolder()) ?>" value="<?php echo $about_us->section_02_summary->EditValue ?>"<?php echo $about_us->section_02_summary->EditAttributes() ?>>
</span>
<?php echo $about_us->section_02_summary->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($about_us->section_02_summary_ar->Visible) { // section_02_summary_ar ?>
	<div id="r_section_02_summary_ar" class="form-group">
		<label id="elh_about_us_section_02_summary_ar" for="x_section_02_summary_ar" class="<?php echo $about_us_edit->LeftColumnClass ?>"><?php echo $about_us->section_02_summary_ar->FldCaption() ?></label>
		<div class="<?php echo $about_us_edit->RightColumnClass ?>"><div<?php echo $about_us->section_02_summary_ar->CellAttributes() ?>>
<span id="el_about_us_section_02_summary_ar">
<input type="text" data-table="about_us" data-field="x_section_02_summary_ar" data-page="2" name="x_section_02_summary_ar" id="x_section_02_summary_ar" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($about_us->section_02_summary_ar->getPlaceHolder()) ?>" value="<?php echo $about_us->section_02_summary_ar->EditValue ?>"<?php echo $about_us->section_02_summary_ar->EditAttributes() ?>>
</span>
<?php echo $about_us->section_02_summary_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($about_us->section_02_description_01->Visible) { // section_02_description_01 ?>
	<div id="r_section_02_description_01" class="form-group">
		<label id="elh_about_us_section_02_description_01" class="<?php echo $about_us_edit->LeftColumnClass ?>"><?php echo $about_us->section_02_description_01->FldCaption() ?></label>
		<div class="<?php echo $about_us_edit->RightColumnClass ?>"><div<?php echo $about_us->section_02_description_01->CellAttributes() ?>>
<span id="el_about_us_section_02_description_01">
<?php ew_AppendClass($about_us->section_02_description_01->EditAttrs["class"], "editor"); ?>
<textarea data-table="about_us" data-field="x_section_02_description_01" data-page="2" name="x_section_02_description_01" id="x_section_02_description_01" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($about_us->section_02_description_01->getPlaceHolder()) ?>"<?php echo $about_us->section_02_description_01->EditAttributes() ?>><?php echo $about_us->section_02_description_01->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fabout_usedit", "x_section_02_description_01", 35, 4, <?php echo ($about_us->section_02_description_01->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $about_us->section_02_description_01->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($about_us->section_02_description_01_ar->Visible) { // section_02_description_01_ar ?>
	<div id="r_section_02_description_01_ar" class="form-group">
		<label id="elh_about_us_section_02_description_01_ar" class="<?php echo $about_us_edit->LeftColumnClass ?>"><?php echo $about_us->section_02_description_01_ar->FldCaption() ?></label>
		<div class="<?php echo $about_us_edit->RightColumnClass ?>"><div<?php echo $about_us->section_02_description_01_ar->CellAttributes() ?>>
<span id="el_about_us_section_02_description_01_ar">
<?php ew_AppendClass($about_us->section_02_description_01_ar->EditAttrs["class"], "editor"); ?>
<textarea data-table="about_us" data-field="x_section_02_description_01_ar" data-page="2" name="x_section_02_description_01_ar" id="x_section_02_description_01_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($about_us->section_02_description_01_ar->getPlaceHolder()) ?>"<?php echo $about_us->section_02_description_01_ar->EditAttributes() ?>><?php echo $about_us->section_02_description_01_ar->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fabout_usedit", "x_section_02_description_01_ar", 35, 4, <?php echo ($about_us->section_02_description_01_ar->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $about_us->section_02_description_01_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($about_us->section_02_description_02->Visible) { // section_02_description_02 ?>
	<div id="r_section_02_description_02" class="form-group">
		<label id="elh_about_us_section_02_description_02" class="<?php echo $about_us_edit->LeftColumnClass ?>"><?php echo $about_us->section_02_description_02->FldCaption() ?></label>
		<div class="<?php echo $about_us_edit->RightColumnClass ?>"><div<?php echo $about_us->section_02_description_02->CellAttributes() ?>>
<span id="el_about_us_section_02_description_02">
<?php ew_AppendClass($about_us->section_02_description_02->EditAttrs["class"], "editor"); ?>
<textarea data-table="about_us" data-field="x_section_02_description_02" data-page="2" name="x_section_02_description_02" id="x_section_02_description_02" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($about_us->section_02_description_02->getPlaceHolder()) ?>"<?php echo $about_us->section_02_description_02->EditAttributes() ?>><?php echo $about_us->section_02_description_02->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fabout_usedit", "x_section_02_description_02", 35, 4, <?php echo ($about_us->section_02_description_02->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $about_us->section_02_description_02->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($about_us->section_02_description_02_ar->Visible) { // section_02_description_02_ar ?>
	<div id="r_section_02_description_02_ar" class="form-group">
		<label id="elh_about_us_section_02_description_02_ar" class="<?php echo $about_us_edit->LeftColumnClass ?>"><?php echo $about_us->section_02_description_02_ar->FldCaption() ?></label>
		<div class="<?php echo $about_us_edit->RightColumnClass ?>"><div<?php echo $about_us->section_02_description_02_ar->CellAttributes() ?>>
<span id="el_about_us_section_02_description_02_ar">
<?php ew_AppendClass($about_us->section_02_description_02_ar->EditAttrs["class"], "editor"); ?>
<textarea data-table="about_us" data-field="x_section_02_description_02_ar" data-page="2" name="x_section_02_description_02_ar" id="x_section_02_description_02_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($about_us->section_02_description_02_ar->getPlaceHolder()) ?>"<?php echo $about_us->section_02_description_02_ar->EditAttributes() ?>><?php echo $about_us->section_02_description_02_ar->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fabout_usedit", "x_section_02_description_02_ar", 35, 4, <?php echo ($about_us->section_02_description_02_ar->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $about_us->section_02_description_02_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
	</div><!-- /multi-page .nav-tabs-custom .tab-content -->
</div><!-- /multi-page .nav-tabs-custom -->
</div><!-- /multi-page -->
<?php if (!$about_us_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $about_us_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $about_us_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fabout_usedit.Init();
</script>
<?php
$about_us_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$about_us_edit->Page_Terminate();
?>
