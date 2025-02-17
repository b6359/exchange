<?php
declare(strict_types=1);

session_start();
date_default_timezone_set('Europe/Tirane');

require_once('ConMySQL.php');

if (isset($_SESSION['uid'])) {
  $user_info = $_SESSION['Username'] ?? '';

  $v_reptype = $_POST['reptype'] ?? '';

  $v_begindate = '';
  $v_perioddate = '';
  $v_perioddate2 = '';
  $v_view_dt = '';
  
  if (!empty($_POST['p_date1'])) {
    $date1 = DateTime::createFromFormat('d.m.Y', $_POST['p_date1']);
    if ($date1) {
      $v_perioddate = " and ek.date_trans = '" . $date1->format('Y-m-d') . "'";
      $v_perioddate2 = " and hyrjedalje.date_trans = '" . $date1->format('Y-m-d') . "'";
      
      // Month name mapping using array instead of multiple if statements
      $monthNames = [
        '01' => 'Jan', '02' => 'Shk', '03' => 'Mar', '04' => 'Pri',
        '05' => 'Maj', '06' => 'Qer', '07' => 'Kor', '08' => 'Gus',
        '09' => 'Sht', '10' => 'Tet', '11' => 'Nen', '12' => 'Dhj'
      ];
      
      $v_monthdisp = $monthNames[$date1->format('m')] ?? '';
      $v_view_dt = $date1->format('d') . " " . $v_monthdisp . " " . $date1->format('Y');
    }
  }

  if (!empty($_POST['p_date2'])) {
    $date2 = DateTime::createFromFormat('d.m.Y', $_POST['p_date2']);
    if ($date2) {
      $v_perioddate = " and ek.date_trans >= '" . $date1->format('Y-m-d') . "'
                      and ek.date_trans <= '" . $date2->format('Y-m-d') . "' ";
      
      $v_perioddate2 = " and hyrjedalje.date_trans >= '" . $date1->format('Y-m-d') . "'
                       and hyrjedalje.date_trans <= '" . $date2->format('Y-m-d') . "' ";
      
      $v_monthdisp = $monthNames[$date2->format('m')] ?? '';
      $v_view_dt .= " - " . $date2->format('d') . " " . $v_monthdisp . " " . $date2->format('Y');
    }
  }

  $v_klient_id = (int)($_POST['id_klienti'] ?? 0);

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

    <title><?= htmlspecialchars($_SESSION['CNAME'] ?? '') ?> - Web Exchange System - Raport per transaksionet ditore/periodike</title>

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
              Printuar dt. </span><span class="ReportDateUserB"><?php echo strftime('%Y-%m-%d'); ?></span>
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
              <caption><span class="ReportTitle"> Raport per klient </span></caption>
              <?php
              if ($v_klient_id > 0) {
                $query_filiali_info = "SELECT * FROM klienti WHERE id = ?";
                $stmt = mysqli_prepare($MySQL, $query_filiali_info);
                mysqli_stmt_bind_param($stmt, 'i', $v_klient_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                while ($row_filiali_info = mysqli_fetch_assoc($result)) {
                  ?>
                  <caption><span class="ReportSubTitle"> <?= htmlspecialchars(strtoupper($row_filiali_info['emri'] . " " . $row_filiali_info['mbiemri'])) ?> </span></caption>
                  <?php
                }
                mysqli_stmt_close($stmt);
              }
              ?>
              <caption><span class="ReportSubTitle"> <?php echo $v_view_dt; ?> </span></caption>
              <thead>
                <tr>
                  <th height="0" colspan="12">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </th>
                </tr>
                <?php if ($v_reptype == "kembim") {  ?>
                  <tr>
                    <th class="OraColumnHeader" colspan="12"> K&euml;mbime valutore </th>
                  </tr>
                  <tr>
                    <th class="OraColumnHeader"> Nr. </th>
                    <th class="OraColumnHeader"> Nr. Fature </th>
                    <th class="OraColumnHeader"> Dt. Trans. </th>
                    <th class="OraColumnHeader"> Emri </th>
                    <th class="OraColumnHeader"> Mbiemri </th>
                    <th class="OraColumnHeader"> Hyr&euml; </th>
                    <th class="OraColumnHeader"> Dal&euml; </th>
                    <th class="OraColumnHeader"> Shuma e Hyr&euml; </th>
                    <th class="OraColumnHeader"> Kursi </th>
                    <th class="OraColumnHeader"> Shuma e Dal&euml; </th>
                    <th class="OraColumnHeader"> Komisioni </th>
                    <th class="OraColumnHeader"> Totali i Dal&euml; </th>
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
                        and ek.id_klienti     = " . $v_klient_id . "
                        " . $v_perioddate . "
                        and ek.id_klienti     = k.id
                        and ek.id_monkreditim = m1.id
                        and ed.id_mondebituar = m2.id
                   ";

                  $RepInfoRS   = mysqli_query($MySQL, $RepInfo_sql) or die(mysqli_error($MySQL));
                  $row_RepInfo = $RepInfoRS->fetch_assoc();

                  $rowno   = 0;

                  while ($row_RepInfo) {
                    $rowno++;

                    $v_kursi = 0;
                    if ($row_RepInfo['kursi'] > $row_RepInfo['kursi1']) {
                      $v_kursi = $row_RepInfo['kursi'];
                    } else {
                      $v_kursi = $row_RepInfo['kursi1'];
                    }
                ?>
                  <tr>
                    <td height="0" colspan="12">
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
                    <td align="center" class="OraCellGroup3"><?php echo $row_RepInfo['emri']; ?></td>
                    <td align="center" class="OraCellGroup3"><?php echo $row_RepInfo['mbiemri']; ?></td>
                    <td align="center" class="OraCellGroup2"><?php echo $row_RepInfo['mon2']; ?></td>
                    <td align="center" class="OraCellGroup2"><?php echo $row_RepInfo['mon1']; ?></td>
                    <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftadebituar'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                    <td align="right" class="OraCellGroup2"><?php echo number_format($v_kursi, 4, '.', ','); ?>&nbsp;&nbsp;</td>
                    <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftakredituar'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                    <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftakomisionit'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                    <td align="right" class="OraCellGroup2"><?php echo number_format($row_RepInfo['vleftapaguar'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                  </tr>
                <?php $row_RepInfo = $RepInfoRS->fetch_assoc();
                  };
                  mysqli_free_result($RepInfoRS);
                ?>
                <tr>
                  <td height="0" colspan="12">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              <?php  }  ?>
              <?php if ($v_reptype == "hyrdal") {  ?>
                <tr>
                  <th class="OraColumnHeader" colspan="12"> Hyrje / Dalje </th>
                </tr>
                <tr>
                  <th class="OraColumnHeader"> Nr. </th>
                  <th class="OraColumnHeader"> Emri / Mbiemri </th>
                  <th class="OraColumnHeader"> Monedha </th>
                  <th class="OraColumnHeader" colspan="3"> Hyr&euml; </th>
                  <th class="OraColumnHeader" colspan="3"> </th>
                  <th class="OraColumnHeader" colspan="3"> Dal&euml; </th>
                </tr>
                <?php

                $query_gjendje_info = " SELECT hyrjedalje.id_klienti, klienti.emri, klienti.mbiemri, hyrjedalje.id_monedhe, monedha.monedha,
                                         SUM( case when hyrjedalje.drcr = 'Debitim'  then hyrjedalje.vleftapaguar else 0 end) vleftadebit,
                                         SUM( case when hyrjedalje.drcr = 'Kreditim' then hyrjedalje.vleftapaguar else 0 end) vleftakredit
                                    FROM hyrjedalje, monedha, klienti
                                   WHERE hyrjedalje.id_monedhe = monedha.id
                                     AND hyrjedalje.id_klienti = klienti.id
                                     AND hyrjedalje.chstatus   = 'T'
                                     AND hyrjedalje.id_klienti = " . $v_klient_id . "
                                     " . $v_perioddate2 . "
                                GROUP BY hyrjedalje.id_klienti, klienti.emri, klienti.mbiemri, hyrjedalje.id_monedhe, monedha.monedha
                                ORDER BY klienti.emri, klienti.mbiemri, hyrjedalje.id_monedhe ";
                $gjendje_info     = mysqli_query($MySQL, $query_gjendje_info) or die(mysqli_error($MySQL));
                $row_gjendje_info = $gjendje_info->fetch_assoc();;
                $rowno2 = 0;

                while ($row_gjendje_info) {
                  $rowno2++;

                ?>
                  <tr>
                    <td align="center" class="OraCellGroup"> <?php echo $rowno2; ?> </td>
                    <td align="center" class="OraCellGroup3"> <?php echo $row_gjendje_info['emri']; ?> <?php echo $row_gjendje_info['mbiemri']; ?> </td>
                    <td align="center" class="OraCellGroup"> <?php echo $row_gjendje_info['monedha']; ?> </td>
                    <td align="right" class="OraCellGroup2" colspan="3"><?php echo number_format($row_gjendje_info['vleftadebit'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                    <td align="right" class="OraCellGroup2" colspan="3">&nbsp;&nbsp;</td>
                    <td align="right" class="OraCellGroup2" colspan="3"><?php echo number_format($row_gjendje_info['vleftakredit'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="0" colspan="12">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr class="line">
                          <td height="0">
                            <DIV class=line></DIV>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                <?php $row_gjendje_info = $gjendje_info->fetch_assoc();;
                }
                mysqli_free_result($gjendje_info);
                // ---------------------------------------------------------------------------------
                ?>

                <tr>
                  <td height="0" colspan="12">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

              <?php  }  ?>

              <tr>
                <td height="0" colspan="12">
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
                <td align="center" class="OraCellGroup4" colspan="3">&nbsp;<b>Monedha</b>&nbsp;</td>
                <td align="right" class="OraCellGroup4" colspan="3">&nbsp;<b>Shuma e hyr&euml;</b>&nbsp;</td>
                <td align="right" class="OraCellGroup4" colspan="3">&nbsp;<b>Komisioni</b>&nbsp;</td>
                <td align="right" class="OraCellGroup4" colspan="3">&nbsp;<b>Shuma e dal&euml;</b>&nbsp;</td>
              </tr>
              <tr>
                <td height="0" colspan="12">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr class="line">
                      <td height="0">
                        <DIV class=line></DIV>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <?php


              if ($v_reptype == "kembim") {

                $RepInfo_sql = " select info.mon, sum(info.vlerakredit) as vlerakredit, sum(info.komision) as komision, sum(info.vleradebit) as vleradebit
                       from (
                                    select 0 as vlerakredit, sum(ek.vleftakomisionit) as komision, sum(ek.vleftapaguar) as vleradebit, m1.id, m1.monedha as mon
                                      from exchange_koke as ek,
                                           klienti as k,
                                           monedha as m1
                                     where ek.chstatus       = 'T'
                                       and ek.id_klienti     = " . $v_klient_id . "
                                       " . $v_perioddate . "
                                       and ek.id_klienti     = k.id
                                       and ek.id_monkreditim = m1.id
                                  group by m1.id, m1.monedha
                                    union all
                                    select sum(ed.vleftadebituar) as vlerakredit, 0 as komision, 0 as vleradebit, m2.id, m2.monedha as mon
                                      from exchange_koke as ek,
                                           exchange_detaje as ed,
                                           klienti as k,
                                           monedha as m2
                                     where ek.chstatus       = 'T'
                                       and ek.id             = ed.id_exchangekoke
                                       and ek.id_klienti     = " . $v_klient_id . "
                                       " . $v_perioddate . "
                                       and ek.id_klienti     = k.id
                                       and ed.id_mondebituar = m2.id
                                  group by m2.id, m2.monedha
                            ) info
                     group by info.mon, info.id
                     order by info.id ";
              } else {

                $RepInfo_sql = " select info.mon, sum(info.vlerakredit) as vlerakredit, sum(info.komision) as komision, sum(info.vleradebit) as vleradebit
                       from (
                                    SELECT SUM( case when hyrjedalje.drcr = 'Debitim'  then hyrjedalje.vleftapaguar else 0 end) as vleftakredit,
                                           0 as komision,
                                           SUM( case when hyrjedalje.drcr = 'Kreditim' then hyrjedalje.vleftapaguar else 0 end) as vleftadebit,
                                           hyrjedalje.id_monedhe as id, monedha.monedha as mon
                                      FROM hyrjedalje, monedha, klienti
                                     WHERE hyrjedalje.id_monedhe = monedha.id
                                       AND hyrjedalje.id_klienti = klienti.id
                                       AND hyrjedalje.chstatus   = 'T'
                                       AND hyrjedalje.id_klienti = " . $v_klient_id . "
                                       " . $v_perioddate2 . "
                                  GROUP BY hyrjedalje.id_monedhe, monedha.monedha
                            ) info
                     group by info.mon, info.id
                     order by info.id ";
              }

              $RepInfoRS   = mysqli_query($MySQL, $RepInfo_sql) or die(mysqli_error($MySQL));
              $row_RepInfo = $RepInfoRS->fetch_assoc();

              while ($row_RepInfo) {
              ?>
                <tr>
                  <td align="center" class="OraCellGroup" colspan="3"> <?php echo $row_RepInfo['mon']; ?> </td>
                  <td align="right" class="OraCellGroup2" colspan="3"><?php echo number_format($row_RepInfo['vlerakredit'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                  <td align="right" class="OraCellGroup2" colspan="3"><?php echo number_format($row_RepInfo['komision'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                  <td align="right" class="OraCellGroup2" colspan="3"><?php echo number_format($row_RepInfo['vleradebit'], 2, '.', ','); ?>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                  <td height="0" colspan="12">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="line">
                        <td height="0">
                          <DIV class=line></DIV>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              <?php $row_RepInfo = $RepInfoRS->fetch_assoc();
              };
              mysqli_free_result($RepInfoRS);
              ?>
              <tr>
                <td align="left" class="OraCellGroup4" colspan="12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Totali i transaksioneve:</b>&nbsp;&nbsp;<b>[ <?php echo $rowno; ?> ] [ <?php echo isset($rowno2) ? $rowno2 : 0; ?> ]</b>&nbsp;</td>
              </tr>
              <tr>
                <td height="0" colspan="12">
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
                <td height="5" colspan="12"></td>
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
  document.addEventListener('contextmenu', e => e.preventDefault());
</script>

<script>
  // Disable keyCode
  document.addEventListener('keydown', e => {
    const blockedKeys = [112, 114, 116, 117, 118, 121, 122, 123];
    
    if (blockedKeys.includes(e.keyCode) || 
        e.ctrlKey || 
        e.shiftKey || 
        e.altKey || 
        (e.ctrlKey && e.shiftKey) || 
        (e.ctrlKey && e.shiftKey && e.altKey)) {
      e.preventDefault();
    }
  });
</script>