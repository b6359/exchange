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

       $v_file = "";
       $v_dt1  = strftime('%d.%m.%Y');
       if ((isset($_POST['date_trans1'])) && ($_POST['date_trans1'] != "")) {
           $v_dt1 = $_POST['date_trans1'];
       }
       $v_dt2  = strftime('%d.%m.%Y');
       if ((isset($_POST['date_trans2'])) && ($_POST['date_trans2'] != "")) {
           $v_dt2 = $_POST['date_trans2'];
       }

       $v_view = "n/e";
       if ((isset($_POST['view'])) && ($_POST['view'] != "")) {
           $v_view = $_POST['view'];
       }

       if ( $v_view == "excel") {

           include("kembimi.php");
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
       <a href="exchange_balance.php"  class="ButLart2" target="_top"><b>Bilanci sipas veprimeve</b></a>
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
      <TD height="15" align="left" valign="middle">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a title="Print" href="JavaScript: window.print();"><img src="images/print.gif" border="0"></a>&nbsp; <B>&nbsp;Bilanci sipas veprimeve p&euml;r dat&euml;n <?php echo isset($v_dt) ? $v_dt : ''; ?></B>&nbsp;</TD>
    </TR>
  </TBODY>
</TABLE>
<br />

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD align="left" colSpan=0 height="15">
       <DIV class=ctxheading6><br>

<form enctype="multipart/form-data" ACTION="exchange_balance.php" METHOD="POST" name="formmenu">
  <input name="act"  type="hidden" value="n/e">
  <input name="view" type="hidden" value="n/e">

<table border="0" cellpadding="0" width="100%" cellspacing="0">
  <tr valign="middle">
    <td colspan="5" ><lable>Nga dat&euml;:&nbsp;<input name="date_trans1" type="text" value="<?php echo $v_dt1; ?>" id="date_trans" size="10" readonly>&nbsp;
       <script language="JavaScript">
            var o_cal = new tcal ({
                'formname': 'formmenu',
                'controlname': 'date_trans1'
            });
            o_cal.a_tpl.yearscroll = true;
            o_cal.a_tpl.weekstart = 1;
       </script>
       &nbsp; &nbsp; &nbsp; Deri dat&euml;:&nbsp;<input name="date_trans2" type="text" value="<?php echo $v_dt2; ?>" id="date_trans" size="10" readonly>&nbsp;
       <script language="JavaScript">
            var o_cal = new tcal ({
                'formname': 'formmenu',
                'controlname': 'date_trans2'
            });
            o_cal.a_tpl.yearscroll = true;
            o_cal.a_tpl.weekstart = 1;
       </script>
  &nbsp; &nbsp; &nbsp; <input name="insupd" class="inputtext4" type="button" value=" Shfaq informacionin " onClick="JavaScript: document.formmenu.view.value = 'n/e';   document.formmenu.submit(); ">
  <!--
  &nbsp; &nbsp; &nbsp; <input name="showfl" class="inputtext4" type="button" value=" Shfaq Fitimin excel " onClick="JavaScript: document.formmenu.view.value = 'excel'; document.formmenu.submit(); ">
  -->
  </lable></td>
  </tr>
  <tr>
    <td height="10" colspan="5"></td>
  </tr>
  <tr>
    <td height="1" colspan="5" bgcolor="#000033"></td>
  </tr>
  <tr>
    <td colspan="5"><DIV class="ctxheading7"><B>Hapja e balancave ditore</B></DIV></td>
  </tr>
  <tr>
    <td><b>Llogaria</b></td>
    <td><b>Monedha</b></td>
    <td align="right"><b>Hyrje</b>&nbsp; &nbsp; &nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td height="5" colspan="5"></td>
  </tr>
<?php

     set_time_limit(0);

     $v_wheresql = "";
     if ($_SESSION['Usertype'] == 2)  $v_wheresql = " and openbalance.id_llogfilial = ". $_SESSION['Userfilial'] ." ";
     if ($_SESSION['Usertype'] == 3)  $v_wheresql = " and openbalance.perdoruesi    = '". $_SESSION['Username'] ."' ";

        //mysql_select_db($database_MySQL, $MySQL);
        $query_gjendje_info = " SELECT openbalance.id, filiali.filiali, monedha.monedha, sum(openbalance.vleftakredituar) as vleftakredituar
                                  FROM openbalance, monedha, filiali
                                 WHERE openbalance.monedha_id    = monedha.id
                                   AND openbalance.chstatus      = 'T'
                                   AND openbalance.id_llogfilial = filiali.id
                                   AND openbalance.date_trans   >= '". substr($v_dt1, 6, 4)."-".substr($v_dt1, 3, 2)."-".substr($v_dt1, 0, 2) ."'
                                   AND openbalance.date_trans   <= '". substr($v_dt2, 6, 4)."-".substr($v_dt2, 3, 2)."-".substr($v_dt2, 0, 2) ."'
                                    ". $v_wheresql ."
                              GROUP BY openbalance.id, filiali.filiali, monedha.monedha
                              ORDER BY filiali.filiali, openbalance.monedha_id ";
        $gjendje_info     = mysqli_query($MySQL,$query_gjendje_info) or die(mysql_error());
        $row_gjendje_info = $gjendje_info->fetch_assoc();

  while ($row_gjendje_info) {
?>
  <tr>
    <td height="1" colspan="5" bgcolor="#000033"></td>
  </tr>
  <tr>
    <td><?php echo $row_gjendje_info['filiali']; ?></td>
    <td><?php echo $row_gjendje_info['monedha']; ?></td>
    <td align="right"><?php echo number_format( $row_gjendje_info['vleftakredituar'], 2, '.', ','); ?>&nbsp; &nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
<?php      $row_gjendje_info = $gjendje_info->fetch_assoc();;
       }
    mysqli_free_result($gjendje_info);
// ---------------------------------------------------------------------------------
?>
  <tr>
    <td height="1" colspan="5" bgcolor="#000033"></td>
  </tr>
  <tr>
    <td height="25" colspan="5"></td>
  </tr>
  <tr>
    <td height="1" colspan="5" bgcolor="#000033"></td>
  </tr>
  <tr>
    <td colspan="5"><DIV class="ctxheading7"><B>Veprimet e brendshme (hyrje/dalje)</B></DIV></td>
  </tr>
  <tr>
    <td><b>Klienti</b></td>
    <td><b>Monedha</b></td>
    <td align="right"><b>Hyrje</b>&nbsp; &nbsp; &nbsp; </td>
    <td align="right"><b>Dalje</b>&nbsp; &nbsp; &nbsp; </td>
    <td align="right"><b>Gjendje</b>&nbsp; &nbsp; &nbsp; </td>
  </tr>
  <tr>
    <td height="5" colspan="5"></td>
  </tr>
<?php

     set_time_limit(0);

     $v_wheresql = "";
     if ($_SESSION['Usertype'] == 2)  $v_wheresql = " and hyrjedalje.id_llogfilial = ". $_SESSION['Userfilial'] ." ";
     if ($_SESSION['Usertype'] == 3)  $v_wheresql = " and hyrjedalje.perdoruesi    = '". $_SESSION['Username'] ."' ";

        //mysql_select_db($database_MySQL, $MySQL);
        $query_gjendje_info = " SELECT hyrjedalje.id_klienti, klienti.emri, klienti.mbiemri, hyrjedalje.id_monedhe, monedha.monedha,
                                       SUM( case when hyrjedalje.drcr = 'D' then hyrjedalje.vleftapaguar else 0 end) vleftadebit,
                                       SUM( case when hyrjedalje.drcr = 'K' then hyrjedalje.vleftapaguar else 0 end) vleftakredit
                                  FROM hyrjedalje, monedha, klienti
                                 WHERE hyrjedalje.id_monedhe  = monedha.id
                                   AND hyrjedalje.id_klienti  = klienti.id
                                   AND hyrjedalje.chstatus    = 'T'
                                   AND hyrjedalje.date_trans >= '". substr($v_dt1, 6, 4)."-".substr($v_dt1, 3, 2)."-".substr($v_dt1, 0, 2) ."'
                                   AND hyrjedalje.date_trans <= '". substr($v_dt2, 6, 4)."-".substr($v_dt2, 3, 2)."-".substr($v_dt2, 0, 2) ."'
                                    ". $v_wheresql ."
                              GROUP BY hyrjedalje.id_klienti, klienti.emri, klienti.mbiemri, hyrjedalje.id_monedhe, monedha.monedha
                              ORDER BY klienti.emri, klienti.mbiemri, hyrjedalje.id_monedhe ";
        $gjendje_info     = mysqli_query($MySQL,$query_gjendje_info) or die(mysql_error());
        $row_gjendje_info = $gjendje_info->fetch_assoc();

  while ($row_gjendje_info) {
?>
  <tr>
    <td height="1" colspan="5" bgcolor="#000033"></td>
  </tr>
  <tr>
    <td><?php echo $row_gjendje_info['emri'] ." ". $row_gjendje_info['mbiemri']; ?></td>
    <td><?php echo $row_gjendje_info['monedha']; ?></td>
    <td align="right"><?php echo number_format( $row_gjendje_info['vleftadebit'], 2, '.', ','); ?>&nbsp; &nbsp;</td>
    <td align="right"><?php echo number_format( $row_gjendje_info['vleftakredit'], 2, '.', ','); ?>&nbsp; &nbsp;</td>
    <td align="right"><?php echo number_format( ($row_gjendje_info['vleftadebit'] - $row_gjendje_info['vleftakredit']), 2, '.', ','); ?>&nbsp; &nbsp;</td>
  </tr>
<?php      $row_gjendje_info = $gjendje_info->fetch_assoc();
       }
    mysqli_free_result($gjendje_info);
// ---------------------------------------------------------------------------------
?>
  <tr>
    <td height="1" colspan="5" bgcolor="#000033"></td>
  </tr>
  <tr>
    <td height="25" colspan="5"></td>
  </tr>
  <tr>
    <td height="1" colspan="5" bgcolor="#000033"></td>
  </tr>
  <tr>
    <td colspan="5"><DIV class="ctxheading7"><B>K&euml;mbimet ditore</B></DIV></td>
  </tr>
  <tr>
    <td height="1" colspan="5" bgcolor="#000033"></td>
  </tr>
  <tr>
    <td><b>Llogaria</b></td>
    <td><b>Monedha</b></td>
    <td align="right"><b>Hyrje</b>&nbsp; &nbsp; &nbsp; </td>
    <td align="right"><b>Dalje</b>&nbsp; &nbsp; &nbsp; </td>
    <td align="right"><b>Gjendje</b>&nbsp; &nbsp; &nbsp; </td>
  </tr>
  <tr>
    <td height="5" colspan="5"></td>
  </tr>
<?php

     $v_wheresql = "";
     if ($_SESSION['Usertype'] == 2)  $v_wheresql = " and ek.id_llogfilial = ". $_SESSION['Userfilial'] ." ";
     if ($_SESSION['Usertype'] == 3)  $v_wheresql = " and ek.perdoruesi    = '". $_SESSION['Username'] ."' ";

        //mysql_select_db($database_MySQL, $MySQL);
        $query_gjendje_info = " select tab_info.llogaria, tab_info.monedha, sum(tab_info.vleftakredituar) vleftakredituar, sum(tab_info.vleftadebituar) vleftadebituar
                                  from (
                                             select ek.id_llogkomision llogaria, m1.id, m1.monedha, sum(ek.vleftakomisionit) vleftakredituar, sum(0) vleftadebituar
                                               from exchange_koke ek, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.tipiveprimit   = 'CHN'
                                                and ek.date_trans    >= '". substr($v_dt1, 6, 4)."-".substr($v_dt1, 3, 2)."-".substr($v_dt1, 0, 2) ."'
                                                and ek.date_trans    <= '". substr($v_dt2, 6, 4)."-".substr($v_dt2, 3, 2)."-".substr($v_dt2, 0, 2) ."'
                                                and ek.id_monkreditim = m1.id ". $v_wheresql ."
                                           group by ek.id_llogkomision, m1.id, m1.monedha
                                             having (sum(ek.vleftakomisionit) <> 0)
                                          union all
                                             select filiali.filiali llogaria, m1.id, m1.monedha, sum(ek.vleftapaguar) vleftakredituar, sum(0) vleftadebituar
                                               from exchange_koke ek, filiali, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.tipiveprimit   = 'CHN'
                                                and ek.id_llogfilial  = filiali.id
                                                and ek.date_trans    >= '". substr($v_dt1, 6, 4)."-".substr($v_dt1, 3, 2)."-".substr($v_dt1, 0, 2) ."'
                                                and ek.date_trans    <= '". substr($v_dt2, 6, 4)."-".substr($v_dt2, 3, 2)."-".substr($v_dt2, 0, 2) ."'
                                                and ek.id_monkreditim = m1.id ". $v_wheresql ."
                                           group by filiali.filiali, m1.id, m1.monedha
                                          union all
                                             select filiali.filiali llogaria, m1.id, m1.monedha, sum(0) vleftakredituar, sum( ed.vleftadebituar ) vleftadebituar
                                               from exchange_koke ek, exchange_detaje ed, filiali, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.tipiveprimit   = 'CHN'
                                                and ek.id             = ed.id_exchangekoke
                                                and ek.id_llogfilial  = filiali.id
                                                and ek.date_trans    >= '". substr($v_dt1, 6, 4)."-".substr($v_dt1, 3, 2)."-".substr($v_dt1, 0, 2) ."'
                                                and ek.date_trans    <= '". substr($v_dt2, 6, 4)."-".substr($v_dt2, 3, 2)."-".substr($v_dt2, 0, 2) ."'
                                                and ed.id_mondebituar = m1.id ". $v_wheresql ."
                                           group by filiali.filiali, m1.id, m1.monedha
                                          union all
                                             select filiali.filiali llogaria, m1.id, m1.monedha, sum(ek.vleftapaguar) vleftakredituar, sum(0) vleftadebituar
                                               from exchange_koke ek, filiali, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.tipiveprimit   = 'TRN'
                                                and ek.id_llogfilial  = filiali.id
                                                and ek.date_trans    >= '". substr($v_dt1, 6, 4)."-".substr($v_dt1, 3, 2)."-".substr($v_dt1, 0, 2) ."'
                                                and ek.date_trans    <= '". substr($v_dt2, 6, 4)."-".substr($v_dt2, 3, 2)."-".substr($v_dt2, 0, 2) ."'
                                                and ek.id_monkreditim = m1.id ". $v_wheresql ."
                                           group by filiali.filiali, m1.id, m1.monedha
                                          union all
                                             select filiali.filiali llogaria, m1.id, m1.monedha, sum(0) vleftakredituar, sum(ek.vleftapaguar) vleftadebituar
                                               from exchange_koke ek, filiali, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.tipiveprimit   = 'TRN'
                                                and ek.id_klienti     = filiali.id
                                                and ek.date_trans    >= '". substr($v_dt1, 6, 4)."-".substr($v_dt1, 3, 2)."-".substr($v_dt1, 0, 2) ."'
                                                and ek.date_trans    <= '". substr($v_dt2, 6, 4)."-".substr($v_dt2, 3, 2)."-".substr($v_dt2, 0, 2) ."'
                                                and ek.id_monkreditim = m1.id ". $v_wheresql ."
                                           group by filiali.filiali, m1.id, m1.monedha
                                       ) tab_info
                               group by tab_info.llogaria, tab_info.id
                               order by tab_info.llogaria, tab_info.id";
        $gjendje_info     = mysqli_query($MySQL,$query_gjendje_info) or die(mysql_error());
        $row_gjendje_info = $gjendje_info->fetch_assoc();

  while ($row_gjendje_info) {
?>
  <tr>
    <td height="1" colspan="5" bgcolor="#000033"></td>
  </tr>
  <tr>
    <td><?php echo $row_gjendje_info['llogaria']; ?></td>
    <td><?php echo $row_gjendje_info['monedha']; ?></td>
    <td align="right"><?php echo number_format( $row_gjendje_info['vleftadebituar'], 2, '.', ','); ?>&nbsp; &nbsp;</td>
    <td align="right"><?php echo number_format( $row_gjendje_info['vleftakredituar'], 2, '.', ','); ?>&nbsp; &nbsp;</td>
    <td align="right"><?php echo number_format( ($row_gjendje_info['vleftadebituar'] - $row_gjendje_info['vleftakredituar']), 2, '.', ','); ?>&nbsp; &nbsp;</td>
  </tr>
<?php      $row_gjendje_info = $gjendje_info->fetch_assoc();;
       }
    mysqli_free_result($gjendje_info);
// ---------------------------------------------------------------------------------
?>
  <tr>
    <td height="1" colspan="5" bgcolor="#000033"></td>
  </tr>
  <tr>
    <td height="5" colspan="5"></td>
  </tr>
<?php
       $query_gjendje_info = " select tab_info.monedha, sum(tab_info.vleftakredituar) vleftakredituar, sum(tab_info.vleftadebituar) vleftadebituar
                                 from  (

                                             select ek.id_llogkomision llogaria, m1.id, m1.monedha, sum(ek.vleftakomisionit) vleftakredituar, sum(0) vleftadebituar
                                               from exchange_koke ek, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.tipiveprimit   = 'CHN'
                                                and ek.date_trans    >= '". substr($v_dt1, 6, 4)."-".substr($v_dt1, 3, 2)."-".substr($v_dt1, 0, 2) ."'
                                                and ek.date_trans    <= '". substr($v_dt2, 6, 4)."-".substr($v_dt2, 3, 2)."-".substr($v_dt2, 0, 2) ."'
                                                and ek.id_monkreditim = m1.id ". $v_wheresql ."
                                           group by ek.id_llogkomision, m1.id, m1.monedha
                                             having (sum(ek.vleftakomisionit) <> 0)
                                          union all
                                             select filiali.filiali llogaria, m1.id, m1.monedha, sum(ek.vleftapaguar) vleftakredituar, sum(0) vleftadebituar
                                               from exchange_koke ek, filiali, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.tipiveprimit   = 'CHN'
                                                and ek.id_llogfilial  = filiali.id
                                                and ek.date_trans    >= '". substr($v_dt1, 6, 4)."-".substr($v_dt1, 3, 2)."-".substr($v_dt1, 0, 2) ."'
                                                and ek.date_trans    <= '". substr($v_dt2, 6, 4)."-".substr($v_dt2, 3, 2)."-".substr($v_dt2, 0, 2) ."'
                                                and ek.id_monkreditim = m1.id ". $v_wheresql ."
                                           group by filiali.filiali, m1.id, m1.monedha
                                          union all
                                             select filiali.filiali llogaria, m1.id, m1.monedha, sum(0) vleftakredituar, sum( ed.vleftadebituar ) vleftadebituar
                                               from exchange_koke ek, exchange_detaje ed, filiali, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.tipiveprimit   = 'CHN'
                                                and ek.id             = ed.id_exchangekoke
                                                and ek.id_llogfilial  = filiali.id
                                                and ek.date_trans    >= '". substr($v_dt1, 6, 4)."-".substr($v_dt1, 3, 2)."-".substr($v_dt1, 0, 2) ."'
                                                and ek.date_trans    <= '". substr($v_dt2, 6, 4)."-".substr($v_dt2, 3, 2)."-".substr($v_dt2, 0, 2) ."'
                                                and ed.id_mondebituar = m1.id ". $v_wheresql ."
                                           group by filiali.filiali, m1.id, m1.monedha
                                          union all
                                             select filiali.filiali llogaria, m1.id, m1.monedha, sum(ek.vleftapaguar) vleftakredituar, sum(0) vleftadebituar
                                               from exchange_koke ek, filiali, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.tipiveprimit   = 'TRN'
                                                and ek.id_llogfilial  = filiali.id
                                                and ek.date_trans    >= '". substr($v_dt1, 6, 4)."-".substr($v_dt1, 3, 2)."-".substr($v_dt1, 0, 2) ."'
                                                and ek.date_trans    <= '". substr($v_dt2, 6, 4)."-".substr($v_dt2, 3, 2)."-".substr($v_dt2, 0, 2) ."'
                                                and ek.id_monkreditim = m1.id ". $v_wheresql ."
                                           group by filiali.filiali, m1.id, m1.monedha
                                          union all
                                             select filiali.filiali llogaria, m1.id, m1.monedha, sum(0) vleftakredituar, sum(ek.vleftapaguar) vleftadebituar
                                               from exchange_koke ek, filiali, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.tipiveprimit   = 'TRN'
                                                and ek.id_klienti     = filiali.id
                                                and ek.date_trans    >= '". substr($v_dt1, 6, 4)."-".substr($v_dt1, 3, 2)."-".substr($v_dt1, 0, 2) ."'
                                                and ek.date_trans    <= '". substr($v_dt2, 6, 4)."-".substr($v_dt2, 3, 2)."-".substr($v_dt2, 0, 2) ."'
                                                and ek.id_monkreditim = m1.id ". $v_wheresql ."
                                           group by filiali.filiali, m1.id, m1.monedha
                                      ) tab_info
                             group by tab_info.id
                             order by tab_info.id ";
        $gjendje_info = mysqli_query($MySQL,$query_gjendje_info) or die(mysql_error());
        $row_gjendje_info = $gjendje_info->fetch_assoc();

  while ($row_gjendje_info) {
?>
  <tr>
    <td height="1" colspan="5" bgcolor="#000033"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><b><?php echo $row_gjendje_info['monedha']; ?></b></td>
    <td align="right"><b><?php echo number_format( $row_gjendje_info['vleftadebituar'], 2, '.', ','); ?></b>&nbsp; &nbsp;</td>
    <td align="right"><b><?php echo number_format( $row_gjendje_info['vleftakredituar'], 2, '.', ','); ?></b>&nbsp; &nbsp;</td>
    <td align="right"><b><?php echo number_format( ($row_gjendje_info['vleftadebituar'] - $row_gjendje_info['vleftakredituar']), 2, '.', ','); ?></b>&nbsp; &nbsp;</td>
  </tr>
<?php      $row_gjendje_info = $gjendje_info->fetch_assoc();
       }
    mysqli_free_result($gjendje_info);
?>

  <tr>
    <td height="1" colspan="5" bgcolor="#000033"></td>
  </tr>
  <tr>
    <td height="20" colspan="5"></td>
  </tr>
</table>

</form>
</DIV>
<?php  if ($v_file != "") {  ?>
<br /><br />
<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href="<?php echo $v_file; ?>"><?php echo substr($v_file, 4, 100); ?></a>&nbsp;</b>
<br /><br />
<?php  }  ?>
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
