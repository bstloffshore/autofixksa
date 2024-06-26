<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "userfn14.php" ?>
<?php
require('uploadhandler.php');

// Upload handler
class cUploadHandler extends UploadHandler {

	// Override initialize()
	protected function initialize() {
		if ($this->get_server_var("REQUEST_METHOD") == "GET" && isset($_GET["delete"]))
			$this->delete();
		else
			parent::initialize();
	}

	// Override get_user_id()
	protected function get_user_id() {
		global $uploadid, $uploadtable;
		$id = EW_UPLOAD_TEMP_FOLDER_PREFIX . session_id();
		if ($uploadid <> "") {
			$uid = $uploadid;
			if ($uploadtable <> "") $uid = $uploadtable . "/" . $uid;
			$id .= "/" . $uid;
		}
		return $id;
	}

	// Override get_unique_filename()
	protected function get_unique_filename($file_path, $name, $size, $type, $error, $index, $content_range) {
		if (EW_UPLOAD_CONVERT_ACCENTED_CHARS) {
			$name = htmlentities($name, ENT_COMPAT, "UTF-8");
			$name = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde|cedil);/', '$1', $name);
			$name = html_entity_decode($name, ENT_COMPAT, "UTF-8");
		}
		$name = ew_Convert("UTF-8", EW_FILE_SYSTEM_ENCODING, $name);
		return parent::get_unique_filename($file_path, $name, $size, $type, $error, $index, $content_range);
	}

	// Override get_singular_param_name()
	protected function get_singular_param_name() {
		return $this->options['param_name'];
	}

	// Override get_file_names_params()
	protected function get_file_names_params() {
		return array(); // Not used
	}

	// Override handle_file_upload()
	protected function handle_file_upload($uploaded_file, $name, $size, $type, $error,
		$index = null, $content_range = null) {

		// Delete all files in directory if replace
		if (@$_REQUEST["replace"] == "1") {
			$upload_dir = $this->get_upload_path();
			if ($ar = glob($upload_dir . "/*.*")) {
				foreach ($ar as $v)
					@unlink($v);
			}
			foreach ($this->options["image_versions"] as $version => $options) {
				if (!empty($version)) {
					if ($ar = glob($upload_dir . "/" . $version . "/*.*")) {
						foreach ($ar as $v)
							@unlink($v);
					}
				}
			}
		}
		return parent::handle_file_upload($uploaded_file, $name, $size, $type, $error, $index, $content_range);
	}

	// Override post()
	public function post($print_response = true) {
		if ($this->get_query_param('_method') === 'DELETE') {
			return $this->delete($print_response);
		}
		$upload = $this->get_upload_data($this->options['param_name']);

		// Parse the Content-Disposition header, if available:
		$content_disposition_header = $this->get_server_var('HTTP_CONTENT_DISPOSITION');
		$file_name = $content_disposition_header ?
			rawurldecode(preg_replace(
				'/(^[^"]+")|("$)/',
				'',
				$content_disposition_header
			)) : null;

		// Parse the Content-Range header, which has the following form:
		// Content-Range: bytes 0-524287/2000000

		$content_range_header = $this->get_server_var('HTTP_CONTENT_RANGE');
		$content_range = $content_range_header ?
			preg_split('/[^0-9]+/', $content_range_header) : null;
		$size = $content_range ? $content_range[3] : null;
		$files = array();
		if ($upload && is_array($upload['tmp_name'])) { //***

			// param_name is an array identifier like "files[]",
			// $upload is a multi-dimensional array:

			foreach ($upload['tmp_name'] as $index => $value) {
				$files[] = $this->handle_file_upload(
					$upload['tmp_name'][$index],
					$file_name ? $file_name : $upload['name'][$index],
					$size ? $size : $upload['size'][$index],
					$upload['type'][$index],
					$upload['error'][$index],
					$index,
					$content_range
				);
			}
		} else {

			// param_name is a single object identifier like "file",
			// $upload is a one-dimensional array:

			$files[] = $this->handle_file_upload(
				isset($upload['tmp_name']) ? $upload['tmp_name'] : null,
				$file_name ? $file_name : (isset($upload['name']) ?
						$upload['name'] : null),
				$size ? $size : (isset($upload['size']) ?
						$upload['size'] : $this->get_server_var('CONTENT_LENGTH')),
				isset($upload['type']) ?
						$upload['type'] : $this->get_server_var('CONTENT_TYPE'),
				isset($upload['error']) ? $upload['error'] : null,
				null,
				$content_range
			);
		}
		$response = array("files" => $files); // Set key as "files" for jquery.fileupload-ui.js //***
		return $this->generate_response($response, $print_response);
	}

	// Override upcount_name_callback()
	protected function upcount_name_callback($matches) {
		$index = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
		$ext = isset($matches[2]) ? $matches[2] : '';
		return '(' . $index . ')' . $ext;
	}

	// Override upcount_name()
	protected function upcount_name($name) {
		return preg_replace_callback(
			'/(?:(?:\(([\d]+)\))?(\.[^.]+))?$/',
			array($this, 'upcount_name_callback'),
			$name,
			1);
	}

	// Override get_scaled_image_file_paths()
	protected function get_scaled_image_file_paths($file_name, $version) {
		$ar = parent::get_scaled_image_file_paths($file_name, $version);
		$file_path = $this->get_upload_path($file_name);
		foreach ($ar as &$path)
			$path = preg_replace('/(?<!:)\/\//', '/', $path);
		return $ar;
	}
}
ew_Header(FALSE);
$uploadid = NULL;
$uploadtable = NULL;
$upload = new cewupload;
$upload->Page_Main();

