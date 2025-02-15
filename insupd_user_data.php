<?php require_once('ConMySQL.php'); ?>
<?php
//initialize the session
session_start();

if (isset($_SESSION['uid'])) {

$id          = "";
$username    = "";
$password    = "";
$full_name   = "";
$id_trans    = "111";
$id_filiali  = "1";
$id_usertype = "2";
$phone       = "";
$e_mail      = "";
$status      = "T";

if (isset($_GET['action']) && ($_GET['action'] == "upd")) {
    if (isset($_GET['hid'])) {
      $colname_menu_info = (get_magic_quotes_gpc()) ? $_GET['hid'] : addslashes($_GET['hid']);
      mysql_select_db($database_MySQL, $MySQL);
      $query_menu_info = sprintf("SELECT * FROM app_user WHERE id = %s", $colname_menu_info);
      $menu_info = mysql_query($query_menu_info, $MySQL) or die(mysql_error());
      $row_menu_info = mysql_fetch_assoc($menu_info);
      $totalRows_menu_info = mysql_num_rows($menu_info);

        $id          = $row_menu_info['id'];
        $username    = $row_menu_info['username'];
        $password    = $row_menu_info['password'];
        $full_name   = $row_menu_info['full_name'];
        $id_trans    = $row_menu_info['id_trans'];
        $id_filiali  = $row_menu_info['id_filiali'];
        $id_usertype = $row_menu_info['id_usertype'];
        $phone       = $row_menu_info['phone'];
        $e_mail      = $row_menu_info['e_mail'];
        $status      = $row_menu_info['status'];

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
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

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
  $updateSQL = sprintf("UPDATE app_user SET password=%s, full_name=%s, id_trans=%s, id_filiali=%s, id_usertype=%s, phone=%s, e_mail=%s, status=%s WHERE id=%s",
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['full_name'], "text"),
                       GetSQLValueString($_POST['id_trans'], "int"),
                       GetSQLValueString($_POST['id_filiali'], "int"),
                       GetSQLValueString($_POST['id_usertype'], "int"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['e_mail'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_MySQL, $MySQL);
  $Result1 = mysql_query($updateSQL, $MySQL) or die(mysql_error());

  $updateGoTo = "exchange_users.php";
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["form_action"])) && ($_POST["form_action"] == "ins")) {
  $insertSQL = sprintf("INSERT INTO app_user (username, password, full_name, id_trans, id_filiali, id_usertype, phone, e_mail, status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['full_name'], "text"),
                       GetSQLValueString($_POST['id_trans'], "int"),
                       GetSQLValueString($_POST['id_filiali'], "int"),
                       GetSQLValueString($_POST['id_usertype'], "int"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['e_mail'], "text"),
                       GetSQLValueString($_POST['status'], "text"));

  mysql_select_db($database_MySQL, $MySQL);
  $Result1 = mysql_query($insertSQL, $MySQL) or die(mysql_error());

  $updateGoTo = "exchange_users.php";
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
   if (form.username.value == "") {
     alert( "Ju lutem plotesoni fushen: Perdoruesi" );
     form.username.focus();
     return false ;
    }

   if (form.password.value == "") {
     alert( "Ju lutem plotesoni fushen: Fjalekalimi" );
     form.password.focus();
     return false ;
    }

   if (form.full_name.value == "") {
     alert( "Ju lutem plotesoni fushen: emri i plote" );
     form.full_name.focus();
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
    	<a href="exchange_users.php"   class="ButLart2" target="_top"><b>P&Euml;RDORUESIT</b></a>
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
    	<a href="exchange_basedata.php" class="ButLart2" target="_top">T&euml; Dh&euml;nat Baz&euml;</a>
    	<a href="exchange_reports.php"  class="ButLart2" target="_top">Raporte</a>
    </div>

    <div class="clear"></div>
</div>

<br />

<div class="container_12">

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD height="15" colSpan=3 align="left" valign="middle">
        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Administrimi i p&euml;rdorues&euml;ve</DIV></TD>
    </TR>
  </TBODY>
</TABLE>
<br />

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD align="left" colSpan=3 height="15">
        <DIV class=ctxheading1>

<form enctype="multipart/form-data" ACTION="insupd_user_data.php" METHOD="POST" name="formmenu" onsubmit="return checkform(this);">
  <input name="form_action" type="hidden" value="<?php echo $_GET[action]; ?>">
  <input name="id" type="hidden" value="<?php echo $id; ?>">
    <table width="600px" border="0" cellpadding="0" cellspacing="5">
      <tr>
        <td width="200"></td>
        <td width="400"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">P&euml;rdoruesi:</td>
        <td align="left"><input name="username" type="text"  id="username" value="<?php echo $username; ?>" size="35"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Fjal&euml;kalimi:</td>
        <td align="left"><input name="password" type="password"  id="password" value="<?php echo $password; ?>" size="35"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Emri i plot&euml;:</td>
        <td align="left"><input name="full_name" type="text"  id="full_name" value="<?php echo $full_name; ?>" size="35"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Grup Trans.:</td>
        <td align="left"><input name="id_trans" type="text"  id="id_trans" value="<?php echo $id_trans; ?>" size="35"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Filiali:</td>
        <td align="left"><select name="id_filiali" >
<?php
        $sql_info = "select * from filiali where tstatus='T' order by filiali desc";
        $h_menu = mysql_query($sql_info, $MySQL) or die(mysql_error());
        $row_h_menu = mysql_fetch_assoc($h_menu);

         while ($row_h_menu) { ?>
           <option value="<?php echo $row_h_menu['id']; ?>" <?php if ($row_h_menu['id'] == $id_filiali) echo "selected='selected'"; ?> ><?php echo $row_h_menu['filiali']; ?></option>
<?php     $row_h_menu = mysql_fetch_assoc($h_menu);
         };
    mysqli_free_result($h_menu);
?>
                          </select>
      </tr>
      <tr>
        <td align="left" valign="middle">Tipi:</td>
        <td align="left"><select name="id_usertype" >
<?php
        $sql_info = "select * from usertype  where tstatus='T' order by id";
        $h_menu = mysql_query($sql_info, $MySQL) or die(mysql_error());
        $row_h_menu = mysql_fetch_assoc($h_menu);

         while ($row_h_menu) { ?>
           <option value="<?php echo $row_h_menu['id']; ?>" <?php if ($row_h_menu['id'] == $id_usertype) echo "selected='selected'"; ?> ><?php echo $row_h_menu['description']; ?></option>
<?php     $row_h_menu = mysql_fetch_assoc($h_menu);
         };
    mysqli_free_result($h_menu);
?>
                          </select>
      </tr>
      <tr>
        <td align="left" valign="middle">Telefon:</td>
        <td align="left"><input name="phone" type="text"  id="phone" value="<?php echo $phone; ?>" size="35"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">E-mail:</td>
        <td align="left"><input name="e_mail" type="text"  id="e_mail" value="<?php echo $e_mail; ?>" size="35"></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Status:</td>
        <td align="left">
         <select name="status"  id="status">
           <option value="T" <?php if (!(strcmp("T", $status))) {echo "SELECTED";} ?>>Active</option>
           <option value="F" <?php if (!(strcmp("F", $status))) {echo "SELECTED";} ?>>Cancel</option>
         </select>
        </td>
      </tr>
      <tr>
        <td width="200">&nbsp;</td>
        <td width="400"></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input name="insupd" class="inputtext4" type="submit" value=" Ruaj Informacionin "></td>
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
