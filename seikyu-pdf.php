<?php 
  if (session_status() == PHP_SESSION_NONE) {
    // セッションは有効で、開始していないとき
    session_start();
  }
  require_once 'connect.php';

  $skID = $_SESSION['skID'];
  $sql = 'select tk_mei,seikyubi,ow_mei, ow_zip,ow_jusho,ginko
  from seikyu
  left join tokuisaki using(tk_id)
  left join seikyusha using(ow_id)
  where sk_id = ?';
  $sth = $pdo-> prepare($sql);
    $sth -> bindValue( 1, $skID, PDO::PARAM_INT);
    $sth -> execute(); 
    $row = $sth->fetchAll(PDO::FETCH_ASSOC)[0];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>請求書発行管理</title>
</head>

<body>
  <article class="section">
    <div class="container">
      <h1 class="title"><span>請求書</span></h1>
      <div class="_ID">No. <span class="_ID"><?=$skID?></span></div>

      <section class="row2">
        <div class="tkName"><span class="_tkName"> <?=$row['tk_mei']?></span> 様</div>
        <div class="date">請求日: <span class="_date"><?=$row['ow_jusho']?></span></div>
      </section>

      <section class="row3">
        <div class="tkName"> </div>
        <div class="owZip">
          〒<span class="_owZip"><?=$row['ow_jusho']?></span> <span class="_owAddr"><?=$row['seikyubi']?></span>  
        </div>
      </section>

      <section class="row3">
        <div class="tkName"> </div>
        <span class="_owName"><?=$row['ow_mei']?></span>
      </section>

      <section class="table_wrap">
        <table class="table is-bordered is-fullwidth">
          <tbody>
            <tr>
              <th>科目名</th><th>数量</th><th>単位</th><th>単価</th><th>金額</th><th>備考</th>
            </tr>
<?php

$sql = 'select km_id, km_mei, suryo, u.tani, u.tanka, biko
  from uchiwake as u
  left join kamoku using(km_id)
  where sk_id = ?';
  $sth = $pdo-> prepare($sql);
    $sth -> bindValue( 1, $skID, PDO::PARAM_INT);
    $sth -> execute(); 
    $value = $sth->fetchAll(PDO::FETCH_ASSOC);
    krsort($value);

  $gokei  = 0;
  $tr = '<tr>';
  foreach ($value as $key => $val ) {
    if($val['km_id'] > 99 )
      $shokei = $val['suryo']*$val['tanka'];
    else
      $shokei = $val['tanka']; //税なら数量を掛けない｣

    $tr .= "<td>{$val['km_mei']}</td> 
    <td>{$val['suryo']}</td> 
    <td>{$val['tani']}</td> 
    <td>{$val['tanka']}</td> 
    <td>{$shokei}</td>
    <td>{$val['biko']}</td> 
    </tr>"; 
    $gokei += $shokei;
  }
    echo $tr;
?>
          </tbody>
        </table>
      </section>

      <section class="footer_wrap">
        <div class="owBank"><span class="_owBank"><?= str_replace( '\n','<br>',$row['ginko']) ?></span></div>
        <div class="total">
          <div class="gokei">合計</div>
          <div class="kingak">&yen <?= $gokei ?></div>
        </div>
      </section>

    </div>
  </article>
</body>

</html>