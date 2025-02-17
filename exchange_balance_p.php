<?php
declare(strict_types=1);

session_start();
date_default_timezone_set('Europe/Tirane');

// Build logout URL with proper escaping
$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if (!empty($_SERVER['QUERY_STRING'])) {
    $logoutAction .= "&" . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES, 'UTF-8');
}

// Handle logout
if (isset($_GET['doLogout']) && $_GET['doLogout'] === "true") {
    // Clear both global and session variables
    $sessionVars = [
        'uid',
        'Username',
        'full_name',
        'Usertrans',
        'Userfilial',
        'Usertype'
    ];

    // Clear session and global variables
    foreach ($sessionVars as $var) {
        unset($GLOBALS[$var]);
        unset($_SESSION[$var]);
    }

    // Redirect to login page
    $logoutGoTo = "index.php";
    if ($logoutGoTo) {
        header("Location: $logoutGoTo", true, 302);
        exit;
    }
}

require_once('ConMySQL.php');

// Check for active session
if (isset($_SESSION['uid'])) {
    // Your protected content goes here
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

    <style type="text/css">
      <!--
      body,
      td,
      th {
        font-size: 12px;
      }
      -->
    </style>

  </head>

  <body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor=#E7F2ED vlink="#0000ff" link="#0000ff">

    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TBODY>
        <TR>
          <TD align="left" height="15">
            <img src="images/header.png" border="0" width="100%" height="115px">
          </TD>
        </TR>
      </TBODY>
    </TABLE>

    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TBODY>
        <TR>
          <TD align="left" colSpan=3 height="15">
            <DIV class=ctxheading4>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="left" width="300"><B><?php echo $_SESSION['full_name']; ?>&nbsp;: Bilanci sipas Llogarive</B></td>
                  <td align="center" width="200"><a title="Faqja kryesore" class="link4" href="info.php"><img src="images/home.gif" border="0" width="18px"></a>&nbsp;&nbsp;<a title="Administrimi i perdoruesve" class="link4" href="exchange_users.php"><img src="images/user.gif" border="0" width="18px"></a>&nbsp;&nbsp;<a title="Kontakti" class="link4" href="contact.php"><img src="images/contact.gif" border="0" width="18px"></a>&nbsp;&nbsp;<a title="Dalje nga sistemi" class="link4" href="<?php echo $logoutAction ?>"><img src="images/logout.gif" border="0" width="18px"></a></td>
                </tr>
              </table>
            </DIV>
          </TD>
        </TR>
      </TBODY>
    </TABLE>

    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TBODY>
        <TR>
          <TD align="left" colSpan=3 height="15">
            <DIV class=ctxheading1><B><a class="link4" href="exchange.php" title="Kryej Veprim Monetar" target="_self">K&euml;mbim Monetar</a>&nbsp;||&nbsp;<a class="link4" href="exchange_openbal.php" title="Hapje balance ditore" target="_self">Hapje balance ditore</a>&nbsp;||&nbsp;<a class="link4" href="exchange_hyrdal.php" title="Hyrje/Dalje" target="_self">Hyrje/Dalje</a>&nbsp;||&nbsp;<a class="link4" href="exchange_rate.php" title="Kursi" target="_self">Kursi</a>&nbsp;||&nbsp;<span class="activemenu">Bilanci sipas veprimeve</span>&nbsp;||&nbsp;<a class="link4" href="exchange_basedata.php" title="T&euml; Dh&euml;nat Baz&euml;" target="_self">T&euml; Dh&euml;nat Baz&euml;</a>&nbsp;||&nbsp;<a class="link4" href="exchange_reports.php" title="Raporte" target="_self">Raporte</a></B></DIV>
          </TD>
        </TR>
      </TBODY>
    </TABLE>

    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TBODY>
        <TR>
          <TD height="15" colSpan=3 align="left" valign="middle">
            <DIV class=ctxheading><B></B></DIV>
          </TD>
        </TR>
      </TBODY>
    </TABLE>

    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TBODY>
        <TR>
          <TD height="15" colSpan=3 align="left" valign="middle">
            <DIV class=ctxheading><a title="Print" href="JavaScript: window.print();"><img src="images/print.gif" border="0"></a>&nbsp; &nbsp;</DIV>
          </TD>
        </TR>
      </TBODY>
    </TABLE>
    <br>
    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TBODY>
        <TR>
          <TD align="left" colSpan=0 height="15">
            <DIV class=ctxheading6><br>

              <table border="0" cellpadding="0" width="600px" cellspacing="0">
                <tr>
                  <td height="5"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><b>Llogaria</b></td>
                  <td><b>Monedha</b></td>
                  <td align="right"><b>Debitim</b></td>
                  <td align="right"><b>Kreditim</b></td>
                </tr>
                <tr>
                  <td height="5"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <?php

                set_time_limit(0);

                $v_wheresql = "";
                if ($_SESSION['Usertype'] == 2)  $v_wheresql = " and ek.id_llogfilial = " . $_SESSION['Userfilial'] . " ";
                if ($_SESSION['Usertype'] == 3)  $v_wheresql = " and ek.perdoruesi    = '" . $_SESSION['Username'] . "' ";

                $query_gjendje_info = " select tab_info.llogaria, tab_info.monedha, sum(tab_info.vleftakredituar) vleftakredituar, sum(tab_info.vleftadebituar) vleftadebituar
                                  from (
                                             select ek.id_llogkomision llogaria, m1.monedha, sum(ek.vleftakomisionit) vleftakredituar, sum(0) vleftadebituar
                                               from exchange_koke ek, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.date_trans >= '" . gmstrftime("%Y-", time()) . "01-01'
                                                and ek.date_trans <= '" . gmstrftime("%Y-", time()) . "12-31'
                                                and ek.id_monkreditim = m1.id " . $v_wheresql . "
                                           group by ek.id_llogkomision, m1.monedha
                                             having (sum(ek.vleftakomisionit) <> 0)
                                          union all
                                             select filiali.filiali llogaria, m1.monedha, sum(ek.vleftapaguar) vleftakredituar, sum(0) vleftadebituar
                                               from exchange_koke ek, filiali, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.id_llogfilial  = filiali.id
                                                and ek.date_trans >= '" . gmstrftime("%Y-", time()) . "01-01'
                                                and ek.date_trans <= '" . gmstrftime("%Y-", time()) . "12-31'
                                                and ek.id_monkreditim = m1.id " . $v_wheresql . "
                                           group by filiali.filiali, m1.monedha
                                          union all
                                             select filiali.filiali llogaria, m1.monedha, sum(0) vleftakredituar, sum( ed.vleftadebituar ) vleftadebituar
                                               from exchange_koke ek, exchange_detaje ed, filiali, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.id             = ed.id_exchangekoke
                                                and ek.id_llogfilial  = filiali.id
                                                and ek.date_trans >= '" . gmstrftime("%Y-", time()) . "01-01'
                                                and ek.date_trans <= '" . gmstrftime("%Y-", time()) . "12-31'
                                                and ed.id_mondebituar = m1.id " . $v_wheresql . "
                                           group by filiali.filiali, m1.monedha
                                       ) tab_info
                               group by tab_info.llogaria, tab_info.monedha
                               order by tab_info.llogaria, tab_info.monedha";
                $gjendje_info     = mysqli_query($MySQL, $query_gjendje_info) or die(mysqli_error($MySQL));
                $row_gjendje_info = mysqli_fetch_assoc($gjendje_info);

                while ($row_gjendje_info) {
                ?>
                  <tr>
                    <td height="1" colspan="6" bgcolor="#000033"></td>
                  </tr>
                  <tr>
                    <td><?php echo $row_gjendje_info['llogaria']; ?></td>
                    <td><?php echo $row_gjendje_info['monedha']; ?></td>
                    <td align="right"><?php echo number_format($row_gjendje_info['vleftadebituar'], 2, '.', ','); ?>&nbsp; &nbsp;</td>
                    <td align="right"><?php echo number_format($row_gjendje_info['vleftakredituar'], 2, '.', ','); ?>&nbsp; &nbsp;</td>
                  </tr>
                <?php $row_gjendje_info = mysqli_fetch_assoc($gjendje_info);
                }
                mysqli_free_result($gjendje_info);
                // ---------------------------------------------------------------------------------
                ?>
                <tr>
                  <td height="1" colspan="6" bgcolor="#000033"></td>
                </tr>
                <tr>
                  <td height="5" colspan="6"></td>
                </tr>
                <?php
                $query_gjendje_info = " select tab_info.monedha, sum(tab_info.vleftakredituar) vleftakredituar, sum(tab_info.vleftadebituar) vleftadebituar
                                 from  (

                                             select ek.id_llogkomision llogaria, m1.monedha, sum(ek.vleftakomisionit) vleftakredituar, sum(0) vleftadebituar
                                               from exchange_koke ek, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.date_trans >= '" . gmstrftime("%Y-", time()) . "01-01'
                                                and ek.date_trans <= '" . gmstrftime("%Y-", time()) . "12-31'
                                                and ek.id_monkreditim = m1.id " . $v_wheresql . "
                                           group by ek.id_llogkomision, m1.monedha
                                             having (sum(ek.vleftakomisionit) <> 0)
                                          union all
                                             select filiali.filiali llogaria, m1.monedha, sum(ek.vleftapaguar) vleftakredituar, sum(0) vleftadebituar
                                               from exchange_koke ek, filiali, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.id_llogfilial  = filiali.id
                                                and ek.date_trans >= '" . gmstrftime("%Y-", time()) . "01-01'
                                                and ek.date_trans <= '" . gmstrftime("%Y-", time()) . "12-31'
                                                and ek.id_monkreditim = m1.id " . $v_wheresql . "
                                           group by filiali.filiali, m1.monedha
                                          union all
                                             select filiali.filiali llogaria, m1.monedha, sum(0) vleftakredituar, sum( ed.vleftadebituar ) vleftadebituar
                                               from exchange_koke ek, exchange_detaje ed, filiali, monedha m1
                                              where ek.chstatus       = 'T'
                                                and ek.id             = ed.id_exchangekoke
                                                and ek.id_llogfilial  = filiali.id
                                                and ek.date_trans >= '" . gmstrftime("%Y-", time()) . "01-01'
                                                and ek.date_trans <= '" . gmstrftime("%Y-", time()) . "12-31'
                                                and ed.id_mondebituar = m1.id " . $v_wheresql . "
                                           group by filiali.filiali, m1.monedha
                                      ) tab_info
                             group by tab_info.monedha
                             order by tab_info.monedha ";
                $gjendje_info = mysqli_query($MySQL, $query_gjendje_info) or die(mysqli_error($MySQL));
                $row_gjendje_info = mysqli_fetch_assoc($gjendje_info);

                while ($row_gjendje_info) {
                ?>
                  <tr>
                    <td height="1" colspan="6" bgcolor="#000033"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><b><?php echo $row_gjendje_info['monedha']; ?></b></td>
                    <td align="right"><b><?php echo number_format($row_gjendje_info['vleftadebituar'], 2, '.', ','); ?></b>&nbsp; &nbsp;</td>
                    <td align="right"><b><?php echo number_format($row_gjendje_info['vleftakredituar'], 2, '.', ','); ?></b>&nbsp; &nbsp;</td>
                  </tr>
                <?php $row_gjendje_info = mysqli_fetch_assoc($gjendje_info);
                }
                mysqli_free_result($gjendje_info);
                ?>
                <tr>
                  <td height="1" colspan="6" bgcolor="#000033"></td>
                </tr>
                <tr>
                  <td height="20" colspan="6"></td>
                </tr>
              </table>
            </DIV>
          </TD>
        </TR>
      </TBODY>
    </TABLE>

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