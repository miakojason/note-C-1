<span class="t botli">最新消息區
    <?php
    //判斷資料表中設為顯示的資料筆數是否超過5筆
    if($News->count(['sh'=>1])>5){

        //如果超過5筆就輸出more連結，導向更多消息頁面　
        echo "<a href='?do=news' style='float:right'>More...</a>";
    }
    ?>
</span>