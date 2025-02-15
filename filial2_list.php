<?php

session_start();

?>
<html>
<head>
<title><?php echo $_SESSION['CNAME']; ?> - Web Exchange System</title>
<script language="JavaScript">
<!-- Begin

function return_value(p_url) {

    opener.document.formmenu.id_klienti.value = p_url;

    self.close();
    return false;
}

//  End -->
</script>

<style type="text/css">
<!--
body,td,th {
    color: #000000;
}
body {
    background-color: #FFFFFF;
    margin-left: 0px;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
}
-->
</style>

<link href="styles.css" rel="stylesheet" type="text/css">

</head>

<body>
<center>
<?php

    require_once('ConMySQL.php');

    $v_wheresql = " ";
    //if ($_SESSION['Usertype'] == 3)  $v_wheresql = " where id = ". $_SESSION['Userfilial'] ." ";

    $query_filiali_info = "select * from filiali ". $v_wheresql ." order by filiali asc";
    $filiali_info = mysql_query($query_filiali_info, $MySQL) or die(mysql_error());
    $row_filiali_info = mysql_fetch_assoc($filiali_info);

?>
<table width="300" height="100%" border="0">
  <tr>
    <td height="43" colspan="3"><DIV class=ctxheading>Perzgjidh nga lista</DIV></td>
  </tr>
  <tr valign="top">
    <td width="80%" align="center">

<table width="300" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td height="1" width="10" align="center" class="titull"></td>
        <td height="1" width="280" align="center" class="titull"></td>
        <td height="1" width="10" align="center" class="titull"></td>
    </tr>
<?php  while ($row_filiali_info) {  ?>
    <tr bgcolor="#080570">
        <td height="1" colspan="3" align="center" class="titull"></td>
    </tr>
    <tr bgcolor="#99FFCC">
        <td class="titull"></td>
        <td height="16"><a href="JavaScript: return_value('<?php echo $row_filiali_info['id']; ?>');" class="link4"><b><?php echo $row_filiali_info['filiali']; ?></b></a></td>
        <td class="titull"></td>
    </tr>
<?php      $row_filiali_info = mysql_fetch_assoc($filiali_info);
       }
    mysqli_free_result($filiali_info);
?>
    <tr bgcolor="#080570">
        <td height="1" colspan="3" align="center" class="titull"></td>
    </tr>
    <tr>
        <td height="5" colspan="3" align="center" class="titull"></td>
    </tr>
</table>
</center>
<br>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>

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
