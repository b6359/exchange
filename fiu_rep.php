<?php
//initialize the session
session_start();

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
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
    $v_act = "";
    if ((isset($_POST['act'])) && ($_POST['act'] != "")) {
        $v_act = $_POST['act'];
    }
    $v_reptype = "Excel";
    if ((isset($_POST['reptype'])) && ($_POST['reptype'] != "")) {
        $v_reptype = $_POST['reptype'];
    }
    $v_dt1 = "";
    if ((isset($_POST['p_date1'])) && ($_POST['p_date1'] != "")) {
        $v_dt1 = $_POST['p_date1'];
    }
    $v_dt2 = "";
    if ((isset($_POST['p_date2'])) && ($_POST['p_date2'] != "")) {
        $v_dt2 = $_POST['p_date2'];
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

<script language="JavaScript" src="calendar_eu.js"></script>
<link rel="stylesheet" href="calendar.css">

<script language="JavaScript">
<!-- Begin

function Open_Filial_Window() {

    childWindow = window.open( 'filial_list.php', 'FilialList', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=335,height=350');
}

//  End -->
</script>

<link href="styles.css" rel="stylesheet" type="text/css">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link href="styles.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/text.css">
    <link rel="stylesheet" type="text/css" href="css/984_width.css">
    <link rel="stylesheet" type="text/css" href="css/layout.css">
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" type="text/css" href="css/server.css"/>

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
    	<a href="info.php"   class="ButLart2" target="_top">KREU</a>
    	<a href="exchange_users.php"   class="ButLart2" target="_top">P&Euml;RDORUESIT</a>
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
    	<a href="exchange.php"          class="ButLart2" target="_top">K&euml;mbim Monetar</a>
    	<a href="exchange_kalimlog.php" class="ButLart2" target="_top">Kalim nd&euml;rmjet filialeve</a>
    	<a href="exchange_hyrdal.php"   class="ButLart2" target="_top">Veprime Monetare</a>
    	<a href="exchange_rate.php"     class="ButLart2" target="_top">Kursi i K&euml;mbimit</a>
    	<a href="exchange_opclbal.php"  class="ButLart2" target="_top">Hapje/Mbyllje Dite</a>
    	<a href="exchange_balance.php"  class="ButLart2" target="_top">Bilanci sipas veprimeve</a>
    	<a href="exchange_basedata.php" class="ButLart2" target="_top">T&euml; Dh&euml;nat Baz&euml;</a>
    	<a href="exchange_reports.php"  class="ButLart2" target="_top"><b>Raporte</b></a>
    </div>

    <div class="clear"></div>
</div>
<div id="bar">
    <div class="ButonatFillimi">
    	<a href="vle_rep.php" class="ButLart2" target="_top">Raport p&euml;r vlera</a>
    	<a href="cli_rep.php" class="ButLart2" target="_top">Raport p&euml;r Klient</a>
    	<a href="fiu_rep.php" class="ButLart2" target="_top"><b>Raport p&euml;r DPPPP</b></a>
    	<a href="boa_rep.php" class="ButLart2" target="_top">Banka e Shqip&euml;ris&euml;</a>
    	<a href="dt_rep.php"  class="ButLart2" target="_top">Veprimet ditore/periodike</a>
    	<a href="st_rep.php"  class="ButLart2" target="_top">P&euml;rmbledhje e veprimeve</a>
    </div>
    <div class="clear"></div>
</div>

<br />

<div class="container_12">

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD height="15" colSpan=3 align="left" valign="middle">
        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Raporti i DPPPP</DIV></TD>
    </TR>
  </TBODY>
</TABLE>
<br />

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD align="left">

<form action="fiu_rep.php" method="POST" name="formmenu" target="_self">
<input type="hidden" name="act" value="create">
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
    <td height="5"><b>Shfaq:</b></td>
    <td colspan="4">
<select name="reptype" id="reptype">
<option value="Excel">Excel</option>
<option value="XML">XML</option>
</select></td>
    </td>
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
	              var o_cal = new tcal ({
	                  'formname': 'formmenu',
	                  'controlname': 'p_date1'
	              });
	              o_cal.a_tpl.yearscroll = true;
	              o_cal.a_tpl.weekstart = 1;
	    </script>
    </td>
    <td></td>
    <td><input name="p_date2" type="text"  id="p_date2" value="<?php echo strftime('%d.%m.%Y'); ?>" size="15" maxlength="10">
        <script language="JavaScript">
	              var o_cal = new tcal ({
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
        <script>document.write("<input name=\"repdata\" class=\"inputtext4\" type=\"submit\" value=\"Shfaq raportin...\">");</script></td>
    </td>
  </tr>
  <tr>
    <td height="10" colspan="5"></td>
  </tr>
</table>

<?php
      //---------------------------------------------------------------
         if ($v_act == "create") {
            //------------------------------------------------------------------------------------------------------

                //mysql_select_db($database_MySQL, $MySQL);
                $RepInfo_sql = "
                                 select k1.emri, k1.mbiemri, k1.emrikompanise, k1.nipt, k1.dob, k1.gender, k1.nationality, k1.nationalitytxt, k1.nrpashaporte, k1.adresa,
                                        ek1.date_trans,
                                        ek1.vleftapaguar   as vleftapaguar,   m11.id as mon1, m11.monedha as monedha1,
                                        ed1.vleftadebituar as vleftadebituar, m21.id as mon2, m21.monedha as monedha2

                                 from   exchange_koke as ek1,
                                        exchange_detaje as ed1,
                                        klienti as k1,
                                        monedha as m11,
                                        monedha as m21

                                  where k1.id in (
                                                     select k.id
                                                       from exchange_koke as ek,
                                                            exchange_detaje as ed,
                                                            klienti as k,
                                                            monedha as m1,
                                                            monedha as m2
                                                      where ek.chstatus       = 'T'
                                                        and ek.id             = ed.id_exchangekoke
                                                        and ek.date_trans    >= '". substr($v_dt1, 6, 4)."-".substr($v_dt1, 3, 2)."-".substr($v_dt1, 0, 2) ."'
                                                        and ek.date_trans    <= '". substr($v_dt2, 6, 4)."-".substr($v_dt2, 3, 2)."-".substr($v_dt2, 0, 2) ."'
                                                        and ek.id_klienti     = k.id
                                                        and ek.id_monkreditim = m1.id
                                                        and ed.id_mondebituar = m2.id
                                                        and k.id             <> 1
                                                        and (m1.monedha = 'LEK' or m2.monedha = 'LEK')
                                                   group by k.id
                                                     having (sum( case when m2.monedha = 'LEK' then ed.vleftadebituar else ek.vleftapaguar end ) > ". $_SESSION['DPPPP'] .")
                                                 )
                                    and ek1.chstatus       = 'T'
                                    and ek1.id             = ed1.id_exchangekoke
                                    and ek1.date_trans    >= '". substr($v_dt1, 6, 4)."-".substr($v_dt1, 3, 2)."-".substr($v_dt1, 0, 2) ."'
                                    and ek1.date_trans    <= '". substr($v_dt2, 6, 4)."-".substr($v_dt2, 3, 2)."-".substr($v_dt2, 0, 2) ."'
                                    and ek1.id_klienti     = k1.id
                                    and ek1.id_monkreditim = m11.id
                                    and ed1.id_mondebituar = m21.id
                                    and k1.id             <> 1
                                    and (m11.monedha = 'LEK' or m21.monedha = 'LEK')
                               ";

                $RepInfoRS   = mysqli_query($MySQL,$RepInfo_sql) or die(mysql_error());
                $row_RepInfo = $RepInfoRS->fetch_assoc();

        if ($v_reptype == "XML") {

                chdir("rep");
                $v_row = 0;
                while ($row_RepInfo) {  $v_row ++;

                    //------------------------------------------------------------------------------------------------------
                        $v_file = "DPPPP_REP". $v_row ."_" . strftime('%Y%m%d%H%M%S') .".xml";
                        if (file_exists($v_file)) {
                            if (!$file=fopen( $v_file, "w")) {
                                echo("Could not open file");
                             }
                         }
                        else {
                            if (!$file=fopen( $v_file, "x")) {
                                echo("Could not open file");
                             }
                        }
                    //------------------------------------------------------------------------------------------------------

                    $info_txt = "<?xml version='1.0' encoding='UTF-8'?>
<form1>

<FTYPE>U12</FTYPE>

<FT_01>1</FT_01>

<F0_01>1</F0_01>
<F0_02>0</F0_02>
<F0_03>0</F0_03>
<F0_04>0</F0_04>
";

                    if ( ($row_RepInfo['gender'] == "M")||($row_RepInfo['gender'] == "F") ) {

                       $info_txt .= "
<F1_01>". $row_RepInfo['emri'] ."</F1_01>
<F1_02></F1_02>
<F1_03>". $row_RepInfo['mbiemri'] ."</F1_03>
<F1_04></F1_04>
<F1_05>1</F1_05>
<F1_06>0</F1_06>
<F1_07>0</F1_07>
<F1_08>0</F1_08>
<F1_09>0</F1_09>
<F1_10>". $row_RepInfo['nrpashaporte'] ."</F1_10>
<F1_11></F1_11>
<F1_12>". $row_RepInfo['dob'] ."</F1_12>
<F1_13></F1_13>
<F1_14>". $row_RepInfo['nationalitytxt'] ."</F1_14>
<F1_15></F1_15>
<F1_16>". $row_RepInfo['adresa'] ."</F1_16>
";
                     }
                    else {
                       $info_txt .= "
<F1_01></F1_01>
<F1_02></F1_02>
<F1_03></F1_03>
<F1_04>". $row_RepInfo['emri'] ."</F1_04>
<F1_05>0</F1_05>
<F1_06>0</F1_06>
<F1_07>1</F1_07>
<F1_08>0</F1_08>
<F1_09></F1_09>
<F1_10></F1_10>
<F1_11></F1_11>
<F1_12>". $row_RepInfo['dob'] ."</F1_12>
<F1_13></F1_13>
<F1_14>". $row_RepInfo['nationalitytxt'] ."</F1_14>
<F1_15>". $row_RepInfo['nrpashaporte'] ."</F1_15>
<F1_16>". $row_RepInfo['adresa'] ."</F1_16>
";
                    }

                    $info_txt .= "
<F2_01></F2_01>
<F2_02></F2_02>
<F2_03></F2_03>
<F2_04></F2_04>
<F2_05>0</F2_05>
<F2_06>0</F2_06>
<F2_07>0</F2_07>
<F2_08>0</F2_08>
<F2_09>0</F2_09>
<F2_10></F2_10>
<F2_11></F2_11>
<F2_12></F2_12>
<F2_13></F2_13>
<F2_14></F2_14>
<F2_15></F2_15>
<F2_16></F2_16>

<F3_01></F3_01>
<F3_02></F3_02>
<F3_03></F3_03>
<F3_04></F3_04>
<F3_05>0</F3_05>
<F3_06>0</F3_06>
<F3_07>0</F3_07>
<F3_08>0</F3_08>
<F3_09>0</F3_09>
<F3_10></F3_10>
<F3_11></F3_11>
<F3_12></F3_12>
<F3_13></F3_13>
<F3_14></F3_14>
<F3_15></F3_15>
<F3_16></F3_16>
<F3_17>INTERNAL</F3_17>
<F3_18>". $row_RepInfo['date_trans'] ."</F3_18>
<F3_19>KEMBIM VALUTOR</F3_19>
<F3_20>". number_format( $row_RepInfo['vleftapaguar'], 2, '.', '') ."</F3_20>
<F3_21>". $row_RepInfo['mon1'] ."</F3_21>
<F3_22>". $_SESSION['CNAME'] ."</F3_22>
<F3_23>". strftime('%d.%m.%Y') ."</F3_23>
<F3_24>". $_SESSION['CADMI'] ."</F3_24>
<F3_25>". $_SESSION['CMOBI'] ."</F3_25>
<F3_26>". $_SESSION['CADMI'] ."</F3_26>
<F3_27>". $_SESSION['CADDR'] ."</F3_27>
<F3_29>". $_SESSION['CNIPT'] ."</F3_29>

</form1>
";

                    fputs($file, $info_txt);  // Shkrimi i informacionit ne skedar
?>
<?php  if ( $v_row == 1 ) {  ?>
<table width="100%" border="0">
  <tr>
    <td width="10px"></td>
    <td>
        <DIV class=ctxheading>
           <b>Skedari u krijua me sukses</b>
<?php  }  ?>
                       <div class="titull_box_grid">
                        <table width="95%" border="0">
                          <tr bgcolor="#A7CCBA">
                            <td class="titullheader"> &nbsp;&nbsp;Skedari <?php echo $v_row; ?> :&nbsp;</td>
                            <td class="titullheader"> &nbsp;<b><a href="rep/<?php echo $v_file; ?>"><?php echo $v_file; ?><a></b></td>
                          </tr>
                        </table>
        </div>
    </td>
    <td width="10px"></td>
  </tr>
</table>
<?php
                    fclose($file);

                    $row_RepInfo = $RepInfoRS->fetch_assoc();
                };
                mysqli_free_result($RepInfoRS);
      //---------------------------------------------------------------
   }
  else {

          require_once 'Spreadsheet/Excel/Writer.php';

          $v_file = "rep/BalancaPerMonedhe_". strftime('%Y%m%d%H%M%S') .".xls";
          $workbook = new Spreadsheet_Excel_Writer($v_file);

          $format1    =& $workbook->addFormat(array('Size'       => 10,
                                                    'Align'      => 'center',
                                                    'VAlign'     => 'vcenter',
                                                    'Color'      => 'black',
                                                    'FontFamily' => 'Calibri',
                                                    'Bold'       => 1,
                                                    'Pattern'    => 1,
                                                    'border'     => 1,
                                                    'FgColor'    => 'aqua'));
          $format1->setTextWrap();

          $format2    =& $workbook->addFormat(array('Size'       => 10,
                                                    'Align'      => 'left',
                                                    'VAlign'     => 'vcenter',
                                                    'Color'      => 'aqua',
                                                    'FontFamily' => 'Calibri',
                                                    'Bold'       => 1,
                                                    'Pattern'    => 1,
                                                    'border'     => 1,
                                                    'FgColor'    => 'gray'));
          $format2->setTextWrap();

          $format3    =& $workbook->addFormat(array('Size'       => 10,
                                                    'Align'      => 'right',
                                                    'VAlign'     => 'vcenter',
                                                    'Color'      => 'aqua',
                                                    'FontFamily' => 'Calibri',
                                                    'Bold'       => 1,
                                                    'Pattern'    => 1,
                                                    'border'     => 1,
                                                    'FgColor'    => 'gray'));
          $format3->setTextWrap();

          $format4    =& $workbook->addFormat(array('Size'       => 10,
                                                    'Align'      => 'left',
                                                    'VAlign'     => 'vcenter',
                                                    'Color'      => 'black',
                                                    'FontFamily' => 'Calibri',
                                                    'Bold'       => 1,
                                                    'Pattern'    => 1,
                                                    'border'     => 1,
                                                    'FgColor'    => 'white'));
          $format4->setTextWrap();

          $format5    =& $workbook->addFormat(array('Size'       => 10,
                                                    'Align'      => 'right',
                                                    'VAlign'     => 'vcenter',
                                                    'Color'      => 'black',
                                                    'FontFamily' => 'Calibri',
                                                    'Pattern'    => 1,
                                                    'border'     => 1,
                                                    'FgColor'    => 'white'));
          $format5->setTextWrap();


          $format6    =& $workbook->addFormat(array('Size'       => 10,
                                                    'Align'      => 'left',
                                                    'VAlign'     => 'vcenter',
                                                    'Color'      => 'black',
                                                    'FontFamily' => 'Calibri',
                                                    'Bold'       => 1,
                                                    'Pattern'    => 1,
                                                    'border'     => 1,
                                                    'FgColor'    => 'yellow'));
          $format6->setTextWrap();

          $format7    =& $workbook->addFormat(array('Size'       => 10,
                                                    'Align'      => 'right',
                                                    'VAlign'     => 'vcenter',
                                                    'Color'      => 'black',
                                                    'FontFamily' => 'Calibri',
                                                    'Bold'       => 1,
                                                    'Pattern'    => 1,
                                                    'border'     => 1,
                                                    'FgColor'    => 'yellow'));
          $format7->setTextWrap();

          $format8    =& $workbook->addFormat(array('Size'       => 11,
                                                    'Align'      => 'left',
                                                    'VAlign'     => 'vcenter',
                                                    'Color'      => 'black',
                                                    'FontFamily' => 'Calibri',
                                                    'Bold'       => 1,
                                                    'Pattern'    => 1,
                                                    'border'     => 0,
                                                    'FgColor'    => 'white'));
          $format8->setTextWrap();

          $format9    =& $workbook->addFormat(array('Size'       => 10,
                                                    'Align'      => 'right',
                                                    'VAlign'     => 'vcenter',
                                                    'Color'      => 'white',
                                                    'FontFamily' => 'Calibri',
                                                    'Pattern'    => 1,
                                                    'border'     => 1,
                                                    'FgColor'    => 'red'));
          $format9->setTextWrap();

          $format10   =& $workbook->addFormat(array('Size'       => 10,
                                                    'Align'      => 'right',
                                                    'VAlign'     => 'vcenter',
                                                    'Color'      => 'white',
                                                    'FontFamily' => 'Calibri',
                                                    'Bold'       => 1,
                                                    'Pattern'    => 1,
                                                    'border'     => 1,
                                                    'FgColor'    => 'red'));
          $format10->setTextWrap();

        //----------------------------------------------------------------------------------------------------
          set_time_limit(0);

          $worksheet1 =& $workbook->addWorksheet('Raport DPPPP');

          $worksheet1->write(0,  0,  "", $format8);
          $worksheet1->write(0,  1,  "", $format8);
          $worksheet1->write(0,  2,  "", $format8);
          $worksheet1->write(0,  3,  "", $format8);
          $worksheet1->write(0,  4,  "", $format8);
          $worksheet1->write(0,  5,  "", $format8);
          $worksheet1->write(0,  6,  "", $format8);
          $worksheet1->write(0,  7,  "", $format8);
          $worksheet1->write(0,  8,  "", $format8);
          $worksheet1->write(0,  9,  "", $format8);
          $worksheet1->write(0, 10,  "", $format8);
          $worksheet1->write(0, 11,  "", $format8);
          $worksheet1->write(0, 12,  "", $format8);

          $worksheet1->write(1,  0, "", $format8);
          $worksheet1->write(1,  1, "Raport per DPPPP ( periudha ". $v_dt1 ." - ". $v_dt2 .")", $format8);
          $worksheet1->write(1,  2, "", $format8);
          $worksheet1->write(1,  3, "", $format8);
          $worksheet1->write(1,  4, "", $format8);
          $worksheet1->write(1,  5, "", $format8);
          $worksheet1->write(1,  6, "", $format8);
          $worksheet1->write(1,  7, "", $format8);
          $worksheet1->write(1,  8, "", $format8);
          $worksheet1->write(1,  9, "", $format8);
          $worksheet1->write(1, 10, "", $format8);
          $worksheet1->write(1, 11, "", $format8);
          $worksheet1->write(1, 12, "", $format8);
          $worksheet1->setMerge(1, 1, 1, 11);

          $worksheet1->write(2,  0,  "", $format8);
          $worksheet1->write(2,  1,  "", $format8);
          $worksheet1->write(2,  2,  "", $format8);
          $worksheet1->write(2,  3,  "", $format8);
          $worksheet1->write(2,  4,  "", $format8);
          $worksheet1->write(2,  5,  "", $format8);
          $worksheet1->write(2,  6,  "", $format8);
          $worksheet1->write(2,  7,  "", $format8);
          $worksheet1->write(2,  8,  "", $format8);
          $worksheet1->write(2,  9,  "", $format8);
          $worksheet1->write(2, 10,  "", $format8);
          $worksheet1->write(2, 11,  "", $format8);
          $worksheet1->write(2, 12,  "", $format8);

          $worksheet1->setRow(3, 30);
          $worksheet1->write(3,  0,  "", $format8);
          $worksheet1->write(3,  1, "Date TRNX", $format1);
          $worksheet1->write(3,  2, "Vlera e dale", $format1);
          $worksheet1->write(3,  3, "Monedha", $format1);
          $worksheet1->write(3,  4, "Vlera e hyre", $format1);
          $worksheet1->write(3,  5, "Monedha", $format1);
          $worksheet1->write(3,  6, "Emri", $format1);
          $worksheet1->write(3,  7, "Mbiemri", $format1);
          $worksheet1->write(3,  8, "Datelindje", $format1);
          $worksheet1->write(3,  9, "Nr. dokumenti", $format1);
          $worksheet1->write(3, 10, "Emri kompanise", $format1);
          $worksheet1->write(3, 11, "NIPT", $format1);
          $worksheet1->write(3, 12, "", $format8);

          $worksheet1->setColumn( 0,  0,  2);
          $worksheet1->setColumn( 1,  1, 15);
          $worksheet1->setColumn( 2,  2, 20);
          $worksheet1->setColumn( 3,  3, 10);
          $worksheet1->setColumn( 4,  4, 20);
          $worksheet1->setColumn( 5,  5, 10);
          $worksheet1->setColumn( 6,  6, 20);
          $worksheet1->setColumn( 7,  7, 20);
          $worksheet1->setColumn( 8,  8, 15);
          $worksheet1->setColumn( 9,  9, 15);
          $worksheet1->setColumn(10, 10, 25);
          $worksheet1->setColumn(11, 11, 15);
          $worksheet1->setColumn(12, 12,  2);

          $v_rowno = 3;

                $v_row = 0;
                while ($row_RepInfo) {  $v_row ++;


                    $v_rowno ++;
                    $worksheet1->write($v_rowno,        0, "", $format8);
                    $worksheet1->write($v_rowno,        1, $row_RepInfo['date_trans'], $format4);

                    $worksheet1->writeNumber($v_rowno,  2, number_format( $row_RepInfo['vleftapaguar'], 2, '.', ''), $format5);
                    $worksheet1->write($v_rowno,        3, $row_RepInfo['monedha1'], $format4);
                    $worksheet1->writeNumber($v_rowno,  4, number_format( $row_RepInfo['vleftadebituar'], 2, '.', ''), $format5);
                    $worksheet1->write($v_rowno,        5, $row_RepInfo['monedha2'], $format4);

                    $worksheet1->write($v_rowno,        6, $row_RepInfo['emri'], $format4);
                    $worksheet1->write($v_rowno,        7, $row_RepInfo['mbiemri'], $format4);
                    $worksheet1->write($v_rowno,        8, $row_RepInfo['dob'], $format4);
                    $worksheet1->write($v_rowno,        9, $row_RepInfo['nrpashaporte'], $format4);
                    $worksheet1->write($v_rowno,       10, $row_RepInfo['emrikompanise'], $format4);
                    $worksheet1->write($v_rowno,       11, $row_RepInfo['nipt'], $format4);

                    $worksheet1->write($v_rowno,       12, "", $format8);


                    $row_RepInfo = $RepInfoRS->fetch_assoc();
                }
                mysqli_free_result($RepInfoRS);

             $v_rowno ++;
             $worksheet1->write($v_rowno,  0,  "", $format8);
             $worksheet1->write($v_rowno,  1,  "", $format8);
             $worksheet1->write($v_rowno,  2,  "", $format8);
             $worksheet1->write($v_rowno,  3,  "", $format8);
             $worksheet1->write($v_rowno,  4,  "", $format8);
             $worksheet1->write($v_rowno,  5,  "", $format8);
             $worksheet1->write($v_rowno,  6,  "", $format8);
             $worksheet1->write($v_rowno,  7,  "", $format8);
             $worksheet1->write($v_rowno,  8,  "", $format8);
             $worksheet1->write($v_rowno,  9,  "", $format8);
             $worksheet1->write($v_rowno, 10,  "", $format8);
             $worksheet1->write($v_rowno, 11,  "", $format8);
             $worksheet1->write($v_rowno, 12,  "", $format8);
           //----------------------------------------------------
             $workbook->close();
           //----------------------------------------------------
?>
<table width="100%" border="0">
  <tr>
    <td width="10px"></td>
    <td>
        <DIV class=ctxheading>
           <b>Skedari u krijua me sukses (excel)</b>
                       <div class="titull_box_grid">
                        <table width="95%" border="0">
                          <tr bgcolor="#A7CCBA">
                            <td class="titullheader"> &nbsp;&nbsp;Skedari <?php echo $v_row; ?> :&nbsp;</td>
                            <td class="titullheader"> &nbsp;<b><a href="<?php echo $v_file; ?>"><?php echo $v_file; ?><a></b></td>
                          </tr>
                        </table>
        </div>
    </td>
    <td width="10px"></td>
  </tr>
</table>
<?php
         }
      //---------------------------------------------------------------
  }
?>

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
  e.shiftKey  || 
  
  // Disable Alt
  e.altKey  || 
  
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
