<HTML>
<HEAD>
  <TITLE>選手データ更新フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

選手データ 更新フォーム<BR><BR>

<FORM ACTION="rider_update.php" METHOD="GET">

<!-- ここからPHPのスクリプト始まり -->
<?php

// 引数の選手番号を取得
$rider_id = (string) $_GET[ rider_id ];

// データベースに接続
// ※ your_db_name のところは自分のデータベース名に書き換える
$conn = pg_connect( "dbname=abcp7358" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

// 指定された選手番号の選手情報を取得するSQLを作成
$sql = sprintf( "select rider_id, team_id, rider_name, age, nationality, height, weight from rider where rider_id='%s'", $rider_id );

// Queryを実行して検索結果をresultに記録
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 選手が見つからなければエラーメッセージを表示
if ( pg_num_rows( $result ) == 0 )
{
	print( "指定された選手番号のデータが見つかりません。<BR>\n" );
	exit;
}

// 検索結果の選手の情報を変数に記録
$curr_team_id = pg_fetch_result( $result, 0, 0 );
$curr_name = pg_fetch_result( $result, 0, 1 );

// 検索結果の開放
pg_free_result( $result );

// 選手番号を更新スクリプトに渡す
printf( "<INPUT TYPE=hidden NAME=rider_id VALUE=%s>\n", $rider_id );


// チーム一覧を取得するSQLの作成
$sql = "select team_id, team_name, team_location,  maker_id from team";

// Queryを実行して検索結果をresultに記録
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 部門の数だけ選択肢を出力
print( "チーム：\n" );
for ( $i=0; $i<$rows; $i++ )
{
	$team_id = pg_fetch_result( $result, $i, 0 );
	$team_name = pg_fetch_result( $result, $i, 1 );
	
	if ( $team_id == $curr_team_id )
		$checked = "CHECKED";
	else
		$checked = "";
	
	printf( "<INPUT TYPE=radio NAME=team_id VALUE=%s %s> %s </INPUT>\n", $team_id, $checked, $team_name );
}

// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

// 選手名の入力フィールドを出力
print( "<BR>\n" );
print( "選手名：\n" );
printf( "<INPUT TYPE=text SIZE=30 NAME=rider_name VALUE=\"%s\">\n", $curr_rider_name );
print( "　\n" );

// 年齢の入力フィールドを出力
print( "年齢：\n" );
printf( "<INPUT TYPE=text SIZE=4 NAME=age VALUE=%s>\n", $curr_age );
print( "　\n" );

// 国籍の入力フィールドを出力
print( "国籍：\n" );
printf( "<INPUT TYPE=text SIZE=20 NAME=nationality VALUE=%s>\n", $curr_nationality );
print( "　\n" );

// 身長の入力フィールドを出力
print( "身長：\n" );
printf( "<INPUT TYPE=text SIZE=4 NAME=height VALUE=%s>\n", $curr_height );
print( "　\n" );

// 体重の入力フィールドを出力
print( "体重：\n" );
printf( "<INPUT TYPE=text SIZE=4 NAME=weight VALUE=%s>\n", $curr_weight );
?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>

<BR><BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

</BODY>
</HTML>
