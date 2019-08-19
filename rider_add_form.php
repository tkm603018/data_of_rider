<HTML>
<HEAD>
  <TITLE>選手データ追加フォーム（動的生成版）</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

選手データ 追加フォーム<BR><BR>

<FORM ACTION="rider_add.php" METHOD="GET">

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


// 最も大きな選手番号を取り出すSQLの作成
$sql = "select max(rider_id) from rider";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 最大の選手番号を取得
if ( pg_num_rows( $result ) > 0 )
	$max_rider_num = pg_fetch_result( $result, 0, 0 );
$max_rider_num ++;

// 選手番号の初期値を指定して入力エリアを作成
print( "選手番号：\n" );
printf( "<INPUT TYPE=text SIZE=3 NAME=rider_id VALUE=%04s>", $max_rider_id ); // 必ず3桁で出力、空白があれば0で埋める
print( "<BR>\n" );

// 検索結果の開放
pg_free_result( $result );


// チーム名一覧を取得するSQLの作成
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

// チーム名の数だけ選択肢を出力
print( "チーム名：\n" );
for ( $i=0; $i<$rows; $i++ )
{
	$team_id = pg_fetch_result( $result, $i, 0 );
	$dept_name = pg_fetch_result( $result, $i, 1 );
	printf( "<INPUT TYPE=\"radio\" NAME=\"team_id\" VALUE=\"%s\"> %s </INPUT>\n", $team_id, $team_name );
}

// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>


選手名：
<INPUT TYPE="text" SIZE="20" NAME="rider_name">
<br>

年齢：
<INPUT TYPE="text" SIZE="4" NAME="age">
<br>

国籍：
<INPUT TYPE="text" SIZE="15" NAME="nationality">
<br>

身長：
<INPUT TYPE="text" SIZE="3" NAME="height">
<br>

体重：
<INPUT TYPE="text" SIZE="2" NAME="weight">

<BR><BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

</BODY>
</HTML>
