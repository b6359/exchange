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
  session_unregister('Usertrans');
  session_unregister('Userfilial');
  session_unregister('Username');
  session_unregister('full_name');
  session_unregister('uid');

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
  $user_info = $_SESSION['uid'] ?? addslashes($_SESSION['uid']);

$v_wheresql = ""; $v_llog = 0;

if ($_SESSION['Usertype'] == 2)  $v_llog = $_SESSION['Userfilial'];
if ($_SESSION['Usertype'] == 3)  $v_llog = $_SESSION['Userfilial'];
if ($_SESSION['Usertype'] == 2)  $v_wheresql = " where id = ". $_SESSION['Userfilial'] ." ";
if ($_SESSION['Usertype'] == 3)  $v_wheresql = " where id = ". $_SESSION['Userfilial'] ." ";
if ($_SESSION['Usertype'] == 2)  $v_wheresqls = " and id_llogfilial = ". $_SESSION['Userfilial'] ." ";
if ($_SESSION['Usertype'] == 3)  $v_wheresqls = " and id_llogfilial = ". $_SESSION['Userfilial'] ." ";

if ((isset($_POST['id_llogfilial'])) && ($_POST['id_llogfilial'] != "")) {
     $v_wheresqls = " and id_llogfilial = ". $_POST['id_llogfilial'] ." ";
     $v_llog      = $_POST['id_llogfilial'];
 }

$query_filiali_info = "select * from filiali ". $v_wheresql   ." order by filiali asc";

$filiali_info =$MySQL->query($query_filiali_info) or die(mysql_error());
$row_filiali_info = $filiali_info->fetch_assoc();
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
    	<a href="exchange_rate.php"     class="ButLart2" target="_top"><b>Kursi i K&euml;mbimit</b></a>
    	<a href="exchange_opclbal.php"  class="ButLart2" target="_top">Hapje/Mbyllje Dite</a>
    	<a href="exchange_balance.php"  class="ButLart2" target="_top">Bilanci sipas veprimeve</a>
    	<a href="exchange_basedata.php" class="ButLart2" target="_top">T&euml; Dh&euml;nat Baz&euml;</a>
    	<a href="exchange_reports.php"  class="ButLart2" target="_top">Raporte</a>
    </div>

    <div class="clear"></div>
</div>

<br />

<div class="container_12">

<br />

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD height="15" colSpan=3 align="left" valign="middle">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="link4" title="Print" href="JavaScript: window.print();"><img src="images/print.gif" border="0"> Printo </a>&nbsp; &nbsp;<a class="link4" title="Shto kurs kembimi..." href="JavaScript: window.location='ins_rate_data.php?action=ins';"><img src="images/add.gif" border="0" width="18px"> Shto kurs k&euml;mbimi</a></TD>
    </TR>
  </TBODY>
</TABLE>
<br />
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD align="left" colSpan=0 height="15">
       <DIV class=ctxheading6><br>

<table border="0" cellpadding="0" width="95%" cellspacing="0">
  <tr>
    <td height="5" colspan="6"></td>
  </tr>
<form action="exchange_rate.php" method="POST" name="formmenu" target="_self">
  <tr>
    <td colspan="6">&nbsp; <lable>Filiali:&nbsp;<select name="id_llogfilial" id="id_llogfilial" >
	<?php
	       while ($row_filiali_info) {
	?>
	           <option value="<?php echo $row_filiali_info['id']; ?>" <?php if ($row_filiali_info['id'] == $v_llog) { echo "selected"; } ?>><?php echo $row_filiali_info['filiali']; ?></option>
	<?php
	         $row_filiali_info =  $filiali_info->fetch_assoc();
	       }
	    mysqli_free_result($filiali_info);
	?>
        </select>&nbsp;&nbsp;<a class="link4" href="#"><img src="images/doc.gif" border="0"></a>
    &nbsp;&nbsp;&nbsp;
    <input name="repdata" class="inputtext4" type="submit" value="Shfaq kursin...">
    </lable>
    </td>
  </tr>
</form>
  <tr>
    <td height="10" colspan="6"></td>
  </tr>
  <?php
        $temp_v_wheresqls = isset($v_wheresqls) ? $v_wheresqls : "";
        $sql_info = "select k.*, (select f.filiali from filiali as f where f.id = k. id_llogfilial) as filiali from kursi_koka as k where id = (select max(id) from kursi_koka where 1=1 ". $temp_v_wheresqls .") ". $temp_v_wheresqls;
        $h_menu = $MySQL->query($sql_info) or die(mysql_error());
        $row_h_menu = $h_menu->fetch_assoc();
        $totalRows_h_menu = $h_menu->num_rows;

  if ($row_h_menu) { ?>
  <tr>
    <td colspan="6">&nbsp; <lable>Dat&euml;: <b><?php echo substr($row_h_menu['date'], 8, 2) .".". substr($row_h_menu['date'], 5, 2) .".". substr($row_h_menu['date'], 0, 4); ?></b>
    &nbsp; &nbsp; &nbsp; Fraksion kursi: <b><?php echo $row_h_menu['fraksion']; ?></b>
    &nbsp; &nbsp; &nbsp; Llogari: <b><?php echo $row_h_menu['filiali']; ?></b></lable>
    </td>
  </tr>
  <tr>
    <td height="20" colspan="6"></td>
  </tr>
  <tr>
    <td>&nbsp; Monedha</td>
    <td></td>
    <td align="center">Blej<br>Kundrejt LEK</td>
    <td align="center">Mesatar<br>Kundrejt LEK</td>
    <td align="center">Shes<br>Kundrejt LEK</td>
  </tr>
  <tr>
    <td height="5" colspan="6"></td>
  </tr>
  <?php
        //mysql_select_db($database_MySQL, $MySQL);
        $data_sql_info = "select kursi_detaje.*, monedha.monedha from kursi_detaje, monedha where master_id = ". $row_h_menu['id'] ." and kursi_detaje.monedha_id = monedha.id order by monedha.taborder ";
        $h_data = $MySQL->query($data_sql_info) or die(mysql_error());
        $row_h_data = $h_data->fetch_assoc();

  while ($row_h_data) { ?>
  <tr>
    <td height="1" colspan="6">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="line">
          <td height="0"><DIV class=line></DIV></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>&nbsp; &nbsp; <b><?php echo $row_h_data['monedha']; ?></b></td>
    <td></td>
    <td align="center"><b><?php echo number_format($row_h_data['kursiblerje'], 2, '.', ','); ?></b></td>
    <td align="center"><b><?php echo number_format($row_h_data['kursimesatar'], 2, '.', ','); ?></b></td>
    <td align="center"><b><?php echo number_format($row_h_data['kursishitje'], 2, '.', ','); ?></b></td>
  </tr>
  <?php        $row_h_data = $h_data->fetch_assoc();
             };
         };
    mysqli_free_result($h_menu);
?>
  <tr>
    <td height="1" colspan="6">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="line">
          <td height="0"><DIV class=line></DIV></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td height="15" colspan="6"></td>
  </tr>
</table>
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
