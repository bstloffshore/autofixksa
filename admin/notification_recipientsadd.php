<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "notification_recipientsinfo.php" ?>
<?php include_once "cms_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$notification_recipients_add = NULL; // Initialize page object first

class cnotification_recipients_add extends cnotification_recipients {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{8281128E-C7BB-40DA-A1AE-8695DB7283AC}';

	// Table name
	var $TableName = 'notification_recipients';

	// Page object name
	var $PageObjName = 'notification_recipients_add';

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

		// Table object (notification_recipients)
		if (!isset($GLOBALS["notification_recipients"]) || get_class($GLOBALS["notification_recipients"]) == "cnotification_recipients") {
			$GLOBALS["notification_recipients"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["notification_recipients"];
		}

		// Table object (cms_users)
		if (!isset($GLOBALS['cms_users'])) $GLOBALS['cms_users'] = new ccms_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'notification_recipients', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("notification_recipientslist.php"));
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
		$this->idNotificationType->SetVisibility();
		$this->recipientName->SetVisibility();
		$this->recipientEmail->SetVisibility();
		$this->_sendEmail->SetVisibility();
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
		global $EW_EXPORT, $notification_recipients;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($notification_recipients);
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
					if ($pageName == "notification_recipientsview.php")
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
					$this->Page_Terminate("notification_recipientslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "notification_recipientslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "notification_recipientsview.php")
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
		$this->id->CurrentValue = NULL;
		$this->id->OldValue = $this->id->CurrentValue;
		$this->idNotificationType->CurrentValue = NULL;
		$this->idNotificationType->OldValue = $this->idNotificationType->CurrentValue;
		$this->recipientName->CurrentValue = NULL;
		$this->recipientName->OldValue = $this->recipientName->CurrentValue;
		$this->recipientEmail->CurrentValue = NULL;
		$this->recipientEmail->OldValue = $this->recipientEmail->CurrentValue;
		$this->_sendEmail->CurrentValue = NULL;
		$this->_sendEmail->OldValue = $this->_sendEmail->CurrentValue;
		$this->active->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idNotificationType->FldIsDetailKey) {
			$this->idNotificationType->setFormValue($objForm->GetValue("x_idNotificationType"));
		}
		if (!$this->recipientName->FldIsDetailKey) {
			$this->recipientName->setFormValue($objForm->GetValue("x_recipientName"));
		}
		if (!$this->recipientEmail->FldIsDetailKey) {
			$this->recipientEmail->setFormValue($objForm->GetValue("x_recipientEmail"));
		}
		if (!$this->_sendEmail->FldIsDetailKey) {
			$this->_sendEmail->setFormValue($objForm->GetValue("x__sendEmail"));
		}
		if (!$this->active->FldIsDetailKey) {
			$this->active->setFormValue($objForm->GetValue("x_active"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->idNotificationType->CurrentValue = $this->idNotificationType->FormValue;
		$this->recipientName->CurrentValue = $this->recipientName->FormValue;
		$this->recipientEmail->CurrentValue = $this->recipientEmail->FormValue;
		$this->_sendEmail->CurrentValue = $this->_sendEmail->FormValue;
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
		$this->id->setDbValue($row['id']);
		$this->idNotificationType->setDbValue($row['idNotificationType']);
		$this->recipientName->setDbValue($row['recipientName']);
		$this->recipientEmail->setDbValue($row['recipientEmail']);
		$this->_sendEmail->setDbValue($row['sendEmail']);
		$this->active->setDbValue($row['active']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['idNotificationType'] = $this->idNotificationType->CurrentValue;
		$row['recipientName'] = $this->recipientName->CurrentValue;
		$row['recipientEmail'] = $this->recipientEmail->CurrentValue;
		$row['sendEmail'] = $this->_sendEmail->CurrentValue;
		$row['active'] = $this->active->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->idNotificationType->DbValue = $row['idNotificationType'];
		$this->recipientName->DbValue = $row['recipientName'];
		$this->recipientEmail->DbValue = $row['recipientEmail'];
		$this->_sendEmail->DbValue = $row['sendEmail'];
		$this->active->DbValue = $row['active'];
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
		// idNotificationType
		// recipientName
		// recipientEmail
		// sendEmail
		// active

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// idNotificationType
		if (strval($this->idNotificationType->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->idNotificationType->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `notificationType` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `notification_options`";
		$sWhereWrk = "";
		$this->idNotificationType->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idNotificationType, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idNotificationType->ViewValue = $this->idNotificationType->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idNotificationType->ViewValue = $this->idNotificationType->CurrentValue;
			}
		} else {
			$this->idNotificationType->ViewValue = NULL;
		}
		$this->idNotificationType->ViewCustomAttributes = "";

		// recipientName
		$this->recipientName->ViewValue = $this->recipientName->CurrentValue;
		$this->recipientName->ViewCustomAttributes = "";

		// recipientEmail
		$this->recipientEmail->ViewValue = $this->recipientEmail->CurrentValue;
		$this->recipientEmail->ViewCustomAttributes = "";

		// sendEmail
		if (strval($this->_sendEmail->CurrentValue) <> "") {
			$this->_sendEmail->ViewValue = $this->_sendEmail->OptionCaption($this->_sendEmail->CurrentValue);
		} else {
			$this->_sendEmail->ViewValue = NULL;
		}
		$this->_sendEmail->ViewCustomAttributes = "";

		// active
		if (strval($this->active->CurrentValue) <> "") {
			$this->active->ViewValue = $this->active->OptionCaption($this->active->CurrentValue);
		} else {
			$this->active->ViewValue = NULL;
		}
		$this->active->ViewCustomAttributes = "";

			// idNotificationType
			$this->idNotificationType->LinkCustomAttributes = "";
			$this->idNotificationType->HrefValue = "";
			$this->idNotificationType->TooltipValue = "";

			// recipientName
			$this->recipientName->LinkCustomAttributes = "";
			$this->recipientName->HrefValue = "";
			$this->recipientName->TooltipValue = "";

			// recipientEmail
			$this->recipientEmail->LinkCustomAttributes = "";
			$this->recipientEmail->HrefValue = "";
			$this->recipientEmail->TooltipValue = "";

			// sendEmail
			$this->_sendEmail->LinkCustomAttributes = "";
			$this->_sendEmail->HrefValue = "";
			$this->_sendEmail->TooltipValue = "";

			// active
			$this->active->LinkCustomAttributes = "";
			$this->active->HrefValue = "";
			$this->active->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idNotificationType
			$this->idNotificationType->EditAttrs["class"] = "form-control";
			$this->idNotificationType->EditCustomAttributes = "";
			if (trim(strval($this->idNotificationType->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->idNotificationType->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `notificationType` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `notification_options`";
			$sWhereWrk = "";
			$this->idNotificationType->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idNotificationType, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->idNotificationType->EditValue = $arwrk;

			// recipientName
			$this->recipientName->EditAttrs["class"] = "form-control";
			$this->recipientName->EditCustomAttributes = "";
			$this->recipientName->EditValue = ew_HtmlEncode($this->recipientName->CurrentValue);
			$this->recipientName->PlaceHolder = ew_RemoveHtml($this->recipientName->FldCaption());

			// recipientEmail
			$this->recipientEmail->EditAttrs["class"] = "form-control";
			$this->recipientEmail->EditCustomAttributes = "";
			$this->recipientEmail->EditValue = ew_HtmlEncode($this->recipientEmail->CurrentValue);
			$this->recipientEmail->PlaceHolder = ew_RemoveHtml($this->recipientEmail->FldCaption());

			// sendEmail
			$this->_sendEmail->EditAttrs["class"] = "form-control";
			$this->_sendEmail->EditCustomAttributes = "";
			$this->_sendEmail->EditValue = $this->_sendEmail->Options(TRUE);

			// active
			$this->active->EditAttrs["class"] = "form-control";
			$this->active->EditCustomAttributes = "";
			$this->active->EditValue = $this->active->Options(TRUE);

			// Add refer script
			// idNotificationType

			$this->idNotificationType->LinkCustomAttributes = "";
			$this->idNotificationType->HrefValue = "";

			// recipientName
			$this->recipientName->LinkCustomAttributes = "";
			$this->recipientName->HrefValue = "";

			// recipientEmail
			$this->recipientEmail->LinkCustomAttributes = "";
			$this->recipientEmail->HrefValue = "";

			// sendEmail
			$this->_sendEmail->LinkCustomAttributes = "";
			$this->_sendEmail->HrefValue = "";

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

		// idNotificationType
		$this->idNotificationType->SetDbValueDef($rsnew, $this->idNotificationType->CurrentValue, NULL, FALSE);

		// recipientName
		$this->recipientName->SetDbValueDef($rsnew, $this->recipientName->CurrentValue, NULL, FALSE);

		// recipientEmail
		$this->recipientEmail->SetDbValueDef($rsnew, $this->recipientEmail->CurrentValue, NULL, FALSE);

		// sendEmail
		$this->_sendEmail->SetDbValueDef($rsnew, $this->_sendEmail->CurrentValue, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("notification_recipientslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_idNotificationType":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `notificationType` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `notification_options`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->idNotificationType, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($notification_recipients_add)) $notification_recipients_add = new cnotification_recipients_add();

// Page init
$notification_recipients_add->Page_Init();

// Page main
$notification_recipients_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$notification_recipients_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fnotification_recipientsadd = new ew_Form("fnotification_recipientsadd", "add");

// Validate form
fnotification_recipientsadd.Validate = function() {
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
fnotification_recipientsadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fnotification_recipientsadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fnotification_recipientsadd.Lists["x_idNotificationType"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_notificationType","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"notification_options"};
fnotification_recipientsadd.Lists["x_idNotificationType"].Data = "<?php echo $notification_recipients_add->idNotificationType->LookupFilterQuery(FALSE, "add") ?>";
fnotification_recipientsadd.Lists["x__sendEmail"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnotification_recipientsadd.Lists["x__sendEmail"].Options = <?php echo json_encode($notification_recipients_add->_sendEmail->Options()) ?>;
fnotification_recipientsadd.Lists["x_active"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnotification_recipientsadd.Lists["x_active"].Options = <?php echo json_encode($notification_recipients_add->active->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $notification_recipients_add->ShowPageHeader(); ?>
<?php
$notification_recipients_add->ShowMessage();
?>
<form name="fnotification_recipientsadd" id="fnotification_recipientsadd" class="<?php echo $notification_recipients_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($notification_recipients_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $notification_recipients_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="notification_recipients">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($notification_recipients_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($notification_recipients->idNotificationType->Visible) { // idNotificationType ?>
	<div id="r_idNotificationType" class="form-group">
		<label id="elh_notification_recipients_idNotificationType" for="x_idNotificationType" class="<?php echo $notification_recipients_add->LeftColumnClass ?>"><?php echo $notification_recipients->idNotificationType->FldCaption() ?></label>
		<div class="<?php echo $notification_recipients_add->RightColumnClass ?>"><div<?php echo $notification_recipients->idNotificationType->CellAttributes() ?>>
<span id="el_notification_recipients_idNotificationType">
<select data-table="notification_recipients" data-field="x_idNotificationType" data-value-separator="<?php echo $notification_recipients->idNotificationType->DisplayValueSeparatorAttribute() ?>" id="x_idNotificationType" name="x_idNotificationType"<?php echo $notification_recipients->idNotificationType->EditAttributes() ?>>
<?php echo $notification_recipients->idNotificationType->SelectOptionListHtml("x_idNotificationType") ?>
</select>
</span>
<?php echo $notification_recipients->idNotificationType->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($notification_recipients->recipientName->Visible) { // recipientName ?>
	<div id="r_recipientName" class="form-group">
		<label id="elh_notification_recipients_recipientName" for="x_recipientName" class="<?php echo $notification_recipients_add->LeftColumnClass ?>"><?php echo $notification_recipients->recipientName->FldCaption() ?></label>
		<div class="<?php echo $notification_recipients_add->RightColumnClass ?>"><div<?php echo $notification_recipients->recipientName->CellAttributes() ?>>
<span id="el_notification_recipients_recipientName">
<input type="text" data-table="notification_recipients" data-field="x_recipientName" name="x_recipientName" id="x_recipientName" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($notification_recipients->recipientName->getPlaceHolder()) ?>" value="<?php echo $notification_recipients->recipientName->EditValue ?>"<?php echo $notification_recipients->recipientName->EditAttributes() ?>>
</span>
<?php echo $notification_recipients->recipientName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($notification_recipients->recipientEmail->Visible) { // recipientEmail ?>
	<div id="r_recipientEmail" class="form-group">
		<label id="elh_notification_recipients_recipientEmail" for="x_recipientEmail" class="<?php echo $notification_recipients_add->LeftColumnClass ?>"><?php echo $notification_recipients->recipientEmail->FldCaption() ?></label>
		<div class="<?php echo $notification_recipients_add->RightColumnClass ?>"><div<?php echo $notification_recipients->recipientEmail->CellAttributes() ?>>
<span id="el_notification_recipients_recipientEmail">
<input type="text" data-table="notification_recipients" data-field="x_recipientEmail" name="x_recipientEmail" id="x_recipientEmail" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($notification_recipients->recipientEmail->getPlaceHolder()) ?>" value="<?php echo $notification_recipients->recipientEmail->EditValue ?>"<?php echo $notification_recipients->recipientEmail->EditAttributes() ?>>
</span>
<?php echo $notification_recipients->recipientEmail->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($notification_recipients->_sendEmail->Visible) { // sendEmail ?>
	<div id="r__sendEmail" class="form-group">
		<label id="elh_notification_recipients__sendEmail" for="x__sendEmail" class="<?php echo $notification_recipients_add->LeftColumnClass ?>"><?php echo $notification_recipients->_sendEmail->FldCaption() ?></label>
		<div class="<?php echo $notification_recipients_add->RightColumnClass ?>"><div<?php echo $notification_recipients->_sendEmail->CellAttributes() ?>>
<span id="el_notification_recipients__sendEmail">
<select data-table="notification_recipients" data-field="x__sendEmail" data-value-separator="<?php echo $notification_recipients->_sendEmail->DisplayValueSeparatorAttribute() ?>" id="x__sendEmail" name="x__sendEmail"<?php echo $notification_recipients->_sendEmail->EditAttributes() ?>>
<?php echo $notification_recipients->_sendEmail->SelectOptionListHtml("x__sendEmail") ?>
</select>
</span>
<?php echo $notification_recipients->_sendEmail->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($notification_recipients->active->Visible) { // active ?>
	<div id="r_active" class="form-group">
		<label id="elh_notification_recipients_active" for="x_active" class="<?php echo $notification_recipients_add->LeftColumnClass ?>"><?php echo $notification_recipients->active->FldCaption() ?></label>
		<div class="<?php echo $notification_recipients_add->RightColumnClass ?>"><div<?php echo $notification_recipients->active->CellAttributes() ?>>
<span id="el_notification_recipients_active">
<select data-table="notification_recipients" data-field="x_active" data-value-separator="<?php echo $notification_recipients->active->DisplayValueSeparatorAttribute() ?>" id="x_active" name="x_active"<?php echo $notification_recipients->active->EditAttributes() ?>>
<?php echo $notification_recipients->active->SelectOptionListHtml("x_active") ?>
</select>
</span>
<?php echo $notification_recipients->active->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$notification_recipients_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $notification_recipients_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $notification_recipients_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fnotification_recipientsadd.Init();
</script>
<?php
$notification_recipients_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$notification_recipients_add->Page_Terminate();
?>