//
// Page class for upload
//
class cewupload {

	// Page ID
	var $PageID = "upload";

	// Project ID
	var $ProjectID = "{8281128E-C7BB-40DA-A1AE-8695DB7283AC}";

	// Page object name
	var $PageObjName = "upload";

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		return ew_CurrentPage() . "?";
	}

	// Main
	// - Uncomment ** for database connectivity / Page_Loading / Page_Unloaded server event
	function Page_Main() {
		global $conn, $uploadid, $uploadtable;
		$GLOBALS["Page"] = &$this;
		$Language = new cLanguage();

		//**$conn = ew_Connect();
		// Global Page Loading event (in userfn*.php)
		//**Page_Loading();
		// Set up upload parameters

		$uploadid = (@$_REQUEST["id"] <> "") ? $_REQUEST["id"] : "";
		$uploadtable = (@$_REQUEST["table"] <> "") ? $_REQUEST["table"] : "";
		$exts = (@$_REQUEST["exts"] <> "") ? $_REQUEST["exts"] : "";
		$arExt = explode(",", $exts);
		if (EW_UPLOAD_ALLOWED_FILE_EXT <> "") {
			$arAllowedExt = explode(",", EW_UPLOAD_ALLOWED_FILE_EXT);
			$exts = implode(",", array_intersect($arExt, $arAllowedExt)) ?: EW_UPLOAD_ALLOWED_FILE_EXT; // Make sure $exts is a subset of EW_UPLOAD_ALLOWED_FILE_EXT
		} elseif ($exts == "") {
			$exts = "[\s\S]+"; // Allow all file types
		}
		$filetypes = '/\\.(' . str_replace(",", "|", $exts) . ')$/i';
		$maxsize = (@$_REQUEST["maxsize"] <> "") ? intval($_REQUEST["maxsize"]) : NULL;
		$maxfilecount = (@$_REQUEST["maxfilecount"] <> "" && @$_REQUEST["maxfilecount"] <> "0") ? intval($_REQUEST["maxfilecount"]) : NULL;
		$url = ew_ScriptName() . "?rnd=" . ew_Random() . (($uploadid <> "") ? "&id=" . $uploadid : "") . (($uploadtable <> "") ? "&table=" . $uploadtable : ""); // Add id/table for display and delete
		$uploaddir = ew_UploadTempPath();
		$uploadurl = ew_UploadTempPath(FALSE);
		$options = array(
			"param_name" => $uploadid,
			"delete_type" => "POST", // POST or DELETE, set this option to POST for server not supporting DELETE requests
			"user_dirs" => TRUE,
			"download_via_php" => 1,
			"script_url" => $url,
			"upload_dir" => $uploaddir,
			"upload_url" => $uploadurl,
			"max_file_size" => $maxsize,
			"max_number_of_files" => $maxfilecount,
			"accept_file_types" => $filetypes,
			"image_library" => 0, // Set to 0 to use the GD library to scale and orient images
			"image_versions" => array(
				"" => array(
					"auto_orient" => TRUE // Automatically rotate images based on EXIF meta data
				),
				EW_UPLOAD_THUMBNAIL_FOLDER => array(
					"max_width" => EW_UPLOAD_THUMBNAIL_WIDTH,
					"max_height" => EW_UPLOAD_THUMBNAIL_HEIGHT,
					"jpeg_quality" => EW_THUMBNAIL_DEFAULT_QUALITY,
					"png_quality" => 9
				)
			)
		);
		$error_messages = array(
			1 => $Language->Phrase("UploadErrMsg1"),
			2 => $Language->Phrase("UploadErrMsg2"),
			3 => $Language->Phrase("UploadErrMsg3"),
			4 => $Language->Phrase("UploadErrMsg4"),
			6 => $Language->Phrase("UploadErrMsg6"),
			7 => $Language->Phrase("UploadErrMsg7"),
			8 => $Language->Phrase("UploadErrMsg8"),
			'post_max_size' => $Language->Phrase("UploadErrMsgPostMaxSize"),
			'max_file_size' => $Language->Phrase("UploadErrMsgMaxFileSize"),
			'min_file_size' => $Language->Phrase("UploadErrMsgMinFileSize"),
			'accept_file_types' => $Language->Phrase("UploadErrMsgAcceptFileTypes"),
			'max_number_of_files' => $Language->Phrase("UploadErrMsgMaxNumberOfFiles"),
			'max_width' => $Language->Phrase("UploadErrMsgMaxWidth"),
			'min_width' => $Language->Phrase("UploadErrMsgMinWidth"),
			'max_height' => $Language->Phrase("UploadErrMsgMaxHeight"),
			'min_height' => $Language->Phrase("UploadErrMsgMinHeight")
		);
		ob_end_clean();
		$upload_handler = new cUploadHandler($options, TRUE, $error_messages);

		// Global Page Unloaded event (in userfn*.php)
		//**Page_Unloaded();
		// Close connection
		//**ew_CloseConn();

	}
}
?>
