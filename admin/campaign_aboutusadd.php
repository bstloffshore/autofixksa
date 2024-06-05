<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "campaign_aboutusinfo.php" ?>
<?php include_once "cms_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$campaign_aboutus_add = NULL; // Initialize page object first

class ccampaign_aboutus_add extends ccampaign_aboutus {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{8281128E-C7BB-40DA-A1AE-8695DB7283AC}';

	// Table name
	var $TableName = 'campaign_aboutus';

	// Page object name
	var $PageObjName = 'campaign_aboutus_add';

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

		// Table object (campaign_aboutus)
		if (!isset($GLOBALS["campaign_aboutus"]) || get_class($GLOBALS["campaign_aboutus"]) == "ccampaign_aboutus") {
			$GLOBALS["campaign_aboutus"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["campaign_aboutus"];
		}

		// Table object (cms_users)
		if (!isset($GLOBALS['cms_users'])) $GLOBALS['cms_users'] = new ccms_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'campaign_aboutus', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("campaign_aboutuslist.php"));
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
		$this->sliderImage->SetVisibility();
		$this->sliderImage_ar->SetVisibility();
		$this->description->SetVisibility();
		$this->description_ar->SetVisibility();
		$this->section_01_title->SetVisibility();
		$this->section_01_title_ar->SetVisibility();
		$this->section_01_summary->SetVisibility();
		$this->section_01_summary_ar->SetVisibility();
		$this->section_01_icon->SetVisibility();
		$this->section_02_title->SetVisibility();
		$this->section_02_title_ar->SetVisibility();
		$this->section_02_summary->SetVisibility();
		$this->section_02_summary_ar->SetVisibility();
		$this->section_02_icon->SetVisibility();
		$this->section_03_title->SetVisibility();
		$this->section_03_title_ar->SetVisibility();
		$this->section_03_summary->SetVisibility();
		$this->section_03_summary_ar->SetVisibility();
		$this->section_03_icon->SetVisibility();
		$this->section_04_title->SetVisibility();
		$this->section_04_title_ar->SetVisibility();
		$this->section_04_summary->SetVisibility();
		$this->section_04_summary_ar->SetVisibility();
		$this->section_04_icon->SetVisibility();

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
		global $EW_EXPORT, $campaign_aboutus;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($campaign_aboutus);
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
					if ($pageName == "campaign_aboutusview.php")
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
	var $MultiPages; // Multi pages object

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
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
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
					$this->Page_Terminate("campaign_aboutuslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "campaign_aboutuslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "campaign_aboutusview.php")
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
		$this->sliderImage->Upload->Index = $objForm->Index;
		$this->sliderImage->Upload->UploadFile();
		$this->sliderImage->CurrentValue = $this->sliderImage->Upload->FileName;
		$this->sliderImage_ar->Upload->Index = $objForm->Index;
		$this->sliderImage_ar->Upload->UploadFile();
		$this->sliderImage_ar->CurrentValue = $this->sliderImage_ar->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->id->CurrentValue = NULL;
		$this->id->OldValue = $this->id->CurrentValue;
		$this->title->CurrentValue = NULL;
		$this->title->OldValue = $this->title->CurrentValue;
		$this->title_ar->CurrentValue = NULL;
		$this->title_ar->OldValue = $this->title_ar->CurrentValue;
		$this->sliderImage->Upload->DbValue = NULL;
		$this->sliderImage->OldValue = $this->sliderImage->Upload->DbValue;
		$this->sliderImage->CurrentValue = NULL; // Clear file related field
		$this->sliderImage_ar->Upload->DbValue = NULL;
		$this->sliderImage_ar->OldValue = $this->sliderImage_ar->Upload->DbValue;
		$this->sliderImage_ar->CurrentValue = NULL; // Clear file related field
		$this->description->CurrentValue = NULL;
		$this->description->OldValue = $this->description->CurrentValue;
		$this->description_ar->CurrentValue = NULL;
		$this->description_ar->OldValue = $this->description_ar->CurrentValue;
		$this->section_01_title->CurrentValue = NULL;
		$this->section_01_title->OldValue = $this->section_01_title->CurrentValue;
		$this->section_01_title_ar->CurrentValue = NULL;
		$this->section_01_title_ar->OldValue = $this->section_01_title_ar->CurrentValue;
		$this->section_01_summary->CurrentValue = NULL;
		$this->section_01_summary->OldValue = $this->section_01_summary->CurrentValue;
		$this->section_01_summary_ar->CurrentValue = NULL;
		$this->section_01_summary_ar->OldValue = $this->section_01_summary_ar->CurrentValue;
		$this->section_01_icon->CurrentValue = NULL;
		$this->section_01_icon->OldValue = $this->section_01_icon->CurrentValue;
		$this->section_02_title->CurrentValue = NULL;
		$this->section_02_title->OldValue = $this->section_02_title->CurrentValue;
		$this->section_02_title_ar->CurrentValue = NULL;
		$this->section_02_title_ar->OldValue = $this->section_02_title_ar->CurrentValue;
		$this->section_02_summary->CurrentValue = NULL;
		$this->section_02_summary->OldValue = $this->section_02_summary->CurrentValue;
		$this->section_02_summary_ar->CurrentValue = NULL;
		$this->section_02_summary_ar->OldValue = $this->section_02_summary_ar->CurrentValue;
		$this->section_02_icon->CurrentValue = NULL;
		$this->section_02_icon->OldValue = $this->section_02_icon->CurrentValue;
		$this->section_03_title->CurrentValue = NULL;
		$this->section_03_title->OldValue = $this->section_03_title->CurrentValue;
		$this->section_03_title_ar->CurrentValue = NULL;
		$this->section_03_title_ar->OldValue = $this->section_03_title_ar->CurrentValue;
		$this->section_03_summary->CurrentValue = NULL;
		$this->section_03_summary->OldValue = $this->section_03_summary->CurrentValue;
		$this->section_03_summary_ar->CurrentValue = NULL;
		$this->section_03_summary_ar->OldValue = $this->section_03_summary_ar->CurrentValue;
		$this->section_03_icon->CurrentValue = NULL;
		$this->section_03_icon->OldValue = $this->section_03_icon->CurrentValue;
		$this->section_04_title->CurrentValue = NULL;
		$this->section_04_title->OldValue = $this->section_04_title->CurrentValue;
		$this->section_04_title_ar->CurrentValue = NULL;
		$this->section_04_title_ar->OldValue = $this->section_04_title_ar->CurrentValue;
		$this->section_04_summary->CurrentValue = NULL;
		$this->section_04_summary->OldValue = $this->section_04_summary->CurrentValue;
		$this->section_04_summary_ar->CurrentValue = NULL;
		$this->section_04_summary_ar->OldValue = $this->section_04_summary_ar->CurrentValue;
		$this->section_04_icon->CurrentValue = NULL;
		$this->section_04_icon->OldValue = $this->section_04_icon->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
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
		if (!$this->section_01_icon->FldIsDetailKey) {
			$this->section_01_icon->setFormValue($objForm->GetValue("x_section_01_icon"));
		}
		if (!$this->section_02_title->FldIsDetailKey) {
			$this->section_02_title->setFormValue($objForm->GetValue("x_section_02_title"));
		}
		if (!$this->section_02_title_ar->FldIsDetailKey) {
			$this->section_02_title_ar->setFormValue($objForm->GetValue("x_section_02_title_ar"));
		}
		if (!$this->section_02_summary->FldIsDetailKey) {
			$this->section_02_summary->setFormValue($objForm->GetValue("x_section_02_summary"));
		}
		if (!$this->section_02_summary_ar->FldIsDetailKey) {
			$this->section_02_summary_ar->setFormValue($objForm->GetValue("x_section_02_summary_ar"));
		}
		if (!$this->section_02_icon->FldIsDetailKey) {
			$this->section_02_icon->setFormValue($objForm->GetValue("x_section_02_icon"));
		}
		if (!$this->section_03_title->FldIsDetailKey) {
			$this->section_03_title->setFormValue($objForm->GetValue("x_section_03_title"));
		}
		if (!$this->section_03_title_ar->FldIsDetailKey) {
			$this->section_03_title_ar->setFormValue($objForm->GetValue("x_section_03_title_ar"));
		}
		if (!$this->section_03_summary->FldIsDetailKey) {
			$this->section_03_summary->setFormValue($objForm->GetValue("x_section_03_summary"));
		}
		if (!$this->section_03_summary_ar->FldIsDetailKey) {
			$this->section_03_summary_ar->setFormValue($objForm->GetValue("x_section_03_summary_ar"));
		}
		if (!$this->section_03_icon->FldIsDetailKey) {
			$this->section_03_icon->setFormValue($objForm->GetValue("x_section_03_icon"));
		}
		if (!$this->section_04_title->FldIsDetailKey) {
			$this->section_04_title->setFormValue($objForm->GetValue("x_section_04_title"));
		}
		if (!$this->section_04_title_ar->FldIsDetailKey) {
			$this->section_04_title_ar->setFormValue($objForm->GetValue("x_section_04_title_ar"));
		}
		if (!$this->section_04_summary->FldIsDetailKey) {
			$this->section_04_summary->setFormValue($objForm->GetValue("x_section_04_summary"));
		}
		if (!$this->section_04_summary_ar->FldIsDetailKey) {
			$this->section_04_summary_ar->setFormValue($objForm->GetValue("x_section_04_summary_ar"));
		}
		if (!$this->section_04_icon->FldIsDetailKey) {
			$this->section_04_icon->setFormValue($objForm->GetValue("x_section_04_icon"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->title->CurrentValue = $this->title->FormValue;
		$this->title_ar->CurrentValue = $this->title_ar->FormValue;
		$this->description->CurrentValue = $this->description->FormValue;
		$this->description_ar->CurrentValue = $this->description_ar->FormValue;
		$this->section_01_title->CurrentValue = $this->section_01_title->FormValue;
		$this->section_01_title_ar->CurrentValue = $this->section_01_title_ar->FormValue;
		$this->section_01_summary->CurrentValue = $this->section_01_summary->FormValue;
		$this->section_01_summary_ar->CurrentValue = $this->section_01_summary_ar->FormValue;
		$this->section_01_icon->CurrentValue = $this->section_01_icon->FormValue;
		$this->section_02_title->CurrentValue = $this->section_02_title->FormValue;
		$this->section_02_title_ar->CurrentValue = $this->section_02_title_ar->FormValue;
		$this->section_02_summary->CurrentValue = $this->section_02_summary->FormValue;
		$this->section_02_summary_ar->CurrentValue = $this->section_02_summary_ar->FormValue;
		$this->section_02_icon->CurrentValue = $this->section_02_icon->FormValue;
		$this->section_03_title->CurrentValue = $this->section_03_title->FormValue;
		$this->section_03_title_ar->CurrentValue = $this->section_03_title_ar->FormValue;
		$this->section_03_summary->CurrentValue = $this->section_03_summary->FormValue;
		$this->section_03_summary_ar->CurrentValue = $this->section_03_summary_ar->FormValue;
		$this->section_03_icon->CurrentValue = $this->section_03_icon->FormValue;
		$this->section_04_title->CurrentValue = $this->section_04_title->FormValue;
		$this->section_04_title_ar->CurrentValue = $this->section_04_title_ar->FormValue;
		$this->section_04_summary->CurrentValue = $this->section_04_summary->FormValue;
		$this->section_04_summary_ar->CurrentValue = $this->section_04_summary_ar->FormValue;
		$this->section_04_icon->CurrentValue = $this->section_04_icon->FormValue;
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
		$this->sliderImage->Upload->DbValue = $row['sliderImage'];
		$this->sliderImage->setDbValue($this->sliderImage->Upload->DbValue);
		$this->sliderImage_ar->Upload->DbValue = $row['sliderImage_ar'];
		$this->sliderImage_ar->setDbValue($this->sliderImage_ar->Upload->DbValue);
		$this->description->setDbValue($row['description']);
		$this->description_ar->setDbValue($row['description_ar']);
		$this->section_01_title->setDbValue($row['section_01_title']);
		$this->section_01_title_ar->setDbValue($row['section_01_title_ar']);
		$this->section_01_summary->setDbValue($row['section_01_summary']);
		$this->section_01_summary_ar->setDbValue($row['section_01_summary_ar']);
		$this->section_01_icon->setDbValue($row['section_01_icon']);
		$this->section_02_title->setDbValue($row['section_02_title']);
		$this->section_02_title_ar->setDbValue($row['section_02_title_ar']);
		$this->section_02_summary->setDbValue($row['section_02_summary']);
		$this->section_02_summary_ar->setDbValue($row['section_02_summary_ar']);
		$this->section_02_icon->setDbValue($row['section_02_icon']);
		$this->section_03_title->setDbValue($row['section_03_title']);
		$this->section_03_title_ar->setDbValue($row['section_03_title_ar']);
		$this->section_03_summary->setDbValue($row['section_03_summary']);
		$this->section_03_summary_ar->setDbValue($row['section_03_summary_ar']);
		$this->section_03_icon->setDbValue($row['section_03_icon']);
		$this->section_04_title->setDbValue($row['section_04_title']);
		$this->section_04_title_ar->setDbValue($row['section_04_title_ar']);
		$this->section_04_summary->setDbValue($row['section_04_summary']);
		$this->section_04_summary_ar->setDbValue($row['section_04_summary_ar']);
		$this->section_04_icon->setDbValue($row['section_04_icon']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['title'] = $this->title->CurrentValue;
		$row['title_ar'] = $this->title_ar->CurrentValue;
		$row['sliderImage'] = $this->sliderImage->Upload->DbValue;
		$row['sliderImage_ar'] = $this->sliderImage_ar->Upload->DbValue;
		$row['description'] = $this->description->CurrentValue;
		$row['description_ar'] = $this->description_ar->CurrentValue;
		$row['section_01_title'] = $this->section_01_title->CurrentValue;
		$row['section_01_title_ar'] = $this->section_01_title_ar->CurrentValue;
		$row['section_01_summary'] = $this->section_01_summary->CurrentValue;
		$row['section_01_summary_ar'] = $this->section_01_summary_ar->CurrentValue;
		$row['section_01_icon'] = $this->section_01_icon->CurrentValue;
		$row['section_02_title'] = $this->section_02_title->CurrentValue;
		$row['section_02_title_ar'] = $this->section_02_title_ar->CurrentValue;
		$row['section_02_summary'] = $this->section_02_summary->CurrentValue;
		$row['section_02_summary_ar'] = $this->section_02_summary_ar->CurrentValue;
		$row['section_02_icon'] = $this->section_02_icon->CurrentValue;
		$row['section_03_title'] = $this->section_03_title->CurrentValue;
		$row['section_03_title_ar'] = $this->section_03_title_ar->CurrentValue;
		$row['section_03_summary'] = $this->section_03_summary->CurrentValue;
		$row['section_03_summary_ar'] = $this->section_03_summary_ar->CurrentValue;
		$row['section_03_icon'] = $this->section_03_icon->CurrentValue;
		$row['section_04_title'] = $this->section_04_title->CurrentValue;
		$row['section_04_title_ar'] = $this->section_04_title_ar->CurrentValue;
		$row['section_04_summary'] = $this->section_04_summary->CurrentValue;
		$row['section_04_summary_ar'] = $this->section_04_summary_ar->CurrentValue;
		$row['section_04_icon'] = $this->section_04_icon->CurrentValue;
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
		$this->sliderImage->Upload->DbValue = $row['sliderImage'];
		$this->sliderImage_ar->Upload->DbValue = $row['sliderImage_ar'];
		$this->description->DbValue = $row['description'];
		$this->description_ar->DbValue = $row['description_ar'];
		$this->section_01_title->DbValue = $row['section_01_title'];
		$this->section_01_title_ar->DbValue = $row['section_01_title_ar'];
		$this->section_01_summary->DbValue = $row['section_01_summary'];
		$this->section_01_summary_ar->DbValue = $row['section_01_summary_ar'];
		$this->section_01_icon->DbValue = $row['section_01_icon'];
		$this->section_02_title->DbValue = $row['section_02_title'];
		$this->section_02_title_ar->DbValue = $row['section_02_title_ar'];
		$this->section_02_summary->DbValue = $row['section_02_summary'];
		$this->section_02_summary_ar->DbValue = $row['section_02_summary_ar'];
		$this->section_02_icon->DbValue = $row['section_02_icon'];
		$this->section_03_title->DbValue = $row['section_03_title'];
		$this->section_03_title_ar->DbValue = $row['section_03_title_ar'];
		$this->section_03_summary->DbValue = $row['section_03_summary'];
		$this->section_03_summary_ar->DbValue = $row['section_03_summary_ar'];
		$this->section_03_icon->DbValue = $row['section_03_icon'];
		$this->section_04_title->DbValue = $row['section_04_title'];
		$this->section_04_title_ar->DbValue = $row['section_04_title_ar'];
		$this->section_04_summary->DbValue = $row['section_04_summary'];
		$this->section_04_summary_ar->DbValue = $row['section_04_summary_ar'];
		$this->section_04_icon->DbValue = $row['section_04_icon'];
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
		// sliderImage
		// sliderImage_ar
		// description
		// description_ar
		// section_01_title
		// section_01_title_ar
		// section_01_summary
		// section_01_summary_ar
		// section_01_icon
		// section_02_title
		// section_02_title_ar
		// section_02_summary
		// section_02_summary_ar
		// section_02_icon
		// section_03_title
		// section_03_title_ar
		// section_03_summary
		// section_03_summary_ar
		// section_03_icon
		// section_04_title
		// section_04_title_ar
		// section_04_summary
		// section_04_summary_ar
		// section_04_icon

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

		// sliderImage
		$this->sliderImage->UploadPath = 'uploads/campaign';
		if (!ew_Empty($this->sliderImage->Upload->DbValue)) {
			$this->sliderImage->ImageWidth = 100;
			$this->sliderImage->ImageHeight = 0;
			$this->sliderImage->ImageAlt = $this->sliderImage->FldAlt();
			$this->sliderImage->ViewValue = $this->sliderImage->Upload->DbValue;
		} else {
			$this->sliderImage->ViewValue = "";
		}
		$this->sliderImage->ViewCustomAttributes = "";

		// sliderImage_ar
		$this->sliderImage_ar->UploadPath = 'uploads/campaign';
		if (!ew_Empty($this->sliderImage_ar->Upload->DbValue)) {
			$this->sliderImage_ar->ImageWidth = 100;
			$this->sliderImage_ar->ImageHeight = 0;
			$this->sliderImage_ar->ImageAlt = $this->sliderImage_ar->FldAlt();
			$this->sliderImage_ar->ViewValue = $this->sliderImage_ar->Upload->DbValue;
		} else {
			$this->sliderImage_ar->ViewValue = "";
		}
		$this->sliderImage_ar->ViewCustomAttributes = "";

		// description
		$this->description->ViewValue = $this->description->CurrentValue;
		$this->description->ViewCustomAttributes = "";

		// description_ar
		$this->description_ar->ViewValue = $this->description_ar->CurrentValue;
		$this->description_ar->ViewCustomAttributes = "";

		// section_01_title
		$this->section_01_title->ViewValue = $this->section_01_title->CurrentValue;
		$this->section_01_title->ViewCustomAttributes = "";

		// section_01_title_ar
		$this->section_01_title_ar->ViewValue = $this->section_01_title_ar->CurrentValue;
		$this->section_01_title_ar->ViewCustomAttributes = "";

		// section_01_summary
		$this->section_01_summary->ViewValue = $this->section_01_summary->CurrentValue;
		$this->section_01_summary->ViewCustomAttributes = "";

		// section_01_summary_ar
		$this->section_01_summary_ar->ViewValue = $this->section_01_summary_ar->CurrentValue;
		$this->section_01_summary_ar->ViewCustomAttributes = "";

		// section_01_icon
		$this->section_01_icon->ViewValue = $this->section_01_icon->CurrentValue;
		$this->section_01_icon->ViewCustomAttributes = "";

		// section_02_title
		$this->section_02_title->ViewValue = $this->section_02_title->CurrentValue;
		$this->section_02_title->ViewCustomAttributes = "";

		// section_02_title_ar
		$this->section_02_title_ar->ViewValue = $this->section_02_title_ar->CurrentValue;
		$this->section_02_title_ar->ViewCustomAttributes = "";

		// section_02_summary
		$this->section_02_summary->ViewValue = $this->section_02_summary->CurrentValue;
		$this->section_02_summary->ViewCustomAttributes = "";

		// section_02_summary_ar
		$this->section_02_summary_ar->ViewValue = $this->section_02_summary_ar->CurrentValue;
		$this->section_02_summary_ar->ViewCustomAttributes = "";

		// section_02_icon
		$this->section_02_icon->ViewValue = $this->section_02_icon->CurrentValue;
		$this->section_02_icon->ViewCustomAttributes = "";

		// section_03_title
		$this->section_03_title->ViewValue = $this->section_03_title->CurrentValue;
		$this->section_03_title->ViewCustomAttributes = "";

		// section_03_title_ar
		$this->section_03_title_ar->ViewValue = $this->section_03_title_ar->CurrentValue;
		$this->section_03_title_ar->ViewCustomAttributes = "";

		// section_03_summary
		$this->section_03_summary->ViewValue = $this->section_03_summary->CurrentValue;
		$this->section_03_summary->ViewCustomAttributes = "";

		// section_03_summary_ar
		$this->section_03_summary_ar->ViewValue = $this->section_03_summary_ar->CurrentValue;
		$this->section_03_summary_ar->ViewCustomAttributes = "";

		// section_03_icon
		$this->section_03_icon->ViewValue = $this->section_03_icon->CurrentValue;
		$this->section_03_icon->ViewCustomAttributes = "";

		// section_04_title
		$this->section_04_title->ViewValue = $this->section_04_title->CurrentValue;
		$this->section_04_title->ViewCustomAttributes = "";

		// section_04_title_ar
		$this->section_04_title_ar->ViewValue = $this->section_04_title_ar->CurrentValue;
		$this->section_04_title_ar->ViewCustomAttributes = "";

		// section_04_summary
		$this->section_04_summary->ViewValue = $this->section_04_summary->CurrentValue;
		$this->section_04_summary->ViewCustomAttributes = "";

		// section_04_summary_ar
		$this->section_04_summary_ar->ViewValue = $this->section_04_summary_ar->CurrentValue;
		$this->section_04_summary_ar->ViewCustomAttributes = "";

		// section_04_icon
		$this->section_04_icon->ViewValue = $this->section_04_icon->CurrentValue;
		$this->section_04_icon->ViewCustomAttributes = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";
			$this->title->TooltipValue = "";

			// title_ar
			$this->title_ar->LinkCustomAttributes = "";
			$this->title_ar->HrefValue = "";
			$this->title_ar->TooltipValue = "";

			// sliderImage
			$this->sliderImage->LinkCustomAttributes = "";
			$this->sliderImage->UploadPath = 'uploads/campaign';
			if (!ew_Empty($this->sliderImage->Upload->DbValue)) {
				$this->sliderImage->HrefValue = ew_GetFileUploadUrl($this->sliderImage, $this->sliderImage->Upload->DbValue); // Add prefix/suffix
				$this->sliderImage->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->sliderImage->HrefValue = ew_FullUrl($this->sliderImage->HrefValue, "href");
			} else {
				$this->sliderImage->HrefValue = "";
			}
			$this->sliderImage->HrefValue2 = $this->sliderImage->UploadPath . $this->sliderImage->Upload->DbValue;
			$this->sliderImage->TooltipValue = "";
			if ($this->sliderImage->UseColorbox) {
				if (ew_Empty($this->sliderImage->TooltipValue))
					$this->sliderImage->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->sliderImage->LinkAttrs["data-rel"] = "campaign_aboutus_x_sliderImage";
				ew_AppendClass($this->sliderImage->LinkAttrs["class"], "ewLightbox");
			}

			// sliderImage_ar
			$this->sliderImage_ar->LinkCustomAttributes = "";
			$this->sliderImage_ar->UploadPath = 'uploads/campaign';
			if (!ew_Empty($this->sliderImage_ar->Upload->DbValue)) {
				$this->sliderImage_ar->HrefValue = ew_GetFileUploadUrl($this->sliderImage_ar, $this->sliderImage_ar->Upload->DbValue); // Add prefix/suffix
				$this->sliderImage_ar->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->sliderImage_ar->HrefValue = ew_FullUrl($this->sliderImage_ar->HrefValue, "href");
			} else {
				$this->sliderImage_ar->HrefValue = "";
			}
			$this->sliderImage_ar->HrefValue2 = $this->sliderImage_ar->UploadPath . $this->sliderImage_ar->Upload->DbValue;
			$this->sliderImage_ar->TooltipValue = "";
			if ($this->sliderImage_ar->UseColorbox) {
				if (ew_Empty($this->sliderImage_ar->TooltipValue))
					$this->sliderImage_ar->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->sliderImage_ar->LinkAttrs["data-rel"] = "campaign_aboutus_x_sliderImage_ar";
				ew_AppendClass($this->sliderImage_ar->LinkAttrs["class"], "ewLightbox");
			}

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";
			$this->description->TooltipValue = "";

			// description_ar
			$this->description_ar->LinkCustomAttributes = "";
			$this->description_ar->HrefValue = "";
			$this->description_ar->TooltipValue = "";

			// section_01_title
			$this->section_01_title->LinkCustomAttributes = "";
			$this->section_01_title->HrefValue = "";
			$this->section_01_title->TooltipValue = "";

			// section_01_title_ar
			$this->section_01_title_ar->LinkCustomAttributes = "";
			$this->section_01_title_ar->HrefValue = "";
			$this->section_01_title_ar->TooltipValue = "";

			// section_01_summary
			$this->section_01_summary->LinkCustomAttributes = "";
			$this->section_01_summary->HrefValue = "";
			$this->section_01_summary->TooltipValue = "";

			// section_01_summary_ar
			$this->section_01_summary_ar->LinkCustomAttributes = "";
			$this->section_01_summary_ar->HrefValue = "";
			$this->section_01_summary_ar->TooltipValue = "";

			// section_01_icon
			$this->section_01_icon->LinkCustomAttributes = "";
			$this->section_01_icon->HrefValue = "";
			$this->section_01_icon->TooltipValue = "";

			// section_02_title
			$this->section_02_title->LinkCustomAttributes = "";
			$this->section_02_title->HrefValue = "";
			$this->section_02_title->TooltipValue = "";

			// section_02_title_ar
			$this->section_02_title_ar->LinkCustomAttributes = "";
			$this->section_02_title_ar->HrefValue = "";
			$this->section_02_title_ar->TooltipValue = "";

			// section_02_summary
			$this->section_02_summary->LinkCustomAttributes = "";
			$this->section_02_summary->HrefValue = "";
			$this->section_02_summary->TooltipValue = "";

			// section_02_summary_ar
			$this->section_02_summary_ar->LinkCustomAttributes = "";
			$this->section_02_summary_ar->HrefValue = "";
			$this->section_02_summary_ar->TooltipValue = "";

			// section_02_icon
			$this->section_02_icon->LinkCustomAttributes = "";
			$this->section_02_icon->HrefValue = "";
			$this->section_02_icon->TooltipValue = "";

			// section_03_title
			$this->section_03_title->LinkCustomAttributes = "";
			$this->section_03_title->HrefValue = "";
			$this->section_03_title->TooltipValue = "";

			// section_03_title_ar
			$this->section_03_title_ar->LinkCustomAttributes = "";
			$this->section_03_title_ar->HrefValue = "";
			$this->section_03_title_ar->TooltipValue = "";

			// section_03_summary
			$this->section_03_summary->LinkCustomAttributes = "";
			$this->section_03_summary->HrefValue = "";
			$this->section_03_summary->TooltipValue = "";

			// section_03_summary_ar
			$this->section_03_summary_ar->LinkCustomAttributes = "";
			$this->section_03_summary_ar->HrefValue = "";
			$this->section_03_summary_ar->TooltipValue = "";

			// section_03_icon
			$this->section_03_icon->LinkCustomAttributes = "";
			$this->section_03_icon->HrefValue = "";
			$this->section_03_icon->TooltipValue = "";

			// section_04_title
			$this->section_04_title->LinkCustomAttributes = "";
			$this->section_04_title->HrefValue = "";
			$this->section_04_title->TooltipValue = "";

			// section_04_title_ar
			$this->section_04_title_ar->LinkCustomAttributes = "";
			$this->section_04_title_ar->HrefValue = "";
			$this->section_04_title_ar->TooltipValue = "";

			// section_04_summary
			$this->section_04_summary->LinkCustomAttributes = "";
			$this->section_04_summary->HrefValue = "";
			$this->section_04_summary->TooltipValue = "";

			// section_04_summary_ar
			$this->section_04_summary_ar->LinkCustomAttributes = "";
			$this->section_04_summary_ar->HrefValue = "";
			$this->section_04_summary_ar->TooltipValue = "";

			// section_04_icon
			$this->section_04_icon->LinkCustomAttributes = "";
			$this->section_04_icon->HrefValue = "";
			$this->section_04_icon->TooltipValue = "";
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

			// sliderImage
			$this->sliderImage->EditAttrs["class"] = "form-control";
			$this->sliderImage->EditCustomAttributes = "";
			$this->sliderImage->UploadPath = 'uploads/campaign';
			if (!ew_Empty($this->sliderImage->Upload->DbValue)) {
				$this->sliderImage->ImageWidth = 100;
				$this->sliderImage->ImageHeight = 0;
				$this->sliderImage->ImageAlt = $this->sliderImage->FldAlt();
				$this->sliderImage->EditValue = $this->sliderImage->Upload->DbValue;
			} else {
				$this->sliderImage->EditValue = "";
			}
			if (!ew_Empty($this->sliderImage->CurrentValue))
					$this->sliderImage->Upload->FileName = $this->sliderImage->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->sliderImage);

			// sliderImage_ar
			$this->sliderImage_ar->EditAttrs["class"] = "form-control";
			$this->sliderImage_ar->EditCustomAttributes = "";
			$this->sliderImage_ar->UploadPath = 'uploads/campaign';
			if (!ew_Empty($this->sliderImage_ar->Upload->DbValue)) {
				$this->sliderImage_ar->ImageWidth = 100;
				$this->sliderImage_ar->ImageHeight = 0;
				$this->sliderImage_ar->ImageAlt = $this->sliderImage_ar->FldAlt();
				$this->sliderImage_ar->EditValue = $this->sliderImage_ar->Upload->DbValue;
			} else {
				$this->sliderImage_ar->EditValue = "";
			}
			if (!ew_Empty($this->sliderImage_ar->CurrentValue))
					$this->sliderImage_ar->Upload->FileName = $this->sliderImage_ar->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->sliderImage_ar);

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

			// section_01_icon
			$this->section_01_icon->EditAttrs["class"] = "form-control";
			$this->section_01_icon->EditCustomAttributes = "";
			$this->section_01_icon->EditValue = ew_HtmlEncode($this->section_01_icon->CurrentValue);
			$this->section_01_icon->PlaceHolder = ew_RemoveHtml($this->section_01_icon->FldCaption());

			// section_02_title
			$this->section_02_title->EditAttrs["class"] = "form-control";
			$this->section_02_title->EditCustomAttributes = "";
			$this->section_02_title->EditValue = ew_HtmlEncode($this->section_02_title->CurrentValue);
			$this->section_02_title->PlaceHolder = ew_RemoveHtml($this->section_02_title->FldCaption());

			// section_02_title_ar
			$this->section_02_title_ar->EditAttrs["class"] = "form-control";
			$this->section_02_title_ar->EditCustomAttributes = "";
			$this->section_02_title_ar->EditValue = ew_HtmlEncode($this->section_02_title_ar->CurrentValue);
			$this->section_02_title_ar->PlaceHolder = ew_RemoveHtml($this->section_02_title_ar->FldCaption());

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

			// section_02_icon
			$this->section_02_icon->EditAttrs["class"] = "form-control";
			$this->section_02_icon->EditCustomAttributes = "";
			$this->section_02_icon->EditValue = ew_HtmlEncode($this->section_02_icon->CurrentValue);
			$this->section_02_icon->PlaceHolder = ew_RemoveHtml($this->section_02_icon->FldCaption());

			// section_03_title
			$this->section_03_title->EditAttrs["class"] = "form-control";
			$this->section_03_title->EditCustomAttributes = "";
			$this->section_03_title->EditValue = ew_HtmlEncode($this->section_03_title->CurrentValue);
			$this->section_03_title->PlaceHolder = ew_RemoveHtml($this->section_03_title->FldCaption());

			// section_03_title_ar
			$this->section_03_title_ar->EditAttrs["class"] = "form-control";
			$this->section_03_title_ar->EditCustomAttributes = "";
			$this->section_03_title_ar->EditValue = ew_HtmlEncode($this->section_03_title_ar->CurrentValue);
			$this->section_03_title_ar->PlaceHolder = ew_RemoveHtml($this->section_03_title_ar->FldCaption());

			// section_03_summary
			$this->section_03_summary->EditAttrs["class"] = "form-control";
			$this->section_03_summary->EditCustomAttributes = "";
			$this->section_03_summary->EditValue = ew_HtmlEncode($this->section_03_summary->CurrentValue);
			$this->section_03_summary->PlaceHolder = ew_RemoveHtml($this->section_03_summary->FldCaption());

			// section_03_summary_ar
			$this->section_03_summary_ar->EditAttrs["class"] = "form-control";
			$this->section_03_summary_ar->EditCustomAttributes = "";
			$this->section_03_summary_ar->EditValue = ew_HtmlEncode($this->section_03_summary_ar->CurrentValue);
			$this->section_03_summary_ar->PlaceHolder = ew_RemoveHtml($this->section_03_summary_ar->FldCaption());

			// section_03_icon
			$this->section_03_icon->EditAttrs["class"] = "form-control";
			$this->section_03_icon->EditCustomAttributes = "";
			$this->section_03_icon->EditValue = ew_HtmlEncode($this->section_03_icon->CurrentValue);
			$this->section_03_icon->PlaceHolder = ew_RemoveHtml($this->section_03_icon->FldCaption());

			// section_04_title
			$this->section_04_title->EditAttrs["class"] = "form-control";
			$this->section_04_title->EditCustomAttributes = "";
			$this->section_04_title->EditValue = ew_HtmlEncode($this->section_04_title->CurrentValue);
			$this->section_04_title->PlaceHolder = ew_RemoveHtml($this->section_04_title->FldCaption());

			// section_04_title_ar
			$this->section_04_title_ar->EditAttrs["class"] = "form-control";
			$this->section_04_title_ar->EditCustomAttributes = "";
			$this->section_04_title_ar->EditValue = ew_HtmlEncode($this->section_04_title_ar->CurrentValue);
			$this->section_04_title_ar->PlaceHolder = ew_RemoveHtml($this->section_04_title_ar->FldCaption());

			// section_04_summary
			$this->section_04_summary->EditAttrs["class"] = "form-control";
			$this->section_04_summary->EditCustomAttributes = "";
			$this->section_04_summary->EditValue = ew_HtmlEncode($this->section_04_summary->CurrentValue);
			$this->section_04_summary->PlaceHolder = ew_RemoveHtml($this->section_04_summary->FldCaption());

			// section_04_summary_ar
			$this->section_04_summary_ar->EditAttrs["class"] = "form-control";
			$this->section_04_summary_ar->EditCustomAttributes = "";
			$this->section_04_summary_ar->EditValue = ew_HtmlEncode($this->section_04_summary_ar->CurrentValue);
			$this->section_04_summary_ar->PlaceHolder = ew_RemoveHtml($this->section_04_summary_ar->FldCaption());

			// section_04_icon
			$this->section_04_icon->EditAttrs["class"] = "form-control";
			$this->section_04_icon->EditCustomAttributes = "";
			$this->section_04_icon->EditValue = ew_HtmlEncode($this->section_04_icon->CurrentValue);
			$this->section_04_icon->PlaceHolder = ew_RemoveHtml($this->section_04_icon->FldCaption());

			// Add refer script
			// title

			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";

			// title_ar
			$this->title_ar->LinkCustomAttributes = "";
			$this->title_ar->HrefValue = "";

			// sliderImage
			$this->sliderImage->LinkCustomAttributes = "";
			$this->sliderImage->UploadPath = 'uploads/campaign';
			if (!ew_Empty($this->sliderImage->Upload->DbValue)) {
				$this->sliderImage->HrefValue = ew_GetFileUploadUrl($this->sliderImage, $this->sliderImage->Upload->DbValue); // Add prefix/suffix
				$this->sliderImage->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->sliderImage->HrefValue = ew_FullUrl($this->sliderImage->HrefValue, "href");
			} else {
				$this->sliderImage->HrefValue = "";
			}
			$this->sliderImage->HrefValue2 = $this->sliderImage->UploadPath . $this->sliderImage->Upload->DbValue;

			// sliderImage_ar
			$this->sliderImage_ar->LinkCustomAttributes = "";
			$this->sliderImage_ar->UploadPath = 'uploads/campaign';
			if (!ew_Empty($this->sliderImage_ar->Upload->DbValue)) {
				$this->sliderImage_ar->HrefValue = ew_GetFileUploadUrl($this->sliderImage_ar, $this->sliderImage_ar->Upload->DbValue); // Add prefix/suffix
				$this->sliderImage_ar->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->sliderImage_ar->HrefValue = ew_FullUrl($this->sliderImage_ar->HrefValue, "href");
			} else {
				$this->sliderImage_ar->HrefValue = "";
			}
			$this->sliderImage_ar->HrefValue2 = $this->sliderImage_ar->UploadPath . $this->sliderImage_ar->Upload->DbValue;

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";

			// description_ar
			$this->description_ar->LinkCustomAttributes = "";
			$this->description_ar->HrefValue = "";

			// section_01_title
			$this->section_01_title->LinkCustomAttributes = "";
			$this->section_01_title->HrefValue = "";

			// section_01_title_ar
			$this->section_01_title_ar->LinkCustomAttributes = "";
			$this->section_01_title_ar->HrefValue = "";

			// section_01_summary
			$this->section_01_summary->LinkCustomAttributes = "";
			$this->section_01_summary->HrefValue = "";

			// section_01_summary_ar
			$this->section_01_summary_ar->LinkCustomAttributes = "";
			$this->section_01_summary_ar->HrefValue = "";

			// section_01_icon
			$this->section_01_icon->LinkCustomAttributes = "";
			$this->section_01_icon->HrefValue = "";

			// section_02_title
			$this->section_02_title->LinkCustomAttributes = "";
			$this->section_02_title->HrefValue = "";

			// section_02_title_ar
			$this->section_02_title_ar->LinkCustomAttributes = "";
			$this->section_02_title_ar->HrefValue = "";

			// section_02_summary
			$this->section_02_summary->LinkCustomAttributes = "";
			$this->section_02_summary->HrefValue = "";

			// section_02_summary_ar
			$this->section_02_summary_ar->LinkCustomAttributes = "";
			$this->section_02_summary_ar->HrefValue = "";

			// section_02_icon
			$this->section_02_icon->LinkCustomAttributes = "";
			$this->section_02_icon->HrefValue = "";

			// section_03_title
			$this->section_03_title->LinkCustomAttributes = "";
			$this->section_03_title->HrefValue = "";

			// section_03_title_ar
			$this->section_03_title_ar->LinkCustomAttributes = "";
			$this->section_03_title_ar->HrefValue = "";

			// section_03_summary
			$this->section_03_summary->LinkCustomAttributes = "";
			$this->section_03_summary->HrefValue = "";

			// section_03_summary_ar
			$this->section_03_summary_ar->LinkCustomAttributes = "";
			$this->section_03_summary_ar->HrefValue = "";

			// section_03_icon
			$this->section_03_icon->LinkCustomAttributes = "";
			$this->section_03_icon->HrefValue = "";

			// section_04_title
			$this->section_04_title->LinkCustomAttributes = "";
			$this->section_04_title->HrefValue = "";

			// section_04_title_ar
			$this->section_04_title_ar->LinkCustomAttributes = "";
			$this->section_04_title_ar->HrefValue = "";

			// section_04_summary
			$this->section_04_summary->LinkCustomAttributes = "";
			$this->section_04_summary->HrefValue = "";

			// section_04_summary_ar
			$this->section_04_summary_ar->LinkCustomAttributes = "";
			$this->section_04_summary_ar->HrefValue = "";

			// section_04_icon
			$this->section_04_icon->LinkCustomAttributes = "";
			$this->section_04_icon->HrefValue = "";
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
			$this->sliderImage->OldUploadPath = 'uploads/campaign';
			$this->sliderImage->UploadPath = $this->sliderImage->OldUploadPath;
			$this->sliderImage_ar->OldUploadPath = 'uploads/campaign';
			$this->sliderImage_ar->UploadPath = $this->sliderImage_ar->OldUploadPath;
		}
		$rsnew = array();

		// title
		$this->title->SetDbValueDef($rsnew, $this->title->CurrentValue, NULL, FALSE);

		// title_ar
		$this->title_ar->SetDbValueDef($rsnew, $this->title_ar->CurrentValue, NULL, FALSE);

		// sliderImage
		if ($this->sliderImage->Visible && !$this->sliderImage->Upload->KeepFile) {
			$this->sliderImage->Upload->DbValue = ""; // No need to delete old file
			if ($this->sliderImage->Upload->FileName == "") {
				$rsnew['sliderImage'] = NULL;
			} else {
				$rsnew['sliderImage'] = $this->sliderImage->Upload->FileName;
			}
		}

		// sliderImage_ar
		if ($this->sliderImage_ar->Visible && !$this->sliderImage_ar->Upload->KeepFile) {
			$this->sliderImage_ar->Upload->DbValue = ""; // No need to delete old file
			if ($this->sliderImage_ar->Upload->FileName == "") {
				$rsnew['sliderImage_ar'] = NULL;
			} else {
				$rsnew['sliderImage_ar'] = $this->sliderImage_ar->Upload->FileName;
			}
		}

		// description
		$this->description->SetDbValueDef($rsnew, $this->description->CurrentValue, NULL, FALSE);

		// description_ar
		$this->description_ar->SetDbValueDef($rsnew, $this->description_ar->CurrentValue, NULL, FALSE);

		// section_01_title
		$this->section_01_title->SetDbValueDef($rsnew, $this->section_01_title->CurrentValue, NULL, FALSE);

		// section_01_title_ar
		$this->section_01_title_ar->SetDbValueDef($rsnew, $this->section_01_title_ar->CurrentValue, NULL, FALSE);

		// section_01_summary
		$this->section_01_summary->SetDbValueDef($rsnew, $this->section_01_summary->CurrentValue, NULL, FALSE);

		// section_01_summary_ar
		$this->section_01_summary_ar->SetDbValueDef($rsnew, $this->section_01_summary_ar->CurrentValue, NULL, FALSE);

		// section_01_icon
		$this->section_01_icon->SetDbValueDef($rsnew, $this->section_01_icon->CurrentValue, NULL, FALSE);

		// section_02_title
		$this->section_02_title->SetDbValueDef($rsnew, $this->section_02_title->CurrentValue, NULL, FALSE);

		// section_02_title_ar
		$this->section_02_title_ar->SetDbValueDef($rsnew, $this->section_02_title_ar->CurrentValue, NULL, FALSE);

		// section_02_summary
		$this->section_02_summary->SetDbValueDef($rsnew, $this->section_02_summary->CurrentValue, NULL, FALSE);

		// section_02_summary_ar
		$this->section_02_summary_ar->SetDbValueDef($rsnew, $this->section_02_summary_ar->CurrentValue, NULL, FALSE);

		// section_02_icon
		$this->section_02_icon->SetDbValueDef($rsnew, $this->section_02_icon->CurrentValue, NULL, FALSE);

		// section_03_title
		$this->section_03_title->SetDbValueDef($rsnew, $this->section_03_title->CurrentValue, NULL, FALSE);

		// section_03_title_ar
		$this->section_03_title_ar->SetDbValueDef($rsnew, $this->section_03_title_ar->CurrentValue, NULL, FALSE);

		// section_03_summary
		$this->section_03_summary->SetDbValueDef($rsnew, $this->section_03_summary->CurrentValue, NULL, FALSE);

		// section_03_summary_ar
		$this->section_03_summary_ar->SetDbValueDef($rsnew, $this->section_03_summary_ar->CurrentValue, NULL, FALSE);

		// section_03_icon
		$this->section_03_icon->SetDbValueDef($rsnew, $this->section_03_icon->CurrentValue, NULL, FALSE);

		// section_04_title
		$this->section_04_title->SetDbValueDef($rsnew, $this->section_04_title->CurrentValue, NULL, FALSE);

		// section_04_title_ar
		$this->section_04_title_ar->SetDbValueDef($rsnew, $this->section_04_title_ar->CurrentValue, NULL, FALSE);

		// section_04_summary
		$this->section_04_summary->SetDbValueDef($rsnew, $this->section_04_summary->CurrentValue, NULL, FALSE);

		// section_04_summary_ar
		$this->section_04_summary_ar->SetDbValueDef($rsnew, $this->section_04_summary_ar->CurrentValue, NULL, FALSE);

		// section_04_icon
		$this->section_04_icon->SetDbValueDef($rsnew, $this->section_04_icon->CurrentValue, NULL, FALSE);
		if ($this->sliderImage->Visible && !$this->sliderImage->Upload->KeepFile) {
			$this->sliderImage->UploadPath = 'uploads/campaign';
			$OldFiles = ew_Empty($this->sliderImage->Upload->DbValue) ? array() : array($this->sliderImage->Upload->DbValue);
			if (!ew_Empty($this->sliderImage->Upload->FileName)) {
				$NewFiles = array($this->sliderImage->Upload->FileName);
				$NewFileCount = count($NewFiles);
				for ($i = 0; $i < $NewFileCount; $i++) {
					$fldvar = ($this->sliderImage->Upload->Index < 0) ? $this->sliderImage->FldVar : substr($this->sliderImage->FldVar, 0, 1) . $this->sliderImage->Upload->Index . substr($this->sliderImage->FldVar, 1);
					if ($NewFiles[$i] <> "") {
						$file = $NewFiles[$i];
						if (file_exists(ew_UploadTempPath($fldvar, $this->sliderImage->TblVar) . $file)) {
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
							$file1 = ew_UploadFileNameEx($this->sliderImage->PhysicalUploadPath(), $file); // Get new file name
							if ($file1 <> $file) { // Rename temp file
								while (file_exists(ew_UploadTempPath($fldvar, $this->sliderImage->TblVar) . $file1) || file_exists($this->sliderImage->PhysicalUploadPath() . $file1)) // Make sure no file name clash
									$file1 = ew_UniqueFilename($this->sliderImage->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
								rename(ew_UploadTempPath($fldvar, $this->sliderImage->TblVar) . $file, ew_UploadTempPath($fldvar, $this->sliderImage->TblVar) . $file1);
								$NewFiles[$i] = $file1;
							}
						}
					}
				}
				$this->sliderImage->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
				$this->sliderImage->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				$this->sliderImage->SetDbValueDef($rsnew, $this->sliderImage->Upload->FileName, NULL, FALSE);
			}
		}
		if ($this->sliderImage_ar->Visible && !$this->sliderImage_ar->Upload->KeepFile) {
			$this->sliderImage_ar->UploadPath = 'uploads/campaign';
			$OldFiles = ew_Empty($this->sliderImage_ar->Upload->DbValue) ? array() : array($this->sliderImage_ar->Upload->DbValue);
			if (!ew_Empty($this->sliderImage_ar->Upload->FileName)) {
				$NewFiles = array($this->sliderImage_ar->Upload->FileName);
				$NewFileCount = count($NewFiles);
				for ($i = 0; $i < $NewFileCount; $i++) {
					$fldvar = ($this->sliderImage_ar->Upload->Index < 0) ? $this->sliderImage_ar->FldVar : substr($this->sliderImage_ar->FldVar, 0, 1) . $this->sliderImage_ar->Upload->Index . substr($this->sliderImage_ar->FldVar, 1);
					if ($NewFiles[$i] <> "") {
						$file = $NewFiles[$i];
						if (file_exists(ew_UploadTempPath($fldvar, $this->sliderImage_ar->TblVar) . $file)) {
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
							$file1 = ew_UploadFileNameEx($this->sliderImage_ar->PhysicalUploadPath(), $file); // Get new file name
							if ($file1 <> $file) { // Rename temp file
								while (file_exists(ew_UploadTempPath($fldvar, $this->sliderImage_ar->TblVar) . $file1) || file_exists($this->sliderImage_ar->PhysicalUploadPath() . $file1)) // Make sure no file name clash
									$file1 = ew_UniqueFilename($this->sliderImage_ar->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
								rename(ew_UploadTempPath($fldvar, $this->sliderImage_ar->TblVar) . $file, ew_UploadTempPath($fldvar, $this->sliderImage_ar->TblVar) . $file1);
								$NewFiles[$i] = $file1;
							}
						}
					}
				}
				$this->sliderImage_ar->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
				$this->sliderImage_ar->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				$this->sliderImage_ar->SetDbValueDef($rsnew, $this->sliderImage_ar->Upload->FileName, NULL, FALSE);
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
				if ($this->sliderImage->Visible && !$this->sliderImage->Upload->KeepFile) {
					$OldFiles = ew_Empty($this->sliderImage->Upload->DbValue) ? array() : array($this->sliderImage->Upload->DbValue);
					if (!ew_Empty($this->sliderImage->Upload->FileName)) {
						$NewFiles = array($this->sliderImage->Upload->FileName);
						$NewFiles2 = array($rsnew['sliderImage']);
						$NewFileCount = count($NewFiles);
						for ($i = 0; $i < $NewFileCount; $i++) {
							$fldvar = ($this->sliderImage->Upload->Index < 0) ? $this->sliderImage->FldVar : substr($this->sliderImage->FldVar, 0, 1) . $this->sliderImage->Upload->Index . substr($this->sliderImage->FldVar, 1);
							if ($NewFiles[$i] <> "") {
								$file = ew_UploadTempPath($fldvar, $this->sliderImage->TblVar) . $NewFiles[$i];
								if (file_exists($file)) {
									if (@$NewFiles2[$i] <> "") // Use correct file name
										$NewFiles[$i] = $NewFiles2[$i];
									if (!$this->sliderImage->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
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
							@unlink($this->sliderImage->OldPhysicalUploadPath() . $OldFiles[$i]);
					}
				}
				if ($this->sliderImage_ar->Visible && !$this->sliderImage_ar->Upload->KeepFile) {
					$OldFiles = ew_Empty($this->sliderImage_ar->Upload->DbValue) ? array() : array($this->sliderImage_ar->Upload->DbValue);
					if (!ew_Empty($this->sliderImage_ar->Upload->FileName)) {
						$NewFiles = array($this->sliderImage_ar->Upload->FileName);
						$NewFiles2 = array($rsnew['sliderImage_ar']);
						$NewFileCount = count($NewFiles);
						for ($i = 0; $i < $NewFileCount; $i++) {
							$fldvar = ($this->sliderImage_ar->Upload->Index < 0) ? $this->sliderImage_ar->FldVar : substr($this->sliderImage_ar->FldVar, 0, 1) . $this->sliderImage_ar->Upload->Index . substr($this->sliderImage_ar->FldVar, 1);
							if ($NewFiles[$i] <> "") {
								$file = ew_UploadTempPath($fldvar, $this->sliderImage_ar->TblVar) . $NewFiles[$i];
								if (file_exists($file)) {
									if (@$NewFiles2[$i] <> "") // Use correct file name
										$NewFiles[$i] = $NewFiles2[$i];
									if (!$this->sliderImage_ar->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
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
							@unlink($this->sliderImage_ar->OldPhysicalUploadPath() . $OldFiles[$i]);
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
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}

		// sliderImage
		ew_CleanUploadTempPath($this->sliderImage, $this->sliderImage->Upload->Index);

		// sliderImage_ar
		ew_CleanUploadTempPath($this->sliderImage_ar, $this->sliderImage_ar->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("campaign_aboutuslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Set up multi pages
	function SetupMultiPages() {
		$pages = new cSubPages();
		$pages->Style = "tabs";
		$pages->Add(0);
		$pages->Add(1);
		$pages->Add(2);
		$pages->Add(3);
		$pages->Add(4);
		$pages->Add(5);
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
if (!isset($campaign_aboutus_add)) $campaign_aboutus_add = new ccampaign_aboutus_add();

// Page init
$campaign_aboutus_add->Page_Init();

// Page main
$campaign_aboutus_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$campaign_aboutus_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcampaign_aboutusadd = new ew_Form("fcampaign_aboutusadd", "add");

// Validate form
fcampaign_aboutusadd.Validate = function() {
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
fcampaign_aboutusadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcampaign_aboutusadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Multi-Page
fcampaign_aboutusadd.MultiPage = new ew_MultiPage("fcampaign_aboutusadd");

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $campaign_aboutus_add->ShowPageHeader(); ?>
<?php
$campaign_aboutus_add->ShowMessage();
?>
<form name="fcampaign_aboutusadd" id="fcampaign_aboutusadd" class="<?php echo $campaign_aboutus_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($campaign_aboutus_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $campaign_aboutus_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="campaign_aboutus">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($campaign_aboutus_add->IsModal) ?>">
<div class="ewMultiPage"><!-- multi-page -->
<div class="nav-tabs-custom" id="campaign_aboutus_add"><!-- multi-page .nav-tabs-custom -->
	<ul class="nav<?php echo $campaign_aboutus_add->MultiPages->NavStyle() ?>">
		<li<?php echo $campaign_aboutus_add->MultiPages->TabStyle("1") ?>><a href="#tab_campaign_aboutus1" data-toggle="tab"><?php echo $campaign_aboutus->PageCaption(1) ?></a></li>
		<li<?php echo $campaign_aboutus_add->MultiPages->TabStyle("2") ?>><a href="#tab_campaign_aboutus2" data-toggle="tab"><?php echo $campaign_aboutus->PageCaption(2) ?></a></li>
		<li<?php echo $campaign_aboutus_add->MultiPages->TabStyle("3") ?>><a href="#tab_campaign_aboutus3" data-toggle="tab"><?php echo $campaign_aboutus->PageCaption(3) ?></a></li>
		<li<?php echo $campaign_aboutus_add->MultiPages->TabStyle("4") ?>><a href="#tab_campaign_aboutus4" data-toggle="tab"><?php echo $campaign_aboutus->PageCaption(4) ?></a></li>
		<li<?php echo $campaign_aboutus_add->MultiPages->TabStyle("5") ?>><a href="#tab_campaign_aboutus5" data-toggle="tab"><?php echo $campaign_aboutus->PageCaption(5) ?></a></li>
	</ul>
	<div class="tab-content"><!-- multi-page .nav-tabs-custom .tab-content -->
		<div class="tab-pane<?php echo $campaign_aboutus_add->MultiPages->PageStyle("1") ?>" id="tab_campaign_aboutus1"><!-- multi-page .tab-pane -->
<div class="ewAddDiv"><!-- page* -->
<?php if ($campaign_aboutus->title->Visible) { // title ?>
	<div id="r_title" class="form-group">
		<label id="elh_campaign_aboutus_title" for="x_title" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->title->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->title->CellAttributes() ?>>
<span id="el_campaign_aboutus_title">
<input type="text" data-table="campaign_aboutus" data-field="x_title" data-page="1" name="x_title" id="x_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->title->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->title->EditValue ?>"<?php echo $campaign_aboutus->title->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->title_ar->Visible) { // title_ar ?>
	<div id="r_title_ar" class="form-group">
		<label id="elh_campaign_aboutus_title_ar" for="x_title_ar" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->title_ar->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->title_ar->CellAttributes() ?>>
<span id="el_campaign_aboutus_title_ar">
<input type="text" data-table="campaign_aboutus" data-field="x_title_ar" data-page="1" name="x_title_ar" id="x_title_ar" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->title_ar->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->title_ar->EditValue ?>"<?php echo $campaign_aboutus->title_ar->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->title_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->sliderImage->Visible) { // sliderImage ?>
	<div id="r_sliderImage" class="form-group">
		<label id="elh_campaign_aboutus_sliderImage" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->sliderImage->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->sliderImage->CellAttributes() ?>>
<span id="el_campaign_aboutus_sliderImage">
<div id="fd_x_sliderImage">
<span title="<?php echo $campaign_aboutus->sliderImage->FldTitle() ? $campaign_aboutus->sliderImage->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($campaign_aboutus->sliderImage->ReadOnly || $campaign_aboutus->sliderImage->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="campaign_aboutus" data-field="x_sliderImage" data-page="1" name="x_sliderImage" id="x_sliderImage"<?php echo $campaign_aboutus->sliderImage->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_sliderImage" id= "fn_x_sliderImage" value="<?php echo $campaign_aboutus->sliderImage->Upload->FileName ?>">
<input type="hidden" name="fa_x_sliderImage" id= "fa_x_sliderImage" value="0">
<input type="hidden" name="fs_x_sliderImage" id= "fs_x_sliderImage" value="255">
<input type="hidden" name="fx_x_sliderImage" id= "fx_x_sliderImage" value="<?php echo $campaign_aboutus->sliderImage->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_sliderImage" id= "fm_x_sliderImage" value="<?php echo $campaign_aboutus->sliderImage->UploadMaxFileSize ?>">
</div>
<table id="ft_x_sliderImage" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $campaign_aboutus->sliderImage->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->sliderImage_ar->Visible) { // sliderImage_ar ?>
	<div id="r_sliderImage_ar" class="form-group">
		<label id="elh_campaign_aboutus_sliderImage_ar" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->sliderImage_ar->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->sliderImage_ar->CellAttributes() ?>>
<span id="el_campaign_aboutus_sliderImage_ar">
<div id="fd_x_sliderImage_ar">
<span title="<?php echo $campaign_aboutus->sliderImage_ar->FldTitle() ? $campaign_aboutus->sliderImage_ar->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($campaign_aboutus->sliderImage_ar->ReadOnly || $campaign_aboutus->sliderImage_ar->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="campaign_aboutus" data-field="x_sliderImage_ar" data-page="1" name="x_sliderImage_ar" id="x_sliderImage_ar"<?php echo $campaign_aboutus->sliderImage_ar->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_sliderImage_ar" id= "fn_x_sliderImage_ar" value="<?php echo $campaign_aboutus->sliderImage_ar->Upload->FileName ?>">
<input type="hidden" name="fa_x_sliderImage_ar" id= "fa_x_sliderImage_ar" value="0">
<input type="hidden" name="fs_x_sliderImage_ar" id= "fs_x_sliderImage_ar" value="255">
<input type="hidden" name="fx_x_sliderImage_ar" id= "fx_x_sliderImage_ar" value="<?php echo $campaign_aboutus->sliderImage_ar->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_sliderImage_ar" id= "fm_x_sliderImage_ar" value="<?php echo $campaign_aboutus->sliderImage_ar->UploadMaxFileSize ?>">
</div>
<table id="ft_x_sliderImage_ar" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $campaign_aboutus->sliderImage_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->description->Visible) { // description ?>
	<div id="r_description" class="form-group">
		<label id="elh_campaign_aboutus_description" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->description->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->description->CellAttributes() ?>>
<span id="el_campaign_aboutus_description">
<?php ew_AppendClass($campaign_aboutus->description->EditAttrs["class"], "editor"); ?>
<textarea data-table="campaign_aboutus" data-field="x_description" data-page="1" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->description->getPlaceHolder()) ?>"<?php echo $campaign_aboutus->description->EditAttributes() ?>><?php echo $campaign_aboutus->description->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fcampaign_aboutusadd", "x_description", 35, 4, <?php echo ($campaign_aboutus->description->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $campaign_aboutus->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->description_ar->Visible) { // description_ar ?>
	<div id="r_description_ar" class="form-group">
		<label id="elh_campaign_aboutus_description_ar" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->description_ar->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->description_ar->CellAttributes() ?>>
<span id="el_campaign_aboutus_description_ar">
<?php ew_AppendClass($campaign_aboutus->description_ar->EditAttrs["class"], "editor"); ?>
<textarea data-table="campaign_aboutus" data-field="x_description_ar" data-page="1" name="x_description_ar" id="x_description_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->description_ar->getPlaceHolder()) ?>"<?php echo $campaign_aboutus->description_ar->EditAttributes() ?>><?php echo $campaign_aboutus->description_ar->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fcampaign_aboutusadd", "x_description_ar", 35, 4, <?php echo ($campaign_aboutus->description_ar->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $campaign_aboutus->description_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
		<div class="tab-pane<?php echo $campaign_aboutus_add->MultiPages->PageStyle("2") ?>" id="tab_campaign_aboutus2"><!-- multi-page .tab-pane -->
<div class="ewAddDiv"><!-- page* -->
<?php if ($campaign_aboutus->section_01_title->Visible) { // section_01_title ?>
	<div id="r_section_01_title" class="form-group">
		<label id="elh_campaign_aboutus_section_01_title" for="x_section_01_title" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_01_title->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_01_title->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_01_title">
<input type="text" data-table="campaign_aboutus" data-field="x_section_01_title" data-page="2" name="x_section_01_title" id="x_section_01_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_01_title->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_01_title->EditValue ?>"<?php echo $campaign_aboutus->section_01_title->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_01_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_01_title_ar->Visible) { // section_01_title_ar ?>
	<div id="r_section_01_title_ar" class="form-group">
		<label id="elh_campaign_aboutus_section_01_title_ar" for="x_section_01_title_ar" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_01_title_ar->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_01_title_ar->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_01_title_ar">
<input type="text" data-table="campaign_aboutus" data-field="x_section_01_title_ar" data-page="2" name="x_section_01_title_ar" id="x_section_01_title_ar" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_01_title_ar->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_01_title_ar->EditValue ?>"<?php echo $campaign_aboutus->section_01_title_ar->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_01_title_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_01_summary->Visible) { // section_01_summary ?>
	<div id="r_section_01_summary" class="form-group">
		<label id="elh_campaign_aboutus_section_01_summary" for="x_section_01_summary" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_01_summary->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_01_summary->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_01_summary">
<input type="text" data-table="campaign_aboutus" data-field="x_section_01_summary" data-page="2" name="x_section_01_summary" id="x_section_01_summary" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_01_summary->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_01_summary->EditValue ?>"<?php echo $campaign_aboutus->section_01_summary->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_01_summary->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_01_summary_ar->Visible) { // section_01_summary_ar ?>
	<div id="r_section_01_summary_ar" class="form-group">
		<label id="elh_campaign_aboutus_section_01_summary_ar" for="x_section_01_summary_ar" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_01_summary_ar->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_01_summary_ar->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_01_summary_ar">
<input type="text" data-table="campaign_aboutus" data-field="x_section_01_summary_ar" data-page="2" name="x_section_01_summary_ar" id="x_section_01_summary_ar" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_01_summary_ar->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_01_summary_ar->EditValue ?>"<?php echo $campaign_aboutus->section_01_summary_ar->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_01_summary_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_01_icon->Visible) { // section_01_icon ?>
	<div id="r_section_01_icon" class="form-group">
		<label id="elh_campaign_aboutus_section_01_icon" for="x_section_01_icon" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_01_icon->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_01_icon->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_01_icon">
<input type="text" data-table="campaign_aboutus" data-field="x_section_01_icon" data-page="2" name="x_section_01_icon" id="x_section_01_icon" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_01_icon->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_01_icon->EditValue ?>"<?php echo $campaign_aboutus->section_01_icon->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_01_icon->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
		<div class="tab-pane<?php echo $campaign_aboutus_add->MultiPages->PageStyle("3") ?>" id="tab_campaign_aboutus3"><!-- multi-page .tab-pane -->
<div class="ewAddDiv"><!-- page* -->
<?php if ($campaign_aboutus->section_02_title->Visible) { // section_02_title ?>
	<div id="r_section_02_title" class="form-group">
		<label id="elh_campaign_aboutus_section_02_title" for="x_section_02_title" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_02_title->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_02_title->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_02_title">
<input type="text" data-table="campaign_aboutus" data-field="x_section_02_title" data-page="3" name="x_section_02_title" id="x_section_02_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_02_title->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_02_title->EditValue ?>"<?php echo $campaign_aboutus->section_02_title->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_02_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_02_title_ar->Visible) { // section_02_title_ar ?>
	<div id="r_section_02_title_ar" class="form-group">
		<label id="elh_campaign_aboutus_section_02_title_ar" for="x_section_02_title_ar" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_02_title_ar->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_02_title_ar->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_02_title_ar">
<input type="text" data-table="campaign_aboutus" data-field="x_section_02_title_ar" data-page="3" name="x_section_02_title_ar" id="x_section_02_title_ar" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_02_title_ar->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_02_title_ar->EditValue ?>"<?php echo $campaign_aboutus->section_02_title_ar->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_02_title_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_02_summary->Visible) { // section_02_summary ?>
	<div id="r_section_02_summary" class="form-group">
		<label id="elh_campaign_aboutus_section_02_summary" for="x_section_02_summary" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_02_summary->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_02_summary->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_02_summary">
<input type="text" data-table="campaign_aboutus" data-field="x_section_02_summary" data-page="3" name="x_section_02_summary" id="x_section_02_summary" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_02_summary->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_02_summary->EditValue ?>"<?php echo $campaign_aboutus->section_02_summary->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_02_summary->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_02_summary_ar->Visible) { // section_02_summary_ar ?>
	<div id="r_section_02_summary_ar" class="form-group">
		<label id="elh_campaign_aboutus_section_02_summary_ar" for="x_section_02_summary_ar" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_02_summary_ar->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_02_summary_ar->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_02_summary_ar">
<input type="text" data-table="campaign_aboutus" data-field="x_section_02_summary_ar" data-page="3" name="x_section_02_summary_ar" id="x_section_02_summary_ar" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_02_summary_ar->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_02_summary_ar->EditValue ?>"<?php echo $campaign_aboutus->section_02_summary_ar->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_02_summary_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_02_icon->Visible) { // section_02_icon ?>
	<div id="r_section_02_icon" class="form-group">
		<label id="elh_campaign_aboutus_section_02_icon" for="x_section_02_icon" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_02_icon->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_02_icon->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_02_icon">
<input type="text" data-table="campaign_aboutus" data-field="x_section_02_icon" data-page="3" name="x_section_02_icon" id="x_section_02_icon" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_02_icon->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_02_icon->EditValue ?>"<?php echo $campaign_aboutus->section_02_icon->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_02_icon->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
		<div class="tab-pane<?php echo $campaign_aboutus_add->MultiPages->PageStyle("4") ?>" id="tab_campaign_aboutus4"><!-- multi-page .tab-pane -->
<div class="ewAddDiv"><!-- page* -->
<?php if ($campaign_aboutus->section_03_title->Visible) { // section_03_title ?>
	<div id="r_section_03_title" class="form-group">
		<label id="elh_campaign_aboutus_section_03_title" for="x_section_03_title" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_03_title->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_03_title->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_03_title">
<input type="text" data-table="campaign_aboutus" data-field="x_section_03_title" data-page="4" name="x_section_03_title" id="x_section_03_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_03_title->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_03_title->EditValue ?>"<?php echo $campaign_aboutus->section_03_title->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_03_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_03_title_ar->Visible) { // section_03_title_ar ?>
	<div id="r_section_03_title_ar" class="form-group">
		<label id="elh_campaign_aboutus_section_03_title_ar" for="x_section_03_title_ar" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_03_title_ar->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_03_title_ar->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_03_title_ar">
<input type="text" data-table="campaign_aboutus" data-field="x_section_03_title_ar" data-page="4" name="x_section_03_title_ar" id="x_section_03_title_ar" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_03_title_ar->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_03_title_ar->EditValue ?>"<?php echo $campaign_aboutus->section_03_title_ar->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_03_title_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_03_summary->Visible) { // section_03_summary ?>
	<div id="r_section_03_summary" class="form-group">
		<label id="elh_campaign_aboutus_section_03_summary" for="x_section_03_summary" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_03_summary->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_03_summary->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_03_summary">
<input type="text" data-table="campaign_aboutus" data-field="x_section_03_summary" data-page="4" name="x_section_03_summary" id="x_section_03_summary" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_03_summary->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_03_summary->EditValue ?>"<?php echo $campaign_aboutus->section_03_summary->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_03_summary->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_03_summary_ar->Visible) { // section_03_summary_ar ?>
	<div id="r_section_03_summary_ar" class="form-group">
		<label id="elh_campaign_aboutus_section_03_summary_ar" for="x_section_03_summary_ar" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_03_summary_ar->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_03_summary_ar->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_03_summary_ar">
<input type="text" data-table="campaign_aboutus" data-field="x_section_03_summary_ar" data-page="4" name="x_section_03_summary_ar" id="x_section_03_summary_ar" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_03_summary_ar->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_03_summary_ar->EditValue ?>"<?php echo $campaign_aboutus->section_03_summary_ar->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_03_summary_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_03_icon->Visible) { // section_03_icon ?>
	<div id="r_section_03_icon" class="form-group">
		<label id="elh_campaign_aboutus_section_03_icon" for="x_section_03_icon" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_03_icon->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_03_icon->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_03_icon">
<input type="text" data-table="campaign_aboutus" data-field="x_section_03_icon" data-page="4" name="x_section_03_icon" id="x_section_03_icon" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_03_icon->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_03_icon->EditValue ?>"<?php echo $campaign_aboutus->section_03_icon->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_03_icon->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
		<div class="tab-pane<?php echo $campaign_aboutus_add->MultiPages->PageStyle("5") ?>" id="tab_campaign_aboutus5"><!-- multi-page .tab-pane -->
<div class="ewAddDiv"><!-- page* -->
<?php if ($campaign_aboutus->section_04_title->Visible) { // section_04_title ?>
	<div id="r_section_04_title" class="form-group">
		<label id="elh_campaign_aboutus_section_04_title" for="x_section_04_title" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_04_title->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_04_title->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_04_title">
<input type="text" data-table="campaign_aboutus" data-field="x_section_04_title" data-page="5" name="x_section_04_title" id="x_section_04_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_04_title->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_04_title->EditValue ?>"<?php echo $campaign_aboutus->section_04_title->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_04_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_04_title_ar->Visible) { // section_04_title_ar ?>
	<div id="r_section_04_title_ar" class="form-group">
		<label id="elh_campaign_aboutus_section_04_title_ar" for="x_section_04_title_ar" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_04_title_ar->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_04_title_ar->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_04_title_ar">
<input type="text" data-table="campaign_aboutus" data-field="x_section_04_title_ar" data-page="5" name="x_section_04_title_ar" id="x_section_04_title_ar" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_04_title_ar->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_04_title_ar->EditValue ?>"<?php echo $campaign_aboutus->section_04_title_ar->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_04_title_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_04_summary->Visible) { // section_04_summary ?>
	<div id="r_section_04_summary" class="form-group">
		<label id="elh_campaign_aboutus_section_04_summary" for="x_section_04_summary" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_04_summary->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_04_summary->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_04_summary">
<input type="text" data-table="campaign_aboutus" data-field="x_section_04_summary" data-page="5" name="x_section_04_summary" id="x_section_04_summary" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_04_summary->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_04_summary->EditValue ?>"<?php echo $campaign_aboutus->section_04_summary->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_04_summary->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_04_summary_ar->Visible) { // section_04_summary_ar ?>
	<div id="r_section_04_summary_ar" class="form-group">
		<label id="elh_campaign_aboutus_section_04_summary_ar" for="x_section_04_summary_ar" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_04_summary_ar->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_04_summary_ar->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_04_summary_ar">
<input type="text" data-table="campaign_aboutus" data-field="x_section_04_summary_ar" data-page="5" name="x_section_04_summary_ar" id="x_section_04_summary_ar" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_04_summary_ar->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_04_summary_ar->EditValue ?>"<?php echo $campaign_aboutus->section_04_summary_ar->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_04_summary_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($campaign_aboutus->section_04_icon->Visible) { // section_04_icon ?>
	<div id="r_section_04_icon" class="form-group">
		<label id="elh_campaign_aboutus_section_04_icon" for="x_section_04_icon" class="<?php echo $campaign_aboutus_add->LeftColumnClass ?>"><?php echo $campaign_aboutus->section_04_icon->FldCaption() ?></label>
		<div class="<?php echo $campaign_aboutus_add->RightColumnClass ?>"><div<?php echo $campaign_aboutus->section_04_icon->CellAttributes() ?>>
<span id="el_campaign_aboutus_section_04_icon">
<input type="text" data-table="campaign_aboutus" data-field="x_section_04_icon" data-page="5" name="x_section_04_icon" id="x_section_04_icon" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($campaign_aboutus->section_04_icon->getPlaceHolder()) ?>" value="<?php echo $campaign_aboutus->section_04_icon->EditValue ?>"<?php echo $campaign_aboutus->section_04_icon->EditAttributes() ?>>
</span>
<?php echo $campaign_aboutus->section_04_icon->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
	</div><!-- /multi-page .nav-tabs-custom .tab-content -->
</div><!-- /multi-page .nav-tabs-custom -->
</div><!-- /multi-page -->
<?php if (!$campaign_aboutus_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $campaign_aboutus_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $campaign_aboutus_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcampaign_aboutusadd.Init();
</script>
<?php
$campaign_aboutus_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$campaign_aboutus_add->Page_Terminate();
?>
