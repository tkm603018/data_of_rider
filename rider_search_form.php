<HTML>
<HEAD>
  <TITLE>選手の検索フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

<CENTER>

選手データ 検索フォーム<BR><BR>

検索したい選手のチームを選択して送信ボタンを押してください。<BR><BR>

<FORM ACTION="rider_search.php" METHOD="GET">

<!-- ここからPHPのスクリプト始まり -->
<?php

// データベースに接続
// ※ your_db_name のところは自分のデータベース名に書き換える
$conn = pg_connect( "dbname=abcp7358" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

// SQLを作成
$sql = "select team_id, team_name from team";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 検索結果を選択肢として表示
for ( $i=0; $i<$rows; $i++ )
{
	// チームの選択のためのラジオボタンを表示
	$team_id = pg_fetch_result( $result, $i, 0 );
	$team_name = pg_fetch_result( $result, $i, 1 );
	print( "<INPUT TYPE=\"radio\" NAME=\"team_id\" VALUE=\"$team_id\"> $team_name </INPUT></BR>\n" );
}

// 全てのチームの選択肢のラジオボタンを表示
print( "<INPUT TYPE=\"radio\" NAME=\"team_id\" VALUE=\"ALL\" CHECKED>全てのチーム</INPUT></BR>\n" );

// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

<BR>
<A HREF="menu.html">操作メニューに戻る</A>

</CENTER>

</BODY>
</HTML>

