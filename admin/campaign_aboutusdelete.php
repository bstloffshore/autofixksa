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

$campaign_aboutus_delete = NULL; // Initialize page object first

class ccampaign_aboutus_delete extends ccampaign_aboutus {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{8281128E-C7BB-40DA-A1AE-8695DB7283AC}';

	// Table name
	var $TableName = 'campaign_aboutus';

	// Page object name
	var $PageObjName = 'campaign_aboutus_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("campaign_aboutuslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->title->SetVisibility();
		$this->title_ar->SetVisibility();
		$this->campaignSlug->SetVisibility();
		$this->sliderImage->SetVisibility();
		$this->sliderImage_ar->SetVisibility();

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
			$this->Page_Terminate("campaign_aboutuslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in campaign_aboutus class, campaign_aboutusinfo.php

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
				$this->Page_Terminate("campaign_aboutuslist.php"); // Return to list
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
		$this->id->setDbValue($row['id']);
		$this->title->setDbValue($row['title']);
		$this->title_ar->setDbValue($row['title_ar']);
		$this->campaignSlug->setDbValue($row['campaignSlug']);
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
		$row = array();
		$row['id'] = NULL;
		$row['title'] = NULL;
		$row['title_ar'] = NULL;
		$row['campaignSlug'] = NULL;
		$row['sliderImage'] = NULL;
		$row['sliderImage_ar'] = NULL;
		$row['description'] = NULL;
		$row['description_ar'] = NULL;
		$row['section_01_title'] = NULL;
		$row['section_01_title_ar'] = NULL;
		$row['section_01_summary'] = NULL;
		$row['section_01_summary_ar'] = NULL;
		$row['section_01_icon'] = NULL;
		$row['section_02_title'] = NULL;
		$row['section_02_title_ar'] = NULL;
		$row['section_02_summary'] = NULL;
		$row['section_02_summary_ar'] = NULL;
		$row['section_02_icon'] = NULL;
		$row['section_03_title'] = NULL;
		$row['section_03_title_ar'] = NULL;
		$row['section_03_summary'] = NULL;
		$row['section_03_summary_ar'] = NULL;
		$row['section_03_icon'] = NULL;
		$row['section_04_title'] = NULL;
		$row['section_04_title_ar'] = NULL;
		$row['section_04_summary'] = NULL;
		$row['section_04_summary_ar'] = NULL;
		$row['section_04_icon'] = NULL;
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
		$this->campaignSlug->DbValue = $row['campaignSlug'];
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

		// campaignSlug
		$this->campaignSlug->ViewValue = $this->campaignSlug->CurrentValue;
		$this->campaignSlug->ViewCustomAttributes = "";

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

			// campaignSlug
			$this->campaignSlug->LinkCustomAttributes = "";
			$this->campaignSlug->HrefValue = "";
			$this->campaignSlug->TooltipValue = "";

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
				$sThisKey .= $row['id'];

				// Delete old files
				$this->LoadDbValues($row);
				$this->sliderImage->OldUploadPath = 'uploads/campaign';
				$OldFiles = ew_Empty($row['sliderImage']) ? array() : array($row['sliderImage']);
				$OldFileCount = count($OldFiles);
				for ($i = 0; $i < $OldFileCount; $i++) {
					if (file_exists($this->sliderImage->OldPhysicalUploadPath() . $OldFiles[$i]))
						@unlink($this->sliderImage->OldPhysicalUploadPath() . $OldFiles[$i]);
				}
				$this->sliderImage_ar->OldUploadPath = 'uploads/campaign';
				$OldFiles = ew_Empty($row['sliderImage_ar']) ? array() : array($row['sliderImage_ar']);
				$OldFileCount = count($OldFiles);
				for ($i = 0; $i < $OldFileCount; $i++) {
					if (file_exists($this->sliderImage_ar->OldPhysicalUploadPath() . $OldFiles[$i]))
						@unlink($this->sliderImage_ar->OldPhysicalUploadPath() . $OldFiles[$i]);
				}
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("campaign_aboutuslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($campaign_aboutus_delete)) $campaign_aboutus_delete = new ccampaign_aboutus_delete();

// Page init
$campaign_aboutus_delete->Page_Init();

// Page main
$campaign_aboutus_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$campaign_aboutus_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fcampaign_aboutusdelete = new ew_Form("fcampaign_aboutusdelete", "delete");

// Form_CustomValidate event
fcampaign_aboutusdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcampaign_aboutusdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $campaign_aboutus_delete->ShowPageHeader(); ?>
<?php
$campaign_aboutus_delete->ShowMessage();
?>
<form name="fcampaign_aboutusdelete" id="fcampaign_aboutusdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($campaign_aboutus_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $campaign_aboutus_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="campaign_aboutus">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($campaign_aboutus_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($campaign_aboutus->id->Visible) { // id ?>
		<th class="<?php echo $campaign_aboutus->id->HeaderCellClass() ?>"><span id="elh_campaign_aboutus_id" class="campaign_aboutus_id"><?php echo $campaign_aboutus->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($campaign_aboutus->title->Visible) { // title ?>
		<th class="<?php echo $campaign_aboutus->title->HeaderCellClass() ?>"><span id="elh_campaign_aboutus_title" class="campaign_aboutus_title"><?php echo $campaign_aboutus->title->FldCaption() ?></span></th>
<?php } ?>
<?php if ($campaign_aboutus->title_ar->Visible) { // title_ar ?>
		<th class="<?php echo $campaign_aboutus->title_ar->HeaderCellClass() ?>"><span id="elh_campaign_aboutus_title_ar" class="campaign_aboutus_title_ar"><?php echo $campaign_aboutus->title_ar->FldCaption() ?></span></th>
<?php } ?>
<?php if ($campaign_aboutus->campaignSlug->Visible) { // campaignSlug ?>
		<th class="<?php echo $campaign_aboutus->campaignSlug->HeaderCellClass() ?>"><span id="elh_campaign_aboutus_campaignSlug" class="campaign_aboutus_campaignSlug"><?php echo $campaign_aboutus->campaignSlug->FldCaption() ?></span></th>
<?php } ?>
<?php if ($campaign_aboutus->sliderImage->Visible) { // sliderImage ?>
		<th class="<?php echo $campaign_aboutus->sliderImage->HeaderCellClass() ?>"><span id="elh_campaign_aboutus_sliderImage" class="campaign_aboutus_sliderImage"><?php echo $campaign_aboutus->sliderImage->FldCaption() ?></span></th>
<?php } ?>
<?php if ($campaign_aboutus->sliderImage_ar->Visible) { // sliderImage_ar ?>
		<th class="<?php echo $campaign_aboutus->sliderImage_ar->HeaderCellClass() ?>"><span id="elh_campaign_aboutus_sliderImage_ar" class="campaign_aboutus_sliderImage_ar"><?php echo $campaign_aboutus->sliderImage_ar->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$campaign_aboutus_delete->RecCnt = 0;
$i = 0;
while (!$campaign_aboutus_delete->Recordset->EOF) {
	$campaign_aboutus_delete->RecCnt++;
	$campaign_aboutus_delete->RowCnt++;

	// Set row properties
	$campaign_aboutus->ResetAttrs();
	$campaign_aboutus->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$campaign_aboutus_delete->LoadRowValues($campaign_aboutus_delete->Recordset);

	// Render row
	$campaign_aboutus_delete->RenderRow();
?>
	<tr<?php echo $campaign_aboutus->RowAttributes() ?>>
<?php if ($campaign_aboutus->id->Visible) { // id ?>
		<td<?php echo $campaign_aboutus->id->CellAttributes() ?>>
<span id="el<?php echo $campaign_aboutus_delete->RowCnt ?>_campaign_aboutus_id" class="campaign_aboutus_id">
<span<?php echo $campaign_aboutus->id->ViewAttributes() ?>>
<?php echo $campaign_aboutus->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($campaign_aboutus->title->Visible) { // title ?>
		<td<?php echo $campaign_aboutus->title->CellAttributes() ?>>
<span id="el<?php echo $campaign_aboutus_delete->RowCnt ?>_campaign_aboutus_title" class="campaign_aboutus_title">
<span<?php echo $campaign_aboutus->title->ViewAttributes() ?>>
<?php echo $campaign_aboutus->title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($campaign_aboutus->title_ar->Visible) { // title_ar ?>
		<td<?php echo $campaign_aboutus->title_ar->CellAttributes() ?>>
<span id="el<?php echo $campaign_aboutus_delete->RowCnt ?>_campaign_aboutus_title_ar" class="campaign_aboutus_title_ar">
<span<?php echo $campaign_aboutus->title_ar->ViewAttributes() ?>>
<?php echo $campaign_aboutus->title_ar->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($campaign_aboutus->campaignSlug->Visible) { // campaignSlug ?>
		<td<?php echo $campaign_aboutus->campaignSlug->CellAttributes() ?>>
<span id="el<?php echo $campaign_aboutus_delete->RowCnt ?>_campaign_aboutus_campaignSlug" class="campaign_aboutus_campaignSlug">
<span<?php echo $campaign_aboutus->campaignSlug->ViewAttributes() ?>>
<?php echo $campaign_aboutus->campaignSlug->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($campaign_aboutus->sliderImage->Visible) { // sliderImage ?>
		<td<?php echo $campaign_aboutus->sliderImage->CellAttributes() ?>>
<span id="el<?php echo $campaign_aboutus_delete->RowCnt ?>_campaign_aboutus_sliderImage" class="campaign_aboutus_sliderImage">
<span>
<?php echo ew_GetFileViewTag($campaign_aboutus->sliderImage, $campaign_aboutus->sliderImage->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($campaign_aboutus->sliderImage_ar->Visible) { // sliderImage_ar ?>
		<td<?php echo $campaign_aboutus->sliderImage_ar->CellAttributes() ?>>
<span id="el<?php echo $campaign_aboutus_delete->RowCnt ?>_campaign_aboutus_sliderImage_ar" class="campaign_aboutus_sliderImage_ar">
<span>
<?php echo ew_GetFileViewTag($campaign_aboutus->sliderImage_ar, $campaign_aboutus->sliderImage_ar->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$campaign_aboutus_delete->Recordset->MoveNext();
}
$campaign_aboutus_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $campaign_aboutus_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fcampaign_aboutusdelete.Init();
</script>
<?php
$campaign_aboutus_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$campaign_aboutus_delete->Page_Terminate();
?>
