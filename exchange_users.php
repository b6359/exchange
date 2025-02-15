<?php
//initialize the session
session_start();

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
?>
<?php require_once('ConMySQL.php'); ?>
<?php

if (isset($_SESSION['uid'])) {
  $user_id = $_SESSION['uid'] ?? addslashes($_SESSION['uid']);

  if ("1" != $_SESSION['Usertype']) {

    $logoutGoTo = "info.php";
    header("Location: $logoutGoTo");
    exit;
  }

?>


  <!-- --------------------------------------- -->
  <!--          Aplikacioni Xchange            -->
  <!--                                         -->
  <!--  Kontakt:                               -->
  <!--                                         -->
  <!--            GlobalTech.al                -->
  <!--                                         -->
  <!--         info@globaltech.al              -->
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
        <!--
    	<a href="exchange_users.php"   class="ButLart2" target="_top"><b>P&Euml;RDORUESIT</b></a>
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
        <a href="exchange_reports.php" class="ButLart2" target="_top">Raporte</a>
      </div>

      <div class="clear"></div>
    </div>

    <br />

    <div class="container_12">

      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY>
          <TR>
            <TD height="15" colSpan=3 align="left" valign="middle">
              <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a title="Print" href="JavaScript: window.print();"><img src="images/print.gif" border="0"></a>&nbsp; &nbsp;<a title="Shto perdorues te ri" href="JavaScript: window.location='insupd_user_data.php?action=ins';"><img src="images/add.gif" border="0" width="18px"> <b>Shto p&euml;rdorues t&euml; ri</b></a>
    </DIV>
    </TD>
    </TR>
    </TBODY>
    </TABLE>
    <br>

    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TBODY>
        <TR>
          <TD align="left" colSpan=0 height="15">
            <DIV class=ctxheading><br>

              <table border="0" cellpadding="0" width="100%" cellspacing="0">
                <tr>
                  <td height="5" colspan="6"></td>
                </tr>
                <tr>
                  <td>P&euml;rdoruesi</td>
                  <td>Emri i plot&euml;</td>
                  <td></td>
                  <td>Llogaria</td>
                  <td align="center">Tipi</td>
                  <td></td>
                </tr>
                <tr>
                  <td height="5"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <?php
                //mysql_select_db($database_MySQL, $MySQL);
                $data_sql_info = "select app_user.*, filiali.filiali, usertype.description from app_user, filiali, usertype where app_user.id_filiali = filiali.id and app_user.id_usertype = usertype.id";
                $h_data = mysqli_query($MySQL, $data_sql_info) or die(mysql_error());
                $row_h_data = $h_data->fetch_assoc();

                while ($row_h_data) { ?>
                  <tr>
                    <td height="1" colspan="6" bgcolor="#000033"></td>
                  </tr>
                  <tr>
                    <td><b><?php echo $row_h_data['username']; ?></b></td>
                    <td><b><?php echo $row_h_data['full_name']; ?></b></td>
                    <td></td>
                    <td><b><?php echo $row_h_data['filiali']; ?></b></td>
                    <td><b><?php echo $row_h_data['description']; ?></b></td>
                    <td align="center"><img src="images/edit.gif" border="0" style="cursor: hand" onClick="JavaScript: top.location='insupd_user_data.php?action=upd&hid=<?php echo $row_h_data['id']; ?>';"></td>
                  </tr>
                <?php $row_h_data = $h_data->fetch_assoc();
                };
                mysqli_free_result($h_data);
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