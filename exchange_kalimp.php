<?php

session_start();
date_default_timezone_set('Europe/Tirane');

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  // logout
  $GLOBALS['uid']         = "";
  $GLOBALS['Username']    = "";
  $GLOBALS['full_name']   = "";
  $GLOBALS['Usertrans']   = "";
  $GLOBALS['Userfilial']  = "";
  $GLOBALS['Usertype']    = "";
  $_SESSION['uid']        = "";
  $_SESSION['Username']   = "";
  $_SESSION['full_name']  = "";
  $_SESSION['Usertrans']  = "";
  $_SESSION['Userfilial'] = "";
  $_SESSION['Usertype']   = "";

  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}

?>
<?php require_once('ConMySQL.php'); ?>
<?php

if (isset($_SESSION['uid'])) {
  $user_info = (get_magic_quotes_gpc()) ? $_SESSION['Username'] : addslashes($_SESSION['Username']);

mysql_select_db($database_MySQL, $MySQL);

$sql_exchange_info = "select * from exchange_koke where id = '". $user_info .'TRN'. $_GET['hid'] ."'";
$exchange_info = mysql_query($sql_exchange_info, $MySQL) or die(mysql_error());
$row_exchange_info = mysql_fetch_assoc($exchange_info);

$sql_exchange_det_info = "select * from exchange_detaje where id_exchangekoke = '". $row_exchange_info['id'] ."' ";
$exchange_det_info = mysql_query($sql_exchange_det_info, $MySQL) or die(mysql_error());
$row_exchange_det_info = mysql_fetch_assoc($exchange_det_info);

?>


<!-- --------------------------------------- -->
<!--          Aplikacioni xChange            -->
<!--                                         -->
<!--  Kontakt:                               -->
<!--                                         -->
<!--           GlobalTech.al                 -->
<!--                                         -->
<!--        info@globaltech.al            -->
<!-- --------------------------------------- -->


<html>

<head>

<title><?php echo $_SESSION['CNAME']; ?> - Web Exchange System</title>

<link href="styles2.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
body,td,th {
    font-size: 10px;
}
-->
</style>

</head>

<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="5" bgcolor=#FFFFFF vlink="#0000ff" link="#0000ff" onLoad="JavaScript: window.print();">

<!--
<TABLE cellSpacing=0 cellPadding=0 width="250" border=0>
  <TBODY>
    <TR>
      <TD align="center">
        <img src="images/header.png" border="0" width="250">
      </TD>
    </TR>
  </TBODY>
</TABLE>
-->
<TABLE cellSpacing=0 cellPadding=0 width="250" border=0>
  <TBODY>
    <TR>
      <TD height="15" colSpan=3 align="left" valign="middle">
        <DIV class=ctxheadingP><b><font size="2">&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['CNAME']; ?>&nbsp;<br>&nbsp;&nbsp;&nbsp;NIPT: <?php echo $_SESSION['CNIPT']; ?><br>&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['CADDR']; ?></font></b></DIV></TD>
    </TR>
  </TBODY>
</TABLE>

<TABLE cellSpacing=0 cellPadding=0 width="250" border=0>
  <TBODY>
    <TR>
      <TD align="center" colSpan=3>
        <DIV class=ctxheadingP>

    <table width="250"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="7" height="5"></td>
      </tr>
      <tr valign="middle">
        <td width="5"></td>
        <td width="*" colspan="5">Nr. Fat.:&nbsp;<b><?php echo $row_exchange_info['id_llogfilial']."-".$row_exchange_info['unique_id']; ?></b></td>
        <td width="5"></td>
      </tr>
      <tr>
        <td colspan="7" height="5"></td>
      </tr>
      <tr valign="middle">
        <td width="5"></td>
        <td width="*" colspan="5">Date:&nbsp;<b><?php echo substr($row_exchange_info['datarregjistrimit'], 8, 2) .".". substr($row_exchange_info['datarregjistrimit'], 5, 2) .".". substr($row_exchange_info['datarregjistrimit'], 0, 4) ."  ". substr($row_exchange_info['datarregjistrimit'], 11, 8); ?></b></td>
        <td width="5"></td>
      </tr>
      <tr>
        <td colspan="7" height="5"></td>
      </tr>
      <tr>
        <td width="5"></td>
<?php
        $sql_subinfo = "select * from filiali where id = ". $row_exchange_info['id_llogfilial'];
        $rs_subinfo = mysql_query($sql_subinfo, $MySQL) or die(mysql_error());
        $row_rs_subinfo = mysql_fetch_assoc($rs_subinfo);
        $info = $row_rs_subinfo['filiali'];
        mysqli_free_result($rs_subinfo);
?>
        <td width="*" colspan="5">Nga Llogaria:&nbsp;<b><?php echo $info; ?></b></td>
        <td width="5"></td>
      </tr>
      <tr>
        <td width="5"></td>
<?php
        $sql_subinfo = "select * from filiali where id = ". $row_exchange_info['id_klienti'];
        $rs_subinfo = mysql_query($sql_subinfo, $MySQL) or die(mysql_error());
        $row_rs_subinfo = mysql_fetch_assoc($rs_subinfo);
        $info = $row_rs_subinfo['filiali'];
        mysqli_free_result($rs_subinfo);
?>
        <td width="*" colspan="5">Tek Llogaria:&nbsp;<b><?php echo $info; ?></b></td>
        <td width="5"></td>
      </tr>
      <tr>
        <td colspan="7" height="5"></td>
      </tr>
      <tr>
        <td width="5"></td>
        <td colspan="5" height="1" bgcolor="000000"></td>
        <td width="5"></td>
      </tr>
      <tr>
        <td colspan="7" height="5"></td>
      </tr>
<?php
        $sql_subinfo = "select * from monedha where id = ". $row_exchange_det_info['id_mondebituar'];
        $rs_subinfo = mysql_query($sql_subinfo, $MySQL) or die(mysql_error());
        $row_rs_subinfo = mysql_fetch_assoc($rs_subinfo);
        $info = $row_rs_subinfo['monedha'];
        mysqli_free_result($rs_subinfo);
?>
      <tr>
        <td width="5"></td>
        <td width="*" colspan="5" align="right"><font size="2.5">Shuma e kaluar:&nbsp;<b><?php echo $row_exchange_info['vleftapaguar']; ?></b>&nbsp;<b><?php echo $info; ?></b></font></td>
        <td width="5"></td>
      </tr>
      <tr>
        <td width="5" height="5"></td>
        <td width="20"></td>
        <td width="35"></td>
        <td width="5"></td>
        <td width="55"></td>
        <td width="55"></td>
        <td width="5"></td>
      </tr>
      <tr>
        <td colspan="7" height="5"></td>
      </tr>
    </table>

        </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>

<TABLE cellSpacing=0 cellPadding=0 width="250" border=0>
  <TBODY>
    <TR>
      <TD height="15" colSpan=3 align="left" valign="middle">
        <DIV class=ctxheadingP>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Faleminderit / Thanks !&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a title="Kthehu pas..." class="link4" href="exchange_kalimlog.php"><img src="images/down_arrow.gif" border="0"></a></DIV></TD>
    </TR>
  </TBODY>
</TABLE>

<br>
<br>
<br>


</body>
</html>
<?php
       }
?>

<script>
// Disable right-click context menu
document.addEventListener('contextmenu', event => event.preventDefault());
</script>

<script>
// Disable keyCode
document.addEventListener('keydown', e => {
  if 
  // Disable F1
  (e.keyCode === 112 || 

  // Disable F3
  e.keyCode === 114 || 

  // Disable F5
  e.keyCode === 116 || 

  // Disable F6
  e.keyCode === 117 || 

  // Disable F7
  e.keyCode === 118 || 

  // Disable F10
  e.keyCode === 121 || 

  // Disable F11
  e.keyCode === 122 || 

  // Disable F12
  e.keyCode === 123 || 
  
  // Disable Ctrl
  e.ctrlKey || 
  
  // Disable Shift
  e.shiftKey  || 
  
  // Disable Alt
  e.altKey  || 
  
  // Disable Ctrl+Shift+Key
  e.ctrlKey && e.shiftKey || 

  // Disable Ctrl+Shift+alt
  e.ctrlKey && e.shiftKey && e.altKey
  ) {
    e.preventDefault();
    //alert('Not Allowed');
  }
});
</script>
