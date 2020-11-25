<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['base_url'] = (is_https() ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME'])));
$config['index_page'] = '';
$config['uri_protocol']	= 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language']	= 'indonesia';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = '_';
$config['composer_autoload'] = FALSE;
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';
$config['log_threshold'] = 0;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;
$config['encryption_key'] = '';
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 17200;
$config['sess_save_path'] = NULL;
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;
$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;
$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = FALSE;
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';

$config['title'] = "E-BUSINESS";
$config['copyright'] = 'Copyright &copy; PJBS NIAGA '.date('Y');
$config['date_format'] = "DD-MM-YYYY";
$config['timestamp_format'] = "DD-MM-YYYY hh24:mi:ss";

$config['company_name'] = "PT PJB SERVICES";
$config['company_address'] = "Jl. Raya Juanda No. 17 Sidoarjo, Jawa Timur - Indonesia 61253";
$config['company_telp'] = "(031) 8548391, (031) 8557909";
$config['company_email'] = "info@pjbservices.com";
$config['company_fax'] = "(031) 8548360";

$config['file_upload_config']['upload_path']          = './uploads/';
$config['file_upload_config']['allowed_types']        = 'gif|jpg|jpeg|bmp|png|pdf|doc|docx';
$config['file_upload_config']['max_size']             = 100000; //kb

$config['sso']['auth_page'] = false;
$config['url_java'] = "http://localhost:8081/javabridge/java/Java.inc";
$config['url_hpe'] = "http://localhost/ketonggo_project/pjbs_scm2019/panelbackend/ws/";
$config['url_ellipse'] = "http://172.16.33.157:8082/promise_pr_json";
$config['auth_hpe'] = array("username"=>"ngademin","password"=>"46f7ccf5b4ce37384ec5ac4e524b8f7e5ef28c0a");


$config['url_promis'] = "http://promis.pjbservices.com/panelbackend/ws/";
$config['auth_promis'] = array("username"=>"abud","password"=>"46f7ccf5b4ce37384ec5ac4e524b8f7e5ef28c0a");

$config['url_pembayaran'] = "http://172.16.33.157:8083/fb50163d8bd9895aee6299afdfa8d858";

$config['acc_code7']  = "http://172.16.33.157:9091/account_code7";
$config['acc_code6']  = "http://172.16.33.157:9091/account_code6";
$config['acc_code5']  = "http://172.16.33.157:9091/account_code5";
$config['acc_code4']  = "http://172.16.33.157:9091/account_code4";
$config['acc_code3']  = "http://172.16.33.157:9091/account_code3";
$config['acc_code2']  = "http://172.16.33.157:9091/account_code2";
$config['acc_code1']  = "http://172.16.33.157:9091/account_code1";
$config['acc_code1']  = "http://172.16.33.157:9091/account_code1";
$config['sess_wo']    = "http://172.16.33.157:9091/session_wo";
$config['wo_prospek'] = "http://172.16.33.157:9091/wo_prospek";

$config['wo_prospek_local'] = "http://niaga-api.test/api/workorder/store";

$config['status_fisik'] = [
	1 => 'Batal',
	2 => 'Belum Jalan',
	3 => 'Running',
	4 => 'Selesai',
];


$config['status_niaga'] = [
	1 => 'Belum ada permintaan',
	2 => 'RAB',
	3 => 'Pricing',
	4 => 'Penawaran',
	5 => 'Nego',
	6 => 'Belum Kontrak',
	7 => 'Kesepakatan Harga',
	8 => 'BA Kesepakatan',
	9 => 'Belum Kontrak',
	10 => 'Kontrak',
	11 => 'Laporan/BA',
	12 => 'Termin / Retensi',
	13 => 'Tagihan',
	14 => 'Terbayar',
	15 => 'Cancel',
];