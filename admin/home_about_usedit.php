<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "home_about_usinfo.php" ?>
<?php include_once "cms_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$home_about_us_edit = NULL; // Initialize page object first

class chome_about_us_edit extends chome_about_us {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{8281128E-C7BB-40DA-A1AE-8695DB7283AC}';

	// Table name
	var $TableName = 'home_about_us';

	// Page object name
	var $PageObjName = 'home_about_us_edit';

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

		// Table object (home_about_us)
		if (!isset($GLOBALS["home_about_us"]) || get_class($GLOBALS["home_about_us"]) == "chome_about_us") {
			$GLOBALS["home_about_us"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["home_about_us"];
		}

		// Table object (cms_users)
		if (!isset($GLOBALS['cms_users'])) $GLOBALS['cms_users'] = new ccms_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'home_about_us', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("home_about_uslist.php"));
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
		$this->title->SetVisibility();
		$this->title_ar->SetVisibility();
		$this->description->SetVisibility();
		$this->description_ar->SetVisibility();
		$this->image_01->SetVisibility();
		$this->image_02->SetVisibility();
		$this->image_03->SetVisibility();

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
		global $EW_EXPORT, $home_about_us;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($home_about_us);
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
					if ($pageName == "home_about_usview.php")
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
					$this->Page_Terminate("home_about_uslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "home_about_uslist.php")
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
		$this->image_01->Upload->Index = $objForm->Index;
		$this->image_01->Upload->UploadFile();
		$this->image_01->CurrentValue = $this->image_01->Upload->FileName;
		$this->image_02->Upload->Index = $objForm->Index;
		$this->image_02->Upload->UploadFile();
		$this->image_02->CurrentValue = $this->image_02->Upload->FileName;
		$this->image_03->Upload->Index = $objForm->Index;
		$this->image_03->Upload->UploadFile();
		$this->image_03->CurrentValue = $this->image_03->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->title->FldIsDetailKey) {
			$this->title->setFormValue($objForm->GetValue("x_title"));
		}
		if (!$this->title_ar->FldIsDetailKey) {
			$this->title_ar->setFormValue($objForm->GetValue("x_title_ar"));
		}
		if (!$this->description->FldIsDetailKey) {
			$this->description->setFormValue($objForm->GetValue("x_description"));
		}
		if (!$this->description_ar->FldIsDetailKey) {
			$this->description_ar->setFormValue($objForm->GetValue("x_description_ar"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id->CurrentValue = $this->id->FormValue;
		$this->title->CurrentValue = $this->title->FormValue;
		$this->title_ar->CurrentValue = $this->title_ar->FormValue;
		$this->description->CurrentValue = $this->description->FormValue;
		$this->description_ar->CurrentValue = $this->description_ar->FormValue;
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
		$this->title->setDbValue($row['title']);
		$this->title_ar->setDbValue($row['title_ar']);
		$this->description->setDbValue($row['description']);
		$this->description_ar->setDbValue($row['description_ar']);
		$this->image_01->Upload->DbValue = $row['image_01'];
		$this->image_01->setDbValue($this->image_01->Upload->DbValue);
		$this->image_02->Upload->DbValue = $row['image_02'];
		$this->image_02->setDbValue($this->image_02->Upload->DbValue);
		$this->image_03->Upload->DbValue = $row['image_03'];
		$this->image_03->setDbValue($this->image_03->Upload->DbValue);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['title'] = NULL;
		$row['title_ar'] = NULL;
		$row['description'] = NULL;
		$row['description_ar'] = NULL;
		$row['image_01'] = NULL;
		$row['image_02'] = NULL;
		$row['image_03'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->title->DbValue = $row['title'];
		$this->title_ar->DbValue = $row['title_ar'];
		$this->description->DbValue = $row['description'];
		$this->description_ar->DbValue = $row['description_ar'];
		$this->image_01->Upload->DbValue = $row['image_01'];
		$this->image_02->Upload->DbValue = $row['image_02'];
		$this->image_03->Upload->DbValue = $row['image_03'];
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
		// title
		// title_ar
		// description
		// description_ar
		// image_01
		// image_02
		// image_03

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// title
		$this->title->ViewValue = $this->title->CurrentValue;
		$this->title->ViewCustomAttributes = "";

		// title_ar
		$this->title_ar->ViewValue = $this->title_ar->CurrentValue;
		$this->title_ar->ViewCustomAttributes = "";

		// description
		$this->description->ViewValue = $this->description->CurrentValue;
		$this->description->ViewCustomAttributes = "";

		// description_ar
		$this->description_ar->ViewValue = $this->description_ar->CurrentValue;
		$this->description_ar->ViewCustomAttributes = "";

		// image_01
		$this->image_01->UploadPath = 'uploads/pages';
		if (!ew_Empty($this->image_01->Upload->DbValue)) {
			$this->image_01->ImageWidth = 100;
			$this->image_01->ImageHeight = 0;
			$this->image_01->ImageAlt = $this->image_01->FldAlt();
			$this->image_01->ViewValue = $this->image_01->Upload->DbValue;
		} else {
			$this->image_01->ViewValue = "";
		}
		$this->image_01->ViewCustomAttributes = "";

		// image_02
		$this->image_02->UploadPath = 'uploads/pages';
		if (!ew_Empty($this->image_02->Upload->DbValue)) {
			$this->image_02->ImageWidth = 100;
			$this->image_02->ImageHeight = 0;
			$this->image_02->ImageAlt = $this->image_02->FldAlt();
			$this->image_02->ViewValue = $this->image_02->Upload->DbValue;
		} else {
			$this->image_02->ViewValue = "";
		}
		$this->image_02->ViewCustomAttributes = "";

		// image_03
		$this->image_03->UploadPath = 'uploads/pages';
		if (!ew_Empty($this->image_03->Upload->DbValue)) {
			$this->image_03->ImageWidth = 100;
			$this->image_03->ImageHeight = 0;
			$this->image_03->ImageAlt = $this->image_03->FldAlt();
			$this->image_03->ViewValue = $this->image_03->Upload->DbValue;
		} else {
			$this->image_03->ViewValue = "";
		}
		$this->image_03->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";
			$this->title->TooltipValue = "";

			// title_ar
			$this->title_ar->LinkCustomAttributes = "";
			$this->title_ar->HrefValue = "";
			$this->title_ar->TooltipValue = "";

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";
			$this->description->TooltipValue = "";

			// description_ar
			$this->description_ar->LinkCustomAttributes = "";
			$this->description_ar->HrefValue = "";
			$this->description_ar->TooltipValue = "";

			// image_01
			$this->image_01->LinkCustomAttributes = "";
			$this->image_01->UploadPath = 'uploads/pages';
			if (!ew_Empty($this->image_01->Upload->DbValue)) {
				$this->image_01->HrefValue = ew_GetFileUploadUrl($this->image_01, $this->image_01->Upload->DbValue); // Add prefix/suffix
				$this->image_01->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->image_01->HrefValue = ew_FullUrl($this->image_01->HrefValue, "href");
			} else {
				$this->image_01->HrefValue = "";
			}
			$this->image_01->HrefValue2 = $this->image_01->UploadPath . $this->image_01->Upload->DbValue;
			$this->image_01->TooltipValue = "";
			if ($this->image_01->UseColorbox) {
				if (ew_Empty($this->image_01->TooltipValue))
					$this->image_01->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->image_01->LinkAttrs["data-rel"] = "home_about_us_x_image_01";
				ew_AppendClass($this->image_01->LinkAttrs["class"], "ewLightbox");
			}

			// image_02
			$this->image_02->LinkCustomAttributes = "";
			$this->image_02->UploadPath = 'uploads/pages';
			if (!ew_Empty($this->image_02->Upload->DbValue)) {
				$this->image_02->HrefValue = ew_GetFileUploadUrl($this->image_02, $this->image_02->Upload->DbValue); // Add prefix/suffix
				$this->image_02->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->image_02->HrefValue = ew_FullUrl($this->image_02->HrefValue, "href");
			} else {
				$this->image_02->HrefValue = "";
			}
			$this->image_02->HrefValue2 = $this->image_02->UploadPath . $this->image_02->Upload->DbValue;
			$this->image_02->TooltipValue = "";
			if ($this->image_02->UseColorbox) {
				if (ew_Empty($this->image_02->TooltipValue))
					$this->image_02->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->image_02->LinkAttrs["data-rel"] = "home_about_us_x_image_02";
				ew_AppendClass($this->image_02->LinkAttrs["class"], "ewLightbox");
			}

			// image_03
			$this->image_03->LinkCustomAttributes = "";
			$this->image_03->UploadPath = 'uploads/pages';
			if (!ew_Empty($this->image_03->Upload->DbValue)) {
				$this->image_03->HrefValue = ew_GetFileUploadUrl($this->image_03, $this->image_03->Upload->DbValue); // Add prefix/suffix
				$this->image_03->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->image_03->HrefValue = ew_FullUrl($this->image_03->HrefValue, "href");
			} else {
				$this->image_03->HrefValue = "";
			}
			$this->image_03->HrefValue2 = $this->image_03->UploadPath . $this->image_03->Upload->DbValue;
			$this->image_03->TooltipValue = "";
			if ($this->image_03->UseColorbox) {
				if (ew_Empty($this->image_03->TooltipValue))
					$this->image_03->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->image_03->LinkAttrs["data-rel"] = "home_about_us_x_image_03";
				ew_AppendClass($this->image_03->LinkAttrs["class"], "ewLightbox");
			}
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// title
			$this->title->EditAttrs["class"] = "form-control";
			$this->title->EditCustomAttributes = "";
			$this->title->EditValue = ew_HtmlEncode($this->title->CurrentValue);
			$this->title->PlaceHolder = ew_RemoveHtml($this->title->FldCaption());

			// title_ar
			$this->title_ar->EditAttrs["class"] = "form-control";
			$this->title_ar->EditCustomAttributes = "";
			$this->title_ar->EditValue = ew_HtmlEncode($this->title_ar->CurrentValue);
			$this->title_ar->PlaceHolder = ew_RemoveHtml($this->title_ar->FldCaption());

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

			// image_01
			$this->image_01->EditAttrs["class"] = "form-control";
			$this->image_01->EditCustomAttributes = "";
			$this->image_01->UploadPath = 'uploads/pages';
			if (!ew_Empty($this->image_01->Upload->DbValue)) {
				$this->image_01->ImageWidth = 100;
				$this->image_01->ImageHeight = 0;
				$this->image_01->ImageAlt = $this->image_01->FldAlt();
				$this->image_01->EditValue = $this->image_01->Upload->DbValue;
			} else {
				$this->image_01->EditValue = "";
			}
			if (!ew_Empty($this->image_01->CurrentValue))
					$this->image_01->Upload->FileName = $this->image_01->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->image_01);

			// image_02
			$this->image_02->EditAttrs["class"] = "form-control";
			$this->image_02->EditCustomAttributes = "";
			$this->image_02->UploadPath = 'uploads/pages';
			if (!ew_Empty($this->image_02->Upload->DbValue)) {
				$this->image_02->ImageWidth = 100;
				$this->image_02->ImageHeight = 0;
				$this->image_02->ImageAlt = $this->image_02->FldAlt();
				$this->image_02->EditValue = $this->image_02->Upload->DbValue;
			} else {
				$this->image_02->EditValue = "";
			}
			if (!ew_Empty($this->image_02->CurrentValue))
					$this->image_02->Upload->FileName = $this->image_02->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->image_02);

			// image_03
			$this->image_03->EditAttrs["class"] = "form-control";
			$this->image_03->EditCustomAttributes = "";
			$this->image_03->UploadPath = 'uploads/pages';
			if (!ew_Empty($this->image_03->Upload->DbValue)) {
				$this->image_03->ImageWidth = 100;
				$this->image_03->ImageHeight = 0;
				$this->image_03->ImageAlt = $this->image_03->FldAlt();
				$this->image_03->EditValue = $this->image_03->Upload->DbValue;
			} else {
				$this->image_03->EditValue = "";
			}
			if (!ew_Empty($this->image_03->CurrentValue))
					$this->image_03->Upload->FileName = $this->image_03->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->image_03);

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";

			// title_ar
			$this->title_ar->LinkCustomAttributes = "";
			$this->title_ar->HrefValue = "";

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";

			// description_ar
			$this->description_ar->LinkCustomAttributes = "";
			$this->description_ar->HrefValue = "";

			// image_01
			$this->image_01->LinkCustomAttributes = "";
			$this->image_01->UploadPath = 'uploads/pages';
			if (!ew_Empty($this->image_01->Upload->DbValue)) {
				$this->image_01->HrefValue = ew_GetFileUploadUrl($this->image_01, $this->image_01->Upload->DbValue); // Add prefix/suffix
				$this->image_01->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->image_01->HrefValue = ew_FullUrl($this->image_01->HrefValue, "href");
			} else {
				$this->image_01->HrefValue = "";
			}
			$this->image_01->HrefValue2 = $this->image_01->UploadPath . $this->image_01->Upload->DbValue;

			// image_02
			$this->image_02->LinkCustomAttributes = "";
			$this->image_02->UploadPath = 'uploads/pages';
			if (!ew_Empty($this->image_02->Upload->DbValue)) {
				$this->image_02->HrefValue = ew_GetFileUploadUrl($this->image_02, $this->image_02->Upload->DbValue); // Add prefix/suffix
				$this->image_02->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->image_02->HrefValue = ew_FullUrl($this->image_02->HrefValue, "href");
			} else {
				$this->image_02->HrefValue = "";
			}
			$this->image_02->HrefValue2 = $this->image_02->UploadPath . $this->image_02->Upload->DbValue;

			// image_03
			$this->image_03->LinkCustomAttributes = "";
			$this->image_03->UploadPath = 'uploads/pages';
			if (!ew_Empty($this->image_03->Upload->DbValue)) {
				$this->image_03->HrefValue = ew_GetFileUploadUrl($this->image_03, $this->image_03->Upload->DbValue); // Add prefix/suffix
				$this->image_03->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->image_03->HrefValue = ew_FullUrl($this->image_03->HrefValue, "href");
			} else {
				$this->image_03->HrefValue = "";
			}
			$this->image_03->HrefValue2 = $this->image_03->UploadPath . $this->image_03->Upload->DbValue;
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
			$this->image_01->OldUploadPath = 'uploads/pages';
			$this->image_01->UploadPath = $this->image_01->OldUploadPath;
			$this->image_02->OldUploadPath = 'uploads/pages';
			$this->image_02->UploadPath = $this->image_02->OldUploadPath;
			$this->image_03->OldUploadPath = 'uploads/pages';
			$this->image_03->UploadPath = $this->image_03->OldUploadPath;
			$rsnew = array();

			// title
			$this->title->SetDbValueDef($rsnew, $this->title->CurrentValue, NULL, $this->title->ReadOnly);

			// title_ar
			$this->title_ar->SetDbValueDef($rsnew, $this->title_ar->CurrentValue, NULL, $this->title_ar->ReadOnly);

			// description
			$this->description->SetDbValueDef($rsnew, $this->description->CurrentValue, NULL, $this->description->ReadOnly);

			// description_ar
			$this->description_ar->SetDbValueDef($rsnew, $this->description_ar->CurrentValue, NULL, $this->description_ar->ReadOnly);

			// image_01
			if ($this->image_01->Visible && !$this->image_01->ReadOnly && !$this->image_01->Upload->KeepFile) {
				$this->image_01->Upload->DbValue = $rsold['image_01']; // Get original value
				if ($this->image_01->Upload->FileName == "") {
					$rsnew['image_01'] = NULL;
				} else {
					$rsnew['image_01'] = $this->image_01->Upload->FileName;
				}
			}

			// image_02
			if ($this->image_02->Visible && !$this->image_02->ReadOnly && !$this->image_02->Upload->KeepFile) {
				$this->image_02->Upload->DbValue = $rsold['image_02']; // Get original value
				if ($this->image_02->Upload->FileName == "") {
					$rsnew['image_02'] = NULL;
				} else {
					$rsnew['image_02'] = $this->image_02->Upload->FileName;
				}
			}

			// image_03
			if ($this->image_03->Visible && !$this->image_03->ReadOnly && !$this->image_03->Upload->KeepFile) {
				$this->image_03->Upload->DbValue = $rsold['image_03']; // Get original value
				if ($this->image_03->Upload->FileName == "") {
					$rsnew['image_03'] = NULL;
				} else {
					$rsnew['image_03'] = $this->image_03->Upload->FileName;
				}
			}
			if ($this->image_01->Visible && !$this->image_01->Upload->KeepFile) {
				$this->image_01->UploadPath = 'uploads/pages';
				$OldFiles = ew_Empty($this->image_01->Upload->DbValue) ? array() : array($this->image_01->Upload->DbValue);
				if (!ew_Empty($this->image_01->Upload->FileName)) {
					$NewFiles = array($this->image_01->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->image_01->Upload->Index < 0) ? $this->image_01->FldVar : substr($this->image_01->FldVar, 0, 1) . $this->image_01->Upload->Index . substr($this->image_01->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->image_01->TblVar) . $file)) {
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
								$file1 = ew_UploadFileNameEx($this->image_01->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->image_01->TblVar) . $file1) || file_exists($this->image_01->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->image_01->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->image_01->TblVar) . $file, ew_UploadTempPath($fldvar, $this->image_01->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->image_01->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->image_01->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->image_01->SetDbValueDef($rsnew, $this->image_01->Upload->FileName, NULL, $this->image_01->ReadOnly);
				}
			}
			if ($this->image_02->Visible && !$this->image_02->Upload->KeepFile) {
				$this->image_02->UploadPath = 'uploads/pages';
				$OldFiles = ew_Empty($this->image_02->Upload->DbValue) ? array() : array($this->image_02->Upload->DbValue);
				if (!ew_Empty($this->image_02->Upload->FileName)) {
					$NewFiles = array($this->image_02->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->image_02->Upload->Index < 0) ? $this->image_02->FldVar : substr($this->image_02->FldVar, 0, 1) . $this->image_02->Upload->Index . substr($this->image_02->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->image_02->TblVar) . $file)) {
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
								$file1 = ew_UploadFileNameEx($this->image_02->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->image_02->TblVar) . $file1) || file_exists($this->image_02->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->image_02->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->image_02->TblVar) . $file, ew_UploadTempPath($fldvar, $this->image_02->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->image_02->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->image_02->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->image_02->SetDbValueDef($rsnew, $this->image_02->Upload->FileName, NULL, $this->image_02->ReadOnly);
				}
			}
			if ($this->image_03->Visible && !$this->image_03->Upload->KeepFile) {
				$this->image_03->UploadPath = 'uploads/pages';
				$OldFiles = ew_Empty($this->image_03->Upload->DbValue) ? array() : array($this->image_03->Upload->DbValue);
				if (!ew_Empty($this->image_03->Upload->FileName)) {
					$NewFiles = array($this->image_03->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->image_03->Upload->Index < 0) ? $this->image_03->FldVar : substr($this->image_03->FldVar, 0, 1) . $this->image_03->Upload->Index . substr($this->image_03->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->image_03->TblVar) . $file)) {
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
								$file1 = ew_UploadFileNameEx($this->image_03->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->image_03->TblVar) . $file1) || file_exists($this->image_03->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->image_03->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->image_03->TblVar) . $file, ew_UploadTempPath($fldvar, $this->image_03->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->image_03->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->image_03->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->image_03->SetDbValueDef($rsnew, $this->image_03->Upload->FileName, NULL, $this->image_03->ReadOnly);
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
					if ($this->image_01->Visible && !$this->image_01->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->image_01->Upload->DbValue) ? array() : array($this->image_01->Upload->DbValue);
						if (!ew_Empty($this->image_01->Upload->FileName)) {
							$NewFiles = array($this->image_01->Upload->FileName);
							$NewFiles2 = array($rsnew['image_01']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->image_01->Upload->Index < 0) ? $this->image_01->FldVar : substr($this->image_01->FldVar, 0, 1) . $this->image_01->Upload->Index . substr($this->image_01->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->image_01->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->image_01->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
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
								@unlink($this->image_01->OldPhysicalUploadPath() . $OldFiles[$i]);
						}
					}
					if ($this->image_02->Visible && !$this->image_02->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->image_02->Upload->DbValue) ? array() : array($this->image_02->Upload->DbValue);
						if (!ew_Empty($this->image_02->Upload->FileName)) {
							$NewFiles = array($this->image_02->Upload->FileName);
							$NewFiles2 = array($rsnew['image_02']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->image_02->Upload->Index < 0) ? $this->image_02->FldVar : substr($this->image_02->FldVar, 0, 1) . $this->image_02->Upload->Index . substr($this->image_02->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->image_02->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->image_02->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
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
								@unlink($this->image_02->OldPhysicalUploadPath() . $OldFiles[$i]);
						}
					}
					if ($this->image_03->Visible && !$this->image_03->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->image_03->Upload->DbValue) ? array() : array($this->image_03->Upload->DbValue);
						if (!ew_Empty($this->image_03->Upload->FileName)) {
							$NewFiles = array($this->image_03->Upload->FileName);
							$NewFiles2 = array($rsnew['image_03']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->image_03->Upload->Index < 0) ? $this->image_03->FldVar : substr($this->image_03->FldVar, 0, 1) . $this->image_03->Upload->Index . substr($this->image_03->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->image_03->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->image_03->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
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
								@unlink($this->image_03->OldPhysicalUploadPath() . $OldFiles[$i]);
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

		// image_01
		ew_CleanUploadTempPath($this->image_01, $this->image_01->Upload->Index);

		// image_02
		ew_CleanUploadTempPath($this->image_02, $this->image_02->Upload->Index);

		// image_03
		ew_CleanUploadTempPath($this->image_03, $this->image_03->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("home_about_uslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($home_about_us_edit)) $home_about_us_edit = new chome_about_us_edit();

// Page init
$home_about_us_edit->Page_Init();

// Page main
$home_about_us_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$home_about_us_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fhome_about_usedit = new ew_Form("fhome_about_usedit", "edit");

// Validate form
fhome_about_usedit.Validate = function() {
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
fhome_about_usedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fhome_about_usedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Multi-Page
fhome_about_usedit.MultiPage = new ew_MultiPage("fhome_about_usedit");

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $home_about_us_edit->ShowPageHeader(); ?>
<?php
$home_about_us_edit->ShowMessage();
?>
<form name="fhome_about_usedit" id="fhome_about_usedit" class="<?php echo $home_about_us_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($home_about_us_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $home_about_us_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="home_about_us">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($home_about_us_edit->IsModal) ?>">
<div class="ewMultiPage"><!-- multi-page -->
<div class="nav-tabs-custom" id="home_about_us_edit"><!-- multi-page .nav-tabs-custom -->
	<ul class="nav<?php echo $home_about_us_edit->MultiPages->NavStyle() ?>">
		<li<?php echo $home_about_us_edit->MultiPages->TabStyle("1") ?>><a href="#tab_home_about_us1" data-toggle="tab"><?php echo $home_about_us->PageCaption(1) ?></a></li>
		<li<?php echo $home_about_us_edit->MultiPages->TabStyle("2") ?>><a href="#tab_home_about_us2" data-toggle="tab"><?php echo $home_about_us->PageCaption(2) ?></a></li>
	</ul>
	<div class="tab-content"><!-- multi-page .nav-tabs-custom .tab-content -->
		<div class="tab-pane<?php echo $home_about_us_edit->MultiPages->PageStyle("1") ?>" id="tab_home_about_us1"><!-- multi-page .tab-pane -->
<div class="ewEditDiv"><!-- page* -->
<?php if ($home_about_us->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_home_about_us_id" class="<?php echo $home_about_us_edit->LeftColumnClass ?>"><?php echo $home_about_us->id->FldCaption() ?></label>
		<div class="<?php echo $home_about_us_edit->RightColumnClass ?>"><div<?php echo $home_about_us->id->CellAttributes() ?>>
<span id="el_home_about_us_id">
<span<?php echo $home_about_us->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $home_about_us->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="home_about_us" data-field="x_id" data-page="1" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($home_about_us->id->CurrentValue) ?>">
<?php echo $home_about_us->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about_us->title->Visible) { // title ?>
	<div id="r_title" class="form-group">
		<label id="elh_home_about_us_title" for="x_title" class="<?php echo $home_about_us_edit->LeftColumnClass ?>"><?php echo $home_about_us->title->FldCaption() ?></label>
		<div class="<?php echo $home_about_us_edit->RightColumnClass ?>"><div<?php echo $home_about_us->title->CellAttributes() ?>>
<span id="el_home_about_us_title">
<input type="text" data-table="home_about_us" data-field="x_title" data-page="1" name="x_title" id="x_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($home_about_us->title->getPlaceHolder()) ?>" value="<?php echo $home_about_us->title->EditValue ?>"<?php echo $home_about_us->title->EditAttributes() ?>>
</span>
<?php echo $home_about_us->title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about_us->title_ar->Visible) { // title_ar ?>
	<div id="r_title_ar" class="form-group">
		<label id="elh_home_about_us_title_ar" for="x_title_ar" class="<?php echo $home_about_us_edit->LeftColumnClass ?>"><?php echo $home_about_us->title_ar->FldCaption() ?></label>
		<div class="<?php echo $home_about_us_edit->RightColumnClass ?>"><div<?php echo $home_about_us->title_ar->CellAttributes() ?>>
<span id="el_home_about_us_title_ar">
<input type="text" data-table="home_about_us" data-field="x_title_ar" data-page="1" name="x_title_ar" id="x_title_ar" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($home_about_us->title_ar->getPlaceHolder()) ?>" value="<?php echo $home_about_us->title_ar->EditValue ?>"<?php echo $home_about_us->title_ar->EditAttributes() ?>>
</span>
<?php echo $home_about_us->title_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about_us->description->Visible) { // description ?>
	<div id="r_description" class="form-group">
		<label id="elh_home_about_us_description" class="<?php echo $home_about_us_edit->LeftColumnClass ?>"><?php echo $home_about_us->description->FldCaption() ?></label>
		<div class="<?php echo $home_about_us_edit->RightColumnClass ?>"><div<?php echo $home_about_us->description->CellAttributes() ?>>
<span id="el_home_about_us_description">
<?php ew_AppendClass($home_about_us->description->EditAttrs["class"], "editor"); ?>
<textarea data-table="home_about_us" data-field="x_description" data-page="1" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($home_about_us->description->getPlaceHolder()) ?>"<?php echo $home_about_us->description->EditAttributes() ?>><?php echo $home_about_us->description->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fhome_about_usedit", "x_description", 35, 4, <?php echo ($home_about_us->description->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $home_about_us->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about_us->description_ar->Visible) { // description_ar ?>
	<div id="r_description_ar" class="form-group">
		<label id="elh_home_about_us_description_ar" class="<?php echo $home_about_us_edit->LeftColumnClass ?>"><?php echo $home_about_us->description_ar->FldCaption() ?></label>
		<div class="<?php echo $home_about_us_edit->RightColumnClass ?>"><div<?php echo $home_about_us->description_ar->CellAttributes() ?>>
<span id="el_home_about_us_description_ar">
<?php ew_AppendClass($home_about_us->description_ar->EditAttrs["class"], "editor"); ?>
<textarea data-table="home_about_us" data-field="x_description_ar" data-page="1" name="x_description_ar" id="x_description_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($home_about_us->description_ar->getPlaceHolder()) ?>"<?php echo $home_about_us->description_ar->EditAttributes() ?>><?php echo $home_about_us->description_ar->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fhome_about_usedit", "x_description_ar", 35, 4, <?php echo ($home_about_us->description_ar->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $home_about_us->description_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
		<div class="tab-pane<?php echo $home_about_us_edit->MultiPages->PageStyle("2") ?>" id="tab_home_about_us2"><!-- multi-page .tab-pane -->
<div class="ewEditDiv"><!-- page* -->
<?php if ($home_about_us->image_01->Visible) { // image_01 ?>
	<div id="r_image_01" class="form-group">
		<label id="elh_home_about_us_image_01" class="<?php echo $home_about_us_edit->LeftColumnClass ?>"><?php echo $home_about_us->image_01->FldCaption() ?></label>
		<div class="<?php echo $home_about_us_edit->RightColumnClass ?>"><div<?php echo $home_about_us->image_01->CellAttributes() ?>>
<span id="el_home_about_us_image_01">
<div id="fd_x_image_01">
<span title="<?php echo $home_about_us->image_01->FldTitle() ? $home_about_us->image_01->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($home_about_us->image_01->ReadOnly || $home_about_us->image_01->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="home_about_us" data-field="x_image_01" data-page="2" name="x_image_01" id="x_image_01"<?php echo $home_about_us->image_01->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_image_01" id= "fn_x_image_01" value="<?php echo $home_about_us->image_01->Upload->FileName ?>">
<?php if (@$_POST["fa_x_image_01"] == "0") { ?>
<input type="hidden" name="fa_x_image_01" id= "fa_x_image_01" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_image_01" id= "fa_x_image_01" value="1">
<?php } ?>
<input type="hidden" name="fs_x_image_01" id= "fs_x_image_01" value="255">
<input type="hidden" name="fx_x_image_01" id= "fx_x_image_01" value="<?php echo $home_about_us->image_01->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_image_01" id= "fm_x_image_01" value="<?php echo $home_about_us->image_01->UploadMaxFileSize ?>">
</div>
<table id="ft_x_image_01" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $home_about_us->image_01->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about_us->image_02->Visible) { // image_02 ?>
	<div id="r_image_02" class="form-group">
		<label id="elh_home_about_us_image_02" class="<?php echo $home_about_us_edit->LeftColumnClass ?>"><?php echo $home_about_us->image_02->FldCaption() ?></label>
		<div class="<?php echo $home_about_us_edit->RightColumnClass ?>"><div<?php echo $home_about_us->image_02->CellAttributes() ?>>
<span id="el_home_about_us_image_02">
<div id="fd_x_image_02">
<span title="<?php echo $home_about_us->image_02->FldTitle() ? $home_about_us->image_02->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($home_about_us->image_02->ReadOnly || $home_about_us->image_02->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="home_about_us" data-field="x_image_02" data-page="2" name="x_image_02" id="x_image_02"<?php echo $home_about_us->image_02->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_image_02" id= "fn_x_image_02" value="<?php echo $home_about_us->image_02->Upload->FileName ?>">
<?php if (@$_POST["fa_x_image_02"] == "0") { ?>
<input type="hidden" name="fa_x_image_02" id= "fa_x_image_02" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_image_02" id= "fa_x_image_02" value="1">
<?php } ?>
<input type="hidden" name="fs_x_image_02" id= "fs_x_image_02" value="255">
<input type="hidden" name="fx_x_image_02" id= "fx_x_image_02" value="<?php echo $home_about_us->image_02->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_image_02" id= "fm_x_image_02" value="<?php echo $home_about_us->image_02->UploadMaxFileSize ?>">
</div>
<table id="ft_x_image_02" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $home_about_us->image_02->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($home_about_us->image_03->Visible) { // image_03 ?>
	<div id="r_image_03" class="form-group">
		<label id="elh_home_about_us_image_03" class="<?php echo $home_about_us_edit->LeftColumnClass ?>"><?php echo $home_about_us->image_03->FldCaption() ?></label>
		<div class="<?php echo $home_about_us_edit->RightColumnClass ?>"><div<?php echo $home_about_us->image_03->CellAttributes() ?>>
<span id="el_home_about_us_image_03">
<div id="fd_x_image_03">
<span title="<?php echo $home_about_us->image_03->FldTitle() ? $home_about_us->image_03->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($home_about_us->image_03->ReadOnly || $home_about_us->image_03->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="home_about_us" data-field="x_image_03" data-page="2" name="x_image_03" id="x_image_03"<?php echo $home_about_us->image_03->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_image_03" id= "fn_x_image_03" value="<?php echo $home_about_us->image_03->Upload->FileName ?>">
<?php if (@$_POST["fa_x_image_03"] == "0") { ?>
<input type="hidden" name="fa_x_image_03" id= "fa_x_image_03" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_image_03" id= "fa_x_image_03" value="1">
<?php } ?>
<input type="hidden" name="fs_x_image_03" id= "fs_x_image_03" value="255">
<input type="hidden" name="fx_x_image_03" id= "fx_x_image_03" value="<?php echo $home_about_us->image_03->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_image_03" id= "fm_x_image_03" value="<?php echo $home_about_us->image_03->UploadMaxFileSize ?>">
</div>
<table id="ft_x_image_03" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $home_about_us->image_03->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
	</div><!-- /multi-page .nav-tabs-custom .tab-content -->
</div><!-- /multi-page .nav-tabs-custom -->
</div><!-- /multi-page -->
<?php if (!$home_about_us_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $home_about_us_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $home_about_us_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fhome_about_usedit.Init();
</script>
<?php
$home_about_us_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$home_about_us_edit->Page_Terminate();
?>
