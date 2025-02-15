<?php

session_start();
date_default_timezone_set('Europe/Tirane');

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

$clid = $_GET['clid'];

if (isset($_SESSION['uid'])) {
  $user_info = (get_magic_quotes_gpc()) ? $_SESSION['Username'] : addslashes($_SESSION['Username']);

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

  if ((isset($_POST["form_action"])) && ($_POST["form_action"] == "ins")) {

    $date = strftime('%Y-%m-%d');
    $v_dt = $_POST['date_trans'];

    $prerje = array(
      "100",
      "150",
      "200",
      "100",
      "250",
      "400",
      "350",
      "500",
      "150",
      "250",
      "150",
      "100",
      "50",
      "210",
      "450",
      "170",
      "320",
      "470",
      "120",
      "220",
      "370"
    );
    $id_mondebituar = $_POST['id_mondebituar'];
    if ($id_mondebituar == 1) {

      $vleftakredituartot = $_POST['vleftakredituar'];
      while ($vleftakredituartot > 0) {

        $sql_id_info = "select (max(calculate_id)) nr from exchange_koke where perdoruesi = '" . $user_info . "'";
        $id_info = mysql_query($sql_id_info, $MySQL) or die(mysql_error());
        $row_id_info = mysql_fetch_assoc($id_info);
        $id_info_value = $row_id_info['nr'] + 1;
        $id_calc = $user_info . 'CHN' . $id_info_value;

        $sql_id_info = "select kodi from llogarite where chnvl = 'T'";
        $id_info = mysql_query($sql_id_info, $MySQL) or die(mysql_error());
        $row_id_info = mysql_fetch_assoc($id_info);
        $id_llogarie = $row_id_info['kodi'];

        $sql_id_info = "select kodi from llogarite where chnco = 'T'";
        $id_info = mysql_query($sql_id_info, $MySQL) or die(mysql_error());
        $row_id_info = mysql_fetch_assoc($id_info);
        $id_komisioni = $row_id_info['kodi'];

        $vleftakredituar = $prerje[rand(1, 20)];
        if ($vleftakredituar > $vleftakredituartot) {
          $vleftakredituar = $vleftakredituartot;
        }
        $vleftadebituar  = $vleftakredituar / $_POST['kursi'];

        if ($vleftakredituar > 0) {

          $insertSQL = sprintf(
            "INSERT INTO exchange_koke ( id, calculate_id, id_trans, date_trans, id_llogfilial, id_monkreditim, id_klienti, perqindjekomisioni, vleftakomisionit, vleftapaguar, burimteardhura, perdoruesi, datarregjistrimit) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($id_calc, "text"),
            GetSQLValueString($id_info_value, "int"),
            GetSQLValueString($_POST['id_trans'], "int"),
            GetSQLValueString(substr($v_dt, 6, 4) . "-" . substr($v_dt, 3, 2) . "-" . substr($v_dt, 0, 2), "date"),
            GetSQLValueString($_POST['id_llogfilial'], "int"),
            GetSQLValueString($_POST['id_monkreditim'], "int"),
            GetSQLValueString($_POST['id_klienti'], "int"),
            GetSQLValueString("0", "double"),
            GetSQLValueString("0", "double"),
            GetSQLValueString($vleftakredituar, "double"),
            GetSQLValueString($_POST['burimteardhura'], "text"),
            GetSQLValueString($user_info, "text"),
            GetSQLValueString(substr($v_dt, 6, 4) . "-" . substr($v_dt, 3, 2) . "-" . substr($v_dt, 0, 2), "date")
          );
          $Result1 = mysql_query($insertSQL, $MySQL) or die(mysql_error());

          $insertSQL = sprintf(
            "INSERT INTO exchange_detaje ( id_exchangekoke, id_mondebituar, vleftadebituar, vleftakredituar, kursi, kursi_txt, kursi1, kursi1_txt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($id_calc, "text"),
            GetSQLValueString($_POST['id_mondebituar'], "int"),
            GetSQLValueString($vleftadebituar, "double"),
            GetSQLValueString($vleftakredituar, "double"),
            GetSQLValueString($_POST['kursi'], "double"),
            GetSQLValueString($_POST['kursi_txt'], "text"),
            GetSQLValueString($_POST['kursi1'], "double"),
            GetSQLValueString($_POST['kursi1_txt'], "text")
          );
          $Result1 = mysql_query($insertSQL, $MySQL) or die(mysql_error());
        }

        $vleftakredituartot = $vleftakredituartot - $vleftakredituar;
      }
    } else {

      $vleftadebituartot = $_POST['vleftadebituar'];
      while ($vleftadebituartot > 0) {

        $sql_id_info = "select (max(calculate_id)) nr from exchange_koke where perdoruesi = '" . $user_info . "'";
        $id_info = mysql_query($sql_id_info, $MySQL) or die(mysql_error());
        $row_id_info = mysql_fetch_assoc($id_info);
        $id_info_value = $row_id_info['nr'] + 1;
        $id_calc = $user_info . 'CHN' . $id_info_value;

        $sql_id_info = "select kodi from llogarite where chnvl = 'T'";
        $id_info = mysql_query($sql_id_info, $MySQL) or die(mysql_error());
        $row_id_info = mysql_fetch_assoc($id_info);
        $id_llogarie = $row_id_info['kodi'];

        $sql_id_info = "select kodi from llogarite where chnco = 'T'";
        $id_info = mysql_query($sql_id_info, $MySQL) or die(mysql_error());
        $row_id_info = mysql_fetch_assoc($id_info);
        $id_komisioni = $row_id_info['kodi'];

        $vleftadebituar  = $prerje[rand(1, 20)];
        if ($vleftadebituar > $vleftadebituartot) {
          $vleftadebituar = $vleftadebituartot;
        }
        $vleftakredituar = $vleftadebituar * $_POST['kursi'];

        if ($vleftadebituar > 0) {

          $insertSQL = sprintf(
            "INSERT INTO exchange_koke ( id, calculate_id, id_trans, date_trans, id_llogfilial, id_monkreditim, id_klienti, perqindjekomisioni, vleftakomisionit, vleftapaguar, burimteardhura, perdoruesi, datarregjistrimit) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($id_calc, "text"),
            GetSQLValueString($id_info_value, "int"),
            GetSQLValueString($_POST['id_trans'], "int"),
            GetSQLValueString(substr($v_dt, 6, 4) . "-" . substr($v_dt, 3, 2) . "-" . substr($v_dt, 0, 2), "date"),
            GetSQLValueString($_POST['id_llogfilial'], "int"),
            GetSQLValueString($_POST['id_monkreditim'], "int"),
            GetSQLValueString($_POST['id_klienti'], "int"),
            GetSQLValueString("0", "double"),
            GetSQLValueString("0", "double"),
            GetSQLValueString($vleftakredituar, "double"),
            GetSQLValueString($_POST['burimteardhura'], "text"),
            GetSQLValueString($user_info, "text"),
            GetSQLValueString(substr($v_dt, 6, 4) . "-" . substr($v_dt, 3, 2) . "-" . substr($v_dt, 0, 2), "date")
          );
          $Result1 = mysql_query($insertSQL, $MySQL) or die(mysql_error());

          $insertSQL = sprintf(
            "INSERT INTO exchange_detaje ( id_exchangekoke, id_mondebituar, vleftadebituar, vleftakredituar, kursi, kursi_txt, kursi1, kursi1_txt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($id_calc, "text"),
            GetSQLValueString($_POST['id_mondebituar'], "int"),
            GetSQLValueString($vleftadebituar, "double"),
            GetSQLValueString($vleftakredituar, "double"),
            GetSQLValueString($_POST['kursi'], "double"),
            GetSQLValueString($_POST['kursi_txt'], "text"),
            GetSQLValueString($_POST['kursi1'], "double"),
            GetSQLValueString($_POST['kursi1_txt'], "text")
          );
          $Result1 = mysql_query($insertSQL, $MySQL) or die(mysql_error());
        }

        $vleftadebituartot = $vleftadebituartot - $vleftadebituar;
      }
    }

    $updateGoTo = "exchange_trans.php";
    header(sprintf("Location: %s", $updateGoTo));
  }

  $sql_id_info = "select opstatus from opencloseday ";
  $id_info     = mysql_query($sql_id_info, $MySQL) or die(mysql_error());
  $row_id_info = mysql_fetch_assoc($id_info);
  $opstatus    = $row_id_info['opstatus'];

  if ($opstatus == "C") {

    $updateGoTo = "info.php";
    header(sprintf("Location: %s", $updateGoTo));
  }

  //----------------------------------------------------------------------------------

  $v_wheresql = "";
  $v_llog = 1;
  if ($_SESSION['Usertype'] == 2)  $v_llog = $_SESSION['Userfilial'];
  if ($_SESSION['Usertype'] == 3)  $v_llog = $_SESSION['Userfilial'];
  if ($_SESSION['Usertype'] == 2)  $v_wheresql = " where id = " . $_SESSION['Userfilial'] . " ";
  if ($_SESSION['Usertype'] == 3)  $v_wheresql = " where id = " . $_SESSION['Userfilial'] . " ";
  if ($_SESSION['Usertype'] == 2)  $v_wheresqls = " and id_llogfilial = " . $_SESSION['Userfilial'] . " ";
  if ($_SESSION['Usertype'] == 3)  $v_wheresqls = " and id_llogfilial = " . $_SESSION['Userfilial'] . " ";

  $query_filiali_info = "select * from filiali " . $v_wheresql   . " order by filiali asc";
  $filiali_info = mysql_query($query_filiali_info, $MySQL) or die(mysql_error());
  $row_filiali_info = mysql_fetch_assoc($filiali_info);

  $query_klienti_info = "select * from klienti order by emri, mbiemri";
  $klienti_info = mysql_query($query_klienti_info, $MySQL) or die(mysql_error());
  $row_klienti_info = mysql_fetch_assoc($klienti_info);

  $query_monedha_info = "select * from monedha order by mon_vendi desc, id ";
  $monedha_info = mysql_query($query_monedha_info, $MySQL) or die(mysql_error());
  $row_monedha_info = mysql_fetch_assoc($monedha_info);

  //----------------------------------------------------------------------------------
  $sql_info = "select * from kursi_koka where id = (select max(id) from kursi_koka where 1=1 " . $v_wheresqls . ") " . $v_wheresqls;
  $id_kursi = mysql_query($sql_info, $MySQL) or die(mysql_error());
  $row_id_kursi = mysql_fetch_assoc($id_kursi);

  $query_monkurs_info = " select kursi_detaje.*, monedha.monedha, monedha.id monid
                          from kursi_detaje, monedha
                         where master_id = " . $row_id_kursi['id'] . "
                           and kursi_detaje.monedha_id = monedha.id ";
  $monkurs_info = mysql_query($query_monkurs_info, $MySQL) or die(mysql_error());
  $row_monkurs_info = mysql_fetch_assoc($monkurs_info);
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

    <script language="JavaScript">
      <!-- Begin
      function focusOnMyInputBox() {
        document.getElementById("vleftadebituar").focus();
      }

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
        news[<?php echo $row_monkurs_info['monid']; ?>][2] = "<?php echo $row_monkurs_info['kursiblerje']; ?>";
        news[<?php echo $row_monkurs_info['monid']; ?>][3] = "<?php echo $row_monkurs_info['kursishitje']; ?>";
      <?php
        $row_monkurs_info = mysql_fetch_assoc($monkurs_info);
      };

      mysqli_free_result($monkurs_info);

      ?>

      function disp_kursitxt(inic_id, mon_id, ndares) {

        document.formmenu.kursi_txt.value = news[inic_id][1] + ndares + news[mon_id][1];
        document.formmenu.kursi1_txt.value = news[mon_id][1] + ndares + news[inic_id][1];

      };

      function calculate_rate_value() {

        if ((document.formmenu.id_mondebituar.value != '999') && (document.formmenu.id_monkreditim.value != '999')) {

          rate_value = news[document.formmenu.id_mondebituar.value][2] / news[document.formmenu.id_monkreditim.value][3];

          document.formmenu.hkursi.value = news[document.formmenu.id_mondebituar.value][2] / news[document.formmenu.id_monkreditim.value][3];

          var mrv = new String(rate_value);

          if (mrv.indexOf('.') == -1) {
            document.formmenu.kursi.value = mrv.substr(0, mrv.length);
          } else {
            document.formmenu.kursi.value = mrv.substr(0, mrv.indexOf('.') + 7);
          };

          rate_value = news[document.formmenu.id_monkreditim.value][3] / news[document.formmenu.id_mondebituar.value][2];

          var mrv = new String(rate_value);

          if (mrv.indexOf('.') == -1) {
            document.formmenu.kursi1.value = mrv.substr(0, mrv.length);
          } else {
            document.formmenu.kursi1.value = mrv.substr(0, mrv.indexOf('.') + 7);
          };

          var v_nr1 = new Number(document.formmenu.vleftadebituar.value);
          var v_nr2 = new Number(document.formmenu.hkursi.value);

          var tv = new String(v_nr1.valueOf() * v_nr2.valueOf());

          if (tv.indexOf('.') == -1) {
            document.formmenu.vleftakredituar.value = parseInt(Math.round(tv.substr(0, tv.length)));
            document.formmenu.vleftapaguar.value = parseInt(Math.round(tv.substr(0, tv.length)));
          } else {
            document.formmenu.vleftakredituar.value = parseInt(Math.round(tv.substr(0, tv.indexOf('.') + 5)));
            document.formmenu.vleftapaguar.value = parseInt(Math.round(tv.substr(0, tv.indexOf('.') + 3)));
          };
        };
      };

      function calculate_rate_value2() {

        if ((document.formmenu.id_mondebituar.value != '999') && (document.formmenu.id_monkreditim.value != '999')) {

          rate_value = 1 / document.formmenu.kursi1.value;

          document.formmenu.hkursi.value = 1 / document.formmenu.kursi1.value;

          var mrv = new String(rate_value);

          if (mrv.indexOf('.') == -1) {
            document.formmenu.kursi.value = mrv.substr(0, mrv.length);
          } else {
            document.formmenu.kursi.value = mrv.substr(0, mrv.indexOf('.') + 7);
          };

          var v_nr1 = new Number(document.formmenu.vleftadebituar.value);
          var v_nr2 = new Number(document.formmenu.hkursi.value);

          var tv = new String(v_nr1.valueOf() * v_nr2.valueOf());

          if (tv.indexOf('.') == -1) {
            document.formmenu.vleftakredituar.value = parseInt(Math.round(tv.substr(0, tv.length)));
            document.formmenu.vleftapaguar.value = parseInt(Math.round(tv.substr(0, tv.length)));
          } else {
            document.formmenu.vleftakredituar.value = parseInt(Math.round(tv.substr(0, tv.indexOf('.') + 5)));
            document.formmenu.vleftapaguar.value = parseInt(Math.round(tv.substr(0, tv.indexOf('.') + 3)));
          };
        };
      };

      function calculate_rate_value3() {

        if ((document.formmenu.id_mondebituar.value != '999') && (document.formmenu.id_monkreditim.value != '999')) {

          rate_value = 1 / document.formmenu.kursi.value;

          document.formmenu.hkursi.value = document.formmenu.kursi.value;

          var mrv = new String(rate_value);

          if (mrv.indexOf('.') == -1) {
            document.formmenu.kursi1.value = mrv.substr(0, mrv.length);
          } else {
            document.formmenu.kursi1.value = mrv.substr(0, mrv.indexOf('.') + 7);
          };

          var v_nr1 = new Number(document.formmenu.vleftadebituar.value);
          var v_nr2 = new Number(document.formmenu.hkursi.value);

          var tv = new String(v_nr1.valueOf() * v_nr2.valueOf());

          if (tv.indexOf('.') == -1) {
            document.formmenu.vleftakredituar.value = parseInt(Math.round(tv.substr(0, tv.length)));
            document.formmenu.vleftapaguar.value = parseInt(Math.round(tv.substr(0, tv.length)));
          } else {
            document.formmenu.vleftakredituar.value = parseInt(Math.round(tv.substr(0, tv.indexOf('.') + 5)));
            document.formmenu.vleftapaguar.value = parseInt(Math.round(tv.substr(0, tv.indexOf('.') + 3)));
          };
        };
      };

      function calculate_value() {

        if ((document.formmenu.kursi.value != '0') && (document.formmenu.kursi.value != '0.0') && (document.formmenu.kursi.value != '0.00')) {

          var v_nr1 = new Number(document.formmenu.vleftadebituar.value);
          var v_nr2 = new Number(document.formmenu.hkursi.value);

          var tv = new String(v_nr1.valueOf() * v_nr2.valueOf());

          if (tv.indexOf('.') == -1) {
            document.formmenu.vleftakredituar.value = parseInt(Math.round(tv.substr(0, tv.length)));
            document.formmenu.vleftapaguar.value = parseInt(Math.round(tv.substr(0, tv.length)));
          } else {
            document.formmenu.vleftakredituar.value = parseInt(Math.round(tv.substr(0, tv.indexOf('.') + 5)));
            document.formmenu.vleftapaguar.value = parseInt(Math.round(tv.substr(0, tv.indexOf('.') + 3)));
          };
        };
      };

      function llogarit_komisionin() {

        var v_nr1 = new Number(document.formmenu.vleftakredituar.value);
        var v_nr2 = new Number(document.formmenu.perqindjekomisioni.value);

        var kv = new String(v_nr1.valueOf() / 100 * v_nr2.valueOf());

        if (kv.indexOf('.') == -1) {
          document.formmenu.vleftakomisionit.value = parseInt(Math.round(kv.substr(0, kv.length)));
        } else {
          document.formmenu.vleftakomisionit.value = parseInt(Math.round(kv.substr(0, kv.indexOf('.') + 3)));
        };

        var v_nr1 = new Number(document.formmenu.vleftakredituar.value);
        var v_nr2 = new Number(document.formmenu.vleftakomisionit.value);

        var tv = new String(v_nr1.valueOf() - v_nr2.valueOf());

        if (tv.indexOf('.') == -1) {
          document.formmenu.vleftapaguar.value = parseInt(Math.round(tv.substr(0, tv.length)));
        } else {
          document.formmenu.vleftapaguar.value = parseInt(Math.round(tv.substr(0, tv.indexOf('.') + 3)));
        };

      };

      function llogarit_komisionin_fix() {

        var v_nr1 = new Number(document.formmenu.vleftakredituar.value);
        var v_nr2 = new Number(document.formmenu.vleftakomisionit.value);

        var tv = new String(v_nr1.valueOf() - v_nr2.valueOf());

        if (tv.indexOf('.') == -1) {
          document.formmenu.vleftapaguar.value = tv.substr(0, tv.length);
        } else {
          document.formmenu.vleftapaguar.value = tv.substr(0, tv.indexOf('.') + 3);
        };

      };

      function llogarit_mbrapsht() {

        if ((document.formmenu.perqindjekomisioni.value != '0') && (document.formmenu.perqindjekomisioni.value != '0.0') && (document.formmenu.perqindjekomisioni.value != '0.00')) {

          var v_nr1 = new Number(document.formmenu.vleftapaguar.value);
          var v_nr2 = new Number(document.formmenu.perqindjekomisioni.value);

          var kv = new String(v_nr1.valueOf() / (100 - v_nr2.valueOf()) * v_nr2.valueOf());

          if (kv.indexOf('.') == -1) {
            document.formmenu.vleftakomisionit.value = kv.substr(0, kv.length);
          } else {
            document.formmenu.vleftakomisionit.value = kv.substr(0, kv.indexOf('.') + 3);
          };
        }

        var v_nr1 = new Number(document.formmenu.vleftapaguar.value);
        var v_nr2 = new Number(document.formmenu.vleftakomisionit.value);
        var v_nr3 = new Number(document.formmenu.hkursi.value);

        var tv = new String(v_nr1.valueOf() + v_nr2.valueOf());

        if (tv.indexOf('.') == -1) {
          document.formmenu.vleftakredituar.value = tv.substr(0, tv.length);
        } else {
          document.formmenu.vleftakredituar.value = tv.substr(0, tv.indexOf('.') + 3);
        };

        var tv = new String((v_nr1.valueOf() + v_nr2.valueOf()) / v_nr3.valueOf());

        if (tv.indexOf('.') == -1) {
          document.formmenu.vleftadebituar.value = tv.substr(0, tv.length);
        } else {
          document.formmenu.vleftadebituar.value = tv.substr(0, tv.indexOf('.') + 3);
        };

      };

      //  End 
      -->
    </script>

    <script language="JavaScript">
      <!-- Begin
      function Open_Filial_Window() {

        childWindow = window.open('filial_list.php', 'FilialList', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=335,height=350');
      }

      function Open_Klient_Window() {

        childWindow = window.open('klient_list.php', 'KlientList', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=335,height=350');
      }

      //  End 
      -->
    </script>

    <script language="JavaScript" src="calendar_eu.js"></script>
    <link rel="stylesheet" href="calendar.css">

    <script language="JavaScript">
      <!--  Begin
      function checkform(form) {
        if (form.vleftadebituar.value == "") {
          alert("Ju lutem plotesoni fushen: vlefta");
          form.vleftadebituar.focus();
          return false;
        }
        if (form.vleftadebituar.value == "0") {
          alert("Ju lutem plotesoni fushen: vlefta");
          form.vleftadebituar.focus();
          return false;
        }
        if (form.vleftadebituar.value == "0.0") {
          alert("Ju lutem plotesoni fushen: vlefta");
          form.vleftadebituar.focus();
          return false;
        }
        if (form.vleftadebituar.value == "0.00") {
          alert("Ju lutem plotesoni fushen: vlefta");
          form.vleftadebituar.focus();
          return false;
        }

        if (form.id_monkreditim.value == "999") {
          alert("Ju lutem plotesoni fushen: jap");
          form.id_monkreditim.focus();
          return false;
        }

        if (form.kursi.value == "") {
          alert("Ju lutem plotesoni fushen: kursi");
          form.kursi.focus();
          return false;
        }

        return true;
      }

      //  End 
      -->
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

  <body onLoad="focusOnMyInputBox();">

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
        <a href="exchange.php" class="ButLart2" target="_top"><b>K&euml;mbim Monetar</b></a>
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
    <div id="bar">
      <div class="ButonatFillimi">
        <a href="#" class="ButLart2" target="_top"></a>
        <a href="insupd_client_data2.php" class="ButLart2" target="_top">Shto klient</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="#" class="ButLart2" target="_top"></a>
        <a href="exchange_trans.php" class="ButLart2" target="_top">Lista e transaksioneve</a>
      </div>
      <div class="clear"></div>
    </div>

    <div class="container_12">

      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY>
          <TR>
            <TD align="left">

              <form enctype="multipart/form-data" ACTION="exchangen.php" METHOD="POST" name="formmenu" id="formmenu" onsubmit="return checkform(this);">

                <input name="form_action" type="hidden" value="ins">
                <input name="rate_value" type="hidden" value="">
                <input name="total_value" type="hidden" value="">

                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td colspan="7" height="15"></td>
                  </tr>
                  <tr valign="middle">
                    <td width="20"></td>
                    <td width="150" colspan="2">
                      <lable>Grup Trans.:&nbsp;<input name="id_trans" type="text" id="id_trans" value="<?php echo $_SESSION['Usertrans']; ?>" size="10" readonly></lable>
                    </td>
                    <td width="2"></td>
                    <td width="400" colspan="2">
                      <lable>Dat&euml;:&nbsp;<input name="date_trans" type="text" value="<?php echo strftime('%d.%m.%Y'); ?>" id="date_trans" size="10" readonly>&nbsp;
                        <script language="JavaScript">
                          var o_cal = new tcal({
                            'formname': 'formmenu',
                            'controlname': 'date_trans'
                          });
                          o_cal.a_tpl.yearscroll = true;
                          o_cal.a_tpl.weekstart = 1;
                        </script>
                      </lable>
                    </td>
                    <td width="20"></td>
                  </tr>
                  <tr>
                    <td colspan="7" height="5"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="2">
                      <lable>Filiali:&nbsp;<select name="id_llogfilial" id="id_llogfilial">
                          <?php
                          while ($row_filiali_info) {
                          ?>
                            <option value="<?php echo $row_filiali_info['id']; ?>" <?php if ($row_filiali_info['id'] == $_SESSION['Userfilial']) {
                                                                                      echo "selected";
                                                                                    } ?>><?php echo $row_filiali_info['filiali']; ?></option>
                          <?php
                            $row_filiali_info = mysql_fetch_assoc($filiali_info);
                          }
                          mysqli_free_result($filiali_info);
                          ?>
                        </select>&nbsp;&nbsp;<a class="link4" href="JavaScript: Open_Filial_Window();"><img src="images/doc.gif" border="0"></a></lable>
                    </td>
                    <td></td>
                    <td colspan="2">
                      <lable>Klienti:&nbsp;<select name="id_klienti" id="id_klienti">
                          <?php
                          while ($row_klienti_info) {
                          ?>
                            <option value="<?php echo $row_klienti_info['id']; ?>" <?php if ($row_klienti_info['id'] == $clid) {
                                                                                      echo "selected";
                                                                                    } ?>><?php echo $row_klienti_info['emriplote']; ?></option>
                          <?php
                            $row_klienti_info = mysql_fetch_assoc($klienti_info);
                          }
                          mysqli_free_result($klienti_info);
                          ?>
                        </select>&nbsp;&nbsp;<a class="link4" href="JavaScript: Open_Klient_Window();"><img src="images/doc.gif" border="0"></a></lable>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="7" height="5"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="5" height="1" bgcolor="000000"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="7" height="5"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="2">
                      <lable>Blej:&nbsp;&nbsp;&nbsp;&nbsp;<select name="id_mondebituar" id="id_mondebituar" OnChange="JavaScript: disp_kursitxt( document.formmenu.id_mondebituar.value, document.formmenu.id_monkreditim.value, '/');  calculate_rate_value (); ">
                          <?php
                          while ($row_monedha_info) {

                            if ($row_monedha_info['id'] == "2") {
                          ?>
                              <option value="<?php echo $row_monedha_info['id']; ?>" selected="selected"><?php echo $row_monedha_info['monedha']; ?> - <?php echo $row_monedha_info['pershkrimi']; ?></option>
                            <?php       } else {
                            ?>
                              <option value="<?php echo $row_monedha_info['id']; ?>"><?php echo $row_monedha_info['monedha']; ?> - <?php echo $row_monedha_info['pershkrimi']; ?></option>
                          <?php
                            }
                            $row_monedha_info = mysql_fetch_assoc($monedha_info);
                          }
                          mysqli_free_result($monedha_info);
                          ?>
                        </select></lable>
                    </td>
                    <td></td>
                    <td colspan="2">
                      <lable>Shuma:&nbsp;<input name="vleftadebituar" type="text" class="inputtext2" id="vleftadebituar" value=".00" size="15" onChange="JavaScript: if (document.formmenu.id_monkreditim.value != '999')  calculate_rate_value (); " onKeyDown="if (event.keyCode == 13) document.formmenu.insupd.focus(); "></lable>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="7" height="5"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="5" height="1" bgcolor="000000"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="7" height="5"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="2">
                      <lable>Shitje:&nbsp;&nbsp;<select name="id_monkreditim" id="id_monkreditim" OnChange="JavaScript: disp_kursitxt( document.formmenu.id_mondebituar.value, document.formmenu.id_monkreditim.value, '/'); calculate_rate_value ();" onKeyDown="if (event.keyCode == 13) document.formmenu.insupd.focus(); ">
                          <option value="999"></option>
                          <?php

                          $monedha_info = mysql_query($query_monedha_info, $MySQL) or die(mysql_error());
                          $row_monedha_info = mysql_fetch_assoc($monedha_info);

                          while ($row_monedha_info) {

                            if ($row_monedha_info['id'] == "1") {
                          ?>
                              <option value="<?php echo $row_monedha_info['id']; ?>" selected="selected"><?php echo $row_monedha_info['monedha']; ?> - <?php echo $row_monedha_info['pershkrimi']; ?></option>
                            <?php       } else {
                            ?>
                              <option value="<?php echo $row_monedha_info['id']; ?>"><?php echo $row_monedha_info['monedha']; ?> - <?php echo $row_monedha_info['pershkrimi']; ?></option>
                          <?php
                            }
                            $row_monedha_info = mysql_fetch_assoc($monedha_info);
                          }
                          mysqli_free_result($monedha_info);
                          ?>
                        </select></lable>
                    </td>
                    <td></td>
                    <td colspan="2">
                      <lable>Kursi: &nbsp;<input name="kursi_txt" type="text" class="inputtext5" id="kursi_txt" value="LEK/" size="10" readonly>&nbsp;=&nbsp;<input name="kursi" type="text" class="inputtext2" id="kursi" value="" size="10" OnChange="JavaScript: calculate_rate_value3 (); calculate_value ();"></lable>
                    </td>
                    <td></td>
                  </tr>
                  <input name="hkursi" type="hidden" id="hkursi" value="">
                  <tr>
                    <td colspan="7" height="5"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="2">
                      <lable>Totali:&nbsp; <input name="vleftakredituar" type="text" class="inputtext2" id="vleftakredituar" value="0.00" size="15" readonly></lable>
                    </td>
                    <td></td>
                    <td colspan="2">
                      <lable>Kursi: &nbsp;<input name="kursi1_txt" type="text" class="inputtext5" id="kursi1_txt" value="/LEK" size="10" readonly>&nbsp;=&nbsp;<input name="kursi1" type="text" class="inputtext2" id="kursi1" value="" size="10" OnChange="JavaScript: calculate_rate_value2 (); calculate_value ();"></lable>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="7" height="5"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="5" height="1" bgcolor="000000"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="7" height="5"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="5" align="right">
                      <lable>Komisioni:&nbsp;<input name="perqindjekomisioni" type="text" class="inputtext2" id="perqindjekomisioni" value="0.00" size="4" OnChange="JavaScript: llogarit_komisionin ();">&nbsp;%&nbsp;<input name="vleftakomisionit" type="text" class="inputtext2" id="vleftakomisionit" value="0.00" size="10" onChange="JavaScript: llogarit_komisionin_fix ();"></lable>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="7" height="5"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="5" height="1" bgcolor="000000"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="7" height="5"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="5" align="right">
                      <DIV class=ctxheading>
                        <lable>P&euml;r t'u paguar:&nbsp;<input name="vleftapaguar" type="text" class="inputtext2" id="vleftapaguar" value="0.00" size="15" onChange="JavaScript: llogarit_mbrapsht ();"></lable>&nbsp; &nbsp; &nbsp;<lable>Burimi i t&euml; ardhurave:&nbsp;<input name="burimteardhura" type="text" class="inputtext" id="burimteardhura" value="" size="40"></lable>
                      </div>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="7" height="5"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="5" height="1" bgcolor="000000"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="7" height="10"></td>
                  </tr>
                  <tr>
                    <td colspan="7" align="center">&nbsp;&nbsp;&nbsp;<input name="insupd" class="inputtext4" type="button" value=" Kryej veprimin " onClick="JavaScript: if (document.formmenu.vleftapaguar.value != 0) { document.formmenu.submit(); }"></td>
                  </tr>
                  <tr>
                    <td colspan="7" height="10"></td>
                  </tr>
                </table>
                <script>
                  focusOnMyInputBox();
                  disp_kursitxt(document.formmenu.id_mondebituar.value, document.formmenu.id_monkreditim.value, '/');
                  calculate_rate_value();
                </script>
              </form>
            </TD>
          </TR>
        </TBODY>
      </TABLE>

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