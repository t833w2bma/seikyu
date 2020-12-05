<?php session_start(); ?>

<link rel="stylesheet" href="style.css">
<h3>この内容で登録します</h3>

<?php
// var_dump($_SESSION['taxs']);
//最初はこれだけ書く
// print_r($_POST);

foreach ($_POST as $key => $value) {
  if( !is_array($value)){
    $post[$key] = htmlspecialchars($value,ENT_QUOTES);
  }else{
    foreach ($value as $k => $v) {
      $post[$key][$k] = htmlspecialchars($v,ENT_QUOTES);
    }
  }
}
//torok.phpに渡すためSESSIONにも代入する
$_SESSION['post']=$post;

 $tkIDs = explode("\t" , $post['tkID'] );
 echo '<p>得意先ID: ', $tkIDs[0];
 echo '<p>得意先名: ' , $tkIDs[1];

 $_SESSION['post']['tkID']=$tkIDs[0]; //得意IDだけ上書きする
 $i=0; // 科目名を回しながら､数量と単価､小計金額､備考も全て出すためのカウンター
 echo '<table>
 <tr> <th>科目名</th> <th>数量</th> <th>単位</th> <th>単価</th> <th>金額</th> <th>備考</th></tr>';
 
  foreach ($post['kmID'] as $key) {
    echo "<tr><td> {$_SESSION['kamokus'][$key]} </td>
    <td>{$post['kmSuryo'][$i]} </td>
    <td>{$post['kmTani'][$i]} </td>
    <td>{$post['kmTanka'][$i]} </td>
    <td>{$post['shokei'][$i]} </td>
    <td>{$post['kmBiko'][$i]} </td><tr>
    ";
    $i++; //カウントアップして次の行
  }

  $taxs = $_SESSION['taxs'];
  echo " </table>";

  echo "<p> 合計: {$post['goke']} </p>
        <p> 請求者: {$post['owName']} 住所: {$post['owZip']} {$post['owAddr']} 
        <p> 口座: {$post['owBank']} </p>"
  ?>
<form action="torok.php" method="post">
  <input type="submit" value="登録する">
</form>

  <!--全部セッションで送るのでformにする必要はない-->
<a href="torok.php" class="look-like-button">登録する</a>
