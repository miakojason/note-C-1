<?php
include_once "db.php";
/**
 * 判斷$_POST中沒有id這個項目，有的話表示有資料要編輯，
 * 沒有的話表示資料表中還沒有資料。
 */
if (isset($_POST['id'])) {
    foreach ($_POST['id'] as $idx => $id) {
        if (isset($_POST['del']) && in_array($id, $_POST['del'])) {
            $Menu->del($id);
        } else {
            $row = $Menu->find($id);
            $row['text'] = $_POST['text'][$idx];
            $row['href'] = $_POST['href'][$idx];
            $Menu->save($row);
        }
    }
}

//判斷$_POST中是否有add_text這個項目，有的話表示有資料要新增
if (isset($_POST['add_text'])) {

    //新增的資料可能多筆，因此使用迴圈來一筆一筆處理
    foreach ($_POST['add_text'] as $idx => $text) {

        //判斷$text的內容是否為空值，如果是空值則不新增
        if ($text != "") {
            $data = [];
            $data['text'] = $text;
            $data['href'] = $_POST['add_href'][$idx];
            $data['sh'] = 1;
            $data['menu_id'] = $_POST['menu_id'];

            $Menu->save($data);
        }
    }
}

//導回後台的選單管理頁面
to("../back.php?do=menu");
