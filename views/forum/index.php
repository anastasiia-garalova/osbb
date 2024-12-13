<h2>Форум нашого сайту</h2>
<?php foreach($data['forum'] as $thems_data){ ?>
    <div style="margin-top: 20px;">
        <a href="/forum/view/<?=$thems_data['id']?>"><?=$thems_data['name']?></a>
    </div>

<?php } ?>