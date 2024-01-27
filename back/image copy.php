<div style="width:99%; height:87%; margin:auto; overflow:auto; border:#666 1px solid;">
	<p class="t cent botli">校園映像資料管理</p>
	<form method="post" action="./api/edit.php">
		<table width="100%" style="text-align: center">
			<tr class="yel">
				<td width="70%">校園映像資料圖片</td>
				<td width="10%">顯示</td>
				<td width="10%">刪除</td>
				<td></td>
			</tr>
			<?php
			//建立分頁功能需要的參數及計算
			$total = $DB->count();
			$div = 3;
			$pages = ceil($total / $div);
			$now = $_GET['p'] ?? 1;
			$start = ($now - 1) * $div;

			//根據分頁計算結果取出當前頁的資料
			$rows = $DB->all(" limit $start,$div");
			foreach ($rows as $row) {
			?>
				<tr>
					<td>
						<img src="./img/<?= $row['img']; ?>" style="width:100px;height:68px">
						<input type="hidden" name="id[]" value="<?= $row['id']; ?>">
					</td>
					<td>
						<input type="checkbox" name="sh[]" value="<?= $row['id']; ?>" <?= ($row['sh'] == 1) ? 'checked' : ''; ?>>
					</td>
					<td>
						<input type="checkbox" name="del[]" value="<?= $row['id']; ?>">
					</td>
					<td>
						<input type="button" onclick="op('#cover','#cvr','./modal/upload.php?table=<?= $do; ?>&id=<?= $row['id']; ?>')" value="更換動畫">
					</td>
				</tr>
			<?php } ?>
		</table>
		<div class="cent">
			<?php
			//判斷是否有前一頁並建立前一頁的連結
			if ($now > 1) {
				$prev = $now - 1;
				echo "<a href='?do=$do&p=$prev'> < </a>";
			}

			//建立每一頁的連結
			for ($i = 1; $i <= $pages; $i++) {
				//判斷是否為當前頁，並給予不同的字型大小設定
				$fontsize = ($now == $i) ? '24px' : '16px';
				echo "<a href='?do=$do&p=$i' style='font-size:$fontsize'> $i </a>";
			}

			//判斷是否有下一頁並建立下一頁的連結
			if ($now < $pages) {
				$next = $now + 1;
				echo "<a href='?do=$do&p=$next'> > </a>";
			}
			?>
		</div>
		<table style="margin-top:40px; width:70%;">
			<tr>
				<input type="hidden" name="table" value="<?= $do; ?>">
				<td width="200px">
					<input type="button" onclick="op('#cover','#cvr','./modal/<?= $do; ?>.php?table=<?= $do; ?>')" value="新增校園映像資料圖片">
				</td>
				<td class="cent">
					<input type="submit" value="修改確定">
					<input type="reset" value="重置">
				</td>
			</tr>
		</table>
	</form>
</div>