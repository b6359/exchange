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

  require_once('ConMySQL.php');

if ((isset($_SESSION['uid']))&&($_SESSION['Usertype'] != 3)) {
  $user_info = $_SESSION['uid'] ?? addslashes($_SESSION['uid']);

       $v_dt = strftime('%d.%m.%Y');
       if ((isset($_POST['date_trans'])) && ($_POST['date_trans'] != "")) {
           $v_dt = $_POST['date_trans'];
       }
       if ((isset($_GET['dt'])) && ($_GET['dt'] != "")) {
           $v_dt = $_GET['dt'];
       }

?>
<?php
    if (isset($_GET['action']) && ($_GET['action'] == "del")) {
        $sql_info = "DELETE FROM openbalance WHERE id = ". $_GET['hid'];
        $result = mysqli_query($MySQL,$sql_info) or die(mysqli_error($MySQL));
    }
?>

<!-- --------------------------------------- -->
<!--          Aplikacioni xChange            -->
<!--                                         -->
<!--  Kontakt:                               -->
<!--                                         -->
<!--           GlobalTech.al                 -->
<!--                                         -->
<!--        info@globaltech.al               -->
<!-- --------------------------------------- -->


<html>

<head>

<title><?php echo $_SESSION['CNAME']; ?> - Web Exchange System</title>

<link href="styles.css" rel="stylesheet" type="text/css">

<SCRIPT LANGUAGE="JavaScript">
<!--
function do_delete(val1, val2) {
    var flag=false;

        flag = confirm('Jeni i sigurte per fshirjen e ketij rekordi ?!. ');

        if (flag == true) {
                window.location = 'exchange_openbal.php?action=del&hid='+ val1 + '&dt=' + val2;
         }
}
// -->
</SCRIPT>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link href="styles.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/text.css">
    <link rel="stylesheet" type="text/css" href="css/984_width.css">
    <link rel="stylesheet" type="text/css" href="css/layout.css">
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" type="text/css" href="css/server.css"/>

<script language="JavaScript" src="calendar_eu.js"></script>
<link rel="stylesheet" href="calendar.css">

<!--[if gte IE 9]>
  <style type="text/css">
    .gradient {
       filter: none;
    }
  </style>
<![endif]-->

</head>

<body>

<div id="bar">
    <div class="ButonatFillimi">
    	<b>Mir&euml;seerdh&euml;t:&nbsp; <?php echo $_SESSION['full_name']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    	<a href="info.php"   class="ButLart2" target="_top">KREU</a>
    	<a href="exchange_users.php"   class="ButLart2" target="_top">P&Euml;RDORUESIT</a>
    	<!--
      <a href="contact.php" class="ButLart2" target="_top">KONTAKT</a>
      -->
    	<a onclick="openWin()" class="ButLart2" target="_top">TABELA</a>
    	<a href="<?php echo $logoutAction ?>" onclick="closeWin()" class="ButLart2" target="_top">DALJE</a>
      <!--
      <button onclick="openWin()" class="ButLart">TABELA</button>
      <button onclick="closeWin()" class="ButLart">MBYLL</button>
      -->
<script>
let tableWindow;

function openWin() {
  tableWindow = window.open('exchange_tabel.php', ' ', 'toolbar=no,scrollbars=no,resizable=no,width=1280,height=768,top=100,left=' + screen.availWidth);
    return 0;
}

function closeWin() {
  tableWindow.close();
}

</script>
    </div>
    <div class="clear"></div>
</div>

<div class="ShiritiLogo">
    <div class="logo">
    	<a href="info.php" target="_top">
    	<img src="images/header.png" title="<?php echo $_SESSION['CNAME']; ?>" alt="<?php echo $_SESSION['CNAME']; ?>" height="50px">
        </a>
    </div>

    <div class="clear"></div>

</div>

<div id="bar">
    <!-- Login Starts Here -->

    <div class="ButonatFundi">
    	<a href="exchange.php"          class="ButLart2" target="_top">K&euml;mbim Monetar</a>
    	<a href="exchange_kalimlog.php" class="ButLart2" target="_top">Kalim nd&euml;rmjet filialeve</a>
    	<a href="exchange_hyrdal.php"   class="ButLart2" target="_top">Veprime Monetare</a>
    	<a href="exchange_rate.php"     class="ButLart2" target="_top">Kursi i K&euml;mbimit</a>
    	<a href="exchange_opclbal.php"  class="ButLart2" target="_top">Hapje/Mbyllje Dite</a>
    	<a href="exchange_balance.php"  class="ButLart2" target="_top">Bilanci sipas veprimeve</a>
    	<a href="exchange_basedata.php" class="ButLart2" target="_top"><b>T&euml; Dh&euml;nat Baz&euml;</b></a>
    	<a href="exchange_reports.php"  class="ButLart2" target="_top">Raporte</a>
    </div>

    <div class="clear"></div>
</div>
<div id="bar">
    <div class="ButonatFillimi">
    	<a href="exchange_openbal.php"  class="ButLart2" target="_top"><b>Hapje balance</b></a>
    	<a href="exchange_llogari.php"  class="ButLart2" target="_top">Llogarit&euml;</a>
    	<a href="exchange_account.php"  class="ButLart2" target="_top">Filialet</a>
    	<a href="exchange_client.php"   class="ButLart2" target="_top">Klient&euml;t</a>
    	<a href="exchange_currency.php" class="ButLart2" target="_top">Monedhat</a>
    </div>
    <div class="clear"></div>
</div>

<br />

<div class="container_12">

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD height="15" colSpan=3 align="left" valign="middle">
        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a title="Print" href="JavaScript: window.print();"><img src="images/print.gif" border="0"></a>&nbsp; <B>&nbsp;Hapja e balancave p&euml;r dat&euml; (<?php echo $v_dt; ?>)</B></TD>
    </TR>
  </TBODY>
</TABLE>
<br />
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD align="left" colSpan=0 height="15">
       <DIV class=ctxheading6><br>

<form enctype="multipart/form-data" ACTION="exchange_openbal.php" METHOD="POST" name="formmenu">

<table border="0" cellpadding="0" width="600px" cellspacing="0">
  <tr valign="middle">
    <td colspan="5" align="center">Dat&euml;:&nbsp;<input name="date_trans" type="text" value="<?php echo $v_dt; ?>" id="date_trans" size="10" reandonly>&nbsp;
        <script language="JavaScript">
	              var o_cal = new tcal ({
	                  'formname': 'formmenu',
	                  'controlname': 'date_trans'
	              });
	              o_cal.a_tpl.yearscroll = true;
	              o_cal.a_tpl.weekstart = 1;
	    </script>&nbsp; &nbsp; &nbsp; <input name="insupd" class="inputtext4" type="button" value=" Shfaq informacionin " onClick="JavaScript: document.formmenu.submit(); ">
    </td>
  </tr>
  <tr>
    <td height="5" colspan="5"></td>
  </tr>
  <tr>
    <td><b>Llogaria</b></td>
    <td><b>Monedha</b></td>
    <td align="right"><b>Vlera</b>&nbsp; &nbsp; &nbsp; </td>
   <th class="OraColumnHeader">  </th>
   <th class="OraColumnHeader">  </th>
  </tr>
  <tr>
    <td height="5" colspan="5"></td>
  </tr>
<?php

     set_time_limit(0);

     $v_wheresql = "";
     //if ($_SESSION['Usertype'] == 2)  $v_wheresql = " and openbalance.id_llogfilial = ". $_SESSION['Userfilial'] ." ";
     if ($_SESSION['Usertype'] == 3)  $v_wheresql = " and openbalance.perdoruesi    = '". $_SESSION['Username'] ."' ";

        //mysql_select_db($database_MySQL, $MySQL);
        $query_gjendje_info = " SELECT openbalance.id, filiali.filiali, monedha.monedha, openbalance.vleftakredituar
                                  FROM openbalance, monedha, filiali
                                 WHERE openbalance.monedha_id    = monedha.id
                                   AND openbalance.id_llogfilial = filiali.id
                                   and openbalance.id            > (select max(id_opb) from systembalance)
                                   AND openbalance.date_trans    = '". substr($v_dt, 6, 4)."-".substr($v_dt, 3, 2)."-".substr($v_dt, 0, 2) ."'
                                    ". $v_wheresql ."
                              ORDER BY filiali.filiali, openbalance.monedha_id ";
        $gjendje_info     = mysqli_query($MySQL,$query_gjendje_info) or die(mysqli_error($MySQL));
        $row_gjendje_info = mysqli_fetch_assoc($gjendje_info);

  while ($row_gjendje_info) {
?>
  <tr>
    <td height="1" colspan="5" bgcolor="#000033"></td>
  </tr>
  <tr>
    <td><?php echo $row_gjendje_info['filiali']; ?></td>
    <td><?php echo $row_gjendje_info['monedha']; ?></td>
    <td align="right"><?php echo number_format( $row_gjendje_info['vleftakredituar'], 2, '.', ','); ?>&nbsp; &nbsp;</td>
    <td width="20"><a title="Modifiko Informacionin" href="insupd_openbal_data.php?action=upd&hid=<?php echo $row_gjendje_info['id']; ?>"><img src="images/edit.gif" border="0"></a></td>
    <td width="20"><a title="Fshij Informacionin" href="JavaScript: do_delete(<?php echo $row_gjendje_info['id']; ?>); "><img src="images/del.gif" border="0"></a></td>
  </tr>
<?php      $row_gjendje_info = mysqli_fetch_assoc($gjendje_info);
       }
    mysqli_free_result($gjendje_info);
// ---------------------------------------------------------------------------------
?>
  <tr>
    <td height="1" colspan="5" bgcolor="#000033"></td>
  </tr>
  <tr>
    <td height="20" colspan="5"></td>
  </tr>
</table>
<table width="600px" border="0">
  <tr>
    <td>&nbsp;<input name="insert_dt" type="button"  value=" Shto Balance ... " onClick="JavaScript: window.location='insupd_openbal_data.php?action=ins';"></td>
  </tr>
</table>

</form>
</DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>

<br />

</div>

</body>
</html>
<?php
       } else {  header("Location: exchange_basedata.php");  }
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
