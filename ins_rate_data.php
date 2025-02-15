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
  session_unregister('Usertrans');
  session_unregister('Userfilial');
  session_unregister('Username');
  session_unregister('full_name');
  session_unregister('uid');

  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}

?>
<?php require_once('ConMySQL.php'); ?>
<?php

//------------------------------------------------------------------------------------------------
//                                                                                       //
//------------------------------------------------------------------------------------------------
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  $theValue = addslashes($theValue) ?? $theValue;

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
//------------------------------------------------------------------------------------------------

if (isset($_SESSION['uid'])) {

  $v_wheresql = "";
  $v_llog = 0;

  if ($_SESSION['Usertype'] == 2)  $v_llog = $_SESSION['Userfilial'];
  if ($_SESSION['Usertype'] == 3)  $v_llog = $_SESSION['Userfilial'];
  if ($_SESSION['Usertype'] == 2)  $v_wheresql = " where id = " . $_SESSION['Userfilial'] . " ";
  if ($_SESSION['Usertype'] == 3)  $v_wheresql = " where id = " . $_SESSION['Userfilial'] . " ";
  if ($_SESSION['Usertype'] == 2)  $v_wheresqls = " and id_llogfilial = " . $_SESSION['Userfilial'] . " ";
  if ($_SESSION['Usertype'] == 3)  $v_wheresqls = " and id_llogfilial = " . $_SESSION['Userfilial'] . " ";

  if ((isset($_POST['id_llogfilial'])) && ($_POST['id_llogfilial'] != "")) {
    $v_wheresqls = " and id_llogfilial = " . $_POST['id_llogfilial'] . " ";
    $v_llog      = $_POST['id_llogfilial'];
  }

  $query_filiali_info = "select * from filiali " . $v_wheresql   . " order by filiali asc";
  $filiali_info = $MySQL->query($query_filiali_info) or die(mysql_error());
  $row_filiali_info =  $filiali_info->fetch_assoc();

  //----------------------------------------------------------------------------------------------------------------------------------------------
  if ((isset($_POST["form_action"])) && ($_POST["form_action"] == "ins")) {

    $v_insert = 1;
    //----------------------------------------------------------------------------------------------------------------------------------------------
    $mon_sql_info = "select monedha.id, monedha.monedha from monedha where mon_vendi = 'J'";
    $mon_data = $MySQL->query($mon_sql_info) or die(mysql_error());
    $row_mon_data = $mon_data->fetch_assoc();

    while ($row_mon_data) {
      /*
                if (($_POST[$row_mon_data['monedha'].'kursiblerje'] == "0") ||
                    ($_POST[$row_mon_data['monedha'].'kursiblerje'] == "0.0") ||
                    ($_POST[$row_mon_data['monedha'].'kursiblerje'] == "")       ) $v_insert = 0;

                if (($_POST[$row_mon_data['monedha'].'kursishitje'] == "0") ||
                    ($_POST[$row_mon_data['monedha'].'kursishitje'] == "0.0") ||
                    ($_POST[$row_mon_data['monedha'].'kursishitje'] == "")       ) $v_insert = 0;
*/
      $row_mon_data = $mon_data->fetch_assoc();
    };
    mysqli_free_result($mon_data);
    //----------------------------------------------------------------------------------------------------------------------------------------------

    if ($v_insert == 1) {

      //----------------------------------------------------------------------------------------------------------------------------------------------
      $sql_info = sprintf("select max(fraksion) frak_nr from kursi_koka where date = %s", GetSQLValueString($_POST['date'], "date"));
      $id_fraksion = $MySQL->query($sql_info) or die(mysql_error());
      $row_id_fraksion = $id_fraksion->fetch_assoc();
      $frak_no = $row_id_fraksion['frak_nr'] + 1;
      mysqli_free_result($id_fraksion);
      //----------------------------------------------------------------------------------------------------------------------------------------------
      $user_info =  $_SESSION['Username'] ?? addslashes($_SESSION['Username']);
      //----------------------------------------------------------------------------------------------------------------------------------------------
      $insertSQL = sprintf(
        "INSERT INTO kursi_koka (date, id_llogfilial, fraksion, perdoruesi) VALUES (%s, %s, %s, %s)",
        GetSQLValueString($_POST['date'], "date"),
        GetSQLValueString($_POST['id_llogfilial'], "int"),
        GetSQLValueString($frak_no, "int"),
        GetSQLValueString($user_info, "text")
      );

      //            $Result1 = mysql_query($insertSQL, $MySQL) or die(mysql_error());
      if (mysqli_query($MySQL, $insertSQL)) {
        $last_id = mysqli_insert_id($MySQL);
        $Result1 = mysqli_query($MySQL, "SELECT * FROM kursi_koka WHERE id = $last_id");
      }
      //----------------------------------------------------------------------------------------------------------------------------------------------
      $sql_info = "select max(id) id_trans from kursi_koka";
      $id_trans = $MySQL->query($sql_info) or die(mysql_error());
      $row_id_trans = $id_trans->fetch_assoc();
      $trans_no = $row_id_trans['id_trans'];
      mysqli_free_result($id_trans);
      //----------------------------------------------------------------------------------------------------------------------------------------------
      $mon_sql_info = "select monedha.id, monedha.monedha from monedha where mon_vendi = 'J'";
      $mon_data = $MySQL->query($mon_sql_info) or die(mysql_error());
      $row_mon_data = $mon_data->fetch_assoc();

      while ($row_mon_data) {

        //----------------------------------------------------------------------------------------------------------------------------------------------
        $kursiblerje = isset($_POST[$row_mon_data['monedha'] . 'kursiblerje']) ? (float) $_POST[$row_mon_data['monedha'] . 'kursiblerje'] : 0;
        $kursishitje = isset($_POST[$row_mon_data['monedha'] . 'kursishitje']) ? (float) $_POST[$row_mon_data['monedha'] . 'kursishitje'] : 0;

        $kursimesatar = ($kursiblerje + $kursishitje) / 2;

        $insertSQL = sprintf(
          "INSERT INTO kursi_detaje (master_id, monedha_id, kursiblerje, kursimesatar, kursishitje) VALUES (%s, %s, %s, %s, %s)",
          GetSQLValueString($trans_no, "int"),
          GetSQLValueString($row_mon_data['id'], "int"),
          GetSQLValueString($kursiblerje, "double"),
          GetSQLValueString($kursimesatar, "double"),
          GetSQLValueString($kursishitje, "double")
        );

        if (mysqli_query($MySQL, $insertSQL)) {
          $last_id = mysqli_insert_id($MySQL);
          $Result1 = mysqli_query($MySQL, "SELECT * FROM kursi_detaje WHERE id = $last_id");
        }
        //----------------------------------------------------------------------------------------------------------------------------------------------

        $row_mon_data = $mon_data->fetch_assoc();
      };
      mysqli_free_result($mon_data);
      //----------------------------------------------------------------------------------------------------------------------------------------------
      $mon_sql_info = "select monedha.id, monedha.monedha from monedha where mon_vendi = 'J' and monedha like 'EUR%'";
      $mon_data = $MySQL->query($mon_sql_info) or die(mysql_error());
      $row_mon_data = $mon_data->fetch_assoc();

      while ($row_mon_data) {

        //----------------------------------------------------------------------------------------------------------------------------------------------
        $kursiblerje = isset($_POST['e' . $row_mon_data['monedha'] . 'kursiblerje']) ? (float) $_POST['e' . $row_mon_data['monedha'] . 'kursiblerje'] : 0;
        $kursimesatar = isset($_POST['e' . $row_mon_data['monedha'] . 'kursimesatar']) ? (float) $_POST['e' . $row_mon_data['monedha'] . 'kursimesatar'] : 0;
        $kursishitje = isset($_POST['e' . $row_mon_data['monedha'] . 'kursishitje']) ? (float) $_POST['e' . $row_mon_data['monedha'] . 'kursishitje'] : 0;

        $insertSQL = sprintf(
          "INSERT INTO kursi_eurusd (master_id, monedha_id, kursiblerje, kursimesatar, kursishitje) VALUES (%s, %s, %s, %s, %s)",
          GetSQLValueString($trans_no, "int"),
          GetSQLValueString($row_mon_data['id'], "int"),
          GetSQLValueString($kursiblerje, "double"),
          GetSQLValueString($kursimesatar, "double"),
          GetSQLValueString($kursishitje, "double")
        );

        // $Result1 = mysql_query($insertSQL, $MySQL) or die(mysql_error());
        //----------------------------------------------------------------------------------------------------------------------------------------------

        $row_mon_data =  $mon_data->fetch_assoc();
      };
      mysqli_free_result($mon_data);
      //----------------------------------------------------------------------------------------------------------------------------------------------
    }
    //----------------------------------------------------------------------------------------------------------------------------------------------
    $updateGoTo = "exchange_rate.php";
    //if (isset($_SERVER['QUERY_STRING'])) {
    //$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    //$updateGoTo .= $_SERVER['QUERY_STRING'];
    //}
    header(sprintf("Location: %s", $updateGoTo));
    //----------------------------------------------------------------------------------------------------------------------------------------------
  }
  //----------------------------------------------------------------------------------------------------------------------------------------------


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

    <script language="JavaScript" src="CalendarPopup.js"></script>

    <script language="JavaScript">
      document.write(getCalendarStyles());
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
        <a href="exchange_rate.php" class="ButLart2" target="_top"><b>Kursi i K&euml;mbimit</b></a>
        <a href="exchange_opclbal.php" class="ButLart2" target="_top">Hapje/Mbyllje Dite</a>
        <a href="exchange_balance.php" class="ButLart2" target="_top">Bilanci sipas veprimeve</a>
        <a href="exchange_basedata.php" class="ButLart2" target="_top">T&euml; Dh&euml;nat Baz&euml;</a>
        <a href="exchange_reports.php" class="ButLart2" target="_top">Raporte</a>
      </div>

      <div class="clear"></div>
    </div>

    <br />

    <div class="container_12">

      <br />

      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY>
          <TR>
            <TD height="15" colSpan=3 align="left" valign="middle">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kursi i k&euml;mbimit</TD>
          </TR>
        </TBODY>
      </TABLE>
      <br />

      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY>
          <TR>
            <TD align="left" colSpan=0 height="15">
              <DIV class=ctxheading><br>

                <form enctype="multipart/form-data" ACTION="ins_rate_data.php" METHOD="POST" name="formmenu">
                  <input name="form_action" type="hidden" value="src">

                  <table border="0" cellpadding="0" width="100%" cellspacing="0">
                    <tr>
                      <td height="5" colspan="6"></td>
                    </tr>
                    <tr valign="middle">
                      <td colspan="6">
                        <lable>Dat&euml;:&nbsp;<input name="date" type="text" value="<?php echo strftime('%Y-%m-%d'); ?>" id="date" size="10" readonly>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          Filiali:&nbsp;<select name="id_llogfilial" id="id_llogfilial">
                            <?php
                            while ($row_filiali_info) {
                            ?>
                              <option value="<?php echo $row_filiali_info['id']; ?>" <?php if ($row_filiali_info['id'] == $v_llog) {
                                                                                        echo "selected";
                                                                                      } ?>><?php echo $row_filiali_info['filiali']; ?></option>
                            <?php
                              $row_filiali_info =  $filiali_info->fetch_assoc();
                            }
                            mysqli_free_result($filiali_info);
                            ?>
                          </select>&nbsp;&nbsp;<a class="link4" href="JavaScript: Open_Filial_Window();"><img src="images/doc.gif" border="0"></a>
                          &nbsp;&nbsp;&nbsp;
                          <input name="repdata" class="inputtext4" type="submit" value="Shfaq kursin...">
                        </lable>
                      </td>
                    </tr>
                    <tr>
                      <td height="10" colspan="6"></td>
                    </tr>
                    <tr>
                      <td>&nbsp; Monedha</td>
                      <td></td>
                      <td align="center">Blej<br>Kundrejt LEK</td>
                      <!--    <td align="center">Mesatar<br>Kundrejt LEK</td>  -->
                      <td align="center"></td>
                      <td align="center">Shes<br>Kundrejt LEK</td>
                    </tr>
                    <tr>
                      <td height="5" colspan="4"></td>
                    </tr>
                    <?php
                    $temp_v_wheresqls = isset($v_wheresqls) ? $v_wheresqls : "";
                    $sql_info   = "select * from kursi_koka where id = (select max(id) from kursi_koka where 1=1 " . $temp_v_wheresqls . ") " . $temp_v_wheresqls;
                    $h_menu     = $MySQL->query($sql_info) or die(mysql_error());
                    $row_h_menu =  $h_menu->fetch_assoc();

                    $data_sql_info = "select monedha.monedha from monedha where mon_vendi = 'J' order by taborder";
                    $h_data        = $MySQL->query($data_sql_info) or die(mysql_error());
                    $row_h_data    =  $h_data->fetch_assoc();

                    while ($row_h_data) {

                      $data2_sql_info = "select kursi_detaje.*, monedha.monedha from kursi_detaje, monedha where master_id = " . $row_h_menu['id'] . " and kursi_detaje.monedha_id = monedha.id and monedha.monedha = '" . $row_h_data['monedha'] . "' ";
                      $h_data2        =  $MySQL->query($data2_sql_info) or die(mysql_error());
                      $row_h_data2    =  $h_data2->fetch_assoc();

                    ?>
                      <tr>
                        <td height="1" colspan="6" bgcolor="#000033"></td>
                      </tr>
                      <tr>
                        <td align="center"><b><?php echo $row_h_data['monedha']; ?></b></td>
                        <td></td>
                        <td align="center"><input name="<?php echo $row_h_data['monedha']; ?>kursiblerje" type="text" class="inputtext2" id="<?php echo $row_h_data['monedha']; ?>kursiblerje" value="<?php echo isset($row_h_data2['kursiblerje']) ? number_format($row_h_data2['kursiblerje'], 2, '.', ',') : ''; ?>" size="15">&nbsp; &nbsp;</td>
                        <td align="right"></td>
                        <!--    <td align="right"><input name="<?php echo $row_h_data['monedha']; ?>kursimesatar" type="text" class="inputtext2" id="<?php echo $row_h_data['monedha']; ?>kursimesatar" value="0.0000" size="15">&nbsp; &nbsp;</td>  -->
                        <td align="center"><input name="<?php echo $row_h_data['monedha']; ?>kursishitje" type="text" class="inputtext2" id="<?php echo $row_h_data['monedha']; ?>kursishitje" value="<?php echo isset($row_h_data2['kursishitje']) ? number_format($row_h_data2['kursishitje'], 2, '.', ',') : ''; ?>" size="15">&nbsp; &nbsp;</td>
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

                  <DIV id="datetrans" style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></DIV>

                  <TABLE cellSpacing=0 cellPadding=0 width="600px" border=0>
                    <TBODY>
                      <TR>
                        <TD height="15" colSpan=3 align="center" valign="middle">
                          <DIV class=ctxheading><input name="insupd" class="inputtext4" type="button" onClick="JavaScript: document.formmenu.form_action.value = 'ins'; document.formmenu.submit();" value=" Ruaj kursin e k&euml;mbimit "></DIV>
                        </TD>
                      </TR>
                    </TBODY>
                  </TABLE>

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