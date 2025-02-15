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
    $sql_info = "DELETE FROM klienti 
      WHERE id = " . $_GET['hid'] . "
      AND (SELECT COUNT(*) FROM exchange_koke WHERE exchange_koke.id_klienti = klienti.id) = 0";
    $result = mysqli_query($MySQL, $sql_info) or die(mysql_error());
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
          window.location = 'exchange_client.php?action=del&hid=' + value;
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
        <a href="exchange_llogari.php" class="ButLart2" target="_top">Llogarit&euml;</a>
        <a href="exchange_account.php" class="ButLart2" target="_top">Filialet</a>
        <a href="exchange_client.php" class="ButLart2" target="_top"><b>Klient&euml;t</b></a>
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
              <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Administrimi i klient&euml;ve
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

              <form ACTION="exchange_client.php" METHOD="POST" name="formmenu">
                <table border="0" cellpadding="0" width="100%" cellspacing="0">
                  <tr>
                    <td></td>
                    <td colspan="8"><input name="emri" type="text" id="emri" placeholder="Kerko" value="" onChange="JanaScript: document.formmenu.submit();" size="35"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td height="5" colspan="8"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th width="5px"> </th>
                    <th class="OraColumnHeader"> Emri </th>
                    <th class="OraColumnHeader"> Mbiemri </th>
                    <th class="OraColumnHeader"> Kompani</th>
                    <th class="OraColumnHeader"> Telefon </th>
                    <th class="OraColumnHeader"> Nr. Dokumenti </th>
                    <th class="OraColumnHeader"> Dokumenti </th>
                    <th class="OraColumnHeader"> </th>
                    <th class="OraColumnHeader"> </th>
                    <th width="15px"> </th>
                  </tr>
                  <tr>
                    <td></td>
                    <td height="2" colspan="8" bgcolor="#000033"></td>
                    <td></td>
                  </tr>
                  <?php

                  //mysql_select_db($database_MySQL, $MySQL);
                  $where = " WHERE TRUE ";
                  if ((isset($_POST["emri"])) && ($_POST["emri"] != "")) {
                    $where = " WHERE emri like '%" . $_POST["emri"] . "%' or mbiemri like '%" . $_POST["emri"] . "%' ";
                  }
                  $rec_limit = 50;
                  $sql = "SELECT count(id) FROM klienti " . $where;
                  $retval = mysqli_query($MySQL, $sql);
                  if (! $retval) {
                    die('Could not get data: ' . mysql_error());
                  }
                  $row = mysqli_fetch_array($retval, MYSQLI_NUM);
                  $rec_count = $row[0];

                  if (isset($_GET['page'])) {
                    $page = $_GET['page'] + 1;
                    $offset = $rec_limit * $page;
                  } else {
                    $page = 0;
                    $offset = 0;
                  }
                  $left_rec = $rec_count - ($page * $rec_limit);

                  $sql_info = "SELECT id, emri, mbiemri, emrikompanise, telefon, nrpashaporte, docname " .
                    "FROM klienti " .
                    $where .
                    " order by emri, mbiemri " .
                    "LIMIT $offset, $rec_limit";
                  $h_menu = mysqli_query($MySQL, $sql_info) or die(mysql_error());
                  $row_h_menu = $h_menu->fetch_assoc();
                  $totalRows_h_menu = $h_menu->num_rows;

                  while ($row_h_menu) { ?>
                    <tr>
                      <td></td>
                      <td><?php echo $row_h_menu['emri']; ?></td>
                      <td><?php echo $row_h_menu['mbiemri']; ?></td>
                      <td><?php echo $row_h_menu['emrikompanise']; ?></td>
                      <td><?php echo $row_h_menu['telefon']; ?></td>
                      <td><?php echo $row_h_menu['nrpashaporte']; ?></td>
                      <td><a href="doc/<?php if ($row_h_menu['docname'] == "") {
                                          echo "bosh.png";
                                        } else {
                                          echo $row_h_menu['docname'];
                                        } ?>" target="_blank"><img src="doc/<?php if ($row_h_menu['docname'] == "") {
                                                                                                                                                                              echo "bosh.png";
                                                                                                                                                                            } else {
                                                                                                                                                                              echo $row_h_menu['docname'];
                                                                                                                                                                            } ?>" border="0" width="25px"></a></td>
                      <td width="20"><a title="Modifiko Informacionin" href="insupd_client_data.php?action=upd&hid=<?php echo $row_h_menu['id']; ?>"><img src="images/edit.gif" border="0"></a></td>
                      <td width="20"><a title="Fshij Informacionin" href="JavaScript: do_delete(<?php echo $row_h_menu['id']; ?>); "><img src="images/del.gif" border="0"></a></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td height="1" colspan="8" bgcolor="#000033"></td>
                      <td></td>
                    </tr>
                  <?php $row_h_menu = $h_menu->fetch_assoc();
                  };
                  mysqli_free_result($h_menu);
                  ?>
                  <tr>
                    <td></td>
                    <td height="1" colspan="8" bgcolor="#000033"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td height="1" colspan="8">
                      <?php
                      if ($page > 0) {
                        $last = $page - 2;
                        echo "<a href=\"" . htmlspecialchars($_SERVER['PHP_SELF']) . "?page=$last\">Last 50 Records</a> |";
                        //   echo "<a href=\"$_PHP_SELF?page=$page\">Next 50 Records</a>";
                        echo "<a href=\"" . htmlspecialchars($_SERVER['PHP_SELF']) . "?page=$page\">Next 50 Records</a>";
                      } else if ($page == 0) {
                        // echo "<a href=\"$_PHP_SELF?page=$page\">Next 50 Records</a>";
                        echo "<a href=\"" . htmlspecialchars($_SERVER['PHP_SELF']) . "?page=$page\">Next 50 Records</a>";
                      } else if ($left_rec < $rec_limit) {
                        $last = $page - 2;
                        //echo "<a href=\"$_PHP_SELF?page=$last\">Last 50 Records</a>";
                        echo "<a href=\"" . htmlspecialchars($_SERVER['PHP_SELF']) . "?page=$last\">Last 50 Records</a>";
                      }
                      ?>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td height="1" colspan="8" bgcolor="#000033"></td>
                    <td></td>
                  </tr>
                </table>
              </form>
              <br />
              <table width="600px" border="0">
                <tr>
                  <td>&nbsp;<input name="insert_dt" type="button" value="Shto Klient..." onClick="JavaScript: window.location='insupd_client_data.php?action=ins';"></td>
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