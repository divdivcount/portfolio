<?php
/*
FileName: download.php
Modified Date: 20190927
Description: 다운로드 프로세스
*/
// Load Modules
require_once('modules/notification.php');
require_once('modules/db.php');

// Parameter(fname)
$fname = Get('fname', null);

// Functions
function uAgent_IE()
{
  if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false);
    return true;
  return false;
}

// 파일명 보안조치,필요없음
function basename_fix($filename)
{
  return preg_replace('/^.+[\\\\\\/]/', ''. $filename);
}

function getMimeType($filename)
{
  //
  $arr = explode('.', $filename);
  $arrend = end($arr);
  $idx = strtolower($arrend);
  $mimet = array(
    'ai' =>'application/postscript',
    'aif' =>'audio/x-aiff',
    'aifc' =>'audio/x-aiff',
    'xyz' =>'chemical/x-xyz',
    'zip' =>'application/zip',
    'xls' =>'application/vnd.ms-excel',
    'ppt' =>'application/mspowerpoint',
    'doc' =>'application/msword',
    'htm' =>'text/html',
    'html' =>'text/html',
    'eml' =>'message/rfc822',
    'txt' =>'text/plain',
    'pdf' =>'application/pdf',
    'jpg' =>'image/jpeg',
    'gif' =>'image/gif',
    'png' =>'image/png',
    'dwg' =>'application/acad',
    'dxf' =>'application/dxf'
  );

  if (isset( $mimet[$idx] )) {
    return $mimet[$idx];
  } else {
    return 'application/octet-stream';
  }
}

// Process
try
{
  // 파라미터 조사
  if(!$fname) {
    userGoto('파일을 요청하지 않았습니다.','');
  }
  $boardObj = new YoYangBoard($DBconfig['dburl'], $DBconfig['dbid'], $DBconfig['dbpw'], $DBconfig['dbtable'], $DBconfig['dbtype']);
  $fdir = 'upload_file';
  $furl = "$fdir/$fname";

  if(!file_exists($furl)) {
    userGoto('서버에 파일이 존재하지 않습니다.','');
  }
  if(!is_readable($furl)) {
    userGoto('파일을 가져올 권한이 없습니다.','');
  }

  // 파일 조사하기
  $r_fname = $boardObj->SelectRealFile($fname);
  $r_fsize = filesize($furl);
  $r_fmime = getMimeType($fname);

  // Engine 설정
  ini_set('memory_limit', '5120M');
  set_time_limit(0);

  // HTTP Header
  //header('Last-Modified: '.date('r', $ftime));
  header('Content-Type: '.$r_fmime);
  if(uAgent_IE()) {
    $fname_utf = iconv("UTF-8", "euc-kr//IGNORE", $r_fname);
    header('Content-Disposition: attachment; filename='.$fname_utf);
  } else
    header('Content-Disposition: attachment; filename='.$r_fname);
  header('Content-Length: '.$r_fsize);
  header('Content-Transfer-Encoding: binary');

  // HTTP Body
  $fp = fopen($furl, "rb");
  $fcontents = fread($fp, $r_fsize);
  //fpassthru($fp); 동기 전송 방식
  fclose($fp);
  echo $fcontents;
}
catch(Exception $e) {
  gotoUser($e->getMessage(), '');
}
?>
