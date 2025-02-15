<?php

session_start();
date_default_timezone_set('Europe/Tirane');

require_once('ConMySQL.php');

if (isset($_SESSION['uid'])) {
  $user_info = $_SESSION['Username'] ?? addslashes($_SESSION['Username']);

  $v_begindate = "";
  if ((isset($_POST['p_date1'])) && ($_POST['p_date1'] != "")) {

    $v_perioddate  = " and ek.date_trans = '" . substr($_POST['p_date1'], 6, 4) . "-" . substr($_POST['p_date1'], 3, 2) . "-" . substr($_POST['p_date1'], 0, 2) . "'";

    $v_tempdate   = substr($_POST['p_date1'], 6, 4) . "-" . substr($_POST['p_date1'], 3, 2) . "-" . substr($_POST['p_date1'], 0, 2);
    $v_view_dt    = substr($v_tempdate, 8, 2);
    $v_beginmonth = substr($v_tempdate, 5, 2);
    $v_monthdisp = "";
    if ($v_beginmonth == "01") {
      $v_monthdisp = "Jan";
    }
    if ($v_beginmonth == "02") {
      $v_monthdisp = "Shk";
    }
    if ($v_beginmonth == "03") {
      $v_monthdisp = "Mar";
    }
    if ($v_beginmonth == "04") {
      $v_monthdisp = "Pri";
    }
    if ($v_beginmonth == "05") {
      $v_monthdisp = "Maj";
    }
    if ($v_beginmonth == "06") {
      $v_monthdisp = "Qer";
    }
    if ($v_beginmonth == "07") {
      $v_monthdisp = "Kor";
    }
    if ($v_beginmonth == "08") {
      $v_monthdisp = "Gus";
    }
    if ($v_beginmonth == "09") {
      $v_monthdisp = "Sht";
    }
    if ($v_beginmonth == "10") {
      $v_monthdisp = "Tet";
    }
    if ($v_beginmonth == "11") {
      $v_monthdisp = "Nen";
    }
    if ($v_beginmonth == "12") {
      $v_monthdisp = "Dhj";
    }

    $v_view_dt    .= " " . $v_monthdisp . " " . substr($v_tempdate, 0, 4);
  }

  $v_enddate = "";
  if ((isset($_POST['p_date2'])) && ($_POST['p_date2'] != "")) {

    $v_perioddate  = " and ek.date_trans >= '" . substr($_POST['p_date1'], 6, 4) . "-" . substr($_POST['p_date1'], 3, 2) . "-" . substr($_POST['p_date1'], 0, 2) . "'
                           and ek.date_trans <= '" . substr($_POST['p_date2'], 6, 4) . "-" . substr($_POST['p_date2'], 3, 2) . "-" . substr($_POST['p_date2'], 0, 2) . "' ";

    $v_tempdate   = substr($_POST['p_date2'], 6, 4) . "-" . substr($_POST['p_date2'], 3, 2) . "-" . substr($_POST['p_date2'], 0, 2);
    $v_view_dt   .= " - " . substr($v_tempdate, 8, 2);
    $v_beginmonth = substr($v_tempdate, 5, 2);
    $v_monthdisp = "";
    if ($v_beginmonth == "01") {
      $v_monthdisp = "Jan";
    }
    if ($v_beginmonth == "02") {
      $v_monthdisp = "Shk";
    }
    if ($v_beginmonth == "03") {
      $v_monthdisp = "Mar";
    }
    if ($v_beginmonth == "04") {
      $v_monthdisp = "Pri";
    }
    if ($v_beginmonth == "05") {
      $v_monthdisp = "Maj";
    }
    if ($v_beginmonth == "06") {
      $v_monthdisp = "Qer";
    }
    if ($v_beginmonth == "07") {
      $v_monthdisp = "Kor";
    }
    if ($v_beginmonth == "08") {
      $v_monthdisp = "Gus";
    }
    if ($v_beginmonth == "09") {
      $v_monthdisp = "Sht";
    }
    if ($v_beginmonth == "10") {
      $v_monthdisp = "Tet";
    }
    if ($v_beginmonth == "11") {
      $v_monthdisp = "Nen";
    }
    if ($v_beginmonth == "12") {
      $v_monthdisp = "Dhj";
    }

    $v_view_dt    .= " " . $v_monthdisp . " " . substr($v_tempdate, 0, 4);
  }

  $v_branch_id = 0;
  if ((isset($_POST['id_llogfilial'])) && ($_POST['id_llogfilial'] != "")) {
    $v_branch_id = $_POST['id_llogfilial'];
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

    <title><?php echo $_SESSION['CNAME']; ?> - Web Exchange System - Raport permbledhes i transaksioneve </title>

    <link href="rep.css" rel="stylesheet" type="text/css">

  </head>

  <body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor=#ffffff vlink="#0000ff" link="#0000ff">

    <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
      <TBODY>
        <TR>
          <TD bgColor=#ffffff rowSpan=2 vAlign=center width=188>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<IMG src="images/logo.png" width="auto" height="36"><br>
            </p>
          </TD>
          <TD bgColor=#ffffff height=40 vAlign=top><IMG alt="" height=1 src="images/stretch.gif" width=5></TD>
          <TD align=center bgColor=#ffffff height=40 vAlign=middle><span class="titull"><b> <?php echo $_SESSION['CNAME']; ?> - Web Exchange System</b></span></TD>
          <TD align=right bgColor=#ffffff vAlign=bottom>
            <span class="ReportDateUserN">
              Printuar dt. </span><span class="ReportDateUserB"><?php echo strftime('%d.%m.%Y'); ?></span>
            <span class="ReportDateUserN">P&euml;rdoruesi: </span><span class="ReportDateUserB"><?php echo $user_info; ?>
            </span>
          </TD>
        </TR>
      </TBODY>
    </TABLE>
    <TABLE bgColor=#ff0000 border=0 cellPadding=0 cellSpacing=0 width="100%">
      <TBODY>
        <TR>
          <TD bgColor=#ff0000 class="OraColumnHeader">&nbsp; </TD>
        </TR>
      </TBODY>
    </TABLE>
    <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
      <TBODY>
        <TR>
          <TD bgColor=#ff0000 vAlign=top class="OraColumnHeader"><IMG alt="" border=0 height=17 src="images/topcurl.gif" width=30></TD>
          <TD vAlign=top width="100%">
            <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
              <TBODY>
                <TR>
                  <TD bgColor=#000000 height=1><IMG alt="" border=0 height=1 src="images/stretch.gif" width=1></TD>
                </TR>
                <TR>
                  <TD bgColor=#9a9c9a height=1><IMG alt="" border=0 height=1 src="images/stretch.gif" width=1></TD>
                </TR>
                <TR>
                  <TD bgColor=#b3b4b3 height=1><IMG alt="" border=0 height=1 src="images/stretch.gif" width=1></TD>
                </TR>
              </TBODY>
            </TABLE>
          </TD>
        </TR>
      </TBODY>
    </TABLE>
    <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
      <TR>
        <TD width="100%">
          <DIV align="center">
            <table class="OraTable">
              <caption><span class="ReportTitle"> Raport permbledhes i transaksioneve </span></caption>
              <?php
              //mysql_select_db($database_MySQL, $MySQL);
              $query_filiali_info = "select * from filiali where id = " . $v_branch_id;
              $filiali_info = mysqli_query($MySQL, $query_filiali_info) or die(mysql_error());
              $row_filiali_info = $filiali_info->fetch_assoc();

              while ($row_filiali_info) {
              ?>
                <caption><span class="ReportSubTitle"> <?php echo strtoupper($row_filiali_info['filiali']); ?> </span></caption>
              <?php
                $row_filiali_info = $filiali_info->fetch_assoc();
              }
              mysqli_free_result($filiali_info);
              ?>
              <caption><span class="ReportSubTitle"> <?php echo $v_view_dt; ?> </span></caption>
              <thead>
                <tr>
                  <th height="0" colspan="13">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </th>
                </tr>
                <tr>
                  <th class="OraColumnHeader" rowspan="2"> Nr.. </th>
                  <th class="OraColumnHeader" rowspan="2"> Nr. Fature </th>
                  <th class="OraColumnHeader" rowspan="2"> Dt. Trans. </th>
                  <th class="OraColumnHeader" colspan="9"> Blerje </th>
                  <th class="OraColumnHeader" rowspan="2"> Perdoruesi </th>
                </tr>
                <tr>
                  <th class="OraColumnHeader"> USD </th>
                  <th class="OraColumnHeader"> RATE </th>
                  <th class="OraColumnHeader"> LEK </th>
                  <th class="OraColumnHeader"> EUR </th>
                  <th class="OraColumnHeader"> RATE </th>
                  <th class="OraColumnHeader"> LEK </th>
                  <th class="OraColumnHeader"> EUR </th>
                  <th class="OraColumnHeader"> RATE </th>
                  <th class="OraColumnHeader"> USD </th>
                </tr>
              </thead>
              <tbody>

                <?php

                set_time_limit(0);

                $v_wheresql = "";
                if ($_SESSION['Usertype'] == 2)  $v_wheresql = " and ek.id_llogfilial = " . $_SESSION['Userfilial'] . " ";
                if ($_SESSION['Usertype'] == 3)  $v_wheresql = " and ek.perdoruesi    = '" . $_SESSION['Username'] . "' ";

                //mysql_select_db($database_MySQL, $MySQL);
                $RepInfo_sql = " select ek.*, ed.*, k.emri, k.mbiemri, m1.monedha as mon1, m2.monedha as mon2
                       from exchange_koke as ek,
                            exchange_detaje as ed,
                            klienti as k,
                            monedha as m1,
                            monedha as m2
                      where ek.chstatus       = 'T'
                        and ek.id             = ed.id_exchangekoke
                        and ek.id_llogfilial  = " . $v_branch_id . "
                       " . $v_perioddate . "
                       " . $v_wheresql   . "
                        and ek.id_klienti     = k.id
                        and ek.id_monkreditim = m1.id
                        and ed.id_mondebituar = m2.id
                   ";

                $RepInfoRS   = mysqli_query($MySQL, $RepInfo_sql) or die(mysql_error());
                $row_RepInfo = $RepInfoRS->fetch_assoc();

                $rowno   = 0;
                $v_b_1n  = 0;
                $v_b_11  = 0;
                $v_b_12  = 0;
                $v_b_13  = 0;
                $v_b_2n  = 0;
                $v_b_21  = 0;
                $v_b_22  = 0;
                $v_b_23  = 0;
                $v_b_3n  = 0;
                $v_b_31  = 0;
                $v_b_32  = 0;
                $v_b_33  = 0;

                while ($row_RepInfo) {

                  if ((($row_RepInfo['mon2'] == "USD") && ($row_RepInfo['mon1'] == "LEK"))
                    || (($row_RepInfo['mon2'] == "EUR") && ($row_RepInfo['mon1'] == "LEK"))
                    || (($row_RepInfo['mon2'] == "EUR") && ($row_RepInfo['mon1'] == "USD"))
                  ) {
                    $rowno++;

                ?>
                    <tr>
                      <td height="0" colspan="13">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr class="line">
                            <td height="0">
                              <DIV class=line></DIV>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" class="OraCellGroup"><?php echo $rowno; ?></td>
                      <td align="center" class="OraCellGroup2"><?php echo $row_RepInfo['id_llogfilial'] . "-" . $row_RepInfo['unique_id']; ?></td>
                      <td align="center" class="OraCellGroup2"><?php echo substr($row_RepInfo['datarregjistrimit'], 8, 2) . "." . substr($row_RepInfo['datarregjistrimit'], 5, 2) . "." . substr($row_RepInfo['datarregjistrimit'], 0, 4) . " " . substr($row_RepInfo['datarregjistrimit'], 11, 8); ?></td>

                      <?php if (($row_RepInfo['mon2'] == "USD") && ($row_RepInfo['mon1'] == "LEK")) {

                        $v_kursi = 0;
                        if ($row_RepInfo['kursi'] > $row_RepInfo['kursi1']) {
                          $v_kursi = $row_RepInfo['kursi'];
                        } else {
                          $v_kursi = $row_RepInfo['kursi1'];
                        }

                        $v_b_1n++;
                        $v_b_11 += $row_RepInfo['vleftadebituar'];
                        $v_b_12 += $v_kursi;
                        $v_b_13 += $row_RepInfo['vleftapaguar'];
                      ?>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftadebituar'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($v_kursi, 4, '.', ','); ?>&nbsp;&nbsp;</td>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftapaguar'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                      <?php  } else {  ?>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                      <?php  }  ?>

                      <?php if (($row_RepInfo['mon2'] == "EUR") && ($row_RepInfo['mon1'] == "LEK")) {

                        $v_kursi = 0;
                        if ($row_RepInfo['kursi'] > $row_RepInfo['kursi1']) {
                          $v_kursi = $row_RepInfo['kursi'];
                        } else {
                          $v_kursi = $row_RepInfo['kursi1'];
                        }

                        $v_b_2n++;
                        $v_b_21 += $row_RepInfo['vleftadebituar'];
                        $v_b_22 += $v_kursi;
                        $v_b_23 += $row_RepInfo['vleftapaguar'];
                      ?>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftadebituar'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($v_kursi, 4, '.', ','); ?>&nbsp;&nbsp;</td>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftapaguar'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                      <?php  } else {  ?>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                      <?php  }  ?>

                      <?php if (($row_RepInfo['mon2'] == "EUR") && ($row_RepInfo['mon1'] == "USD")) {

                        $v_kursi = 0;
                        if ($row_RepInfo['kursi'] > $row_RepInfo['kursi1']) {
                          $v_kursi = $row_RepInfo['kursi'];
                        } else {
                          $v_kursi = $row_RepInfo['kursi1'];
                        }

                        $v_b_3n++;
                        $v_b_31 += $row_RepInfo['vleftadebituar'];
                        $v_b_32 += $v_kursi;
                        $v_b_33 += $row_RepInfo['vleftapaguar'];
                      ?>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftadebituar'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($v_kursi, 4, '.', ','); ?>&nbsp;&nbsp;</td>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftapaguar'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                      <?php  } else {  ?>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                      <?php  }  ?>

                      <td align="center" class="OraCellGroup2"><?php echo $row_RepInfo['perdoruesi']; ?></td>
                    </tr>
                <?php        }
                  $row_RepInfo = $RepInfoRS->fetch_assoc();
                };
                mysqli_free_result($RepInfoRS);
                ?>
                <tr>
                  <td height="0" colspan="13">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td height="0" colspan="13">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td align="center" class="OraCellGroup" colspan="3"><b> Total </b></td>
                  <?php
                  if ($v_b_1n != 0) {
                    $v_b_12 = $v_b_12 / $v_b_1n;
                  }
                  if ($v_b_2n != 0) {
                    $v_b_22 = $v_b_22 / $v_b_2n;
                  }
                  if ($v_b_3n != 0) {
                    $v_b_32 = $v_b_32 / $v_b_3n;
                  }
                  ?>
                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_11, 2, '.', ','); ?></b>&nbsp;&nbsp;</td>
                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_12, 4, '.', ','); ?></b>&nbsp;&nbsp;</td>
                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_13, 2, '.', ','); ?></b>&nbsp;&nbsp;</td>

                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_21, 2, '.', ','); ?></b>&nbsp;&nbsp;</td>
                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_22, 4, '.', ','); ?></b>&nbsp;&nbsp;</td>
                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_23, 2, '.', ','); ?></b>&nbsp;&nbsp;</td>

                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_31, 2, '.', ','); ?></b>&nbsp;&nbsp;</td>
                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_32, 4, '.', ','); ?></b>&nbsp;&nbsp;</td>
                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_33, 2, '.', ','); ?></b>&nbsp;&nbsp;</td>

                  <td align="center" class="OraCellGroup">&nbsp;</td>
                </tr>
                <tr>
                  <td height="0" colspan="13">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td height="0" colspan="13">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td align="left" class="OraCellGroup4" colspan="13">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Totali i transaksioneve:</b>&nbsp;&nbsp;<b>[ <?php echo $rowno; ?> ]</b>&nbsp;</td>
                </tr>
                <tr>
                  <td height="0" colspan="13">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td height="5" colspan="13"></td>
                </tr>
            </table>


            <table class="OraTable">
              <thead>
                <tr>
                  <th height="0" colspan="13">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </th>
                </tr>
                <tr>
                  <th class="OraColumnHeader" rowspan="2"> Nr. </th>
                  <th class="OraColumnHeader" rowspan="2"> Nr. Fature </th>
                  <th class="OraColumnHeader" rowspan="2"> Dt. Trans. </th>
                  <th class="OraColumnHeader" colspan="9"> Shitje </th>
                  <th class="OraColumnHeader" rowspan="2"> Perdoruesi </th>
                </tr>
                <tr>
                  <th class="OraColumnHeader"> USD </th>
                  <th class="OraColumnHeader"> RATE </th>
                  <th class="OraColumnHeader"> LEK </th>
                  <th class="OraColumnHeader"> EUR </th>
                  <th class="OraColumnHeader"> RATE </th>
                  <th class="OraColumnHeader"> LEK </th>
                  <th class="OraColumnHeader"> EUR </th>
                  <th class="OraColumnHeader"> RATE </th>
                  <th class="OraColumnHeader"> USD </th>
                </tr>
              </thead>
              <tbody>

                <?php

                set_time_limit(0);

                $RepInfo_sql = " select ek.*, ed.*, k.emri, k.mbiemri, m1.monedha as mon1, m2.monedha as mon2
                       from exchange_koke as ek,
                            exchange_detaje as ed,
                            klienti as k,
                            monedha as m1,
                            monedha as m2
                      where ek.chstatus       = 'T'
                        and ek.id             = ed.id_exchangekoke
                        and ek.id_llogfilial  = " . $v_branch_id . "
                       " . $v_perioddate . "
                       " . $v_wheresql   . "
                        and ek.id_klienti     = k.id
                        and ek.id_monkreditim = m1.id
                        and ed.id_mondebituar = m2.id
                   ";

                $RepInfoRS   = mysqli_query($MySQL, $RepInfo_sql) or die(mysql_error());
                $row_RepInfo = $RepInfoRS->fetch_assoc();

                $rowno   = 0;
                $v_b_1n  = 0;
                $v_b_11  = 0;
                $v_b_12  = 0;
                $v_b_13  = 0;
                $v_b_2n  = 0;
                $v_b_21  = 0;
                $v_b_22  = 0;
                $v_b_23  = 0;
                $v_b_3n  = 0;
                $v_b_31  = 0;
                $v_b_32  = 0;
                $v_b_33  = 0;

                while ($row_RepInfo) {

                  if ((($row_RepInfo['mon1'] == "USD") && ($row_RepInfo['mon2'] == "LEK"))
                    || (($row_RepInfo['mon1'] == "EUR") && ($row_RepInfo['mon2'] == "LEK"))
                    || (($row_RepInfo['mon1'] == "EUR") && ($row_RepInfo['mon2'] == "USD"))
                  ) {
                    $rowno++;

                ?>
                    <tr>
                      <td height="0" colspan="13">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr class="line">
                            <td height="0">
                              <DIV class=line></DIV>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" class="OraCellGroup"><?php echo $rowno; ?></td>
                      <td align="center" class="OraCellGroup2"><?php echo $row_RepInfo['id_llogfilial'] . "-" . $row_RepInfo['unique_id']; ?></td>
                      <td align="center" class="OraCellGroup2"><?php echo substr($row_RepInfo['date_trans'], 8, 2) . "." . substr($row_RepInfo['date_trans'], 5, 2) . "." . substr($row_RepInfo['date_trans'], 0, 4); ?></td>

                      <?php if (($row_RepInfo['mon1'] == "USD") && ($row_RepInfo['mon2'] == "LEK")) {

                        $v_kursi = 0;
                        if ($row_RepInfo['kursi'] > $row_RepInfo['kursi1']) {
                          $v_kursi = $row_RepInfo['kursi'];
                        } else {
                          $v_kursi = $row_RepInfo['kursi1'];
                        }

                        $v_b_1n++;
                        $v_b_11 += $row_RepInfo['vleftapaguar'];
                        $v_b_12 += $v_kursi;
                        $v_b_13 += $row_RepInfo['vleftadebituar'];
                      ?>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftapaguar'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($v_kursi, 4, '.', ','); ?>&nbsp;&nbsp;</td>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftadebituar'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                      <?php  } else {  ?>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                      <?php  }  ?>

                      <?php if (($row_RepInfo['mon1'] == "EUR") && ($row_RepInfo['mon2'] == "LEK")) {

                        $v_kursi = 0;
                        if ($row_RepInfo['kursi'] > $row_RepInfo['kursi1']) {
                          $v_kursi = $row_RepInfo['kursi'];
                        } else {
                          $v_kursi = $row_RepInfo['kursi1'];
                        }

                        $v_b_2n++;
                        $v_b_21 += $row_RepInfo['vleftapaguar'];
                        $v_b_22 += $v_kursi;
                        $v_b_23 += $row_RepInfo['vleftadebituar'];
                      ?>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftapaguar'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($v_kursi, 4, '.', ','); ?>&nbsp;&nbsp;</td>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftadebituar'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                      <?php  } else {  ?>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                      <?php  }  ?>

                      <?php if (($row_RepInfo['mon1'] == "EUR") && ($row_RepInfo['mon2'] == "USD")) {

                        $v_kursi = 0;
                        if ($row_RepInfo['kursi'] > $row_RepInfo['kursi1']) {
                          $v_kursi = $row_RepInfo['kursi'];
                        } else {
                          $v_kursi = $row_RepInfo['kursi1'];
                        }

                        $v_b_3n++;
                        $v_b_31 += $row_RepInfo['vleftapaguar'];
                        $v_b_32 += $v_kursi;
                        $v_b_33 += $row_RepInfo['vleftadebituar'];
                      ?>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftapaguar'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($v_kursi, 4, '.', ','); ?>&nbsp;&nbsp;</td>
                        <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftadebituar'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                      <?php  } else {  ?>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                        <td align="right" class="OraCellGroup2">&nbsp;</td>
                      <?php  }  ?>

                      <td align="center" class="OraCellGroup2"><?php echo $row_RepInfo['perdoruesi']; ?></td>
                    </tr>
                <?php        }
                  $row_RepInfo = $RepInfoRS->fetch_assoc();
                };
                mysqli_free_result($RepInfoRS);
                ?>
                <tr>
                  <td height="0" colspan="13">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td height="0" colspan="13">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td align="center" class="OraCellGroup" colspan="3"><b> Total </b></td>
                  <?php
                  if ($v_b_1n != 0) {
                    $v_b_12 = $v_b_12 / $v_b_1n;
                  }
                  if ($v_b_2n != 0) {
                    $v_b_22 = $v_b_22 / $v_b_2n;
                  }
                  if ($v_b_3n != 0) {
                    $v_b_32 = $v_b_32 / $v_b_3n;
                  }
                  ?>
                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_11, 2, '.', ','); ?></b>&nbsp;&nbsp;</td>
                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_12, 4, '.', ','); ?></b>&nbsp;&nbsp;</td>
                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_13, 2, '.', ','); ?></b>&nbsp;&nbsp;</td>

                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_21, 2, '.', ','); ?></b>&nbsp;&nbsp;</td>
                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_22, 4, '.', ','); ?></b>&nbsp;&nbsp;</td>
                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_23, 2, '.', ','); ?></b>&nbsp;&nbsp;</td>

                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_31, 2, '.', ','); ?></b>&nbsp;&nbsp;</td>
                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_32, 4, '.', ','); ?></b>&nbsp;&nbsp;</td>
                  <td align="right" class="OraCellGroup2"><b><?php echo number_format($v_b_33, 2, '.', ','); ?></b>&nbsp;&nbsp;</td>

                  <td align="center" class="OraCellGroup">&nbsp;</td>
                </tr>
                <tr>
                  <td height="0" colspan="13">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td height="0" colspan="13">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td align="left" class="OraCellGroup4" colspan="13">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Totali i transaksioneve:</b>&nbsp;&nbsp;<b>[ <?php echo $rowno; ?> ]</b>&nbsp;</td>
                </tr>
                <tr>
                  <td height="0" colspan="13">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td height="5" colspan="13"></td>
                </tr>
            </table>

          </DIV>
        </TD>
      </TR>
    </TABLE>

    <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
      <TBODY>
        <TR>
          <TD bgColor=#000000 colSpan=2><IMG alt=" " border=0 height=1 src="images/stretch.gif" width=1></TD>
        </TR>
        <TR>
          <TD bgColor=#ff0000 colSpan=2 class="OraColumnHeader"><IMG alt=" " border=0 height=4 src="images/stretch.gif" width=1></TD>
        </TR>
        <TR>
          <TD bgColor=#000000 colSpan=2><IMG alt=" " border=0 height=1 src="images/stretch.gif" width=1></TD>
        </TR>
        <TR>
          <TD bgColor=#ffffff>&nbsp;<span class="ReportDateUserB"> </span></TD>
          <TD align=right bgColor=#ffffff>&nbsp;</TD>
        </TR>
      </TBODY>
    </TABLE>

  </body>

  </html>
<?php  }  ?>


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
      e.shiftKey ||

      // Disable Alt
      e.altKey ||

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