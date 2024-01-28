<!--因為是獨立的功能，而且會使用到資料表，所以要先include base.php進來使用-->
<?php include_once "../api/db.php";?>
<h3>編輯次選單</h3>
<hr>
<form action="./api/submenu.php" method="post" enctype="multipart/form-data">
<table class='cent' id='sub'>
    <tr>
        <td>次選單名稱</td>
        <td>次選單連結網址</td>
        <td>刪除</td>
    </tr>
    <?php
    //ajax的請求中會在網址中帶入id參數，利用此id參數，我們可以取得主選單下的所有次選單
    $subs=$Menu->all(['menu_id'=>$_GET['id']]);
    foreach($subs as $sub){
    ?>
    <tr>
        <td>
            <input type="text" name="text[]" value="<?=$sub['text'];?>">
        </td>
        <td>
            <input type="text" name="href[]" value="<?=$sub['href'];?>">
        </td>
        <td>
            <input type="checkbox" name="del[]" value="<?=$sub['id'];?>">
        </td>
        <input type="hidden" name="id[]" value="<?=$sub['id'];?>">
    </tr>
    <?php
    }
    ?>
</table>
<div>
    <input type="hidden" name="table" value="<?=$_GET['table'];?>">
            <!--將主選單的id加入到隱藏欄位中，
                讓後台的api知道這個表單的次選單資料是屬於那個主選單的-->
    <input type="hidden" name="menu_id" value="<?=$_GET['id'];?>">
    <input type="submit" value="修改確定">
    <input type="reset" value="重置">
    <input type="button" value="更多次選單" onclick="more()">
</div>

</form>
<script>
/**
 * 新增次選單的js函式
 */
function more(){
    //宣告一個次選單的html字串
    let item=`<tr>
                <td><input type="text" name="add_text[]" id=""></td>
                <td><input type="text" name="add_href[]" id=""></td>
              </tr>`
    //使用append()函式將html字串，添加到列表的最後面    
    $("#sub").append(item);
}
</script>