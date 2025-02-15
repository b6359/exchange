<?php require_once('ConMySQL.php'); ?>
<?php
//initialize the session
session_start();

if (isset($_SESSION['uid'])) {

$id            = "";
$emri          = "";
$atesia        = "";
$mbiemri       = "";
$gender        = "";
$dob           = "";
$emrikompanise = "";
$emriplote     = "";
$nationality   = "";
$nationalitytxt = "";
$telefon       = "";
$fax           = "";
$email         = "";
$adresa        = "";
$tipdokumenti  = "";
$nrpashaporte  = "";
$nipt          = "";
$docname       = "";

if (isset($_GET['action']) && ($_GET['action'] == "upd")) {
    if (isset($_GET['hid'])) {
      $colname_menu_info = $_GET['hid'] ?? addslashes($_GET['hid']);
      //mysql_select_db($database_MySQL, $MySQL);
      $query_menu_info = sprintf("SELECT * FROM klienti WHERE id = %s", $colname_menu_info);
      $menu_info = mysqli_query($MySQL,$query_menu_info) or die(mysql_error());
      $row_menu_info = $menu_info->fetch_assoc();
      $totalRows_menu_info = $menu_info->num_rows;

        $id             = $row_menu_info['id'];
        $emri           = $row_menu_info['emri'];
        $atesia         = $row_menu_info['atesia'];
        $mbiemri        = $row_menu_info['mbiemri'];
        $emrikompanise  = $row_menu_info['emrikompanise'];
        if ($row_menu_info['dob'] != "") {
            $dob            = substr($row_menu_info['dob'], 8, 2).".".substr($row_menu_info['dob'], 5, 2).".".substr($row_menu_info['dob'], 0, 4) ;
        }
        $gender         = $row_menu_info['gender'];
        $nationality    = $row_menu_info['nationality'];
        $nationalitytxt = $row_menu_info['nationalitytxt'];
        $emriplote      = $row_menu_info['emriplote'];
        $telefon        = $row_menu_info['telefon'];
        $fax            = $row_menu_info['fax'];
        $email          = $row_menu_info['email'];
        $adresa         = $row_menu_info['adresa'];
        $tipdokumenti   = $row_menu_info['tipdokumenti'];
        $nrpashaporte   = $row_menu_info['nrpashaporte'];
        $nipt           = $row_menu_info['nipt'];
        $docname        = $row_menu_info['docname'];

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
  $updateSQL = sprintf("UPDATE klienti SET emri=%s, atesia=%s, mbiemri=%s, emriplote=%s, emrikompanise=%s, dob=%s, gender=%s, nationality=%s, nationalitytxt=%s, telefon=%s, fax=%s, email=%s, adresa=%s, tipdokumenti=%s, nrpashaporte=%s, nipt=%s, docname=%s WHERE id=%s",
                       GetSQLValueString($_POST['emri'], "text"),
                       GetSQLValueString($_POST['atesia'], "text"),
                       GetSQLValueString($_POST['mbiemri'], "text"),
                       GetSQLValueString($_POST['emri'] ." ". $_POST['mbiemri'], "text"),
                       GetSQLValueString($_POST['emrikompanise'], "text"),
                       GetSQLValueString(substr($_POST['dob'], 6, 4)."-".substr($_POST['dob'], 3, 2)."-".substr($_POST['dob'], 0, 2), "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['nationality'], "text"),
                       GetSQLValueString($_POST['nationalitytxt'], "text"),
                       GetSQLValueString($_POST['telefon'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['adresa'], "text"),
                       GetSQLValueString($_POST['tipdokumenti'], "int"),
                       GetSQLValueString($_POST['nrpashaporte'], "text"),
                       GetSQLValueString($_POST['nipt'], "text"),
                       GetSQLValueString(upload_images("docname", "doc/"), "text"),
                       GetSQLValueString($_POST['id'], "int"));

  //mysql_select_db($database_MySQL, $MySQL);
  $Result1 = mysqli_query($MySQL,$updateSQL) or die(mysql_error());

  $updateGoTo = "exchange_client.php";

  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


if ((isset($_POST["form_action"])) && ($_POST["form_action"] == "ins")) {
  $insertSQL = sprintf("INSERT INTO klienti (emri, atesia, mbiemri, emriplote, emrikompanise, dob, gender, nationality, nationalitytxt, telefon, fax, email, adresa, tipdokumenti, nrpashaporte, nipt, docname)
                                     VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['emri'], "text"),
                       GetSQLValueString($_POST['atesia'], "text"),
                       GetSQLValueString($_POST['mbiemri'], "text"),
                       GetSQLValueString($_POST['emri'] ." ". $_POST['mbiemri'], "text"),
                       GetSQLValueString($_POST['emrikompanise'], "text"),
                       GetSQLValueString(substr($_POST['dob'], 6, 4)."-".substr($_POST['dob'], 3, 2)."-".substr($_POST['dob'], 0, 2), "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['nationality'], "text"),
                       GetSQLValueString($_POST['nationalitytxt'], "text"),
                       GetSQLValueString($_POST['telefon'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['adresa'], "text"),
                       GetSQLValueString($_POST['tipdokumenti'], "int"),
                       GetSQLValueString($_POST['nrpashaporte'], "text"),
                       GetSQLValueString($_POST['nipt'], "text"),
                       GetSQLValueString(upload_images("docname", "doc/"), "text") );

  //mysql_select_db($database_MySQL, $MySQL);
  $Result1 = mysqli_query($MySQL,$insertSQL) or die(mysql_error());

  $updateGoTo = "exchange_client.php";

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
   if (form.emri.value == "") {
     alert( "Ju lutem plotesoni fushen: emri" );
     form.emri.focus();
     return false ;
    }

   if (form.mbiemri.value == "") {
     alert( "Ju lutem plotesoni fushen: mbiemri" );
     form.mbiemri.focus();
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
    	<a href="exchange_openbal.php"  class="ButLart2" target="_top">Hapje balance</a>
    	<a href="exchange_llogari.php"  class="ButLart2" target="_top">Llogarit&euml;</a>
    	<a href="exchange_account.php"  class="ButLart2" target="_top">Filialet</a>
    	<a href="exchange_client.php"   class="ButLart2" target="_top"><b>Klient&euml;t</b></a>
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
        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Administrimi i klient&euml;ve</DIV></TD>
    </TR>
  </TBODY>
</TABLE>
<br />

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD align="left" colSpan=3 height="15">
        <DIV class=ctxheading>

<form enctype="multipart/form-data" ACTION="insupd_client_data.php" METHOD="POST" name="formmenu" onsubmit="return checkform(this);">
  <input name="form_action" type="hidden" value="<?php echo $_GET[action]; ?>">
  <input name="id" type="hidden" value="<?php echo $id; ?>">
    <table width="100%" border="0" cellpadding="0" cellspacing="5">
      <tr>
        <td width="200"></td>
        <td width="400"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Emri:</td>
        <td align="left"><input name="emri" type="text"  id="emri" value="<?php echo $emri; ?>" size="50" maxlength="50"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">At&euml;sia:</td>
        <td align="left"><input name="atesia" type="text"  id="atesia" value="<?php echo $atesia; ?>" size="50" maxlength="50"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Mbiemri:</td>
        <td align="left"><input name="mbiemri" type="text"  id="mbiemri" value="<?php echo $mbiemri; ?>" size="50" maxlength="50"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Emri i kompanis&euml;:</td>
        <td align="left"><input name="emrikompanise" type="text"  id="emrikompanise" value="<?php echo $emrikompanise; ?>" size="100" maxlength="150"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Dat&euml;lindja:</td>
        <td align="left"><input name="dob" type="text"  placeholder="dd.mm.yyyy" id="dob" value="<?php echo $dob; ?>" size="10" maxlength="10">
        <script language="JavaScript">
	              var o_cal = new tcal ({
	                  'formname': 'formmenu',
	                  'controlname': 'dob'
	              });
	              o_cal.a_tpl.yearscroll = true;
	              o_cal.a_tpl.weekstart = 1;
	    </script>
        </td>
      </tr>
      <tr>
        <td align="left" valign="middle">Gjinia:</td>
        <td align="left">
         <select name="gender"  id="gender">
           <option value="M" <?php if (!(strcmp("M", $gender))) {echo "SELECTED";} ?>>Mashkull</option>
           <option value="F" <?php if (!(strcmp("F", $gender))) {echo "SELECTED";} ?>>Femer</option>
           <option value="C" <?php if (!(strcmp("C", $gender))) {echo "SELECTED";} ?>>Biznese</option>
           <option value="B" <?php if (!(strcmp("B", $gender))) {echo "SELECTED";} ?>>Banka</option>
           <option value="Z" <?php if (!(strcmp("Z", $gender))) {echo "SELECTED";} ?>>Z.K.Valutor</option>
         </select></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Shtet&euml;sia:</td>
        <td align="left">
         <select name="nationality"  id="nationality">
           <option value="0" <?php if (!(strcmp("0", $nationality))) {echo "SELECTED";} ?>>Shqiptar</option>
           <option value="1" <?php if (!(strcmp("1", $nationality))) {echo "SELECTED";} ?>>I Huaj</option>
         </select></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Shtet&euml;sia tekst:</td>
        <td align="left"><input name="nationalitytxt" type="text"  id="nationalitytxt" value="<?php echo $nationalitytxt; ?>" size="35" maxlength="150"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Tip dokumenti:</td>
        <td align="left">
         <select name="tipdokumenti"  id="tipdokumenti">
           <option value="0" <?php if (!(strcmp("0", $tipdokumenti))) {echo "SELECTED";} ?>>Pasaporte</option>
           <option value="1" <?php if (!(strcmp("1", $tipdokumenti))) {echo "SELECTED";} ?>>Leternjoftim</option>
           <option value="2" <?php if (!(strcmp("2", $tipdokumenti))) {echo "SELECTED";} ?>>Certifikate</option>
           <option value="3" <?php if (!(strcmp("3", $tipdokumenti))) {echo "SELECTED";} ?>>Karte Kombe tare Identiteti</option>
           <option value="4" <?php if (!(strcmp("4", $tipdokumenti))) {echo "SELECTED";} ?>>Patente</option>
         </select></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Nr. Dokumenti:</td>
        <td align="left"><input name="nrpashaporte" type="text"  id="nrpashaporte" value="<?php echo $nrpashaporte; ?>" size="35" maxlength="50"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">NIPT:</td>
        <td align="left"><input name="nipt" type="text"  id="nipt" value="<?php echo $nipt; ?>" size="10" maxlength="10"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Telefon:</td>
        <td align="left"><input name="telefon" type="text"  id="telefon" value="<?php echo $telefon; ?>" size="35" maxlength="50"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Fax:</td>
        <td align="left"><input name="fax" type="text"  id="fax" value="<?php echo $fax; ?>" size="35" maxlength="50"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">E-mail:</td>
        <td align="left"><input name="email" type="text"  id="email" value="<?php echo $email; ?>" size="35" maxlength="100"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Adresa:</td>
        <td align="left"><textarea name="adresa" cols="34" rows="5"  id="adresa"><?php echo $adresa; ?></textarea></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Dokumenti:</td>
        <td align="left"><input name="docname" type="file" id="docname" value="<?php echo $docname; ?>" size="250"></td>
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
