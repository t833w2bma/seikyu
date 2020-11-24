

 // 使用者IDを取得、配列に代入
var tkOwn = {
  1: ['自分', '010-0023', '秘密市広小路-10', '振込先：どこかの銀行　YU支店 （普通）3305082 口座名義：ジブン'],
  2: ['自分の名前', '010-0023', '秘密市広小路1-10', '振込先：あの銀行本店(支店番号:400) （普通）0336459 口座名義：ジブン'],
  3: ['自分の偽名', '010-0023', '秘密市広小路1-10', '振込先：秘密銀行 OP支店 （普通）0337350 口座名義：ジブン'],
};


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


/*
  単価を入れ終わったら小計を計算する(したい)
*/
// $('.kmTanka').change(function () { 
 $(document).on("change", ".kmTanka", function () {

  //var suryo = $('.kmSuryo').val(); // 数量を取得
  var suryo = $(this).parent().prev().prev().children().val();
  var tanka = $(this).val();      // 単価を取得
  var shokei = suryo * tanka;     // 小計を求める演算
  // $('.shokei').val(shokei);       // 小計フィールドに値を埋め込む
   $(this).parent().next().children().val(shokei);
});