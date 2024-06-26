<?php

// Global variable for table object
$campaign_aboutus = NULL;

//
// Table class for campaign_aboutus
//
class ccampaign_aboutus extends cTable {
	var $id;
	var $title;
	var $title_ar;
	var $campaignSlug;
	var $sliderImage;
	var $sliderImage_ar;
	var $description;
	var $description_ar;
	var $section_01_title;
	var $section_01_title_ar;
	var $section_01_summary;
	var $section_01_summary_ar;
	var $section_01_icon;
	var $section_02_title;
	var $section_02_title_ar;
	var $section_02_summary;
	var $section_02_summary_ar;
	var $section_02_icon;
	var $section_03_title;
	var $section_03_title_ar;
	var $section_03_summary;
	var $section_03_summary_ar;
	var $section_03_icon;
	var $section_04_title;
	var $section_04_title_ar;
	var $section_04_summary;
	var $section_04_summary_ar;
	var $section_04_icon;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'campaign_aboutus';
		$this->TableName = 'campaign_aboutus';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`campaign_aboutus`";
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
		$this->id = new cField('campaign_aboutus', 'campaign_aboutus', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// title
		$this->title = new cField('campaign_aboutus', 'campaign_aboutus', 'x_title', 'title', '`title`', '`title`', 200, -1, FALSE, '`title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->title->Sortable = TRUE; // Allow sort
		$this->fields['title'] = &$this->title;

		// title_ar
		$this->title_ar = new cField('campaign_aboutus', 'campaign_aboutus', 'x_title_ar', 'title_ar', '`title_ar`', '`title_ar`', 200, -1, FALSE, '`title_ar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->title_ar->Sortable = TRUE; // Allow sort
		$this->fields['title_ar'] = &$this->title_ar;

		// campaignSlug
		$this->campaignSlug = new cField('campaign_aboutus', 'campaign_aboutus', 'x_campaignSlug', 'campaignSlug', '`campaignSlug`', '`campaignSlug`', 200, -1, FALSE, '`campaignSlug`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->campaignSlug->Sortable = TRUE; // Allow sort
		$this->fields['campaignSlug'] = &$this->campaignSlug;

		// sliderImage
		$this->sliderImage = new cField('campaign_aboutus', 'campaign_aboutus', 'x_sliderImage', 'sliderImage', '`sliderImage`', '`sliderImage`', 200, -1, TRUE, '`sliderImage`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->sliderImage->Sortable = TRUE; // Allow sort
		$this->fields['sliderImage'] = &$this->sliderImage;

		// sliderImage_ar
		$this->sliderImage_ar = new cField('campaign_aboutus', 'campaign_aboutus', 'x_sliderImage_ar', 'sliderImage_ar', '`sliderImage_ar`', '`sliderImage_ar`', 200, -1, TRUE, '`sliderImage_ar`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->sliderImage_ar->Sortable = TRUE; // Allow sort
		$this->fields['sliderImage_ar'] = &$this->sliderImage_ar;

		// description
		$this->description = new cField('campaign_aboutus', 'campaign_aboutus', 'x_description', 'description', '`description`', '`description`', 201, -1, FALSE, '`description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->description->Sortable = TRUE; // Allow sort
		$this->fields['description'] = &$this->description;

		// description_ar
		$this->description_ar = new cField('campaign_aboutus', 'campaign_aboutus', 'x_description_ar', 'description_ar', '`description_ar`', '`description_ar`', 201, -1, FALSE, '`description_ar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->description_ar->Sortable = TRUE; // Allow sort
		$this->fields['description_ar'] = &$this->description_ar;

		// section_01_title
		$this->section_01_title = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_01_title', 'section_01_title', '`section_01_title`', '`section_01_title`', 200, -1, FALSE, '`section_01_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_01_title->Sortable = TRUE; // Allow sort
		$this->fields['section_01_title'] = &$this->section_01_title;

		// section_01_title_ar
		$this->section_01_title_ar = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_01_title_ar', 'section_01_title_ar', '`section_01_title_ar`', '`section_01_title_ar`', 200, -1, FALSE, '`section_01_title_ar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_01_title_ar->Sortable = TRUE; // Allow sort
		$this->fields['section_01_title_ar'] = &$this->section_01_title_ar;

		// section_01_summary
		$this->section_01_summary = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_01_summary', 'section_01_summary', '`section_01_summary`', '`section_01_summary`', 200, -1, FALSE, '`section_01_summary`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_01_summary->Sortable = TRUE; // Allow sort
		$this->fields['section_01_summary'] = &$this->section_01_summary;

		// section_01_summary_ar
		$this->section_01_summary_ar = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_01_summary_ar', 'section_01_summary_ar', '`section_01_summary_ar`', '`section_01_summary_ar`', 200, -1, FALSE, '`section_01_summary_ar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_01_summary_ar->Sortable = TRUE; // Allow sort
		$this->fields['section_01_summary_ar'] = &$this->section_01_summary_ar;

		// section_01_icon
		$this->section_01_icon = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_01_icon', 'section_01_icon', '`section_01_icon`', '`section_01_icon`', 200, -1, FALSE, '`section_01_icon`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_01_icon->Sortable = TRUE; // Allow sort
		$this->fields['section_01_icon'] = &$this->section_01_icon;

		// section_02_title
		$this->section_02_title = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_02_title', 'section_02_title', '`section_02_title`', '`section_02_title`', 200, -1, FALSE, '`section_02_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_02_title->Sortable = TRUE; // Allow sort
		$this->fields['section_02_title'] = &$this->section_02_title;

		// section_02_title_ar
		$this->section_02_title_ar = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_02_title_ar', 'section_02_title_ar', '`section_02_title_ar`', '`section_02_title_ar`', 200, -1, FALSE, '`section_02_title_ar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_02_title_ar->Sortable = TRUE; // Allow sort
		$this->fields['section_02_title_ar'] = &$this->section_02_title_ar;

		// section_02_summary
		$this->section_02_summary = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_02_summary', 'section_02_summary', '`section_02_summary`', '`section_02_summary`', 200, -1, FALSE, '`section_02_summary`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_02_summary->Sortable = TRUE; // Allow sort
		$this->fields['section_02_summary'] = &$this->section_02_summary;

		// section_02_summary_ar
		$this->section_02_summary_ar = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_02_summary_ar', 'section_02_summary_ar', '`section_02_summary_ar`', '`section_02_summary_ar`', 200, -1, FALSE, '`section_02_summary_ar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_02_summary_ar->Sortable = TRUE; // Allow sort
		$this->fields['section_02_summary_ar'] = &$this->section_02_summary_ar;

		// section_02_icon
		$this->section_02_icon = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_02_icon', 'section_02_icon', '`section_02_icon`', '`section_02_icon`', 200, -1, FALSE, '`section_02_icon`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_02_icon->Sortable = TRUE; // Allow sort
		$this->fields['section_02_icon'] = &$this->section_02_icon;

		// section_03_title
		$this->section_03_title = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_03_title', 'section_03_title', '`section_03_title`', '`section_03_title`', 200, -1, FALSE, '`section_03_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_03_title->Sortable = TRUE; // Allow sort
		$this->fields['section_03_title'] = &$this->section_03_title;

		// section_03_title_ar
		$this->section_03_title_ar = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_03_title_ar', 'section_03_title_ar', '`section_03_title_ar`', '`section_03_title_ar`', 200, -1, FALSE, '`section_03_title_ar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_03_title_ar->Sortable = TRUE; // Allow sort
		$this->fields['section_03_title_ar'] = &$this->section_03_title_ar;

		// section_03_summary
		$this->section_03_summary = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_03_summary', 'section_03_summary', '`section_03_summary`', '`section_03_summary`', 200, -1, FALSE, '`section_03_summary`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_03_summary->Sortable = TRUE; // Allow sort
		$this->fields['section_03_summary'] = &$this->section_03_summary;

		// section_03_summary_ar
		$this->section_03_summary_ar = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_03_summary_ar', 'section_03_summary_ar', '`section_03_summary_ar`', '`section_03_summary_ar`', 200, -1, FALSE, '`section_03_summary_ar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_03_summary_ar->Sortable = TRUE; // Allow sort
		$this->fields['section_03_summary_ar'] = &$this->section_03_summary_ar;

		// section_03_icon
		$this->section_03_icon = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_03_icon', 'section_03_icon', '`section_03_icon`', '`section_03_icon`', 200, -1, FALSE, '`section_03_icon`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_03_icon->Sortable = TRUE; // Allow sort
		$this->fields['section_03_icon'] = &$this->section_03_icon;

		// section_04_title
		$this->section_04_title = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_04_title', 'section_04_title', '`section_04_title`', '`section_04_title`', 200, -1, FALSE, '`section_04_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_04_title->Sortable = TRUE; // Allow sort
		$this->fields['section_04_title'] = &$this->section_04_title;

		// section_04_title_ar
		$this->section_04_title_ar = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_04_title_ar', 'section_04_title_ar', '`section_04_title_ar`', '`section_04_title_ar`', 200, -1, FALSE, '`section_04_title_ar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_04_title_ar->Sortable = TRUE; // Allow sort
		$this->fields['section_04_title_ar'] = &$this->section_04_title_ar;

		// section_04_summary
		$this->section_04_summary = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_04_summary', 'section_04_summary', '`section_04_summary`', '`section_04_summary`', 200, -1, FALSE, '`section_04_summary`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_04_summary->Sortable = TRUE; // Allow sort
		$this->fields['section_04_summary'] = &$this->section_04_summary;

		// section_04_summary_ar
		$this->section_04_summary_ar = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_04_summary_ar', 'section_04_summary_ar', '`section_04_summary_ar`', '`section_04_summary_ar`', 200, -1, FALSE, '`section_04_summary_ar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_04_summary_ar->Sortable = TRUE; // Allow sort
		$this->fields['section_04_summary_ar'] = &$this->section_04_summary_ar;

		// section_04_icon
		$this->section_04_icon = new cField('campaign_aboutus', 'campaign_aboutus', 'x_section_04_icon', 'section_04_icon', '`section_04_icon`', '`section_04_icon`', 200, -1, FALSE, '`section_04_icon`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->section_04_icon->Sortable = TRUE; // Allow sort
		$this->fields['section_04_icon'] = &$this->section_04_icon;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`campaign_aboutus`";
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
			return "campaign_aboutuslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "campaign_aboutusview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "campaign_aboutusedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "campaign_aboutusadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "campaign_aboutuslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("campaign_aboutusview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("campaign_aboutusview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "campaign_aboutusadd.php?" . $this->UrlParm($parm);
		else
			$url = "campaign_aboutusadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("campaign_aboutusedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("campaign_aboutusadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("campaign_aboutusdelete.php", $this->UrlParm());
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
		$this->campaignSlug->setDbValue($rs->fields('campaignSlug'));
		$this->sliderImage->Upload->DbValue = $rs->fields('sliderImage');
		$this->sliderImage_ar->Upload->DbValue = $rs->fields('sliderImage_ar');
		$this->description->setDbValue($rs->fields('description'));
		$this->description_ar->setDbValue($rs->fields('description_ar'));
		$this->section_01_title->setDbValue($rs->fields('section_01_title'));
		$this->section_01_title_ar->setDbValue($rs->fields('section_01_title_ar'));
		$this->section_01_summary->setDbValue($rs->fields('section_01_summary'));
		$this->section_01_summary_ar->setDbValue($rs->fields('section_01_summary_ar'));
		$this->section_01_icon->setDbValue($rs->fields('section_01_icon'));
		$this->section_02_title->setDbValue($rs->fields('section_02_title'));
		$this->section_02_title_ar->setDbValue($rs->fields('section_02_title_ar'));
		$this->section_02_summary->setDbValue($rs->fields('section_02_summary'));
		$this->section_02_summary_ar->setDbValue($rs->fields('section_02_summary_ar'));
		$this->section_02_icon->setDbValue($rs->fields('section_02_icon'));
		$this->section_03_title->setDbValue($rs->fields('section_03_title'));
		$this->section_03_title_ar->setDbValue($rs->fields('section_03_title_ar'));
		$this->section_03_summary->setDbValue($rs->fields('section_03_summary'));
		$this->section_03_summary_ar->setDbValue($rs->fields('section_03_summary_ar'));
		$this->section_03_icon->setDbValue($rs->fields('section_03_icon'));
		$this->section_04_title->setDbValue($rs->fields('section_04_title'));
		$this->section_04_title_ar->setDbValue($rs->fields('section_04_title_ar'));
		$this->section_04_summary->setDbValue($rs->fields('section_04_summary'));
		$this->section_04_summary_ar->setDbValue($rs->fields('section_04_summary_ar'));
		$this->section_04_icon->setDbValue($rs->fields('section_04_icon'));
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

		// campaignSlug
		$this->campaignSlug->EditAttrs["class"] = "form-control";
		$this->campaignSlug->EditCustomAttributes = "";
		$this->campaignSlug->EditValue = $this->campaignSlug->CurrentValue;
		$this->campaignSlug->PlaceHolder = ew_RemoveHtml($this->campaignSlug->FldCaption());

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

		// section_01_title
		$this->section_01_title->EditAttrs["class"] = "form-control";
		$this->section_01_title->EditCustomAttributes = "";
		$this->section_01_title->EditValue = $this->section_01_title->CurrentValue;
		$this->section_01_title->PlaceHolder = ew_RemoveHtml($this->section_01_title->FldCaption());

		// section_01_title_ar
		$this->section_01_title_ar->EditAttrs["class"] = "form-control";
		$this->section_01_title_ar->EditCustomAttributes = "";
		$this->section_01_title_ar->EditValue = $this->section_01_title_ar->CurrentValue;
		$this->section_01_title_ar->PlaceHolder = ew_RemoveHtml($this->section_01_title_ar->FldCaption());

		// section_01_summary
		$this->section_01_summary->EditAttrs["class"] = "form-control";
		$this->section_01_summary->EditCustomAttributes = "";
		$this->section_01_summary->EditValue = $this->section_01_summary->CurrentValue;
		$this->section_01_summary->PlaceHolder = ew_RemoveHtml($this->section_01_summary->FldCaption());

		// section_01_summary_ar
		$this->section_01_summary_ar->EditAttrs["class"] = "form-control";
		$this->section_01_summary_ar->EditCustomAttributes = "";
		$this->section_01_summary_ar->EditValue = $this->section_01_summary_ar->CurrentValue;
		$this->section_01_summary_ar->PlaceHolder = ew_RemoveHtml($this->section_01_summary_ar->FldCaption());

		// section_01_icon
		$this->section_01_icon->EditAttrs["class"] = "form-control";
		$this->section_01_icon->EditCustomAttributes = "";
		$this->section_01_icon->EditValue = $this->section_01_icon->CurrentValue;
		$this->section_01_icon->PlaceHolder = ew_RemoveHtml($this->section_01_icon->FldCaption());

		// section_02_title
		$this->section_02_title->EditAttrs["class"] = "form-control";
		$this->section_02_title->EditCustomAttributes = "";
		$this->section_02_title->EditValue = $this->section_02_title->CurrentValue;
		$this->section_02_title->PlaceHolder = ew_RemoveHtml($this->section_02_title->FldCaption());

		// section_02_title_ar
		$this->section_02_title_ar->EditAttrs["class"] = "form-control";
		$this->section_02_title_ar->EditCustomAttributes = "";
		$this->section_02_title_ar->EditValue = $this->section_02_title_ar->CurrentValue;
		$this->section_02_title_ar->PlaceHolder = ew_RemoveHtml($this->section_02_title_ar->FldCaption());

		// section_02_summary
		$this->section_02_summary->EditAttrs["class"] = "form-control";
		$this->section_02_summary->EditCustomAttributes = "";
		$this->section_02_summary->EditValue = $this->section_02_summary->CurrentValue;
		$this->section_02_summary->PlaceHolder = ew_RemoveHtml($this->section_02_summary->FldCaption());

		// section_02_summary_ar
		$this->section_02_summary_ar->EditAttrs["class"] = "form-control";
		$this->section_02_summary_ar->EditCustomAttributes = "";
		$this->section_02_summary_ar->EditValue = $this->section_02_summary_ar->CurrentValue;
		$this->section_02_summary_ar->PlaceHolder = ew_RemoveHtml($this->section_02_summary_ar->FldCaption());

		// section_02_icon
		$this->section_02_icon->EditAttrs["class"] = "form-control";
		$this->section_02_icon->EditCustomAttributes = "";
		$this->section_02_icon->EditValue = $this->section_02_icon->CurrentValue;
		$this->section_02_icon->PlaceHolder = ew_RemoveHtml($this->section_02_icon->FldCaption());

		// section_03_title
		$this->section_03_title->EditAttrs["class"] = "form-control";
		$this->section_03_title->EditCustomAttributes = "";
		$this->section_03_title->EditValue = $this->section_03_title->CurrentValue;
		$this->section_03_title->PlaceHolder = ew_RemoveHtml($this->section_03_title->FldCaption());

		// section_03_title_ar
		$this->section_03_title_ar->EditAttrs["class"] = "form-control";
		$this->section_03_title_ar->EditCustomAttributes = "";
		$this->section_03_title_ar->EditValue = $this->section_03_title_ar->CurrentValue;
		$this->section_03_title_ar->PlaceHolder = ew_RemoveHtml($this->section_03_title_ar->FldCaption());

		// section_03_summary
		$this->section_03_summary->EditAttrs["class"] = "form-control";
		$this->section_03_summary->EditCustomAttributes = "";
		$this->section_03_summary->EditValue = $this->section_03_summary->CurrentValue;
		$this->section_03_summary->PlaceHolder = ew_RemoveHtml($this->section_03_summary->FldCaption());

		// section_03_summary_ar
		$this->section_03_summary_ar->EditAttrs["class"] = "form-control";
		$this->section_03_summary_ar->EditCustomAttributes = "";
		$this->section_03_summary_ar->EditValue = $this->section_03_summary_ar->CurrentValue;
		$this->section_03_summary_ar->PlaceHolder = ew_RemoveHtml($this->section_03_summary_ar->FldCaption());

		// section_03_icon
		$this->section_03_icon->EditAttrs["class"] = "form-control";
		$this->section_03_icon->EditCustomAttributes = "";
		$this->section_03_icon->EditValue = $this->section_03_icon->CurrentValue;
		$this->section_03_icon->PlaceHolder = ew_RemoveHtml($this->section_03_icon->FldCaption());

		// section_04_title
		$this->section_04_title->EditAttrs["class"] = "form-control";
		$this->section_04_title->EditCustomAttributes = "";
		$this->section_04_title->EditValue = $this->section_04_title->CurrentValue;
		$this->section_04_title->PlaceHolder = ew_RemoveHtml($this->section_04_title->FldCaption());

		// section_04_title_ar
		$this->section_04_title_ar->EditAttrs["class"] = "form-control";
		$this->section_04_title_ar->EditCustomAttributes = "";
		$this->section_04_title_ar->EditValue = $this->section_04_title_ar->CurrentValue;
		$this->section_04_title_ar->PlaceHolder = ew_RemoveHtml($this->section_04_title_ar->FldCaption());

		// section_04_summary
		$this->section_04_summary->EditAttrs["class"] = "form-control";
		$this->section_04_summary->EditCustomAttributes = "";
		$this->section_04_summary->EditValue = $this->section_04_summary->CurrentValue;
		$this->section_04_summary->PlaceHolder = ew_RemoveHtml($this->section_04_summary->FldCaption());

		// section_04_summary_ar
		$this->section_04_summary_ar->EditAttrs["class"] = "form-control";
		$this->section_04_summary_ar->EditCustomAttributes = "";
		$this->section_04_summary_ar->EditValue = $this->section_04_summary_ar->CurrentValue;
		$this->section_04_summary_ar->PlaceHolder = ew_RemoveHtml($this->section_04_summary_ar->FldCaption());

		// section_04_icon
		$this->section_04_icon->EditAttrs["class"] = "form-control";
		$this->section_04_icon->EditCustomAttributes = "";
		$this->section_04_icon->EditValue = $this->section_04_icon->CurrentValue;
		$this->section_04_icon->PlaceHolder = ew_RemoveHtml($this->section_04_icon->FldCaption());

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
					if ($this->campaignSlug->Exportable) $Doc->ExportCaption($this->campaignSlug);
					if ($this->sliderImage->Exportable) $Doc->ExportCaption($this->sliderImage);
					if ($this->sliderImage_ar->Exportable) $Doc->ExportCaption($this->sliderImage_ar);
					if ($this->description->Exportable) $Doc->ExportCaption($this->description);
					if ($this->description_ar->Exportable) $Doc->ExportCaption($this->description_ar);
					if ($this->section_01_title->Exportable) $Doc->ExportCaption($this->section_01_title);
					if ($this->section_01_title_ar->Exportable) $Doc->ExportCaption($this->section_01_title_ar);
					if ($this->section_01_summary->Exportable) $Doc->ExportCaption($this->section_01_summary);
					if ($this->section_01_summary_ar->Exportable) $Doc->ExportCaption($this->section_01_summary_ar);
					if ($this->section_01_icon->Exportable) $Doc->ExportCaption($this->section_01_icon);
					if ($this->section_02_title->Exportable) $Doc->ExportCaption($this->section_02_title);
					if ($this->section_02_title_ar->Exportable) $Doc->ExportCaption($this->section_02_title_ar);
					if ($this->section_02_summary->Exportable) $Doc->ExportCaption($this->section_02_summary);
					if ($this->section_02_summary_ar->Exportable) $Doc->ExportCaption($this->section_02_summary_ar);
					if ($this->section_02_icon->Exportable) $Doc->ExportCaption($this->section_02_icon);
					if ($this->section_03_title->Exportable) $Doc->ExportCaption($this->section_03_title);
					if ($this->section_03_title_ar->Exportable) $Doc->ExportCaption($this->section_03_title_ar);
					if ($this->section_03_summary->Exportable) $Doc->ExportCaption($this->section_03_summary);
					if ($this->section_03_summary_ar->Exportable) $Doc->ExportCaption($this->section_03_summary_ar);
					if ($this->section_03_icon->Exportable) $Doc->ExportCaption($this->section_03_icon);
					if ($this->section_04_title->Exportable) $Doc->ExportCaption($this->section_04_title);
					if ($this->section_04_title_ar->Exportable) $Doc->ExportCaption($this->section_04_title_ar);
					if ($this->section_04_summary->Exportable) $Doc->ExportCaption($this->section_04_summary);
					if ($this->section_04_summary_ar->Exportable) $Doc->ExportCaption($this->section_04_summary_ar);
					if ($this->section_04_icon->Exportable) $Doc->ExportCaption($this->section_04_icon);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->title->Exportable) $Doc->ExportCaption($this->title);
					if ($this->title_ar->Exportable) $Doc->ExportCaption($this->title_ar);
					if ($this->campaignSlug->Exportable) $Doc->ExportCaption($this->campaignSlug);
					if ($this->sliderImage->Exportable) $Doc->ExportCaption($this->sliderImage);
					if ($this->sliderImage_ar->Exportable) $Doc->ExportCaption($this->sliderImage_ar);
					if ($this->section_01_title->Exportable) $Doc->ExportCaption($this->section_01_title);
					if ($this->section_01_title_ar->Exportable) $Doc->ExportCaption($this->section_01_title_ar);
					if ($this->section_01_summary->Exportable) $Doc->ExportCaption($this->section_01_summary);
					if ($this->section_01_summary_ar->Exportable) $Doc->ExportCaption($this->section_01_summary_ar);
					if ($this->section_01_icon->Exportable) $Doc->ExportCaption($this->section_01_icon);
					if ($this->section_02_title->Exportable) $Doc->ExportCaption($this->section_02_title);
					if ($this->section_02_title_ar->Exportable) $Doc->ExportCaption($this->section_02_title_ar);
					if ($this->section_02_summary->Exportable) $Doc->ExportCaption($this->section_02_summary);
					if ($this->section_02_summary_ar->Exportable) $Doc->ExportCaption($this->section_02_summary_ar);
					if ($this->section_02_icon->Exportable) $Doc->ExportCaption($this->section_02_icon);
					if ($this->section_03_title->Exportable) $Doc->ExportCaption($this->section_03_title);
					if ($this->section_03_title_ar->Exportable) $Doc->ExportCaption($this->section_03_title_ar);
					if ($this->section_03_summary->Exportable) $Doc->ExportCaption($this->section_03_summary);
					if ($this->section_03_summary_ar->Exportable) $Doc->ExportCaption($this->section_03_summary_ar);
					if ($this->section_03_icon->Exportable) $Doc->ExportCaption($this->section_03_icon);
					if ($this->section_04_title->Exportable) $Doc->ExportCaption($this->section_04_title);
					if ($this->section_04_title_ar->Exportable) $Doc->ExportCaption($this->section_04_title_ar);
					if ($this->section_04_summary->Exportable) $Doc->ExportCaption($this->section_04_summary);
					if ($this->section_04_summary_ar->Exportable) $Doc->ExportCaption($this->section_04_summary_ar);
					if ($this->section_04_icon->Exportable) $Doc->ExportCaption($this->section_04_icon);
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
						if ($this->campaignSlug->Exportable) $Doc->ExportField($this->campaignSlug);
						if ($this->sliderImage->Exportable) $Doc->ExportField($this->sliderImage);
						if ($this->sliderImage_ar->Exportable) $Doc->ExportField($this->sliderImage_ar);
						if ($this->description->Exportable) $Doc->ExportField($this->description);
						if ($this->description_ar->Exportable) $Doc->ExportField($this->description_ar);
						if ($this->section_01_title->Exportable) $Doc->ExportField($this->section_01_title);
						if ($this->section_01_title_ar->Exportable) $Doc->ExportField($this->section_01_title_ar);
						if ($this->section_01_summary->Exportable) $Doc->ExportField($this->section_01_summary);
						if ($this->section_01_summary_ar->Exportable) $Doc->ExportField($this->section_01_summary_ar);
						if ($this->section_01_icon->Exportable) $Doc->ExportField($this->section_01_icon);
						if ($this->section_02_title->Exportable) $Doc->ExportField($this->section_02_title);
						if ($this->section_02_title_ar->Exportable) $Doc->ExportField($this->section_02_title_ar);
						if ($this->section_02_summary->Exportable) $Doc->ExportField($this->section_02_summary);
						if ($this->section_02_summary_ar->Exportable) $Doc->ExportField($this->section_02_summary_ar);
						if ($this->section_02_icon->Exportable) $Doc->ExportField($this->section_02_icon);
						if ($this->section_03_title->Exportable) $Doc->ExportField($this->section_03_title);
						if ($this->section_03_title_ar->Exportable) $Doc->ExportField($this->section_03_title_ar);
						if ($this->section_03_summary->Exportable) $Doc->ExportField($this->section_03_summary);
						if ($this->section_03_summary_ar->Exportable) $Doc->ExportField($this->section_03_summary_ar);
						if ($this->section_03_icon->Exportable) $Doc->ExportField($this->section_03_icon);
						if ($this->section_04_title->Exportable) $Doc->ExportField($this->section_04_title);
						if ($this->section_04_title_ar->Exportable) $Doc->ExportField($this->section_04_title_ar);
						if ($this->section_04_summary->Exportable) $Doc->ExportField($this->section_04_summary);
						if ($this->section_04_summary_ar->Exportable) $Doc->ExportField($this->section_04_summary_ar);
						if ($this->section_04_icon->Exportable) $Doc->ExportField($this->section_04_icon);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->title->Exportable) $Doc->ExportField($this->title);
						if ($this->title_ar->Exportable) $Doc->ExportField($this->title_ar);
						if ($this->campaignSlug->Exportable) $Doc->ExportField($this->campaignSlug);
						if ($this->sliderImage->Exportable) $Doc->ExportField($this->sliderImage);
						if ($this->sliderImage_ar->Exportable) $Doc->ExportField($this->sliderImage_ar);
						if ($this->section_01_title->Exportable) $Doc->ExportField($this->section_01_title);
						if ($this->section_01_title_ar->Exportable) $Doc->ExportField($this->section_01_title_ar);
						if ($this->section_01_summary->Exportable) $Doc->ExportField($this->section_01_summary);
						if ($this->section_01_summary_ar->Exportable) $Doc->ExportField($this->section_01_summary_ar);
						if ($this->section_01_icon->Exportable) $Doc->ExportField($this->section_01_icon);
						if ($this->section_02_title->Exportable) $Doc->ExportField($this->section_02_title);
						if ($this->section_02_title_ar->Exportable) $Doc->ExportField($this->section_02_title_ar);
						if ($this->section_02_summary->Exportable) $Doc->ExportField($this->section_02_summary);
						if ($this->section_02_summary_ar->Exportable) $Doc->ExportField($this->section_02_summary_ar);
						if ($this->section_02_icon->Exportable) $Doc->ExportField($this->section_02_icon);
						if ($this->section_03_title->Exportable) $Doc->ExportField($this->section_03_title);
						if ($this->section_03_title_ar->Exportable) $Doc->ExportField($this->section_03_title_ar);
						if ($this->section_03_summary->Exportable) $Doc->ExportField($this->section_03_summary);
						if ($this->section_03_summary_ar->Exportable) $Doc->ExportField($this->section_03_summary_ar);
						if ($this->section_03_icon->Exportable) $Doc->ExportField($this->section_03_icon);
						if ($this->section_04_title->Exportable) $Doc->ExportField($this->section_04_title);
						if ($this->section_04_title_ar->Exportable) $Doc->ExportField($this->section_04_title_ar);
						if ($this->section_04_summary->Exportable) $Doc->ExportField($this->section_04_summary);
						if ($this->section_04_summary_ar->Exportable) $Doc->ExportField($this->section_04_summary_ar);
						if ($this->section_04_icon->Exportable) $Doc->ExportField($this->section_04_icon);
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
