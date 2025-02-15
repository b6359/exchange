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

?>
<?php require_once('ConMySQL.php'); ?>
<?php

if (isset($_SESSION['uid'])) {
    $user_info = $_SESSION['uid'] ?? addslashes($_SESSION['uid']);

    $v_date = strftime('%d.%m.%Y');
    if ((isset($_POST['p_date1'])) && ($_POST['p_date1'] != "")) {
        $v_date = $_POST['p_date1'];
    }
    if ((isset($_GET['dt'])) && ($_GET['dt'] != "")) {
        $v_date = $_GET['dt'];
    }

    if (isset($_GET['action']) && ($_GET['action'] == "del")) {
        $sql_info = "UPDATE exchange_koke SET chstatus ='F' WHERE id = '" . $_GET[tid] . "'";
        $result = mysql_query($sql_info, $MySQL) or die(mysql_error());
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
                    window.location = 'exchange_trans.php?action=del&dt=<?php echo $v_date; ?>&tid=' + value;
                }
            }
            // 
            -->
        </SCRIPT>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <link href="styles.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="css/reset.css">
        <link rel="stylesheet" type="text/css" href="css/text.css">
        <link rel="stylesheet" type="text/css" href="css/984_width.css">
        <link rel="stylesheet" type="text/css" href="css/layout.css">
        <link rel="stylesheet" href="css/login.css" />
        <link rel="stylesheet" type="text/css" href="css/server.css" />

        <script language="JavaScript" src="calendar_eu.js"></script>
        <link rel="stylesheet" href="calendar.css">

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
                        tableWindow = window.open('exchange_tabel.php', ' ',
                            'toolbar=no,scrollbars=no,resizable=no,width=1280,height=768,top=100,left=' + screen.availWidth);
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
                    <img src="images/header.png" title="<?php echo $_SESSION['CNAME']; ?>"
                        alt="<?php echo $_SESSION['CNAME']; ?>" height="50px">
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
                <a href="exchange_trans.php" class="ButLart2" target="_top"><b>Lista e transaksioneve</b></a>
            </div>
            <div class="clear"></div>
        </div>

        <br />

        <div class="container_12">

            <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                <TBODY>
                    <TR>
                        <TD height="15" colSpan=3 align="left" valign="middle">
                            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lista e transaksioneve
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
                        <DIV class=ctxheading7>
                            <br>
                            <form action="exchange_trans.php" method="POST" name="formmenu" target="_self">
                                <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                                    <TBODY>
                                        <TR>
                                            <TD align="left">

                                                <table width="100%" border="0">
                                                    <tr>
                                                        <td colspan="2">&nbsp;&nbsp;<lable>P&euml;rzgjidh
                                                                dat&euml;n:&nbsp;&nbsp;<input name="p_date1" type="text"
                                                                    id="p_date1" value="<?php echo $v_date; ?>" size="10"
                                                                    maxlength="10">
                                                                <script language="JavaScript">
                                                                    var o_cal = new tcal({
                                                                        'formname': 'formmenu',
                                                                        'controlname': 'p_date1'
                                                                    });
                                                                    o_cal.a_tpl.yearscroll = true;
                                                                    o_cal.a_tpl.weekstart = 1;
                                                                </script>
                                                            </lable>
                                                        </td>
                                                        <td><input name="repdata" class="inputtext4" type="submit"
                                                                value=" Shfaq transaksionet ... "></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>
                                                <center>
                                                    <table border="0" cellpadding="0" width="95%" cellspacing="0">
                                                        <tr>
                                                            <td height="10" colspan="9"></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="OraColumnHeader"> Nr. fature </th>
                                                            <th class="OraColumnHeader"> Dat&euml; </th>
                                                            <th class="OraColumnHeader"> Klienti </th>
                                                            <th class="OraColumnHeader"> Shuma e Bler&euml; </th>
                                                            <th class="OraColumnHeader"> Kursi </th>
                                                            <th class="OraColumnHeader"> Shuma e Shitur </th>
                                                            <th class="OraColumnHeader"> P&euml;rdoruesi </th>
                                                            <th class="OraColumnHeader"> </th>
                                                        </tr>
                                                        <tr>
                                                            <td height="5" colspan="9"></td>
                                                        </tr>
                                                        <?php

                                                        set_time_limit(0);

                                                        $v_perioddate  = " and ek.date_trans = '" . substr($v_date, 6, 4) . "-" . substr($v_date, 3, 2) . "-" . substr($v_date, 0, 2) . "'";

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
                      where ek.id             = ed.id_exchangekoke
                        and ek.unique_id      > (select max(id_chn) from systembalance)
                        and ek.chstatus       = 'T'
                        and ek.tipiveprimit   = 'CHN'
                        " . $v_perioddate . "
                        " . $v_wheresql   . "
                        and ek.id_klienti     = k.id
                        and ek.id_monkreditim = m1.id
                        and ed.id_mondebituar = m2.id
                        and ek.chstatus       = 'T'
                      order by ek.unique_id desc
                   ";
                                                        //$RepInfoRS   = mysql_query($RepInfo_sql, $MySQL) or die(mysql_error());
                                                        //$row_RepInfo = mysql_fetch_assoc($RepInfoRS);
                                                        $RepInfoRS = $MySQL->query($RepInfo_sql);
                                                        $row_RepInfo = $RepInfoRS->fetch_assoc();

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
                                                                <td height="1" colspan="9" bgcolor="#000033"></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center" class="OraCellGroup2">
                                                                    <?php echo $row_RepInfo['id_llogfilial'] . "-" . $row_RepInfo['unique_id']; ?>
                                                                </td>
                                                                <td align="center" class="OraCellGroup2">
                                                                    <?php echo substr($row_RepInfo['date_trans'], 8, 2) . "." . substr($row_RepInfo['date_trans'], 5, 2) . "." . substr($row_RepInfo['date_trans'], 0, 4); ?>
                                                                </td>
                                                                <td align="center" class="OraCellGroup2">
                                                                    <?php echo $row_RepInfo['emri']; ?>&nbsp;<?php echo $row_RepInfo['mbiemri']; ?>
                                                                </td>
                                                                <td align="right" class="OraCellGroup2">
                                                                    <?php echo number_format(($row_RepInfo['vleftadebituar'] + $row_RepInfo['vleftadebituarjocash']), 2, '.', ','); ?>&nbsp;<?php echo $row_RepInfo['mon2']; ?>&nbsp;
                                                                </td>
                                                                <td align="right" class="OraCellGroup2">
                                                                    <?php echo number_format($v_kursi, 2, '.', ','); ?>&nbsp;&nbsp;
                                                                </td>
                                                                <td align="right" class="OraCellGroup2">
                                                                    <?php echo number_format($row_RepInfo['vleftapaguar'], 2, '.', ','); ?>&nbsp;<?php echo $row_RepInfo['mon1']; ?>&nbsp;
                                                                </td>
                                                                <td align="center" class="OraCellGroup2">
                                                                    <?php echo $row_RepInfo['perdoruesi']; ?></td>
                                                                <td width="20">
                                                                    <?php if ($_SESSION['Usertype'] != 3) {  ?>
                                                                        <a title="Fshij Informacionin"
                                                                            href="JavaScript: do_delete('<?php echo $row_RepInfo['id']; ?>'); "><img
                                                                                src="images/del.gif" border="0"></a>
                                                                    <?php  }  ?>
                                                                </td>
                                                            </tr>
                                                        <?php $row_RepInfo = mysql_fetch_assoc($RepInfoRS);
                                                        };
                                                        mysqli_free_result($RepInfoRS);
                                                        ?>
                                                        <tr>
                                                            <td height="1" colspan="9" bgcolor="#000033"></td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" colspan="9"></td>
                                                        </tr>
                                                    </table>
                                                    <center>
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