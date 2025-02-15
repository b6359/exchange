<?php require_once('ConMySQL.php'); ?>
<?php
//initialize the session
session_start();

if (isset($_SESSION['uid'])) {
  $user_info = $_SESSION['Username'] ?? addslashes($_SESSION['Username']);

  $date = strftime('%Y-%m-%d %H:%M:%S');

  $id              = "";
  $date_trans      = strftime('%Y-%m-%d');
  $perdoruesi      = "";
  $id_llogfilial   = "";
  $monedha_id      = "";
  $vleftakredituar = ".00";

  if (isset($_GET['action']) && ($_GET['action'] == "upd")) {
    if (isset($_GET['hid'])) {
      $colname_menu_info = $_GET['hid'] ?? addslashes($_GET['hid']);
      //mysql_select_db($database_MySQL, $MySQL);
      $query_menu_info = sprintf("SELECT * FROM openbalance WHERE id = %s", $colname_menu_info);
      $menu_info = mysqli_query($MySQL, $query_menu_info) or die(mysql_error());
      $row_menu_info = $menu_info->fetch_assoc();
      $totalRows_menu_info = mysql_num_rows($menu_info);

      $id              = $row_menu_info['id'];
      $date_trans      = $row_menu_info['date_trans'];
      $perdoruesi      = $row_menu_info['perdoruesi'];
      $id_llogfilial   = $row_menu_info['id_llogfilial'];
      $monedha_id      = $row_menu_info['monedha_id'];
      $vleftakredituar = $row_menu_info['vleftakredituar'];

      mysqli_free_result($menu_info);
    }
  }
  /////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////                                                           /////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
  {
    $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

    switch ($theType) {
      case "text":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "long":
      case "int":
        $theValue = ($theValue != "") ? intval($theValue) : "NULL";
        break;
      case "double":
        $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
        break;
      case "date":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "defined":
        $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
        break;
    }
    return $theValue;
  }
  /////////////////////////////////////////////////////////////////////////////////////////////////
  if ((isset($_POST["form_action"])) && ($_POST["form_action"] == "upd")) {
    $updateSQL = sprintf(
      "UPDATE openbalance SET date_trans=%s, perdoruesi=%s, id_llogfilial=%s, monedha_id=%s, vleftakredituar=%s, rate_value=%s, datarregjistrimit=%s WHERE id=%s",
      GetSQLValueString($_POST['date_trans'], "date"),
      GetSQLValueString($user_info, "text"),
      GetSQLValueString($_POST['id_llogfilial'], "int"),
      GetSQLValueString($_POST['monedha_id'], "int"),
      GetSQLValueString($_POST['vleftakredituar'], "double"),
      GetSQLValueString($_POST['rate_value'], "double"),
      GetSQLValueString($date, "date"),
      GetSQLValueString($_POST['id'], "int")
    );

    //mysql_select_db($database_MySQL, $MySQL);
    $Result1 = mysqli_query($MySQL, $updateSQL) or die(mysql_error());

    $updateGoTo = "exchange_openbal.php";

    if (isset($_SERVER['QUERY_STRING'])) {
      $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
      $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $updateGoTo));
  }


  if ((isset($_POST["form_action"])) && ($_POST["form_action"] == "ins")) {

    $sql_id_info = "select kodllogari from filiali where id = " . $_POST['id_llogfilial'];
    $id_info = mysqli_query($MySQL, $sql_id_info) or die(mysql_error());
    $row_id_info = mysql_fetch_assoc($id_info);
    $id_llogarie01 = $row_id_info['kodllogari'];

    $insertSQL = sprintf(
      "INSERT INTO openbalance (date_trans, perdoruesi, id_llogfilial, monedha_id, vleftakredituar, rate_value, datarregjistrimit)
                                         VALUES (%s, %s, %s, %s, %s, %s, %s)",
      GetSQLValueString($_POST['date_trans'], "date"),
      GetSQLValueString($user_info, "text"),
      GetSQLValueString($_POST['id_llogfilial'], "int"),
      GetSQLValueString($_POST['monedha_id'], "int"),
      GetSQLValueString($_POST['vleftakredituar'], "double"),
      GetSQLValueString($_POST['rate_value'], "double"),
      GetSQLValueString($date, "date")
    );

    //mysql_select_db($database_MySQL);
    $Result1 = mysqli_query($MySQL, $insertSQL) or die(mysql_error());
    $id_calc = mysqli_insert_id($MySQL);

    // shtimi i rreshtave per transaksionet
    if ($_POST['vleftakredituar'] > 0) {

      $insertSQL = sprintf(
        "INSERT INTO tblalltransactions ( id_veprimi, date_trans, tipiveprimit, pershkrimi, id_filiali, id_llogari, id_monedhe, vleradebituar, vlerakredituar, kursi, perdoruesi, datarregjistrimit )
                                                    VALUES ( %s, %s, 'OPN', 'Hapja e balancave', %s, %s, %s, 0, %s, %s, %s, %s )",
        GetSQLValueString($id_calc, "text"),
        GetSQLValueString($_POST['date_trans'], "date"),
        GetSQLValueString($_POST['id_llogfilial'], "int"),
        GetSQLValueString($id_llogarie01, "text"),
        GetSQLValueString($_POST['monedha_id'], "int"),
        GetSQLValueString($_POST['vleftakredituar'], "double"),
        GetSQLValueString($_POST['rate_value'], "double"),
        GetSQLValueString($user_info, "text"),
        GetSQLValueString($date, "date")
      );
      $Result1 = mysqli_query($MySQL, $insertSQL) or die(mysql_error());
    }

    $updateGoTo = "exchange_openbal.php";

    if (isset($_SERVER['QUERY_STRING'])) {
      $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
      $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $updateGoTo));
  }

  //----------------------------------------------------------------------------------
  $sql_info = "select * from kursi_koka where id = (select max(id) from kursi_koka)";
  $id_kursi = mysqli_query($MySQL, $sql_info) or die(mysql_error());
  $row_id_kursi = $id_kursi->fetch_assoc();

  $query_monkurs_info = " select kursi_detaje.*, monedha.monedha, monedha.id monid
                          from kursi_detaje, monedha
                         where master_id = " . $row_id_kursi['id'] . "
                           and kursi_detaje.monedha_id = monedha.id ";
  $monkurs_info = mysqli_query($MySQL, $query_monkurs_info) or die(mysql_error());
  $row_monkurs_info = $monkurs_info->fetch_assoc();;
  //----------------------------------------------------------------------------------

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

    <script language="JavaScript" src="CalendarPopup.js"></script>

    <script language="JavaScript">
      <!-- Begin
      rate_value = 0;

      news = new Array();

      news[1] = new Array();
      news[1][1] = "LEK";
      news[1][2] = "1";
      news[1][3] = "1";

      news[999] = new Array();
      news[999][1] = "";
      news[999][2] = "";
      news[999][3] = "";

      <?php

      while ($row_monkurs_info) { ?>

        news[<?php echo $row_monkurs_info['monid']; ?>] = new Array();
        news[<?php echo $row_monkurs_info['monid']; ?>][1] = "<?php echo $row_monkurs_info['monedha']; ?>";
        news[<?php echo $row_monkurs_info['monid']; ?>][2] = "<?php echo ($row_monkurs_info['kursiblerje'] + $row_monkurs_info['kursishitje']) / 2; ?>";
      <?php
        $row_monkurs_info = $monkurs_info->fetch_assoc();
      };

      mysqli_free_result($monkurs_info);

      ?>

      function disp_kursitxt(mon_id) {

        document.formmenu.rate_value.value = news[mon_id][2];
      };

      //  End 
      -->
    </script>

    <script language="JavaScript">
      document.write(getCalendarStyles());
    </script>

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
        <a href="exchange_openbal.php" class="ButLart2" target="_top"><b>Hapje balance</b></a>
        <a href="exchange_llogari.php" class="ButLart2" target="_top">Llogarit&euml;</a>
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
              <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hapja e balancave
    </DIV>
    </TD>
    </TR>
    </TBODY>
    </TABLE>
    <br />

    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TBODY>
        <TR>
          <TD align="left" colSpan=3 height="15">
            <DIV class=ctxheading>

              <form enctype="multipart/form-data" ACTION="insupd_openbal_data.php" METHOD="POST" name="formmenu">
                <input name="form_action" type="hidden" value="<?php echo $_GET[action]; ?>">
                <input name="id" type="hidden" value="<?php echo $id; ?>">
                <input name="rate_value" type="hidden" value="1">
                <table width="600px" border="0" cellpadding="0" cellspacing="5">

                  <SCRIPT language=JavaScript id=jscal1xx>
                    var cal1xx = new CalendarPopup("datetrans");
                    cal1xx.showNavigationDropdowns();
                  </SCRIPT>

                  <tr>
                    <td width="200"></td>
                    <td width="400"></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle">Dat&euml; veprimi:</td>
                    <td align="left"><input name="date_trans" type="text" value="<?php echo $date_trans; ?>" id="date_trans" size="10" readonly></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle">Filiali:</td>
                    <td align="left"><select name="id_llogfilial" id="id_llogfilial">
                        <?php
                        $v_wheresql = "";
                        if ($_SESSION['Usertype'] == 3)  $v_wheresql = " where id = " . $_SESSION['Userfilial'] . " ";

                        //mysql_select_db($database_MySQL, $MySQL);
                        $query_filiali_info = "select * from filiali " . $v_wheresql . " order by filiali asc";
                        $filiali_info = mysql_query($query_filiali_info, $MySQL) or die(mysql_error());
                        $row_filiali_info = $filiali_info->fetch_assoc();
                        while ($row_filiali_info) {
                        ?>
                          <option value="<?php echo $row_filiali_info['id']; ?>" <?php if (($row_filiali_info['id'] == $_SESSION['Userfilial']) || ($row_filiali_info['id'] == $id_llogfilial)) {
                                                                                    echo "selected";
                                                                                  } ?>><?php echo $row_filiali_info['filiali']; ?></option>
                        <?php
                          $row_filiali_info = $filiali_info->fetch_assoc();
                        }
                        mysqli_free_result($filiali_info);
                        ?>
                      </select></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle">Monedha:</td>
                    <td align="left"><select name="monedha_id" id="monedha_id" OnChange="JavaScript: disp_kursitxt( document.formmenu.monedha_id.value);">
                        <?php
                        //mysql_select_db($database_MySQL, $MySQL);
                        $query_monedha_info = "select * from monedha order by id asc";
                        $monedha_info = mysql_query($query_monedha_info, $MySQL) or die(mysql_error());
                        $row_monedha_info = $monedha_info->fetch_assoc();
                        while ($row_monedha_info) {
                        ?>
                          <option value="<?php echo $row_monedha_info['id']; ?>" <?php if ($row_monedha_info['id'] == $monedha_id) {
                                                                                    echo "selected";
                                                                                  } ?>><?php echo $row_monedha_info['monedha']; ?></option>
                        <?php
                          $row_monedha_info = $monedha_info->fetch_assoc();
                        }
                        mysqli_free_result($monedha_info);
                        ?>
                      </select></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle">Vlera e hyr&euml;:</td>
                    <td align="left"><input name="vleftakredituar" type="text" class="inputtext2" id="vleftakredituar" value="<?php echo $vleftakredituar; ?>" size="25"></td>
                  </tr>
                  <tr>
                    <td width="200">&nbsp;</td>
                    <td width="400"></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center"><input name="insupd" class="inputtext4" type="submit" value="Ruaj Informacionin"></td>
                  </tr>
                  <tr>
                    <td width="200"></td>
                    <td width="400"></td>
                  </tr>
                </table>

                <DIV id="datetrans" style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></DIV>

              </form>
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