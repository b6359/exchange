<?php
declare(strict_types=1);

session_start();
date_default_timezone_set('Europe/Tirane');

$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if (!empty($_SERVER['QUERY_STRING'])) {
    $logoutAction .= "&" . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES, 'UTF-8');
}

if (isset($_GET['doLogout']) && $_GET['doLogout'] === "true") {
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

if (isset($_SESSION['uid']) && ($_SESSION['Usertype'] ?? '') !== '3') {
  $user_info = $_SESSION['Username'] ?? '';

/////////////////////////////////////////////////////////////////////////////////////////////////
//////////////                                                           /////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""): string
{
  $theValue = mysqli_real_escape_string($GLOBALS['MySQL'], $theValue ?? '');

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
/////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST["form_action"]) && $_POST["form_action"] === "ins") {

  $date = date('Y-m-d H:i:s');
  $v_dt = $_POST['date_trans'];

  $sql_id_info = "select (max(calculate_id)) nr from exchange_koke where perdoruesi = '". $user_info ."'";
  $id_info = mysqli_query($MySQL, $sql_id_info) or die(mysqli_error($MySQL));
  $row_id_info = mysqli_fetch_assoc($id_info);
  $id_info_value = ($row_id_info['nr'] ?? 0) + 1;
  $id_calc = $user_info .'TRN'. $id_info_value;

  $sql_id_info = "select kodllogari from filiali where id = ". (int)$_POST['id_llogfilial'];
  $id_info = mysqli_query($MySQL, $sql_id_info) or die(mysqli_error($MySQL));
  $row_id_info = mysqli_fetch_assoc($id_info);
  $id_llogarie01 = $row_id_info['kodllogari'] ?? '';

  $sql_id_info = "select kodllogari from filiali where id = ". $_POST['id_klienti'];
  $id_info = mysqli_query($MySQL, $sql_id_info) or die(mysqli_error($MySQL));
  $row_id_info = mysqli_fetch_assoc($id_info);
  $id_llogarie02 = $row_id_info['kodllogari'];

  $insertSQL = sprintf("INSERT INTO exchange_koke ( tipiveprimit, pershkrimi, id, calculate_id, id_trans, date_trans, id_llogfilial, id_monkreditim, id_klienti, perqindjekomisioni, vleftakomisionit, vleftapaguar, perdoruesi, datarregjistrimit)
                                           VALUES ( 'TRN', %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['pershkrimi'], "text"),
                       GetSQLValueString($id_calc, "text"),
                       GetSQLValueString($id_info_value, "int"),
                       GetSQLValueString($_POST['id_trans'], "int"),
                       GetSQLValueString(substr($v_dt, 6, 4)."-".substr($v_dt, 3, 2)."-".substr($v_dt, 0, 2), "date"),
                       GetSQLValueString($_POST['id_llogfilial'], "int"),
                       GetSQLValueString($_POST['id_mondebituar'], "int"),
                       GetSQLValueString($_POST['id_klienti'], "int"),
                       GetSQLValueString("0", "double"),
                       GetSQLValueString("0", "double"),
                       GetSQLValueString($_POST['vleftapaguar'], "double"),
                       GetSQLValueString($user_info, "text"),
                       GetSQLValueString(substr($v_dt, 6, 4)."-".substr($v_dt, 3, 2)."-".substr($v_dt, 0, 2), "date"));
  $Result1 = mysqli_query($MySQL, $insertSQL) or die(mysqli_error($MySQL));

  $insertSQL = sprintf("INSERT INTO exchange_detaje ( id_exchangekoke, id_mondebituar, vleftadebituar, vleftakredituar, kursi, kursi_txt, kursi1, kursi1_txt)
                                             VALUES ( %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($id_calc, "text"),
                       GetSQLValueString($_POST['id_mondebituar'], "int"),
                       GetSQLValueString($_POST['vleftapaguar'], "double"),
                       GetSQLValueString($_POST['vleftapaguar'], "double"),
                       GetSQLValueString($_POST['rate_value'], "double"),
                       GetSQLValueString($_POST['id_mondebituar']."/".$_POST['id_mondebituar'], "text"),
                       GetSQLValueString($_POST['rate_value'], "double"),
                       GetSQLValueString($_POST['id_mondebituar']."/".$_POST['id_mondebituar'], "text") );
  $Result1 = mysqli_query($MySQL, $insertSQL) or die(mysqli_error($MySQL));

  // shtimi i rreshtave per transaksionet
  if ($_POST['vleftapaguar'] > 0) {

      $insertSQL = sprintf("INSERT INTO tblalltransactions ( id_veprimi, date_trans, tipiveprimit, pershkrimi, id_filiali, id_llogari, id_monedhe, vleradebituar, vlerakredituar, kursi, perdoruesi, datarregjistrimit )
                                                    VALUES ( %s, %s, 'TRN', 'Kalim monetar ndermjet filialeve', %s, %s, %s, %s, 0, %s, %s, %s )",
                           GetSQLValueString($id_calc, "text"),
                           GetSQLValueString(substr($v_dt, 6, 4)."-".substr($v_dt, 3, 2)."-".substr($v_dt, 0, 2), "date"),
                           GetSQLValueString($_POST['id_llogfilial'], "int"),
                           GetSQLValueString($id_llogarie01, "text"),
                           GetSQLValueString($_POST['id_mondebituar'], "int"),
                           GetSQLValueString($_POST['vleftapaguar'], "double"),
                           GetSQLValueString($_POST['rate_value'], "double"),
                           GetSQLValueString($user_info, "text"),
                           GetSQLValueString($date, "date") );
      $Result1 = mysqli_query($MySQL, $insertSQL) or die(mysqli_error($MySQL));
   }
  if ($_POST['vleftapaguar'] > 0) {

      $insertSQL = sprintf("INSERT INTO tblalltransactions ( id_veprimi, date_trans, tipiveprimit, pershkrimi, id_filiali, id_llogari, id_monedhe, vleradebituar, vlerakredituar, kursi, perdoruesi, datarregjistrimit )
                                                    VALUES ( %s, %s, 'TRN', 'Kalim monetar ndermjet filialeve', %s, %s, %s, 0, %s, %s, %s, %s )",
                           GetSQLValueString($id_calc, "text"),
                           GetSQLValueString(substr($v_dt, 6, 4)."-".substr($v_dt, 3, 2)."-".substr($v_dt, 0, 2), "date"),
                           GetSQLValueString($_POST['id_klienti'], "int"),
                           GetSQLValueString($id_llogarie02, "text"),
                           GetSQLValueString($_POST['id_mondebituar'], "int"),
                           GetSQLValueString($_POST['vleftapaguar'], "double"),
                           GetSQLValueString($_POST['rate_value'], "double"),
                           GetSQLValueString($user_info, "text"),
                           GetSQLValueString($date, "date") );
      $Result1 = mysqli_query($MySQL, $insertSQL) or die(mysqli_error($MySQL));
   }



  $updateGoTo = "exchange_kalimp.php?hid=". $id_info_value;
  header(sprintf("Location: %s", $updateGoTo));
}

  $sql_id_info = "select opstatus from opencloseday";
  $id_info = mysqli_query($MySQL, $sql_id_info) or die(mysqli_error($MySQL));
  $row_id_info = mysqli_fetch_assoc($id_info);
  $opstatus    = $row_id_info['opstatus'] ?? '';

  if ($opstatus == "C") {

      $updateGoTo = "info.php";
      header(sprintf("Location: %s", $updateGoTo));
  }

//----------------------------------------------------------------------------------

// Initialize SQL where clauses
$v_wheresql = "";
$v_wheresqls = "";
$v_wheresqle = "";

// Set conditions based on user type
if (($_SESSION['Usertype'] ?? '') === '3') {
    $userFilial = (int)($_SESSION['Userfilial'] ?? 0);
    $v_wheresql = " WHERE id = $userFilial";
    $v_wheresqls = " WHERE id <> $userFilial";
    $v_wheresqle = " AND id_llogfilial = $userFilial";
}

$query_filiali_info = "SELECT * FROM filiali" . $v_wheresql . " ORDER BY id ASC";
$filiali_info = mysqli_query($MySQL, $query_filiali_info) or die(mysqli_error($MySQL));
$row_filiali_info = mysqli_fetch_assoc($filiali_info);

$temp_v_wheresqle_query_klienti_info = isset($v_wheresqle) ? $v_wheresqle : "";
$query_klienti_info = "select * from filiali ". $temp_v_wheresqle_query_klienti_info ." order by id asc";
$klienti_info = mysqli_query($MySQL, $query_klienti_info) or die(mysqli_error($MySQL));
$row_klienti_info = mysqli_fetch_assoc($klienti_info);
$query_monedha_info = "select * from monedha order by mon_vendi desc, id ";
$monedha_info = mysqli_query($MySQL, $query_monedha_info) or die(mysqli_error($MySQL));
$row_monedha_info = mysqli_fetch_assoc($monedha_info);
//----------------------------------------------------------------------------------
$temp_v_wheresqle = isset($v_wheresqle) ? $v_wheresqle : "";
$sql_info = "select * from kursi_koka where id = (select max(id) from kursi_koka where 1=1 ". $temp_v_wheresqle .") ". $temp_v_wheresqle;
$id_kursi = mysqli_query($MySQL, $sql_info) or die(mysqli_error($MySQL));
$row_id_kursi = mysqli_fetch_assoc($id_kursi);
$query_monkurs_info = " select kursi_detaje.*, monedha.monedha, monedha.id monid
                          from kursi_detaje, monedha
                         where master_id = ". $row_id_kursi['id'] ."
                           and kursi_detaje.monedha_id = monedha.id ";
$monkurs_info = mysqli_query($MySQL, $query_monkurs_info) or die(mysqli_error($MySQL));
$row_monkurs_info = mysqli_fetch_assoc($monkurs_info);
//----------------------------------------------------------------------------------

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

<script language="JavaScript">
<!-- Begin

function focusOnMyInputBox(){
    document.getElementById("vleftapaguar").focus();
}

rate_value = 0;

news = new Array();

    news[1] = new Array();
    news[1][1] = "LEK";
    news[1][2] = "1";
    news[1][3] = "1";

    news[999] = new Array();
    news[999][1] = "";
    news[999][2] = "";
    news[999][3] = "";

<?php

  while ( $row_monkurs_info ) { ?>

    news[<?php echo $row_monkurs_info['monid']; ?>] = new Array();
    news[<?php echo $row_monkurs_info['monid']; ?>][1] = "<?php echo $row_monkurs_info['monedha']; ?>";
    news[<?php echo $row_monkurs_info['monid']; ?>][2] = "<?php echo ( $row_monkurs_info['kursiblerje'] + $row_monkurs_info['kursishitje'] ) / 2; ?>";
<?php
           $row_monkurs_info = mysqli_fetch_assoc($monkurs_info);
      };

mysqli_free_result($monkurs_info);

?>

function disp_kursitxt(mon_id) {

    document.formmenu.rate_value.value  = news[mon_id][2];
};

function Open_Filial_Window() {

    childWindow = window.open( 'filial_list.php', 'FilialList', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=335,height=350');
}

function Open_Filial2_Window() {

    childWindow = window.open( 'filial2_list.php', 'FilialList', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=335,height=350');
}

//  End -->
</script>

<script language="JavaScript" src="calendar_eu.js"></script>
<link rel="stylesheet" href="calendar.css">

<script language="JavaScript">
<!--  Begin

function checkform ( form )
 {
   if (form.vleftapaguar.value == "") {
     alert( "Ju lutem plotesoni fushen: vlefta" );
     form.vleftapaguar.focus();
     return false ;
    }
   if (form.vleftapaguar.value == "0") {
     alert( "Ju lutem plotesoni fushen: vlefta" );
     form.vleftapaguar.focus();
     return false ;
    }
   if (form.vleftapaguar.value == "0.0") {
     alert( "Ju lutem plotesoni fushen: vlefta" );
     form.vleftapaguar.focus();
     return false ;
    }
   if (form.vleftapaguar.value == "0.00") {
     alert( "Ju lutem plotesoni fushen: vlefta" );
     form.vleftapaguar.focus();
     return false ;
    }

   if (form.id_mondebituar.value == "999") {
     alert( "Ju lutem plotesoni fushen: jap" );
     form.id_mondebituar.focus();
     return false ;
    }

   return true ;
}

//  End -->
</script>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link href="styles.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/text.css">
    <link rel="stylesheet" type="text/css" href="css/984_width.css">
    <link rel="stylesheet" type="text/css" href="css/layout.css">
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" type="text/css" href="css/server.css"/>

<!--[if gte IE 9]>
  <style type="text/css">
    .gradient {
       filter: none;
    }
  </style>
<![endif]-->

</head>

<body onLoad="focusOnMyInputBox();">

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
    	<a href="exchange_kalimlog.php" class="ButLart2" target="_top"><b>Kalim nd&euml;rmjet filialeve</b></a>
    	<a href="exchange_hyrdal.php"   class="ButLart2" target="_top">Veprime Monetare</a>
    	<a href="exchange_rate.php"     class="ButLart2" target="_top">Kursi i K&euml;mbimit</a>
    	<a href="exchange_opclbal.php"  class="ButLart2" target="_top">Hapje/Mbyllje Dite</a>
    	<a href="exchange_balance.php"  class="ButLart2" target="_top">Bilanci sipas veprimeve</a>
    	<a href="exchange_basedata.php" class="ButLart2" target="_top">T&euml; Dh&euml;nat Baz&euml;</a>
    	<a href="exchange_reports.php"  class="ButLart2" target="_top">Raporte</a>
    </div>

    <div class="clear"></div>
</div>
<div id="bar">
    <div class="ButonatFillimi">
    	<a href="exchange_transkl.php" class="ButLart2" target="_top">Lista e transaksioneve</a>
    </div>
    <div class="clear"></div>
</div>

<div class="container_12">

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD align="left">

<form enctype="multipart/form-data" ACTION="exchange_kalimlog.php" METHOD="POST" name="formmenu" onsubmit="return checkform(this);">

  <input name="form_action" type="hidden" value="ins">
  <input name="rate_value"  type="hidden" value="1">
  <input name="total_value" type="hidden" value="">

    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="7" height="15"></td>
      </tr>
      <tr valign="middle">
        <td width="20"></td>
        <td width="250" colspan="2"><lable>Grup Trans.:&nbsp;<input name="id_trans" type="text" id="id_trans" value="<?php echo $_SESSION['Usertrans']; ?>" size="10" readonly></lable></td>
        <td width="10"></td>
        <td width="300" colspan="2"><lable>Dat&euml;:&nbsp;<input name="date_trans" type="text" value="<?php echo strftime('%d.%m.%Y'); ?>" id="date_trans" size="10" readonly>
        <script language="JavaScript">
	              var o_cal = new tcal ({
	                  'formname': 'formmenu',
	                  'controlname': 'date_trans'
	              });
	              o_cal.a_tpl.yearscroll = true;
	              o_cal.a_tpl.weekstart = 1;
	    </script>        </lable></td>
        <td width="20"></td>
      </tr>
      <tr>
        <td colspan="7" height="5"></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2"><lable>Nga Filiali:&nbsp;<select name="id_llogfilial" id="id_llogfilial">
<?php
       while ($row_filiali_info) {
?>
           <option value="<?php echo $row_filiali_info['id']; ?>" <?php if ($row_filiali_info['id'] == $_SESSION['Userfilial']) { echo "selected"; } ?>><?php echo $row_filiali_info['filiali']; ?></option>
<?php
         $row_filiali_info = mysqli_fetch_assoc($filiali_info);
       }
    mysqli_free_result($filiali_info);
?>
        </select>&nbsp;&nbsp;<a class="link4" href="JavaScript: Open_Filial_Window();"><img src="images/doc.gif" border="0"></a></lable></td>
        <td></td>
        <td colspan="2"><lable>Tek Filiali:&nbsp;<select name="id_klienti" id="id_klienti">
<?php
       while ($row_klienti_info) {
?>
           <option value="<?php echo $row_klienti_info['id']; ?>" <?php if ($row_klienti_info['id'] <> $_SESSION['Userfilial']) { echo "selected"; } ?>><?php echo $row_klienti_info['filiali']; ?></option>
<?php
         $row_klienti_info = mysqli_fetch_assoc($klienti_info);
       }
    mysqli_free_result($klienti_info);
?>
        </select>&nbsp;&nbsp;<a class="link4" href="JavaScript: Open_Filial2_Window();"><img src="images/doc.gif" border="0"></a></lable></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="7" height="5"></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="5" height="1" bgcolor="000000"></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="7" height="5"></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2"><lable>Monedha:&nbsp;&nbsp;&nbsp;&nbsp;<select name="id_mondebituar" id="id_mondebituar" OnChange="JavaScript: disp_kursitxt( document.formmenu.id_mondebituar.value );">
<?php
       while ($row_monedha_info) {
?>
           <option value="<?php echo $row_monedha_info['id']; ?>"><?php echo $row_monedha_info['monedha']; ?> - <?php echo $row_monedha_info['pershkrimi']; ?></option>
<?php
         $row_monedha_info = mysqli_fetch_assoc($monedha_info);
       }
    mysqli_free_result($monedha_info);
?>
        </select></lable></td>
        <td></td>
        <td colspan="2"><lable>P&euml;rshkrimi:&nbsp;<input name="pershkrimi" type="text" class="inputtext" id="pershkrimi" value="Kalim monetar ndermjet filialeve" style="width:350px" maxlength="100"></lable></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="7" height="5"></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="5" height="1" bgcolor="000000"></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="7" height="5"></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="5" align="right"><DIV class=ctxheading><lable>Shuma p&euml;r t'u kaluar:&nbsp;<input name="vleftapaguar" type="text" class="inputtext2" id="vleftapaguar" value=".00" size="22"></lable></div></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="7" height="5"></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="5" height="1" bgcolor="000000"></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="7" height="10"></td>
      </tr>
      <tr>
        <td colspan="7" align="center">&nbsp;&nbsp;&nbsp;<input name="insupd" class="inputtext4" type="button" value=" Kryej veprimin " onClick="JavaScript: if (document.formmenu.vleftapaguar.value != 0) { document.formmenu.submit(); }"></td>
      </tr>
      <tr>
        <td colspan="7" height="10"></td>
      </tr>
    </table>
</form>
      </TD>
    </TR>
  </TBODY>
</TABLE>

        </div>

</body>
</html>
<?php
       } else {  header("Location: exchange.php");  }
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
