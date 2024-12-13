
<h2>Новости</h2>
<?php foreach($data['newses'] as $news_data){ ?>
    <div style="margin-top: 20px;" class="text14">
        <a href="/newses/view/<?=$news_data['alias']?>"><?=$news_data['title']?></a>
    </div>

<?php } ?>