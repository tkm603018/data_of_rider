<HTML>
<HEAD>
  <TITLE>全選手の能力</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

<CENTER>

検索結果を表示します。<BR><BR>
ワンデイレース，総合，タイムトライアル，スプリントは獲得ポイントを表します．
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
$sql = "select result.rider_id,rider_name
,MAX(case result.seq when 1 then result.record end) as overall
,MAX(case result.seq when 2 then result.record end) as oneday
,MAX(case result.seq when 3 then result.record end) as general
,MAX(case result.seq when 4 then result.record end) as timetrial
,MAX(case result.seq when 5 then result.record end) as sprint 
from (select rider_id, record,row_number() over (partition by rider_id) as seq 
from result) result,event,rider 
where rider.rider_id = result.rider_id 
group by result.rider_id,rider_name 
order by result.rider_id";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数・列数を取得
$rows = pg_num_rows( $result );
$cols = pg_num_fields( $result );


// 検索結果をテーブルとして表示
print( "<TABLE BORDER=1>\n" );

// 各列の名前を表示
print( "<TR>" );
print( "<TH>選手番号</TH>" );
print( "<TH>選手名</TH>" );
print( "<TH>全体順位</TH>" );
print( "<TH>ワンデイレース</TH>" );
print( "<TH>総合</TH>" );
print( "<TH>タイムトライアル</TH>" );
print( "<TH>スプリント</TH>" );
print( "</TR>\n" );

// 各行のデータを表示
for ( $j=0; $j<$rows; $j++ )
{
	print( "<TR>" );
	for ( $i=0; $i<$cols; $i++ )
	{
		// j行i列のデータを取得
		$data = pg_fetch_result( $result, $j, $i );
		
		// セルに列の名前を表示
		print( "<TD> $data </TD>" );
	}
	print( "</TR>\n" );
}

// ここまででテーブル終了
print( "</TABLE>" );
print( "<BR>\n" );


// 検索件数を表示
print( "以上、$rows 件のデータを表示しました。<BR>\n" );


// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>
<A HREF="menu.html">操作メニューに戻る</A>

</CENTER>

</BODY>
</HTML>

