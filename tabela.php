<?php

session_start();
require_once('ConMySQL.php');

// Global variables replaced with $_SESSION
$_SESSION['CNAME'] = "EXCHANGE";
$_SESSION['CADDR'] = "Tiranë";
$_SESSION['CNIPT'] = "A12345678B";
$_SESSION['CADMI'] = "Administrator";
$_SESSION['CMOBI'] = "+355 69 123 4567";
$_SESSION['DPPPP'] = "1000000";

$v_wheresql = "";
$v_wheresqls = "";
$v_llog = 0;

if (isset($_SESSION['Usertype'])) {
    if ($_SESSION['Usertype'] == 2 || $_SESSION['Usertype'] == 3) {
        $v_llog = $_SESSION['Userfilial'];
        $v_wheresql = " WHERE id = " . $_SESSION['Userfilial'];
        $v_wheresqls = " AND id_llogfilial = " . $_SESSION['Userfilial'];
    }
}
?>

<script>
  addEventListener("click", function() {
    var el = document.documentElement;
    var rfs = el.requestFullscreen || el.webkitRequestFullscreen || el.mozRequestFullScreen;
    if (rfs) {
        rfs.call(el);
    }
  });
</script>

<html>
<head>
<title> TABELA - <?php echo $_SESSION['CNAME']; ?></title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/text.css">
<link rel="stylesheet" type="text/css" href="css/984_width.css">
<link rel="stylesheet" type="text/css" href="css/layout.css">
<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" type="text/css" href="css/server.css">

<style type="text/css">
body, td, th {
    font-size: 33px;
}
</style>
</head>

<body>

<TABLE width="100%" border="0">
  <tr style="background:white;">
    <td align="center"><img src="images/header.png" style="margin:15px" title="GlobalTech.al" alt="GlobalTech.al" height="100px"></td>
  </tr>
  <tr>
    <td>
      <table width="100%">
        <tr>
          <td style="text-align:center;"><i class="fa fa-calendar"></i> <b> <?php echo date('d.m.Y'); ?> </b></td>
          <td style="text-align:center;"><i class="fa fa-clock-o"></i> <b> <?php echo date('H:i:s'); ?> </b></td>
        </tr>
      </table>
    </td>
  </tr>

  <?php
  $sql_info = "SELECT k.* FROM kursi_koka AS k 
               WHERE id = (SELECT MAX(id) FROM kursi_koka WHERE 1=1 $v_wheresqls) $v_wheresqls";

  $h_menu = mysqli_query($MySQL, $sql_info) or die(mysqli_error($MySQL));
  $row_h_menu = mysqli_fetch_assoc($h_menu);

  if ($row_h_menu) { ?>
  <tr>
    <td>
      <table width="100%">
        <tr bgcolor="#8181F7">
          <td align="center">MONEDHA</td>
          <td></td>
          <td align="center">BLIHET</td>
          <td></td>
          <td align="center">SHITET</td>
        </tr>
      </table>
    </td>
  </tr>

  <?php
  $data_sql_info = "SELECT kursi_detaje.*, monedha.monedha 
                    FROM kursi_detaje, monedha 
                    WHERE master_id = {$row_h_menu['id']} 
                    AND kursi_detaje.monedha_id = monedha.id 
                    AND kursimesatar > 0 
                    ORDER BY kursi_detaje.monedha_id";

  $h_data = mysqli_query($MySQL, $data_sql_info) or die(mysqli_error($MySQL));
  $row_h_data = mysqli_fetch_assoc($h_data);
  $rownum = 0;

  while ($row_h_data) {
      $v_bg = ($rownum % 2 == 0) ? "FFFFFF" : "CED8F6";
      $rownum++;
  ?>
  <tr bgcolor="#<?php echo $v_bg; ?>">
    <td align="right"><img src="images/flag/<?php echo $row_h_data['monedha']; ?>.png" width="50"></td>
    <td><b><?php echo $row_h_data['monedha']; ?></b></td>
    <td align="center"><b><?php echo number_format($row_h_data['kursiblerje'], 2, '.', ','); ?></b></td>
    <td align="center"><b><?php echo number_format($row_h_data['kursishitje'], 2, '.', ','); ?></b></td>
  </tr>
  <?php
      $row_h_data = mysqli_fetch_assoc($h_data);
  }
  mysqli_free_result($h_data);
  ?>

  <?php
  }
  mysqli_free_result($h_menu);
  ?>

  <tr>
    <td>
      <table width="100%">
        <tr>
          <td style="text-align:center;"><b>Mirë se vini! | No Commission</b></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<script>
// Disable right-click context menu
document.addEventListener('contextmenu', event => event.preventDefault());

// Disable certain keys
document.addEventListener('keydown', e => {
  if (
    e.keyCode === 112 || // F1
    e.keyCode === 114 || // F3
    e.keyCode === 116 || // F5
    e.keyCode === 117 || // F6
    e.keyCode === 118 || // F7
    e.keyCode === 121 || // F10
    e.keyCode === 123 || // F12
    e.ctrlKey || e.shiftKey || e.altKey || 
    (e.ctrlKey && e.shiftKey) || 
    (e.ctrlKey && e.shiftKey && e.altKey)
  ) {
    e.preventDefault();
  }
});
</script>

</body>
</html>
