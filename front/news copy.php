<div class="di" style="height:540px; border:#999 1px solid; width:53.2%; margin:2px 0px 0px 0px; float:left; position:relative; left:20px;">
	<?php include "./front/marquee.php"; ?>
	<div style="height:32px; display:block;"></div>
	<!--正中央-->
	<!--正中央-->
	<h3>更多最新消息顯示區</h3>
	<hr>
	<?php
	//建立分頁所需的變數
	$total = $DB->count(['sh' => 1]);
	$div = 5;
	$pages = ceil($total / $div);
	$now = $_GET['p'] ?? 1;
	$start = ($now - 1) * $div;

	//取得當前頁所需的資料
	$news = $News->all(['sh' => 1], " limit $start,$div");
	?>
	<!--使用<ol>標籤的特性來設定列表資料的起始值-->
	<ol start='<?= $start + 1; ?>'>
		<?php
		//利用迴圈來讀出資料內容
		foreach ($news as $n) {
			echo "<li class='sswww'>";
			echo mb_substr($n['text'], 0, 20);
			echo "<div class='all' style='display:none'>";
			echo $n['text'];
			echo "</div>";
			echo "...</li>";
		} ?>
	</ol>
	<div class="cent">
		<?php
		if ($now > 1) {
			$prev = $now - 1;
			echo "<a href='?do=$do&p=$prev'> < </a>";
		}

		for ($i = 1; $i <= $pages; $i++) {
			$fontsize = ($now == $i) ? '24px' : '16px';
			echo "<a href='?do=$do&p=$i' style='font-size:$fontsize'> $i </a>";
		}

		if ($now < $pages) {
			$next = $now + 1;
			echo "<a href='?do=$do&p=$next'> > </a>";
		}
		?>
	</div>
</div>