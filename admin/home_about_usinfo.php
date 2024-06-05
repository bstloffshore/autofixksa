<?php

// Global variable for table object
$home_about_us = NULL;

//
// Table class for home_about_us
//
class chome_about_us extends cTable {
	var $id;
	var $title;
	var $title_ar;
	var $description;
	var $description_ar;
	var $image_01;
	var $image_02;
	var $image_03;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'home_about_us';
		$this->TableName = 'home_about_us';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`home_about_us`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4; // Page size (PHPExcel only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('home_about_us', 'home_about_us', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// title
		$this->title = new cField('home_about_us', 'home_about_us', 'x_title', 'title', '`title`', '`title`', 200, -1, FALSE, '`title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->title->Sortable = TRUE; // Allow sort
		$this->fields['title'] = &$this->title;

		// title_ar
		$this->title_ar = new cField('home_about_us', 'home_about_us', 'x_title_ar', 'title_ar', '`title_ar`', '`title_ar`', 200, -1, FALSE, '`title_ar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->title_ar->Sortable = TRUE; // Allow sort
		$this->fields['title_ar'] = &$this->title_ar;

		// description
		$this->description = new cField('home_about_us', 'home_about_us', 'x_description', 'description', '`description`', '`description`', 201, -1, FALSE, '`description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->description->Sortable = TRUE; // Allow sort
		$this->fields['description'] = &$this->description;

		// description_ar
		$this->description_ar = new cField('home_about_us', 'home_about_us', 'x_description_ar', 'description_ar', '`description_ar`', '`description_ar`', 201, -1, FALSE, '`description_ar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->description_ar->Sortable = TRUE; // Allow sort
		$this->fields['description_ar'] = &$this->description_ar;

		// image_01
		$this->image_01 = new cField('home_about_us', 'home_about_us', 'x_image_01', 'image_01', '`image_01`', '`image_01`', 200, -1, TRUE, '`image_01`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->image_01->Sortable = TRUE; // Allow sort
		$this->fields['image_01'] = &$this->image_01;

		// image_02
		$this->image_02 = new cField('home_about_us', 'home_about_us', 'x_image_02', 'image_02', '`image_02`', '`image_02`', 200, -1, TRUE, '`image_02`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->image_02->Sortable = TRUE; // Allow sort
		$this->fields['image_02'] = &$this->image_02;

		// image_03
		$this->image_03 = new cField('home_about_us', 'home_about_us', 'x_image_03', 'image_03', '`image_03`', '`image_03`', 200, -1, TRUE, '`image_03`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->image_03->Sortable = TRUE; // Allow sort
		$this->fields['image_03'] = &$this->image_03;
	}

	// Field Visibility
	function GetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $class);
		}
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`home_about_us`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$filter = $this->CurrentFilter;
		$filter = $this->ApplyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->GetSQL($filter, $sort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sql) {
		$cnt = -1;
		$pattern = "/^SELECT \* FROM/i";
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match($pattern, $sql)) {
			$sql = "SELECT COUNT(*) FROM" . preg_replace($pattern, "", $sql);
		} else {
			$sql = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($filter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$filter = $this->getSessionWhere();
		ew_AddFilter($filter, $this->CurrentFilter);
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->id->setDbValue($conn->Insert_ID());
			$rs['id'] = $this->id->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "home_about_uslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "home_about_usview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "home_about_usedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "home_about_usadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "home_about_uslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("home_about_usview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("home_about_usview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "home_about_usadd.php?" . $this->UrlParm($parm);
		else
			$url = "home_about_usadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("home_about_usedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("home_about_usadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("home_about_usdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = $_POST["id"];
			elseif (isset($_GET["id"]))
				$arKeys[] = $_GET["id"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($filter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $filter;
		//$sql = $this->SQL();

		$sql = $this->GetSQL($filter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id->setDbValue($rs->fields('id'));
		$this->title->setDbValue($rs->fields('title'));
		$this->title_ar->setDbValue($rs->fields('title_ar'));
		$this->description->setDbValue($rs->fields('description'));
		$this->description_ar->setDbValue($rs->fields('description_ar'));
		$this->image_01->Upload->DbValue = $rs->fields('image_01');
		$this->image_02->Upload->DbValue = $rs->fields('image_02');
		$this->image_03->Upload->DbValue = $rs->fields('image_03');
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id
		// title
		// title_ar
		// description
		// description_ar
		// image_01
		// image_02
		// image_03
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

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// title
		$this->title->EditAttrs["class"] = "form-control";
		$this->title->EditCustomAttributes = "";
		$this->title->EditValue = $this->title->CurrentValue;
		$this->title->PlaceHolder = ew_RemoveHtml($this->title->FldCaption());

		// title_ar
		$this->title_ar->EditAttrs["class"] = "form-control";
		$this->title_ar->EditCustomAttributes = "";
		$this->title_ar->EditValue = $this->title_ar->CurrentValue;
		$this->title_ar->PlaceHolder = ew_RemoveHtml($this->title_ar->FldCaption());

		// description
		$this->description->EditAttrs["class"] = "form-control";
		$this->description->EditCustomAttributes = "";
		$this->description->EditValue = $this->description->CurrentValue;
		$this->description->PlaceHolder = ew_RemoveHtml($this->description->FldCaption());

		// description_ar
		$this->description_ar->EditAttrs["class"] = "form-control";
		$this->description_ar->EditCustomAttributes = "";
		$this->description_ar->EditValue = $this->description_ar->CurrentValue;
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

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->title->Exportable) $Doc->ExportCaption($this->title);
					if ($this->title_ar->Exportable) $Doc->ExportCaption($this->title_ar);
					if ($this->description->Exportable) $Doc->ExportCaption($this->description);
					if ($this->description_ar->Exportable) $Doc->ExportCaption($this->description_ar);
					if ($this->image_01->Exportable) $Doc->ExportCaption($this->image_01);
					if ($this->image_02->Exportable) $Doc->ExportCaption($this->image_02);
					if ($this->image_03->Exportable) $Doc->ExportCaption($this->image_03);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->title->Exportable) $Doc->ExportCaption($this->title);
					if ($this->title_ar->Exportable) $Doc->ExportCaption($this->title_ar);
					if ($this->image_01->Exportable) $Doc->ExportCaption($this->image_01);
					if ($this->image_02->Exportable) $Doc->ExportCaption($this->image_02);
					if ($this->image_03->Exportable) $Doc->ExportCaption($this->image_03);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->title->Exportable) $Doc->ExportField($this->title);
						if ($this->title_ar->Exportable) $Doc->ExportField($this->title_ar);
						if ($this->description->Exportable) $Doc->ExportField($this->description);
						if ($this->description_ar->Exportable) $Doc->ExportField($this->description_ar);
						if ($this->image_01->Exportable) $Doc->ExportField($this->image_01);
						if ($this->image_02->Exportable) $Doc->ExportField($this->image_02);
						if ($this->image_03->Exportable) $Doc->ExportField($this->image_03);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->title->Exportable) $Doc->ExportField($this->title);
						if ($this->title_ar->Exportable) $Doc->ExportField($this->title_ar);
						if ($this->image_01->Exportable) $Doc->ExportField($this->image_01);
						if ($this->image_02->Exportable) $Doc->ExportField($this->image_02);
						if ($this->image_03->Exportable) $Doc->ExportField($this->image_03);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
