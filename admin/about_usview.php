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

$about_us_view = NULL; // Initialize page object first

class cabout_us_view extends cabout_us {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{8281128E-C7BB-40DA-A1AE-8695DB7283AC}';

	// Table name
	var $TableName = 'about_us';

	// Page object name
	var $PageObjName = 'about_us_view';

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

		// Table object (about_us)
		if (!isset($GLOBALS["about_us"]) || get_class($GLOBALS["about_us"]) == "cabout_us") {
			$GLOBALS["about_us"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["about_us"];
		}
		$KeyUrl = "";
		if (@$_GET["id"] <> "") {
			$this->RecKey["id"] = $_GET["id"];
			$KeyUrl .= "&amp;id=" . urlencode($this->RecKey["id"]);
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
				$this->Page_Terminate(ew_GetUrl("about_uslist.php"));
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
		if (@$_GET["id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= $_GET["id"];
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
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} elseif (@$_POST["id"] <> "") {
				$this->id->setFormValue($_POST["id"]);
				$this->RecKey["id"] = $this->id->FormValue;
			} else {
				$sReturnUrl = "about_uslist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "about_uslist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array_keys($EW_EXPORT))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "about_uslist.php"; // Not page request, return to list
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
		$item->Body = "<button id=\"emf_about_us\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_about_us',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fabout_usview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("about_uslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($about_us_view)) $about_us_view = new cabout_us_view();

// Page init
$about_us_view->Page_Init();

// Page main
$about_us_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$about_us_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($about_us->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fabout_usview = new ew_Form("fabout_usview", "view");

// Form_CustomValidate event
fabout_usview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fabout_usview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Multi-Page
fabout_usview.MultiPage = new ew_MultiPage("fabout_usview");

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($about_us->Export == "") { ?>
<div class="ewToolbar">
<?php $about_us_view->ExportOptions->Render("body") ?>
<?php
	foreach ($about_us_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $about_us_view->ShowPageHeader(); ?>
<?php
$about_us_view->ShowMessage();
?>
<form name="fabout_usview" id="fabout_usview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($about_us_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $about_us_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="about_us">
<input type="hidden" name="modal" value="<?php echo intval($about_us_view->IsModal) ?>">
<?php if ($about_us->Export == "") { ?>
<div class="ewMultiPage">
<div class="nav-tabs-custom" id="about_us_view">
	<ul class="nav<?php echo $about_us_view->MultiPages->NavStyle() ?>">
		<li<?php echo $about_us_view->MultiPages->TabStyle("1") ?>><a href="#tab_about_us1" data-toggle="tab"><?php echo $about_us->PageCaption(1) ?></a></li>
		<li<?php echo $about_us_view->MultiPages->TabStyle("2") ?>><a href="#tab_about_us2" data-toggle="tab"><?php echo $about_us->PageCaption(2) ?></a></li>
	</ul>
	<div class="tab-content">
<?php } ?>
<?php if ($about_us->Export == "") { ?>
		<div class="tab-pane<?php echo $about_us_view->MultiPages->PageStyle("1") ?>" id="tab_about_us1">
<?php } ?>
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($about_us->id->Visible) { // id ?>
	<tr id="r_id">
		<td class="col-sm-2"><span id="elh_about_us_id"><?php echo $about_us->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $about_us->id->CellAttributes() ?>>
<span id="el_about_us_id" data-page="1">
<span<?php echo $about_us->id->ViewAttributes() ?>>
<?php echo $about_us->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($about_us->section_01_title->Visible) { // section_01_title ?>
	<tr id="r_section_01_title">
		<td class="col-sm-2"><span id="elh_about_us_section_01_title"><?php echo $about_us->section_01_title->FldCaption() ?></span></td>
		<td data-name="section_01_title"<?php echo $about_us->section_01_title->CellAttributes() ?>>
<span id="el_about_us_section_01_title" data-page="1">
<span<?php echo $about_us->section_01_title->ViewAttributes() ?>>
<?php echo $about_us->section_01_title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($about_us->section_01_title_ar->Visible) { // section_01_title_ar ?>
	<tr id="r_section_01_title_ar">
		<td class="col-sm-2"><span id="elh_about_us_section_01_title_ar"><?php echo $about_us->section_01_title_ar->FldCaption() ?></span></td>
		<td data-name="section_01_title_ar"<?php echo $about_us->section_01_title_ar->CellAttributes() ?>>
<span id="el_about_us_section_01_title_ar" data-page="1">
<span<?php echo $about_us->section_01_title_ar->ViewAttributes() ?>>
<?php echo $about_us->section_01_title_ar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($about_us->section_01_image->Visible) { // section_01_image ?>
	<tr id="r_section_01_image">
		<td class="col-sm-2"><span id="elh_about_us_section_01_image"><?php echo $about_us->section_01_image->FldCaption() ?></span></td>
		<td data-name="section_01_image"<?php echo $about_us->section_01_image->CellAttributes() ?>>
<span id="el_about_us_section_01_image" data-page="1">
<span>
<?php echo ew_GetFileViewTag($about_us->section_01_image, $about_us->section_01_image->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($about_us->section_01_summary->Visible) { // section_01_summary ?>
	<tr id="r_section_01_summary">
		<td class="col-sm-2"><span id="elh_about_us_section_01_summary"><?php echo $about_us->section_01_summary->FldCaption() ?></span></td>
		<td data-name="section_01_summary"<?php echo $about_us->section_01_summary->CellAttributes() ?>>
<span id="el_about_us_section_01_summary" data-page="1">
<span<?php echo $about_us->section_01_summary->ViewAttributes() ?>>
<?php echo $about_us->section_01_summary->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($about_us->section_01_summary_ar->Visible) { // section_01_summary_ar ?>
	<tr id="r_section_01_summary_ar">
		<td class="col-sm-2"><span id="elh_about_us_section_01_summary_ar"><?php echo $about_us->section_01_summary_ar->FldCaption() ?></span></td>
		<td data-name="section_01_summary_ar"<?php echo $about_us->section_01_summary_ar->CellAttributes() ?>>
<span id="el_about_us_section_01_summary_ar" data-page="1">
<span<?php echo $about_us->section_01_summary_ar->ViewAttributes() ?>>
<?php echo $about_us->section_01_summary_ar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($about_us->section_01_description->Visible) { // section_01_description ?>
	<tr id="r_section_01_description">
		<td class="col-sm-2"><span id="elh_about_us_section_01_description"><?php echo $about_us->section_01_description->FldCaption() ?></span></td>
		<td data-name="section_01_description"<?php echo $about_us->section_01_description->CellAttributes() ?>>
<span id="el_about_us_section_01_description" data-page="1">
<span<?php echo $about_us->section_01_description->ViewAttributes() ?>>
<?php echo $about_us->section_01_description->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($about_us->section_01_description_ar->Visible) { // section_01_description_ar ?>
	<tr id="r_section_01_description_ar">
		<td class="col-sm-2"><span id="elh_about_us_section_01_description_ar"><?php echo $about_us->section_01_description_ar->FldCaption() ?></span></td>
		<td data-name="section_01_description_ar"<?php echo $about_us->section_01_description_ar->CellAttributes() ?>>
<span id="el_about_us_section_01_description_ar" data-page="1">
<span<?php echo $about_us->section_01_description_ar->ViewAttributes() ?>>
<?php echo $about_us->section_01_description_ar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($about_us->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($about_us->Export == "") { ?>
		<div class="tab-pane<?php echo $about_us_view->MultiPages->PageStyle("2") ?>" id="tab_about_us2">
<?php } ?>
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($about_us->section_02_summary->Visible) { // section_02_summary ?>
	<tr id="r_section_02_summary">
		<td class="col-sm-2"><span id="elh_about_us_section_02_summary"><?php echo $about_us->section_02_summary->FldCaption() ?></span></td>
		<td data-name="section_02_summary"<?php echo $about_us->section_02_summary->CellAttributes() ?>>
<span id="el_about_us_section_02_summary" data-page="2">
<span<?php echo $about_us->section_02_summary->ViewAttributes() ?>>
<?php echo $about_us->section_02_summary->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($about_us->section_02_summary_ar->Visible) { // section_02_summary_ar ?>
	<tr id="r_section_02_summary_ar">
		<td class="col-sm-2"><span id="elh_about_us_section_02_summary_ar"><?php echo $about_us->section_02_summary_ar->FldCaption() ?></span></td>
		<td data-name="section_02_summary_ar"<?php echo $about_us->section_02_summary_ar->CellAttributes() ?>>
<span id="el_about_us_section_02_summary_ar" data-page="2">
<span<?php echo $about_us->section_02_summary_ar->ViewAttributes() ?>>
<?php echo $about_us->section_02_summary_ar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($about_us->section_02_description_01->Visible) { // section_02_description_01 ?>
	<tr id="r_section_02_description_01">
		<td class="col-sm-2"><span id="elh_about_us_section_02_description_01"><?php echo $about_us->section_02_description_01->FldCaption() ?></span></td>
		<td data-name="section_02_description_01"<?php echo $about_us->section_02_description_01->CellAttributes() ?>>
<span id="el_about_us_section_02_description_01" data-page="2">
<span<?php echo $about_us->section_02_description_01->ViewAttributes() ?>>
<?php echo $about_us->section_02_description_01->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($about_us->section_02_description_01_ar->Visible) { // section_02_description_01_ar ?>
	<tr id="r_section_02_description_01_ar">
		<td class="col-sm-2"><span id="elh_about_us_section_02_description_01_ar"><?php echo $about_us->section_02_description_01_ar->FldCaption() ?></span></td>
		<td data-name="section_02_description_01_ar"<?php echo $about_us->section_02_description_01_ar->CellAttributes() ?>>
<span id="el_about_us_section_02_description_01_ar" data-page="2">
<span<?php echo $about_us->section_02_description_01_ar->ViewAttributes() ?>>
<?php echo $about_us->section_02_description_01_ar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($about_us->section_02_description_02->Visible) { // section_02_description_02 ?>
	<tr id="r_section_02_description_02">
		<td class="col-sm-2"><span id="elh_about_us_section_02_description_02"><?php echo $about_us->section_02_description_02->FldCaption() ?></span></td>
		<td data-name="section_02_description_02"<?php echo $about_us->section_02_description_02->CellAttributes() ?>>
<span id="el_about_us_section_02_description_02" data-page="2">
<span<?php echo $about_us->section_02_description_02->ViewAttributes() ?>>
<?php echo $about_us->section_02_description_02->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($about_us->section_02_description_02_ar->Visible) { // section_02_description_02_ar ?>
	<tr id="r_section_02_description_02_ar">
		<td class="col-sm-2"><span id="elh_about_us_section_02_description_02_ar"><?php echo $about_us->section_02_description_02_ar->FldCaption() ?></span></td>
		<td data-name="section_02_description_02_ar"<?php echo $about_us->section_02_description_02_ar->CellAttributes() ?>>
<span id="el_about_us_section_02_description_02_ar" data-page="2">
<span<?php echo $about_us->section_02_description_02_ar->ViewAttributes() ?>>
<?php echo $about_us->section_02_description_02_ar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($about_us->Export == "") { ?>
		</div>
<?php } ?>
<?php if ($about_us->Export == "") { ?>
	</div>
</div>
</div>
<?php } ?>
</form>
<?php if ($about_us->Export == "") { ?>
<script type="text/javascript">
fabout_usview.Init();
</script>
<?php } ?>
<?php
$about_us_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($about_us->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$about_us_view->Page_Terminate();
?>
