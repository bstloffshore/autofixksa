<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "campaign_masterinfo.php" ?>
<?php include_once "cms_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$campaign_master_add = NULL; // Initialize page object first

class ccampaign_master_add extends ccampaign_master {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{8281128E-C7BB-40DA-A1AE-8695DB7283AC}';

	// Table name
	var $TableName = 'campaign_master';

	// Page object name
	var $PageObjName = 'campaign_master_add';

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

		// Table object (campaign_master)
		if (!isset($GLOBALS["campaign_master"]) || get_class($GLOBALS["campaign_master"]) == "ccampaign_master") {
			$GLOBALS["campaign_master"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["campaign_master"];
		}

		// Table object (cms_users)
		if (!isset($GLOBALS['cms_users'])) $GLOBALS['cms_users'] = new ccms_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'campaign_master', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("campaign_masterlist.php"));
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
		$this->title->SetVisibility();
		$this->title_ar->SetVisibility();
		$this->campaignSlug->SetVisibility();
		$this->dateCreated->SetVisibility();
		$this->active->SetVisibility();

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
		global $EW_EXPORT, $campaign_master;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($campaign_master);
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
					if ($pageName == "campaign_masterview.php")
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["campaignID"] != "") {
				$this->campaignID->setQueryStringValue($_GET["campaignID"]);
				$this->setKey("campaignID", $this->campaignID->CurrentValue); // Set up key
			} else {
				$this->setKey("campaignID", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("campaign_masterlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "campaign_masterlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "campaign_masterview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->campaignID->CurrentValue = NULL;
		$this->campaignID->OldValue = $this->campaignID->CurrentValue;
		$this->title->CurrentValue = NULL;
		$this->title->OldValue = $this->title->CurrentValue;
		$this->title_ar->CurrentValue = NULL;
		$this->title_ar->OldValue = $this->title_ar->CurrentValue;
		$this->campaignSlug->CurrentValue = NULL;
		$this->campaignSlug->OldValue = $this->campaignSlug->CurrentValue;
		$this->dateCreated->CurrentValue = NULL;
		$this->dateCreated->OldValue = $this->dateCreated->CurrentValue;
		$this->active->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->title->FldIsDetailKey) {
			$this->title->setFormValue($objForm->GetValue("x_title"));
		}
		if (!$this->title_ar->FldIsDetailKey) {
			$this->title_ar->setFormValue($objForm->GetValue("x_title_ar"));
		}
		if (!$this->campaignSlug->FldIsDetailKey) {
			$this->campaignSlug->setFormValue($objForm->GetValue("x_campaignSlug"));
		}
		if (!$this->dateCreated->FldIsDetailKey) {
			$this->dateCreated->setFormValue($objForm->GetValue("x_dateCreated"));
			$this->dateCreated->CurrentValue = ew_UnFormatDateTime($this->dateCreated->CurrentValue, 7);
		}
		if (!$this->active->FldIsDetailKey) {
			$this->active->setFormValue($objForm->GetValue("x_active"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->title->CurrentValue = $this->title->FormValue;
		$this->title_ar->CurrentValue = $this->title_ar->FormValue;
		$this->campaignSlug->CurrentValue = $this->campaignSlug->FormValue;
		$this->dateCreated->CurrentValue = $this->dateCreated->FormValue;
		$this->dateCreated->CurrentValue = ew_UnFormatDateTime($this->dateCreated->CurrentValue, 7);
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
		$this->campaignID->setDbValue($row['campaignID']);
		$this->title->setDbValue($row['title']);
		$this->title_ar->setDbValue($row['title_ar']);
		$this->campaignSlug->setDbValue($row['campaignSlug']);
		$this->dateCreated->setDbValue($row['dateCreated']);
		$this->active->setDbValue($row['active']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['campaignID'] = $this->campaignID->CurrentValue;
		$row['title'] = $this->title->CurrentValue;
		$row['title_ar'] = $this->title_ar->CurrentValue;
		$row['campaignSlug'] = $this->campaignSlug->CurrentValue;
		$row['dateCreated'] = $this->dateCreated->CurrentValue;
		$row['active'] = $this->active->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->campaignID->DbValue = $row['campaignID'];
		$this->title->DbValue = $row['title'];
		$this->title_ar->DbValue = $row['title_ar'];
		$this->campaignSlug->DbValue = $row['campaignSlug'];
		$this->dateCreated->DbValue = $row['dateCreated'];
		$this->active->DbValue = $row['active'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("campaignID")) <> "")
			$this->campaignID->CurrentValue = $this->getKey("campaignID"); // campaignID
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
		// campaignID
		// title
		// title_ar
		// campaignSlug
		// dateCreated
		// active

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// campaignID
		$this->campaignID->ViewValue = $this->campaignID->CurrentValue;
		$this->campaignID->ViewCustomAttributes = "";

		// title
		$this->title->ViewValue = $this->title->CurrentValue;
		$this->title->ViewCustomAttributes = "";

		// title_ar
		$this->title_ar->ViewValue = $this->title_ar->CurrentValue;
		$this->title_ar->ViewCustomAttributes = "";

		// campaignSlug
		$this->campaignSlug->ViewValue = $this->campaignSlug->CurrentValue;
		$this->campaignSlug->ViewCustomAttributes = "";

		// dateCreated
		$this->dateCreated->ViewValue = $this->dateCreated->CurrentValue;
		$this->dateCreated->ViewValue = ew_FormatDateTime($this->dateCreated->ViewValue, 7);
		$this->dateCreated->ViewCustomAttributes = "";

		// active
		if (strval($this->active->CurrentValue) <> "") {
			$this->active->ViewValue = $this->active->OptionCaption($this->active->CurrentValue);
		} else {
			$this->active->ViewValue = NULL;
		}
		$this->active->ViewCustomAttributes = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";
			$this->title->TooltipValue = "";

			// title_ar
			$this->title_ar->LinkCustomAttributes = "";
			$this->title_ar->HrefValue = "";
			$this->title_ar->TooltipValue = "";

			// campaignSlug
			$this->campaignSlug->LinkCustomAttributes = "";
			$this->campaignSlug->HrefValue = "";
			$this->campaignSlug->TooltipValue = "";

			// dateCreated
			$this->dateCreated->LinkCustomAttributes = "";
			$this->dateCreated->HrefValue = "";
			$this->dateCreated->TooltipValue = "";

			// active
			$this->active->LinkCustomAttributes = "";
			$this->active->HrefValue = "";
			$this->active->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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

			// campaignSlug
			$this->campaignSlug->EditAttrs["class"] = "form-control";
			$this->campaignSlug->EditCustomAttributes = "";
			$this->campaignSlug->EditValue = ew_HtmlEncode($this->campaignSlug->CurrentValue);
			$this->campaignSlug->PlaceHolder = ew_RemoveHtml($this->campaignSlug->FldCaption());

			// dateCreated
			$this->dateCreated->EditAttrs["class"] = "form-control";
			$this->dateCreated->EditCustomAttributes = "";
			$this->dateCreated->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->dateCreated->CurrentValue, 7));
			$this->dateCreated->PlaceHolder = ew_RemoveHtml($this->dateCreated->FldCaption());

			// active
			$this->active->EditAttrs["class"] = "form-control";
			$this->active->EditCustomAttributes = "";
			$this->active->EditValue = $this->active->Options(TRUE);

			// Add refer script
			// title

			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";

			// title_ar
			$this->title_ar->LinkCustomAttributes = "";
			$this->title_ar->HrefValue = "";

			// campaignSlug
			$this->campaignSlug->LinkCustomAttributes = "";
			$this->campaignSlug->HrefValue = "";

			// dateCreated
			$this->dateCreated->LinkCustomAttributes = "";
			$this->dateCreated->HrefValue = "";

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
		if (!ew_CheckEuroDate($this->dateCreated->FormValue)) {
			ew_AddMessage($gsFormError, $this->dateCreated->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// title
		$this->title->SetDbValueDef($rsnew, $this->title->CurrentValue, NULL, FALSE);

		// title_ar
		$this->title_ar->SetDbValueDef($rsnew, $this->title_ar->CurrentValue, NULL, FALSE);

		// campaignSlug
		$this->campaignSlug->SetDbValueDef($rsnew, $this->campaignSlug->CurrentValue, NULL, FALSE);

		// dateCreated
		$this->dateCreated->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->dateCreated->CurrentValue, 7), NULL, FALSE);

		// active
		$this->active->SetDbValueDef($rsnew, $this->active->CurrentValue, NULL, strval($this->active->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("campaign_masterlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($campaign_master_add)) $campaign_master_add = new ccampaign_master_add();

// Page init
$campaign_master_add->Page_Init();

// Page main
$campaign_master_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$campaign_master_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcampaign_masteradd = new ew_Form("fcampaign_masteradd", "add");

// Validate form
fcampaign_masteradd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_dateCreated");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($campaign_master->dateCreated->FldErrMsg()) ?>");

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
fcampaign_masteradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcampaign_masteradd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcampaign_masteradd.Lists["x_active"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcampaign_masteradd.Lists["x_active"].Options = <?php echo json_encode($campaign_master_add->active->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $campaign_master_add->ShowPageHeader(); ?>
<?php
$campaign_master_add->ShowMessage();
?>
<form name="fcampaign_masteradd" id="fcampaign_masteradd" class="<?php echo $campaign_master_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($campaign_master_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $campaign_master_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="campaign_master">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($campaign_master_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($campaign_master->title->Visible) { // title ?>
	<div id="r_title" class="form-group">
		<label id="elh_campaign_master_title" for="x_title" class="<?php echo $campaign_master_add->LeftColumnClass ?>"><?php echo $campaign_master->title->FldCaption() ?></label>
		<div class="<?php echo $campaign_master_add->RightColumnClass ?>"><div<?php echo $campaign_master->title->CellAttributes() ?>>
<span id="el_campaign_master_title">
<input type="text" data-table="campaign_master" data-field="x_title" name="x_title" id="x_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_master->title->getPlaceHolder()) ?>" value="<?php echo $campaign_master->title->EditValue ?>"<?php echo $campaign_master->title->EditAttributes() ?>>
</span>
<?php echo $campaign_master->title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_master->title_ar->Visible) { // title_ar ?>
	<div id="r_title_ar" class="form-group">
		<label id="elh_campaign_master_title_ar" for="x_title_ar" class="<?php echo $campaign_master_add->LeftColumnClass ?>"><?php echo $campaign_master->title_ar->FldCaption() ?></label>
		<div class="<?php echo $campaign_master_add->RightColumnClass ?>"><div<?php echo $campaign_master->title_ar->CellAttributes() ?>>
<span id="el_campaign_master_title_ar">
<input type="text" data-table="campaign_master" data-field="x_title_ar" name="x_title_ar" id="x_title_ar" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_master->title_ar->getPlaceHolder()) ?>" value="<?php echo $campaign_master->title_ar->EditValue ?>"<?php echo $campaign_master->title_ar->EditAttributes() ?>>
</span>
<?php echo $campaign_master->title_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_master->campaignSlug->Visible) { // campaignSlug ?>
	<div id="r_campaignSlug" class="form-group">
		<label id="elh_campaign_master_campaignSlug" for="x_campaignSlug" class="<?php echo $campaign_master_add->LeftColumnClass ?>"><?php echo $campaign_master->campaignSlug->FldCaption() ?></label>
		<div class="<?php echo $campaign_master_add->RightColumnClass ?>"><div<?php echo $campaign_master->campaignSlug->CellAttributes() ?>>
<span id="el_campaign_master_campaignSlug">
<input type="text" data-table="campaign_master" data-field="x_campaignSlug" name="x_campaignSlug" id="x_campaignSlug" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_master->campaignSlug->getPlaceHolder()) ?>" value="<?php echo $campaign_master->campaignSlug->EditValue ?>"<?php echo $campaign_master->campaignSlug->EditAttributes() ?>>
</span>
<?php echo $campaign_master->campaignSlug->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_master->dateCreated->Visible) { // dateCreated ?>
	<div id="r_dateCreated" class="form-group">
		<label id="elh_campaign_master_dateCreated" for="x_dateCreated" class="<?php echo $campaign_master_add->LeftColumnClass ?>"><?php echo $campaign_master->dateCreated->FldCaption() ?></label>
		<div class="<?php echo $campaign_master_add->RightColumnClass ?>"><div<?php echo $campaign_master->dateCreated->CellAttributes() ?>>
<span id="el_campaign_master_dateCreated">
<input type="text" data-table="campaign_master" data-field="x_dateCreated" data-format="7" name="x_dateCreated" id="x_dateCreated" placeholder="<?php echo ew_HtmlEncode($campaign_master->dateCreated->getPlaceHolder()) ?>" value="<?php echo $campaign_master->dateCreated->EditValue ?>"<?php echo $campaign_master->dateCreated->EditAttributes() ?>>
<?php if (!$campaign_master->dateCreated->ReadOnly && !$campaign_master->dateCreated->Disabled && !isset($campaign_master->dateCreated->EditAttrs["readonly"]) && !isset($campaign_master->dateCreated->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fcampaign_masteradd", "x_dateCreated", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php echo $campaign_master->dateCreated->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_master->active->Visible) { // active ?>
	<div id="r_active" class="form-group">
		<label id="elh_campaign_master_active" for="x_active" class="<?php echo $campaign_master_add->LeftColumnClass ?>"><?php echo $campaign_master->active->FldCaption() ?></label>
		<div class="<?php echo $campaign_master_add->RightColumnClass ?>"><div<?php echo $campaign_master->active->CellAttributes() ?>>
<span id="el_campaign_master_active">
<select data-table="campaign_master" data-field="x_active" data-value-separator="<?php echo $campaign_master->active->DisplayValueSeparatorAttribute() ?>" id="x_active" name="x_active"<?php echo $campaign_master->active->EditAttributes() ?>>
<?php echo $campaign_master->active->SelectOptionListHtml("x_active") ?>
</select>
</span>
<?php echo $campaign_master->active->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$campaign_master_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $campaign_master_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $campaign_master_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcampaign_masteradd.Init();
</script>
<?php
$campaign_master_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$campaign_master_add->Page_Terminate();
?>