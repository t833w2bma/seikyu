

 // 使用者IDを取得、配列に代入
var tkOwn = {
<?php 
     $sql=$pdo->prepare('select * from seikyusha ');
     $sql->execute();
     // テーブルの行を回す
       foreach ($sql as $row) {
         // 0列目は値に､1列目は表示用にする
         echo "$row[0]:[ '$row[1]','$row[2]','$row[3]','$row[4]' ],\n";
       }
?>  
};

// 税種の配列
var taxs = {<?= $taxs ?> };


//税収選択にDBから取得した行を埋め込む
var tax_op = '<option value="">--税種選択--</option>';

  for(let i in taxs ){
    tax_op += `<option value="${i}"> ${taxs[i][0]} </option>`;
  }
  $('#taxID').html( tax_op );



//請求者IDに1､2の選択肢を埋め込む
  var ownid_op = '<option value=""> </option>';
  for(let i in tkOwn ){
    ownid_op += '<option>' + i + '</option>';
  }
  $('#ownid').html(ownid_op );

  
$('#ownid').change(function () {
  var oid = $('#ownid').val();
    $('[name="owName"]').val(tkOwn[oid][0]);
 		$('[name="owZip"]').val(tkOwn[oid][1]);
 		$('[name="owAddr"]').val(tkOwn[oid][2]);
 		$('[name="owBank"]').val(tkOwn[oid][3]);
}); 


// 行を増やす
$('#addRow').click(function (event) { 
  // クリックイベントをキャンセル
  event.preventDefault();
  
  // 要素id='origin'の子の0番目の中身をタグごと取得しtrに代入
  var tr = $('#orign tr').prop('outerHTML');

  // originの最後の子要素の前に挿入｡beforeはそういうメソッド
  $('#orign tr:last-child').before( tr );
});


function taxClear(){
    //税種が指定されてたらクリア
  if( $('#taxID').val() != '' ){
    $('#taxID').val('');
    $('#taxSuryo').val('');
    $('#taxTanka').val('');
    $('#taxNum').val('');
    $('#goke').val('');
  }
}

/*
  単価を入れ終わったら小計を計算する(したい)
*/
// $('.kmTanka').change(function () { 
 $(document).on("change", ".kmTanka", function () {
    var suryo = $(this).parent().prev().prev().children().val();
    var tanka = $(this).val();      // 単価を取得
    var shokei = suryo * tanka;     // 小計を求める演算
    $(this).parent().next().children().val(shokei);
    taxClear();
});

// 数量を入れた場合も計算する
$(document).on("change", ".kmSuryo", function () {
    var tanka = $(this).parent().next().next().children().val();// 単価を取得
    var suryo = $(this).val();      
    var shokei = suryo * tanka;     // 小計を求める演算
    $(this).parent().next().next().next().children().val(shokei);
    taxClear();
});


//科目の重複チェック
  $(document).on("change", ".kmIDcls", function () {
    //今入れた値の取得
    var imaireta = $(this).val(); 
    //全部のtextBoxの値を取得
    var count = 0; //ここで初期化
      $('.kmIDcls').each(function(i,e){
        console.log(i,$(e).val(),count);
        // ここで比較する
        if( imaireta == $(e).val() ){
          ++count ; //カウントアップ
          if(count > 1){
            alert('重複してます!!');
            $(this).val(""); //カラ文字を与える 
          }
        } 
      });
  });


  
  // 税種のchangeでイベントを発火させる  
  $('#taxID').change(function(){
    var taxID = $(this).val(); // 選んだ1とか2
      $('#taxSuryo').val(taxs[taxID][1]); // 数量
      $('#taxTani').val(taxs[taxID][2]); // 単位

    var total = 0;

    //全部のshokeiの値をループして取得
      $('.shokei').each(function(i,e){
        if( $(e).val() != '' )  // カラじゃなければ
        total += parseInt( $(e).val());  //キャストして加算代入
      });

  //選択した税種によって分岐
    switch( taxID ){
     
      case "1": 
        //内税なら小計をいちいち税抜にしてみる
        var zk = 0; 
        var txTotal = 0; // 税金を累計
        var znTotal = 0; // 税抜小計を累計
       
        // 小計をループ
        $('.shokei').each(function(i,e){
          
          if( $(e).val() != '' ){ // カラじゃなければ
            zk = parseInt($(e).val());
            sk =  zk - Math.floor(zk/11) ; //元の小計から税額(切捨)を引く
            $(e).val(sk); // 小計を税抜の値段にする
            $(e).parent().prev().children().val(sk);; // 単価も税抜の値段にする
            txTotal += Math.floor(zk/11);
            znTotal += sk ;
          } 
        });

          $('#taxTanka').val(txTotal)  // 税 単価フィールドに値を埋め込む
          $('#taxNum').val(txTotal)  // 税 金額フィールドに値を埋め込む
          $('#goke').val( znTotal + txTotal )  //合計フィールドに値を埋め込む
        
      break;


      case "2": //源泉なら(一律でいい)
        var taxTanka = Math.floor(total * 0.1021); //税額
          $('#taxTanka').val(taxTanka)  // 税額フィールドに値を埋め込む
          $('#taxNum').val(taxTanka)  // 税額フィールドに値を埋め込む
          $('#goke').val(total - taxTanka)  //合計フィールドに値を埋め込む
      break;

      case "3": //外税なら
        var taxTanka = Math.floor(total * 0.1); //税額
          $('#taxTanka').val(taxTanka)  // 税額単価フィールドに値を埋め込む
          $('#taxNum').val(taxTanka ) // 税額フィールドに値を埋め込む
          $('#goke').val(total + taxTanka)  //合計フィールドに値を埋め込む
      break; 
    }

  });


// 今日の日付を入れる
  var hiduke=new Date(); 
  console.log(hiduke);