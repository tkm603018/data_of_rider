<HTML>
<HEAD>
  <TITLE>選手データ更新処理スクリプト</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

<!-- ここからPHPのスクリプト始まり -->
<?php

// フォームから渡された引数を取得
$rider_id = $_GET[ rider_id ];
$team_id = $_GET[ team_id ];
$rider_name = $_GET[ rider_name ];
$age = $_GET[ age ];
$nationality = $_GET[ nationality ];
$height = $_GET[ height ];
$weight = $_GET[ weight ];

// データベースに接続
// ※ your_db_name のところは自分のデータベース名に書き換える
$conn = pg_connect( "dbname=abcp7358" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

// データ更新のSQLを作成
// ※ 課題：どのようなSQLを作成したら良いか自分で考えてみよ
$sql = "update rider set team_id='$team_id',rider_name='$rider_name',age='$age',nationality='$nationality',height='$height',weight='$weight' where rider_id='$rider_id'";

// 確認用のメッセージ表示
print( "クエリー「" );
print( $sql );
print( "」を実行します。<BR>" );

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

データの更新処理が完了しました。<BR>
<BR>
<A HREF="menu.html">操作メニューに戻る</A>

</BODY>
</HTML>
