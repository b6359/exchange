<?php

session_start();
date_default_timezone_set('Europe/Tirane');

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")) {
  $logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) && ($_GET['doLogout'] == "true")) {
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

require_once('ConMySQL.php');

if (isset($_SESSION['uid'])) {
  $user_info = $_SESSION['Username'] ?? addslashes($_SESSION['Username']);

  $query_klienti_info = "select * from klienti where (id > 100 or id = 1) order by id asc";
  $klienti_info = mysqli_query($MySQL, $query_klienti_info) or die(mysql_error());
  $row_klienti_info = $klienti_info->fetch_assoc();

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

    <script language="JavaScript" src="calendar_eu.js"></script>
    <link rel="stylesheet" href="calendar.css">

    <script language="JavaScript">
      <!-- Begin
      function Open_Klient_Window() {

        childWindow = window.open('klient_list.php', 'KlientList', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=335,height=350');
      }

      //  End 
      -->
    </script>

    <link href="styles.css" rel="stylesheet" type="text/css">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link href="styles.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/text.css">
    <link rel="stylesheet" type="text/css" href="css/984_width.css">
    <link rel="stylesheet" type="text/css" href="css/layout.css">
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" type="text/css" href="css/server.css" />

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
        <a href="info.php" class="ButLart2" target="_top">KREU</a>
        <a href="exchange_users.php" class="ButLart2" target="_top">P&Euml;RDORUESIT</a>
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
        <a href="exchange.php" class="ButLart2" target="_top">K&euml;mbim Monetar</a>
        <a href="exchange_kalimlog.php" class="ButLart2" target="_top">Kalim nd&euml;rmjet filialeve</a>
        <a href="exchange_hyrdal.php" class="ButLart2" target="_top">Veprime Monetare</a>
        <a href="exchange_rate.php" class="ButLart2" target="_top">Kursi i K&euml;mbimit</a>
        <a href="exchange_opclbal.php" class="ButLart2" target="_top">Hapje/Mbyllje Dite</a>
        <a href="exchange_balance.php" class="ButLart2" target="_top">Bilanci sipas veprimeve</a>
        <a href="exchange_basedata.php" class="ButLart2" target="_top">T&euml; Dh&euml;nat Baz&euml;</a>
        <a href="exchange_reports.php" class="ButLart2" target="_top"><b>Raporte</b></a>
      </div>

      <div class="clear"></div>
    </div>
    <div id="bar">
      <div class="ButonatFillimi">
        <a href="vle_rep.php" class="ButLart2" target="_top"><b>Raport p&euml;r vlera</b></a>
        <a href="cli_rep.php" class="ButLart2" target="_top">Raport p&euml;r Klient</a>
        <a href="fiu_rep.php" class="ButLart2" target="_top">Raport p&euml;r DPPPP</a>
        <a href="boa_rep.php" class="ButLart2" target="_top">Banka e Shqip&euml;ris&euml;</a>
        <a href="dt_rep.php" class="ButLart2" target="_top">Veprimet ditore/periodike</a>
        <a href="st_rep.php" class="ButLart2" target="_top">P&euml;rmbledhje e veprimeve</a>
      </div>
      <div class="clear"></div>
    </div>

    <br />

    <div class="container_12">

      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY>
          <TR>
            <TD height="15" colSpan=3 align="left" valign="middle">
              <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Raporti i veprimeve p&euml;r vlera
    </DIV>
    </TD>
    </TR>
    </TBODY>
    </TABLE>
    <br />

    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TBODY>
        <TR>
          <TD align="left">

            <form action="vle_view.php" method="POST" name="formmenu" target="_blank">
              <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                <TBODY>
                  <TR>
                    <TD align="left">
                      <DIV class=ctxheading>

                        <table width="100%" border="0" class="bordertable">
                          <tr>
                            <td height="5" width="90"></td>
                            <td height="5" width="200"></td>
                            <td height="5" width="5"></td>
                            <td height="5" width="200"></td>
                            <td height="5" width="5"></td>
                          </tr>
                          <tr>
                            <td height="5"><b>Klienti:</b></td>
                            <td colspan="4">
                              <select name="id_klienti" id="id_klienti">
                                <option value="all">T&euml; gjith&euml;</option>
                                <?php
                                while ($row_klienti_info) {
                                ?>
                                  <option value="<?php echo $row_klienti_info['id']; ?>"><?php echo $row_klienti_info['emriplote']; ?></option>
                                <?php
                                  $row_klienti_info = $klienti_info->fetch_assoc();
                                }
                                mysqli_free_result($klienti_info);
                                ?>
                              </select>&nbsp;&nbsp;<a class="link4" href="JavaScript: Open_Klient_Window();"><img src="images/doc.gif" border="0"></a>
                            </td>
                    </td>
                  </tr>
                  <tr>
                    <td height="5" colspan="5"></td>
                  </tr>
                  <tr>
                    <td height="5"><b>Vlera:</b></td>
                    <td height="5">Nga:</td>
                    <td height="5"></td>
                    <td height="5">Deri:</td>
                    <td height="5"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><input name="p_vlera1" type="text" id="p_vlera1" value="0" size="15" maxlength="10"></td>
                    <td></td>
                    <td><input name="p_vlera2" type="text" id="p_vlera2" value="9999999999" size="15" maxlength="10"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td height="5" colspan="5"></td>
                  </tr>
                  <tr>
                    <td height="5"><b>Data:</b></td>
                    <td height="5">Nga:</td>
                    <td height="5"></td>
                    <td height="5">Deri:</td>
                    <td height="5"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><input name="p_date1" type="text" id="p_date1" value="<?php echo strftime('%d.%m.%Y'); ?>" size="15" maxlength="10">
                      <script language="JavaScript">
                        var o_cal = new tcal({
                          'formname': 'formmenu',
                          'controlname': 'p_date1'
                        });
                        o_cal.a_tpl.yearscroll = true;
                        o_cal.a_tpl.weekstart = 1;
                      </script>
                    </td>
                    <td></td>
                    <td><input name="p_date2" type="text" id="p_date2" value="<?php echo strftime('%d.%m.%Y'); ?>" size="15" maxlength="10">
                      <script language="JavaScript">
                        var o_cal = new tcal({
                          'formname': 'formmenu',
                          'controlname': 'p_date2'
                        });
                        o_cal.a_tpl.yearscroll = true;
                        o_cal.a_tpl.weekstart = 1;
                      </script>
                    </td>
                    <td></td>
                  </tr>
                  <tr class="nentitull1">
                    <td></td>
                    <td><span class="date">&nbsp;&nbsp;&nbsp;(dd.mm.yyyy)&nbsp;</span></td>
                    <td></td>
                    <td><span class="date">&nbsp;&nbsp;&nbsp;(dd.mm.yyyy)&nbsp;</span></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td height="10" colspan="5"></td>
                  </tr>
                  <tr>
                    <td height="1" colspan="4" bgcolor="#000066"></td>
                    <td height="1"></td>
                  </tr>
                  <tr>
                    <td height="5" colspan="5"></td>
                  </tr>
                  <tr class="nentitull">
                    <td colspan="5" align="center">
                      <script>
                        document.write("<input name=\"repdata\" class=\"inputtext4\" type=\"submit\" value=\"Shfaq raportin...\">");
                      </script>
                    </td>
          </td>
        </tr>
        <tr>
          <td height="10" colspan="5"></td>
        </tr>
    </table>

    </DIV>
    </TD>
    </TR>
    </TBODY>
    </TABLE>

    </form>

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