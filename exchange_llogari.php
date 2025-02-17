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

if (isset($_SESSION['uid'])) {

?>
  <?php require_once('ConMySQL.php'); ?>
  <?php
  if (isset($_GET['action']) && ($_GET['action'] == "del")) {
    $sql_info = "DELETE FROM llogarite 
      WHERE id = " . $_GET['hid'] . "
      AND (SELECT COUNT(*) FROM exchange_koke WHERE exchange_koke.id_llogfilial = llogarite.id) = 0";
    $result = mysqli_query($MySQL, $sql_info) or die(mysqli_error($MySQL));
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


    <SCRIPT LANGUAGE="JavaScript">
      <!--
      function do_delete(value) {
        var flag = false;

        flag = confirm('Jeni i sigurte per fshirjen e ketij rekordi ?!. ');

        if (flag == true) {
          window.location = 'exchange_llogari.php?action=del&hid=' + value;
        }
      }
      // 
      -->
    </SCRIPT>

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
        <a href="exchange_basedata.php" class="ButLart2" target="_top"><b>T&euml; Dh&euml;nat Baz&euml;</b></a>
        <a href="exchange_reports.php" class="ButLart2" target="_top">Raporte</a>
      </div>

      <div class="clear"></div>
    </div>
    <div id="bar">
      <div class="ButonatFillimi">
        <a href="exchange_openbal.php" class="ButLart2" target="_top">Hapje balance</a>
        <a href="exchange_llogari.php" class="ButLart2" target="_top"><b>Llogarit&euml;</b></a>
        <a href="exchange_account.php" class="ButLart2" target="_top">Filialet</a>
        <a href="exchange_client.php" class="ButLart2" target="_top">Klient&euml;t</a>
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
              <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Administrimi i llogarive
    </DIV>
    </TD>
    </TR>
    </TBODY>
    </TABLE>
    <br />

    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TBODY>
        <TR>
          <TD align="left" colSpan=0 height="15">
            <DIV class=ctxheading><br>

              <table border="0" cellpadding="0" width="100%" cellspacing="0">
                <tr>
                  <td height="6" colspan="5"></td>
                </tr>
                <tr>
                  <th width="5px"> </th>
                  <th class="OraColumnHeader"> Kodi </th>
                  <th class="OraColumnHeader"> Llogaria </th>
                  <th class="OraColumnHeader"> Aktive/Pasive </th>
                  <th class="OraColumnHeader"> Veprimi (D/C) </th>
                  <th class="OraColumnHeader"> </th>
                  <th class="OraColumnHeader"> </th>
                  <th width="15px"> </th>
                </tr>
                <tr>
                  <td></td>
                  <td height="2" colspan="6" bgcolor="#000033"></td>
                  <td></td>
                </tr>
                <?php

                $sql_info = "select * from llogarite order by kodi asc";
                $h_menu = mysqli_query($MySQL, $sql_info) or die(mysqli_error($MySQL));
                $row_h_menu = $h_menu->fetch_assoc();
                $totalRows_h_menu = $h_menu->num_rows;

                while ($row_h_menu) { ?>
                  <tr>
                    <td></td>
                    <td align="center"><?php echo $row_h_menu['kodi']; ?></td>
                    <td align="center"><?php echo $row_h_menu['llogaria']; ?></td>
                    <td align="center"><?php echo $row_h_menu['tipi']; ?></td>
                    <td align="center"><?php echo $row_h_menu['veprimi']; ?></td>
                    <td width="20"><a title="Modifiko Informacionin" href="insupd_llogari_data.php?action=upd&hid=<?php echo $row_h_menu['id']; ?>"><img src="images/edit.gif" border="0"></a></td>
                    <td width="20"><a title="Fshij Informacionin" href="JavaScript: do_delete(<?php echo $row_h_menu['id']; ?>); "><img src="images/del.gif" border="0"></a></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td height="1" colspan="6" bgcolor="#000033"></td>
                    <td></td>
                  </tr>
                <?php $row_h_menu = $h_menu->fetch_assoc();;
                };
                mysqli_free_result($h_menu);
                ?>
                <tr>
                  <td></td>
                  <td height="1" colspan="6" bgcolor="#000033"></td>
                  <td></td>
                </tr>
              </table>
              <br />
              <table width="100%" border="0">
                <tr>
                  <td>&nbsp;<input name="insert_dt" type="button" value="Shto Llogari..." onClick="JavaScript: window.location='insupd_llogari_data.php?action=ins';"></td>
                </tr>
              </table>
              <br />
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
};
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