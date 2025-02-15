<?php

session_start();

require_once('ConMySQL.php');


$GLOBALS['CNAME']   = "EXCHANGE";
session_register("CNAME");
$_SESSION['CNAME']  = "EXCHANGE";
$GLOBALS['CADDR']   = "Tiran&euml;";
session_register("CADDR");
$_SESSION['CADDR']  = "Tiran&euml;";
$GLOBALS['CNIPT']   = "A12345678B";
session_register("CNIPT");
$_SESSION['CNIPT']  = "A12345678B";
$GLOBALS['CADMI']   = "Administrator";
session_register("CADMI");
$_SESSION['CADMI']  = "Amdinistrator";
$GLOBALS['CMOBI']   = "+355 69 123 4567";
session_register("CMOBI");
$_SESSION['CMOBI']  = "+355 69 123 4567";
$GLOBALS['DPPPP']   = "1000000";
session_register("DPPPP");
$_SESSION['DPPPP']  = "1000000";

$v_wheresql = ""; $v_llog = 0;

if ($_SESSION['Usertype'] == 2)  $v_llog = $_SESSION['Userfilial'];
if ($_SESSION['Usertype'] == 3)  $v_llog = $_SESSION['Userfilial'];
if ($_SESSION['Usertype'] == 2)  $v_wheresql = " where id = ". $_SESSION['Userfilial'] ." ";
if ($_SESSION['Usertype'] == 3)  $v_wheresql = " where id = ". $_SESSION['Userfilial'] ." ";
if ($_SESSION['Usertype'] == 2)  $v_wheresqls = " and id_llogfilial = ". $_SESSION['Userfilial'] ." ";
if ($_SESSION['Usertype'] == 3)  $v_wheresqls = " and id_llogfilial = ". $_SESSION['Userfilial'] ." ";

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
   <!-- HTML meta refresh URL redirection -->
   <meta http-equiv="refresh"
   content="10; url=exchange_tabel.php">
<head>
   
<title> TABELA - <?php echo $_SESSION['CNAME']; ?></title>

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

<style type="text/css">
<!--
body,td,th {
    font-size: 33px;
}
-->
</style>

</head>

<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" vlink="#0000ff" link="#0000ff">

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>

<tr style="background:white;"><td align="center" colSpan=0 height="5" style="text-align:center">
<img src="images/header.png" style="margin:15px" title="GlobalTech.al" alt="GlobalTech.al" height="100px">

</td></tr>
    <TR>
      <TD align="left" colSpan=0 height="5">

<table border="0" cellpadding="0" width="100%" cellspacing="0">
  <tr>
    <td height="5" colspan="6"></td>
  </tr>
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
    <td height="5" colspan="6"></td>
  </tr>
  <?php
        $sql_info = "select k.* from kursi_koka as k where id = (select max(id) from kursi_koka where 1=1 ". $v_wheresqls .") ". $v_wheresqls;
        $h_menu = mysql_query($sql_info, $MySQL) or die(mysql_error());
        $row_h_menu = mysql_fetch_assoc($h_menu);
        $totalRows_h_menu = mysql_num_rows($h_menu);

  if ($row_h_menu) { ?>
  <tr>
    <td align="center" colspan="6" bgcolor="#FFFFFF">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b><?php echo $_SESSION['CNAME']; ?></b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Dat&euml;: <b><?php echo substr($row_h_menu['date'], 8, 2) .".". substr($row_h_menu['date'], 5, 2) .".". substr($row_h_menu['date'], 0, 4); ?></b></td>
  </tr>
  <tr>
    <td height="5" colspan="6"></td>
  </tr>
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
    <td height="5" colspan="6"></td>
  </tr>
  <tr bgcolor="#8181F7">
    <td colspan="2" align="center">&nbsp; &nbsp; MONEDHA</td>
    <td width="70"></td>
    <td align="center">BLIHET</td>
    <td width="50"></td>
    <td align="center">SHITET</td>
  </tr>
  <tr>
    <td height="5" colspan="6"></td>
  </tr>
  <?php
        mysql_select_db($database_MySQL, $MySQL);
        $data_sql_info = "select kursi_detaje.*, monedha.monedha from kursi_detaje, monedha where master_id = ". $row_h_menu['id'] ." and kursi_detaje.monedha_id = monedha.id and monedha.id not in (20, 21) order by kursi_detaje.monedha_id";
        $h_data = mysql_query($data_sql_info, $MySQL) or die(mysql_error());
        $row_h_data = mysql_fetch_assoc($h_data);

    $rownum = 0;

  while ($row_h_data) {

       if ($rownum == 1) {  $v_bg = "CED8F6";  $rownum = 0; }
       else              {  $v_bg = "FFFFFF";  $rownum ++;  }

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
  <tr bgcolor="#<?php echo $v_bg; ?>">
    <td width="100" align="right">&nbsp; &nbsp; <img src="images/flag/<?php echo $row_h_data['monedha']; ?>.png" width="50"></td>
    <td align="lerft"> <b><?php echo $row_h_data['monedha']; ?></b></td>
    <td></td>
    <td align="center"><b><?php echo number_format($row_h_data['kursiblerje'], 2, '.', ','); ?></b></td>
    <td></td>
    <td align="center"><b><?php echo number_format($row_h_data['kursishitje'], 2, '.', ','); ?></b></td>
  </tr>
  <?php        $row_h_data = mysql_fetch_assoc($h_data);
             };
?>
<?php
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
    <td colspan="6">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="0">&nbsp; * Nuk aplikohen komisione / No Commission</td>
        </tr>
      </table>
    </td>
  </tr>
</table>

      </TD>
    </TR>
  </TBODY>
</TABLE>

</div>

</body>
</html>
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
