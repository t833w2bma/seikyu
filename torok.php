<?php  
/* [torok.php]
  受け取ったデータを請求テーブルと､内訳テーブルに入れる
  やりかた
    セッションを開始して､セッション変数をループ
    ループして取り出した値を請求と､内訳に分岐
    分岐したデータでINSERT文を作る
    データベースに接続
    トランザクション開始 
    SQL文実行 x 2
    コミットして完了 → 印刷イメージの表示
    エラーでロールバック → エラーメッセージの表示
sk_id	    int(11) 連番	
tk_id	   int(11)	
tax_id  	int(11)	
ow_id   	int(11)	
seikyubi	date	

sk_id	int(11) 	
km_id	int(11)	
suryo	int(11)	
tani	varchar(10) NULL	
tanka	decimal(10,0)	
biko	varchar(255) NULL	
*/
session_start();

// 同じブラウザで並行処理すると上書きされるので別の変数に代入する
$post = $_SESSION['post'];

$seikyu = ['tkID','ownid','date'];
$uchiwake = ["kmID",'kmSuryo','kmTani','kmTanka','kmBiko'	];
$seikyu_val = '';
$uchiwake_val = '';

require_once 'connect.php';

// postを回してデータを分ける
  // var_dump( $post); exit;

  try{  // try文でエラーの捕捉
					
    $pdo->beginTransaction(); // 4.トランザクション開始の宣言
    // 請求テーブルに入る方
    $q = 1;
    $sql = 'INSERT INTO seikyu( tk_id, ow_id ,seikyubi) VALUES(?,?,?)';
    $sth = $pdo-> prepare($sql);
    $sth -> bindValue($q++, $post['tkID'], PDO::PARAM_INT);
    $sth -> bindValue($q++, $post['ownid'], PDO::PARAM_INT);
    $sth -> bindValue($q++, $post['date'], PDO::PARAM_STR);
    $sth -> execute(); // SQL実行

    //内訳に入る方 全部2次元
    $_SESSION['skID'] = $skID = $pdo->lastInsertId();  // A_I のsk_id
    $count = count($post['kmID']); //行数を数える
    $q = 1;

    for($i=0; $i < $count; $i++){
        $sql = 'INSERT INTO uchiwake (sk_id,km_id,suryo,tani,tanka,biko) VALUES (?,?,?,?,?,?)';
        $sth = $pdo-> prepare($sql);
        $sth -> bindValue(1, $skID, PDO::PARAM_INT);
        $sth -> bindValue(2, $post['kmID'][$i], PDO::PARAM_INT);
        $sth -> bindValue(3, $post['kmSuryo'][$i], PDO::PARAM_INT);
        $sth -> bindValue(4, $post['kmTani'][$i], PDO::PARAM_STR);
        $sth -> bindValue(5, $post['kmTanka'][$i], PDO::PARAM_INT);
        $sth -> bindValue(6, $post['kmBiko'][$i], PDO::PARAM_STR);
        $sth -> execute(); // SQL実行

    }
    
    $success=$pdo->commit();  

  }catch(PDOException $err){  // 例外エラー捕捉  
   echo '例外エラー : ', $err;
     $pdo->rollBack(); 
  }

  if($success){
    header('Location: seikyu-pdf.php'); exit;
   }else 
   "<h2>何かしらエラーらしいです</h2>";
