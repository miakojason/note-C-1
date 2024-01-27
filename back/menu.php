<div style="width:99%; height:87%; margin:auto; overflow:auto; border:#666 1px solid;">
	<p class="t cent botli">選單管理</p>
	<form method="post" action="./api/edit.php">
		<table width="100%" style="text-align:center">
			<tr class="yel">
				<td width="45%">主選單名稱</td>
				<td width="23%">選單連結網址</td>
				<td width="23%">次選單數</td>
				<td width="7%">顯示</td>
				<td width="7%">刪除</td>
				<td></td>
			</tr>
			<?php
			$rows = $DB->all(['menu_id'=>0]);
			foreach ($rows as $row) {
			?>
				<tr>
					<td >
						<input type="text" name="text[]" value="<?= $row['text']; ?>">
					</td>
					<td >
						<input type="text" name="href[]" value="<?= $row['href']; ?>">
					</td>
					<td>
						<?=$Menu->count(['menu_id'=>$row['id']]);?>
					</td>
					<td>
						<input type="checkbox" name="sh" value="<?=$row['id'];?>"<?=($row['sh']==1)?'checked':'';?>>
					</td>
					<td>
						<input type="checkbox" name="del[]" value="<?=$row['id'];?>">
					</td>
					<td>
						<input type="button" onclick="op('#cover','#cvr','./modal/upload.php?table=<?=$do;?>&id=<?=$row['id'];?> ')" value="編輯次選單">
					</td>
				</tr>
				<input type="hidden" name="id[]" value="<?=$row['id'];?>">
			<?php
			}
			?>
		</table>
		<table style="margin-top:40px; width:70%;">
			<tr>
				<td width="200px">
					<input type="button" onclick="op('#cover','#cvr','./modal/<?= $do; ?>.php?table=<?=$do;?>')" value="新增網站標題圖片">
				</td>
				<td class="cent">
					<input type="hidden" name="table" value="<?=$do;?>">
					<input type="submit" value="修改確定">
					<input type="reset" value="重置">
				</td>
			</tr>
		</table>
	</form>
</div>