<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "slidersinfo.php" ?>
<?php include_once "cms_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$sliders_view = NULL; // Initialize page object first

class csliders_view extends csliders {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{8281128E-C7BB-40DA-A1AE-8695DB7283AC}';

	// Table name
	var $TableName = 'sliders';

	// Page object name
	var $PageObjName = 'sliders_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Table object (sliders)
		if (!isset($GLOBALS["sliders"]) || get_class($GLOBALS["sliders"]) == "csliders") {
			$GLOBALS["sliders"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["sliders"];
		}
		$KeyUrl = "";
		if (@$_GET["sliderID"] <> "") {
			$this->RecKey["sliderID"] = $_GET["sliderID"];
			$KeyUrl .= "&amp;sliderID=" . urlencode($this->RecKey["sliderID"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (cms_users)
		if (!isset($GLOBALS['cms_users'])) $GLOBALS['cms_users'] = new ccms_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'sliders', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("sliderslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 
		// Get export parameters

		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} elseif (@$_GET["cmd"] == "json") {
			$this->Export = $_GET["cmd"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header
		if (@$_GET["sliderID"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= $_GET["sliderID"];
		}

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Setup export options
		$this->SetupExportOptions();
		$this->sliderID->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->sliderID->Visible = FALSE;
		$this->title->SetVisibility();
		$this->title_ar->SetVisibility();
		$this->image->SetVisibility();
		$this->summary->SetVisibility();
		$this->summary_ar->SetVisibility();
		$this->buttonLabel->SetVisibility();
		$this->buttonLabel_ar->SetVisibility();
		$this->buttonlinkTo->SetVisibility();
		$this->so->SetVisibility();
		$this->active->SetVisibility();
		$this->campaign_title->SetVisibility();
		$this->campain_slug->SetVisibility();
		$this->campaign_start_date->SetVisibility();
		$this->campaign_end_date->SetVisibility();
		$this->is_general_image->SetVisibility();

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
		global $EW_EXPORT, $sliders;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($sliders);
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
					if ($pageName == "slidersview.php")
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;
	var $MultiPages; // Multi pages object

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $gbSkipHeaderFooter, $EW_EXPORT;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["sliderID"] <> "") {
				$this->sliderID->setQueryStringValue($_GET["sliderID"]);
				$this->RecKey["sliderID"] = $this->sliderID->QueryStringValue;
			} elseif (@$_POST["sliderID"] <> "") {
				$this->sliderID->setFormValue($_POST["sliderID"]);
				$this->RecKey["sliderID"] = $this->sliderID->FormValue;
			} else {
				$sReturnUrl = "sliderslist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "sliderslist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array_keys($EW_EXPORT))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "sliderslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddQuery($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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
		$this->sliderID->setDbValue($row['sliderID']);
		$this->title->setDbValue($row['title']);
		$this->title_ar->setDbValue($row['title_ar']);
		$this->image->Upload->DbValue = $row['image'];
		$this->image->setDbValue($this->image->Upload->DbValue);
		$this->summary->setDbValue($row['summary']);
		$this->summary_ar->setDbValue($row['summary_ar']);
		$this->buttonLabel->setDbValue($row['buttonLabel']);
		$this->buttonLabel_ar->setDbValue($row['buttonLabel_ar']);
		$this->buttonlinkTo->setDbValue($row['buttonlinkTo']);
		$this->so->setDbValue($row['so']);
		$this->active->setDbValue($row['active']);
		$this->campaign_title->setDbValue($row['campaign_title']);
		$this->campain_slug->setDbValue($row['campain_slug']);
		$this->campaign_start_date->setDbValue($row['campaign_start_date']);
		$this->campaign_end_date->setDbValue($row['campaign_end_date']);
		$this->is_general_image->setDbValue($row['is_general_image']);
		
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['sliderID'] = NULL;
		$row['title'] = NULL;
		$row['title_ar'] = NULL;
		$row['image'] = NULL;
		$row['summary'] = NULL;
		$row['summary_ar'] = NULL;
		$row['buttonLabel'] = NULL;
		$row['buttonLabel_ar'] = NULL;
		$row['buttonlinkTo'] = NULL;
		$row['so'] = NULL;
		$row['active'] = NULL;
		$row['campaign_title'] = NULL;
		$row['campain_slug'] = NULL;
		$row['campaign_start_date'] = NULL;
		$row['campaign_end_date'] = NULL;
		$row['is_general_image'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->sliderID->DbValue = $row['sliderID'];
		$this->title->DbValue = $row['title'];
		$this->title_ar->DbValue = $row['title_ar'];
		$this->image->Upload->DbValue = $row['image'];
		$this->summary->DbValue = $row['summary'];
		$this->summary_ar->DbValue = $row['summary_ar'];
		$this->buttonLabel->DbValue = $row['buttonLabel'];
		$this->buttonLabel_ar->DbValue = $row['buttonLabel_ar'];
		$this->buttonlinkTo->DbValue = $row['buttonlinkTo'];
		$this->so->DbValue = $row['so'];
		$this->active->DbValue = $row['active'];
		$this->campaign_title->DbValue = $row['campaign_title'];
		$this->campain_slug->DbValue = $row['campain_slug'];
		$this->campaign_start_date->DbValue = $row['campaign_start_date'];
		$this->campaign_end_date->DbValue = $row['campaign_end_date'];
		$this->is_general_image->DbValue = $row['is_general_image'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// sliderID
		// title
		// title_ar
		// image
		// summary
		// summary_ar
		// buttonLabel
		// buttonLabel_ar
		// buttonlinkTo
		// so
		// active

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// sliderID
		$this->sliderID->ViewValue = $this->sliderID->CurrentValue;
		$this->sliderID->ViewCustomAttributes = "";

		// title
		$this->title->ViewValue = $this->title->CurrentValue;
		$this->title->ViewCustomAttributes = "";

		// title_ar
		$this->title_ar->ViewValue = $this->title_ar->CurrentValue;
		$this->title_ar->ViewCustomAttributes = "";

		// image
		$this->image->UploadPath = 'uploads/sliders';
		if (!ew_Empty($this->image->Upload->DbValue)) {
			$this->image->ImageWidth = 100;
			$this->image->ImageHeight = 0;
			$this->image->ImageAlt = $this->image->FldAlt();
			$this->image->ViewValue = $this->image->Upload->DbValue;
		} else {
			$this->image->ViewValue = "";
		}
		$this->image->ViewCustomAttributes = "";

		// summary
		$this->summary->ViewValue = $this->summary->CurrentValue;
		$this->summary->ViewCustomAttributes = "";

		// summary_ar
		$this->summary_ar->ViewValue = $this->summary_ar->CurrentValue;
		$this->summary_ar->ViewCustomAttributes = "";

		// buttonLabel
		$this->buttonLabel->ViewValue = $this->buttonLabel->CurrentValue;
		$this->buttonLabel->ViewCustomAttributes = "";

		// buttonLabel_ar
		$this->buttonLabel_ar->ViewValue = $this->buttonLabel_ar->CurrentValue;
		$this->buttonLabel_ar->ViewCustomAttributes = "";

		// buttonlinkTo
		$this->buttonlinkTo->ViewValue = $this->buttonlinkTo->CurrentValue;
		$this->buttonlinkTo->ViewCustomAttributes = "";

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

		// campaign_title
		$this->campaign_title->ViewValue = $this->campaign_title->CurrentValue;
		$this->campaign_title->ViewCustomAttributes = "";

		// campain_slug
		$this->campain_slug->ViewValue = $this->campain_slug->CurrentValue;
		$this->campain_slug->ViewCustomAttributes = "";

		// campaign_start_date
		$this->campaign_start_date->ViewValue = $this->campaign_start_date->CurrentValue;
		$this->campaign_start_date->ViewCustomAttributes = "";

		// campaign_end_date
		$this->campaign_end_date->ViewValue = $this->campaign_end_date->CurrentValue;
		$this->campaign_end_date->ViewCustomAttributes = "";

		// is_general_image
		if (strval($this->is_general_image->CurrentValue) <> "") {
			$this->is_general_image->ViewValue = $this->is_general_image->OptionCaption($this->is_general_image->CurrentValue);
		} else {
			$this->is_general_image->ViewValue = NULL;
		}
		$this->is_general_image->ViewCustomAttributes = "";




			// sliderID
			$this->sliderID->LinkCustomAttributes = "";
			$this->sliderID->HrefValue = "";
			$this->sliderID->TooltipValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";
			$this->title->TooltipValue = "";

			// title_ar
			$this->title_ar->LinkCustomAttributes = "";
			$this->title_ar->HrefValue = "";
			$this->title_ar->TooltipValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->UploadPath = 'uploads/sliders';
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
				$this->image->LinkAttrs["data-rel"] = "sliders_x_image";
				ew_AppendClass($this->image->LinkAttrs["class"], "ewLightbox");
			}

			// summary
			$this->summary->LinkCustomAttributes = "";
			$this->summary->HrefValue = "";
			$this->summary->TooltipValue = "";

			// summary_ar
			$this->summary_ar->LinkCustomAttributes = "";
			$this->summary_ar->HrefValue = "";
			$this->summary_ar->TooltipValue = "";

			// buttonLabel
			$this->buttonLabel->LinkCustomAttributes = "";
			$this->buttonLabel->HrefValue = "";
			$this->buttonLabel->TooltipValue = "";

			// buttonLabel_ar
			$this->buttonLabel_ar->LinkCustomAttributes = "";
			$this->buttonLabel_ar->HrefValue = "";
			$this->buttonLabel_ar->TooltipValue = "";

			// buttonlinkTo
			$this->buttonlinkTo->LinkCustomAttributes = "";
			$this->buttonlinkTo->HrefValue = "";
			$this->buttonlinkTo->TooltipValue = "";

			// so
			$this->so->LinkCustomAttributes = "";
			$this->so->HrefValue = "";
			$this->so->TooltipValue = "";

			// active
			$this->active->LinkCustomAttributes = "";
			$this->active->HrefValue = "";
			$this->active->TooltipValue = "";

			// campaign_title
			$this->campaign_title->LinkCustomAttributes = "";
			$this->campaign_title->HrefValue = "";
			$this->campaign_title->TooltipValue = "";

			// campain_slug
			$this->campain_slug->LinkCustomAttributes = "";
			$this->campain_slug->HrefValue = "";
			$this->campain_slug->TooltipValue = "";

			// campaign_start_date
			$this->campaign_start_date->LinkCustomAttributes = "";
			$this->campaign_start_date->HrefValue = "";
			$this->campaign_start_date->TooltipValue = "";

			// campaign_end_date
			$this->campaign_end_date->LinkCustomAttributes = "";
			$this->campaign_end_date->HrefValue = "";
			$this->campaign_end_date->TooltipValue = "";

			// is_general_image
			$this->is_general_image->LinkCustomAttributes = "";
			$this->is_general_image->HrefValue = "";
			$this->is_general_image->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_sliders\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_sliders',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fslidersview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = TRUE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->ListRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;
		$this->SetupStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "v");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "view");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		if ($this->Export == "email") {
			echo $this->ExportEmail($Doc->Text);
		} else {
			$Doc->Export();
		}
	}

	// Export email
	function ExportEmail($EmailContent) {
		global $gTmpImages, $Language;
		$sSender = @$_POST["sender"];
		$sRecipient = @$_POST["recipient"];
		$sCc = @$_POST["cc"];
		$sBcc = @$_POST["bcc"];

		// Subject
		$sSubject = @$_POST["subject"];
		$sEmailSubject = $sSubject;

		// Message
		$sContent = @$_POST["message"];
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "") {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterSenderEmail") . "</p>";
		}
		if (!ew_CheckEmail($sSender)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperSenderEmail") . "</p>";
		}

		// Check recipient
		if (!ew_CheckEmailList($sRecipient, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperRecipientEmail") . "</p>";
		}

		// Check cc
		if (!ew_CheckEmailList($sCc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperCcEmail") . "</p>";
		}

		// Check bcc
		if (!ew_CheckEmailList($sBcc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperBccEmail") . "</p>";
		}

		// Check email sent count
		if (!isset($_SESSION[EW_EXPORT_EMAIL_COUNTER]))
			$_SESSION[EW_EXPORT_EMAIL_COUNTER] = 0;
		if (intval($_SESSION[EW_EXPORT_EMAIL_COUNTER]) > EW_MAX_EMAIL_SENT_COUNT) {
			return "<p class=\"text-danger\">" . $Language->Phrase("ExceedMaxEmailExport") . "</p>";
		}

		// Send email
		$Email = new cEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Format = "html";
		if ($sEmailMessage <> "")
			$sEmailMessage = ew_RemoveXSS($sEmailMessage) . "<br><br>";
		foreach ($gTmpImages as $tmpimage)
			$Email->AddEmbeddedImage($tmpimage);
		$Email->Content = $sEmailMessage . ew_CleanEmailContent($EmailContent); // Content
		$EventArgs = array();
		if ($this->Recordset) {
			$this->RecCnt = $this->StartRec - 1;
			$this->Recordset->MoveFirst();
			if ($this->StartRec > 1)
				$this->Recordset->Move($this->StartRec - 1);
			$EventArgs["rs"] = &$this->Recordset;
		}
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count
			$_SESSION[EW_EXPORT_EMAIL_COUNTER]++;

			// Sent email success
			return "<p class=\"text-success\">" . $Language->Phrase("SendEmailSuccess") . "</p>"; // Set up success message
		} else {

			// Sent email failure
			return "<p class=\"text-danger\">" . $Email->SendErrDescription . "</p>";
		}
	}

	// Export QueryString
	function ExportQueryString() {

		// Initialize
		$sQry = "export=html";

		// Add record key QueryString
		$sQry .= "&" . substr($this->KeyUrl("", ""), 1);
		return $sQry;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("sliderslist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($sliders_view)) $sliders_view = new csliders_view();

// Page init
$sliders_view->Page_Init();

// Page main
$sliders_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$sliders_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($sliders->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fslidersview = new ew_Form("fslidersview", "view");

// Form_CustomValidate event
fslidersview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fslidersview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Multi-Page
fslidersview.MultiPage = new ew_MultiPage("fslidersview");

// Dynamic selection lists
fslidersview.Lists["x_active"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fslidersview.Lists["x_active"].Options = <?php echo json_encode($sliders_view->active->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($sliders->Export == "") { ?>
<div class="ewToolbar">
<?php $sliders_view->ExportOptions->Render("body") ?>
<?php
	foreach ($sliders_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $sliders_view->ShowPageHeader(); ?>
<?php
$sliders_view->ShowMessage();
?>
<form name="fslidersview" id="fslidersview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($sliders_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $sliders_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="sliders">
<input type="hidden" name="modal" value="<?php echo intval($sliders_view->IsModal) ?>">
<?php if ($sliders->Export == "") { ?>
<div class="ewMultiPage">
<div class="nav-tabs-custom" id="sliders_view">
	<ul class="nav<?php echo $sliders_view->MultiPages->NavStyle() ?>">
		<li<?php echo $sliders_view->MultiPages->TabStyle("1") ?>><a href="#tab_sliders1" data-toggle="tab"><?php echo $sliders->PageCaption(1) ?></a></li>
		<li<?php echo $sliders_view->MultiPages->TabStyle("2") ?>><a href="#tab_sliders2" data-toggle="tab"><?php echo $sliders->PageCaption(2) ?></a></li>
	</ul>
	<div class="tab-content">
<?php } ?>
<?php if ($sliders->Export == "") { ?>
		<div class="tab-pane<?php echo $sliders_view->MultiPages->PageStyle("1") ?>" id="tab_sliders1">
<?php } ?>
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($sliders->sliderID->Visible) { // sliderID ?>
	<tr id="r_sliderID">
		<td class="col-sm-2"><span id="elh_sliders_sliderID"><?php echo $sliders->sliderID->FldCaption() ?></span></td>
		<td data-name="sliderID"<?php echo $sliders->sliderID->CellAttributes() ?>>
<span id="el_sliders_sliderID" data-page="1">
<span<?php echo $sliders->sliderID->ViewAttributes() ?>>
<?php echo $sliders->sliderID->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($sliders->title->Visible) { // title ?>
	<tr id="r_title">
		<td class="col-sm-2"><span id="elh_sliders_title"><?php echo $sliders->title->FldCaption() ?></span></td>
		<td data-name="title"<?php echo $sliders->title->CellAttributes() ?>>
<span id="el_sliders_title" data-page="1">
<span<?php echo $sliders->title->ViewAttributes() ?>>
<?php echo $sliders->title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($sliders->title_ar->Visible) { // title_ar ?>
	<tr id="r_title_ar">
		<td class="col-sm-2"><span id="elh_sliders_title_ar"><?php echo $sliders->title_ar->FldCaption() ?></span></td>
		<td data-name="title_ar"<?php echo $sliders->title_ar->CellAttributes() ?>>
<span id="el_sliders_title_ar" data-page="1">
<span<?php echo $sliders->title_ar->ViewAttributes() ?>>
<?php echo $sliders->title_ar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($sliders->campaign_title->Visible) { // campaign_title ?>
	<tr id="r_campaign_title">
		<td class="col-sm-2"><span id="elh_sliders_campaign_title"><?php echo $sliders->campaign_title->FldCaption() ?></span></td>
		<td data-name="campaign_title"<?php echo $sliders->campaign_title->CellAttributes() ?>>
<span id="el_sliders_campaign_title" data-page="1">
<span<?php echo $sliders->campaign_title->ViewAttributes() ?>>
<?php echo $sliders->campaign_title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($sliders->campain_slug->Visible) { // campain_slug ?>
	<tr id="r_campain_slug">
		<td class="col-sm-2"><span id="elh_sliders_campain_slug"><?php echo $sliders->campain_slug->FldCaption() ?></span></td>
		<td data-name="campain_slug"<?php echo $sliders->campain_slug->CellAttributes() ?>>
<span id="el_sliders_campain_slug" data-page="1">
<span<?php echo $sliders->campain_slug->ViewAttributes() ?>>
<?php echo $sliders->campain_slug->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($sliders->campaign_start_date->Visible) { // campaign_start_date ?>
	<tr id="r_campaign_start_date">
		<td class="col-sm-2"><span id="elh_sliders_campaign_start_date"><?php echo $sliders->campaign_start_date->FldCaption() ?></span></td>
		<td data-name="campaign_start_date"<?php echo $sliders->campaign_start_date->CellAttributes() ?>>
<span id="el_sliders_campaign_start_date" data-page="1">
<span<?php echo $sliders->campaign_start_date->ViewAttributes() ?>>
<?php echo $sliders->campaign_start_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($sliders->campaign_end_date->Visible) { // campaign_end_date ?>
	<tr id="r_campaign_end_date">
		<td class="col-sm-2"><span id="elh_sliders_campaign_end_date"><?php echo $sliders->campaign_end_date->FldCaption() ?></span></td>
		<td data-name="campaign_end_date"<?php echo $sliders->campaign_end_date->CellAttributes() ?>>
<span id="el_sliders_campaign_end_date" data-page="1">
<span<?php echo $sliders->campaign_end_date->ViewAttributes() ?>>
<?php echo $sliders->campaign_end_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($sliders->image->Visible) { // image ?>
	<tr id="r_image">
		<td class="col-sm-2"><span id="elh_sliders_image"><?php echo $sliders->image->FldCaption() ?></span></td>
		<td data-name="image"<?php echo $sliders->image->CellAttributes() ?>>
<span id="el_sliders_image" data-page="1">
<span>
<?php echo ew_GetFileViewTag($sliders->image, $sliders->image->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($sliders->buttonLabel->Visible) { // buttonLabel ?>
	<tr id="r_buttonLabel">
		<td class="col-sm-2"><span id="elh_sliders_buttonLabel"><?php echo $sliders->buttonLabel->FldCaption() ?></span></td>
		<td data-name="buttonLabel"<?php echo $sliders->buttonLabel->CellAttributes() ?>>
<span id="el_sliders_buttonLabel" data-page="1">
<span<?php echo $sliders->buttonLabel->ViewAttributes() ?>>
<?php echo $sliders->buttonLabel->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($sliders->buttonLabel_ar->Visible) { // buttonLabel_ar ?>
	<tr id="r_buttonLabel_ar">
		<td class="col-sm-2"><span id="elh_sliders_buttonLabel_ar"><?php echo $sliders->buttonLabel_ar->FldCaption() ?></span></td>
		<td data-name="buttonLabel_ar"<?php echo $sliders->buttonLabel_ar->CellAttributes() ?>>
<span id="el_sliders_buttonLabel_ar" data-page="1">
<span<?php echo $sliders->buttonLabel_ar->ViewAttributes() ?>>
<?php echo $sliders->buttonLabel_ar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($sliders->buttonlinkTo->Visible) { // buttonlinkTo ?>
	<tr id="r_buttonlinkTo">
		<td class="col-sm-2"><span id="elh_sliders_buttonlinkTo"><?php echo $sliders->buttonlinkTo->FldCaption() ?></span></td>
		<td data-name="buttonlinkTo"<?php echo $sliders->buttonlinkTo->CellAttributes() ?>>
<span id="el_sliders_buttonlinkTo" data-page="1">
<span<?php echo $sliders->buttonlinkTo->ViewAttributes() ?>>
<?php echo $sliders->buttonlinkTo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($sliders->so->Visible) { // so ?>
	<tr id="r_so">
		<td class="col-sm-2"><span id="elh_sliders_so"><?php echo $sliders->so->FldCaption() ?></span></td>
		<td data-name="so"<?php echo $sliders->so->CellAttributes() ?>>
<span id="el_sliders_so" data-page="1">
<span<?php echo $sliders->so->ViewAttributes() ?>>
<?php echo $sliders->so->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($sliders->active->Visible) { // active ?>
	<tr id="r_active">
		<td class="col-sm-2"><span id="elh_sliders_active"><?php echo $sliders->active->FldCaption() ?></span></td>
		<td data-name="active"<?php echo $sliders->active->CellAttributes() ?>>
<span id="el_sliders_active" data-page="1">
<span<?php echo $sliders->active->ViewAttributes() ?>>
<?php echo $sliders->active->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($sliders->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($sliders->Export == "") { ?>
		<div class="tab-pane<?php echo $sliders_view->MultiPages->PageStyle("2") ?>" id="tab_sliders2">
<?php } ?>
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($sliders->summary->Visible) { // summary ?>
	<tr id="r_summary">
		<td class="col-sm-2"><span id="elh_sliders_summary"><?php echo $sliders->summary->FldCaption() ?></span></td>
		<td data-name="summary"<?php echo $sliders->summary->CellAttributes() ?>>
<span id="el_sliders_summary" data-page="2">
<span<?php echo $sliders->summary->ViewAttributes() ?>>
<?php echo $sliders->summary->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($sliders->summary_ar->Visible) { // summary_ar ?>
	<tr id="r_summary_ar">
		<td class="col-sm-2"><span id="elh_sliders_summary_ar"><?php echo $sliders->summary_ar->FldCaption() ?></span></td>
		<td data-name="summary_ar"<?php echo $sliders->summary_ar->CellAttributes() ?>>
<span id="el_sliders_summary_ar" data-page="2">
<span<?php echo $sliders->summary_ar->ViewAttributes() ?>>
<?php echo $sliders->summary_ar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($sliders->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($sliders->Export == "") { ?>
	</div>
</div>
</div>
<?php } ?>
</form>
<?php if ($sliders->Export == "") { ?>
<script type="text/javascript">
fslidersview.Init();
</script>
<?php } ?>
<?php
$sliders_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($sliders->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$sliders_view->Page_Terminate();
?>
