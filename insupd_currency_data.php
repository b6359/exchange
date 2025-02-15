<?php require_once('ConMySQL.php'); ?>
<?php
//initialize the session
session_start();

if (isset($_SESSION['uid'])) {

$id = "";
$monedha = "";
$simboli = "";
$mon_vendi = "";
$kursi_min = "";
$kursi_max = "";
$pershkrimi = "";

if (isset($_GET['action']) && ($_GET['action'] == "upd")) {
    if (isset($_GET['hid'])) {
      $colname_menu_info = $_GET['hid'] ?? addslashes($_GET['hid']);
      //mysql_select_db($database_MySQL, $MySQL);
      $query_menu_info = sprintf("SELECT * FROM monedha WHERE id = %s", $colname_menu_info);
      $menu_info = mysqli_query($MySQL,$query_menu_info) or die(mysql_error());
      $row_menu_info = $menu_info->fetch_assoc();
      $totalRows_menu_info = $menu_info->num_rows;

        $id = $row_menu_info['id'];
        $monedha = $row_menu_info['monedha'];
        $simboli = $row_menu_info['simboli'];
        $mon_vendi = $row_menu_info['mon_vendi'];
        $kursi_min = $row_menu_info['kursi_min'];
        $kursi_max = $row_menu_info['kursi_max'];
        $pershkrimi = $row_menu_info['pershkrimi'];

        mysqli_free_result($menu_info);
  }
}
/////////////////////////////////////////////////////////////////////////////////////////////////
//////////////                                                           /////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
function upload_images($img, $path)
{
    unset($imagename);

    if(!isset($_FILES) && isset($HTTP_POST_FILES))
    $_FILES = $HTTP_POST_FILES;

    if(!isset($_FILES[$img]))
    $error["img_1"] = "An image was not found.";

    $imagename = basename($_FILES[$img]['name']);
    //echo $imagename;

    if(empty($imagename))
    $error["imagename"] = "The name of the image was not found.";

    if(empty($error))
    {
    $newimage = $path . $imagename;
    //echo $newimage;
        $result = @move_uploaded_file($_FILES[$img]['tmp_name'], $newimage);
        if(empty($result))
        $error["result"] = "There was an error moving the uploaded file.";
    }
  return $imagename;
}
/////////////////////////////////////////////////////////////////////////////////////////////////
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  $theValue = addslashes($theValue) ?? $theValue;

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
if ((isset($_POST["form_action"])) && ($_POST["form_action"] == "upd")) {
  $updateSQL = sprintf("UPDATE monedha SET monedha=%s, simboli=%s, mon_vendi=%s, kursi_min=%s, kursi_max=%s, pershkrimi=%s WHERE id=%s",
                       GetSQLValueString($_POST['monedha'], "text"),
                       GetSQLValueString($_POST['simboli'], "text"),
                       GetSQLValueString($_POST['mon_vendi'], "text"),
                       GetSQLValueString($_POST['kursi_min'], "double"),
                       GetSQLValueString($_POST['kursi_max'], "double"),
                       GetSQLValueString($_POST['pershkrimi'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  //mysql_select_db($database_MySQL, $MySQL);
  $Result1 = mysqli_query($MySQL,$updateSQL) or die(mysql_error());
  $updateGoTo = "exchange_currency.php";

  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


if ((isset($_POST["form_action"])) && ($_POST["form_action"] == "ins")) {
  $insertSQL = sprintf("INSERT INTO monedha (monedha, simboli, mon_vendi, kursi_min, kursi_max, pershkrimi) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['monedha'], "text"),
                       GetSQLValueString($_POST['simboli'], "text"),
                       GetSQLValueString($_POST['mon_vendi'], "text"),
                       GetSQLValueString($_POST['kursi_min'], "double"),
                       GetSQLValueString($_POST['kursi_max'], "double"),
                       GetSQLValueString($_POST['pershkrimi'], "text"));

  //mysql_select_db($database_MySQL, $MySQL);
  $Result1 = mysqli_query($MySQL,$insertSQL) or die(mysql_error());

  $updateGoTo = "exchange_currency.php";

  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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

<script language="JavaScript">
<!--  Begin

function checkform ( form )
 {
   if (form.monedha.value == "") {
     alert( "Ju lutem plotesoni fushen: monedha" );
     form.monedha.focus();
     return false ;
    }

   if (form.simboli.value == "") {
     alert( "Ju lutem plotesoni fushen: simboli" );
     form.simboli.focus();
     return false ;
    }

   if (form.pershkrimi.value == "") {
     alert( "Ju lutem plotesoni fushen: pershkrimi" );
     form.pershkrimi.focus();
     return false ;
    }

   if (form.kursi_min.value == "") {
     alert( "Ju lutem plotesoni fushen: kursi minimum" );
     form.kursi_min.focus();
     return false ;
    }

   if (form.kursi_max.value == "") {
     alert( "Ju lutem plotesoni fushen: kursi maksimal" );
     form.kursi_max.focus();
     return false ;
    }

   return true ;
}

//  End -->
</script>

<link href="styles.css" rel="stylesheet" type="text/css">

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
    	<a href="exchange_openbal.php"  class="ButLart2" target="_top">Hapje balance</a>
    	<a href="exchange_llogari.php"  class="ButLart2" target="_top">Llogarit&euml;</a>
    	<a href="exchange_account.php"  class="ButLart2" target="_top">Filialet</a>
    	<a href="exchange_client.php"   class="ButLart2" target="_top">Klient&euml;t</a>
    	<a href="exchange_currency.php" class="ButLart2" target="_top"><b>Monedhat</b></a>
    </div>
    <div class="clear"></div>
</div>

<br />

<div class="container_12">

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD height="15" colSpan=3 align="left" valign="middle">
        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Administrimi i monedhave</DIV></TD>
    </TR>
  </TBODY>
</TABLE>
<br />

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD align="left" colSpan=3 height="15">
        <DIV class=ctxheading>

<form enctype="multipart/form-data" ACTION="insupd_currency_data.php" METHOD="POST" name="formmenu" onsubmit="return checkform(this);">
  <input name="form_action" type="hidden" value="<?php echo $_GET[action]; ?>">
  <input name="id" type="hidden" value="<?php echo $id; ?>">
    <table width="100%" border="0" cellpadding="0" cellspacing="5">
      <tr>
        <td width="200"></td>
        <td width="400"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Monedha:</td>
        <td align="left"><input name="monedha" type="text"  id="monedha" value="<?php echo $monedha; ?>" size="25"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Simboli:</td>
        <td align="left"><input name="simboli" type="text"  id="simboli" value="<?php echo $simboli; ?>" size="25"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">P&euml;rshkrimi:</td>
        <td align="left"><input name="pershkrimi" type="text"  id="pershkrimi" value="<?php echo $pershkrimi; ?>" size="25"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Min Kursi:</td>
        <td align="left"><input name="kursi_min" type="text"  id="kursi_min" value="<?php echo $kursi_min; ?>" size="25"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Max Kursi:</td>
        <td align="left"><input name="kursi_max" type="text"  id="kursi_max" value="<?php echo $kursi_max; ?>" size="25"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Monedha Lokale:</td>
        <td align="left">
         <select name="mon_vendi"  id="mon_vendi">
           <option value="J" <?php if (!(strcmp("J", $mon_vendi))) {echo "SELECTED";} ?>>Jo</option>
           <option value="P" <?php if (!(strcmp("P", $mon_vendi))) {echo "SELECTED";} ?>>Po</option>
         </select>
        </td>
      </tr>
      <tr>
        <td width="200">&nbsp;</td>
        <td width="400"></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input name="insupd" class="inputtext4" type="submit" value="Ruaj Informacionin"></td>
      </tr>
      <tr>
        <td width="200"></td>
        <td width="400"></td>
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
