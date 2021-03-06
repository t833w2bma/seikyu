<?php session_start() ?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>請求書発行管理</title>
  <link rel="stylesheet" href="style.css?v=1">
</head>

<body>

  <div class="container">

    <header>
      <h1 class="title"> 請求書<small>[見本]</small></h1>
    </header>


    <form action="confirm.php" method="post">

      <div class="seikyu-data">
        <select name="tkID" id="tkID" required>
          <option value="">宛先社名</option>
<?php
// DBに接続
require_once 'connect.php';
  //テーブルの全ての行の欲しい列だけ  
  $sql=$pdo->prepare('select tk_id, tk_mei from tokuisaki ');
  $sql->execute();
  // テーブルの行を回す
    foreach ($sql as $row) {
      // 0列目は値に､1列目は表示用にする
      echo "<option value='$row[0]\t$row[1]'>$row[1]</option>";
    }

?> 
        </select>

        <label class="label _date">請求日</label>
        <input class="input" type="date" name="date" value="<?= date('Y-m-d');?>" required>
      </div>

      <div class="own-data">
        <label class="ownid">請求者ID</label>
        <select name="ownid" id="ownid" class="ownid">
          <option value=""> </option>
          <option> 1</option>
          <option> 2</option>
          <option> 3</option>
        </select>

        <input class="input" type="text" name="owZip" placeholder="請求者 〒">

        <input class="input" type="text" name="owAddr" placeholder="請求者住所">

        <input class="input" type="text" name="owName" placeholder="請求者名前">
      </div>

      <div class="field">
        <div class="reject-print">
          <button class="button addRow" id="addRow"> 1行増やす </button>
        </div>

      <!-- 詳細テーブル -->
        <div class="column">
          <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <colgroup span="1" class="col-1">
            <colgroup span="2" class="col-23">
            <colgroup span="3" class="col-456">

            <thead>
              <tr> <th>科目名</th>
                <th>数量</th>
                <th>単位</th>
                <th>単価</th>
                <th>金額</th>
                <th>備考</th>
              </tr>
            </thead>

            <tbody id="orign">
              <!-- 増える行 -->
              <tr>
                <td>
                    <select name="kmID[]" class="kmIDcls">
                      <option value="">--科目名選択--</option>

  <?php
   //確認画面用に 1 => "サーバー保守" , の配列を作って､SESSIONに保存する
     $kamokus = [] ;
     $sql=$pdo->prepare('select km_id, km_mei from kamoku ');
     $sql->execute();
     // テーブルの行を回す
       foreach ($sql as $row) {
         // 0列目は値に､1列目は表示用にする
         echo "<option value='$row[0]'>$row[1]</option>";
         $kamokus[ $row[0] ] = $row[1] ; // 科目の配列を作る
       }
    $_SESSION['kamokus'] = $kamokus; //セッション変数に代入
  ?>                    
                    </select>
                </td>
                <td><input class="input kmSuryo" name="kmSuryo[]" type="text"></td>
                <td><input class="input kmTani" name="kmTani[]" type="text"></td>
                <td><input class="input kmTanka" name="kmTanka[]" type="text" placeholder="単価"></td>
                <td><input class="input shokei" type="text" value="" name="shokei[]" readonly=""></td>
                <td><textarea class="textarea kmBiko" name="kmBiko[]" rows="1"></textarea></td>
              </tr>
              <!-- 増える行ここまで -->


              <!-- TAX -->
              <tr>
                <td>
                    <select name="taxID" id="taxID">
                    </select>
                </td>
                <td><input class="input" name="taxSuryo" type="text" id="taxSuryo"></td>
                <td><input class="input" name="taxTani" type="text" id="taxTani"></td>
                <td><input class="input" name="taxTanka" type="text" id="taxTanka" placeholder="税"></td>
                <td><input class="input" name="taxNum" type="text" id="taxNum" readonly=""></td>
                <td><textarea class="textarea" name="taxBiko" rows="1"></textarea></td>
              </tr><!-- TAX -->

            </tbody>
          </table>

        </div><!--colmn-->

        <div class="row"> 
          <div class="col-6"><textarea class="textarea" name="owBank" rows="3" required></textarea></div>
          <div class="col-6 goke">
            <label class="label">合計</label>
            <input class="input" type="text" id="goke" name="goke">
          </div>

        </div>
        <button type="submit" class="button is-info" id="addRow"> 確認 </button>
      </div><!--field-->

    </form>


  </div> <!--container-->

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script>
  <?php
    include_once "seikyu.js.php";
  ?>

var dd = new Date();
//「年」を取得する
var yy = dd.getFullYear();
//「月」を取得する
var mm = dd.getMonth()+1;
//「日」を取得する
var DD = dd.getDate();
 $('.container').append("<time>" + yy + "/" + mm + "/" + DD + "</time>")

  </script>


</body>

</html>