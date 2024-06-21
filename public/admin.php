      
<section class="col s12 row">
    <aside class="sidebar-menu-blk col s12 m4 l6 xl4 p0">
        <ul class="eat-catg">
            <li>
                <div class="catg-hdr">що приготовити</div>
                <ul class="sidebar-menu browser-default">
                    <li><a href="?tag=92">сніданок</a></li>
                    <li><a href="?tag=94">вечеря</a></li>
                    <li><a href="?tag=101">обід</a></li>
                    <li><a href="?tag=107">полудень</a></li>
                </ul>
            </li>
            <li>
                <div class="catg-hdr red-bgn">повсякденні рецепти</div>
                <ul class="sidebar-menu browser-default">
                    <li><a href="?tag=105">салати</a></li>
                    <li><a href="?tag=167">закуски</a></li>
                    <li><a href="?tag=156">десерти</a></li>
                    <li><a href="?tag=143">соуси</a></li>
                    <li><a href="?tag=145">приправи</a></li>
                    <li><a href="?tag=154">випічка</a></li>
                    <li><a href="?tag=162">гарнір</a></li>
                </ul>
            </li>
            <li>
                <div class="catg-hdr orange-bgn">Рецепти на особливий випадок</div>
                <ul class="sidebar-menu browser-default">
                    <li><a href="?tag=163">вегетаріанські</a></li>
                    <li><a href="?tag=176">ліниві рецепти</a></li>
                    <li><a href="?tag=182">рецепти на літо</a></li>
                    <li><a href="?tag=193">рецепти на зиму</a></li>
                    <li><a href="?tag=196">дешеві рецепти</a></li>
                </ul>
            </li>
            <li>
                <div class="catg-hdr blue-bgn">На праздник</div>
                <ul class="sidebar-menu browser-default">
                    <li><a href="?tag=199">пасха</a></li>
                    <li><a href="?tag=205">день народження</a></li>
                    <li><a href="?tag=210">новий рік</a></li>
                </ul>
            </li>
            <li>
                <div class="catg-hdr light-green-bgn">Кухня народів світу</div>
                <ul class="sidebar-menu browser-default">
                    <li><a href="?tag=215">Українські рецепти</a></li>
                    <li><a href="?tag=218">Арабські рецепти</a></li>
                    <li><a href="?tag=150">Індийскі рецепти</a></li>
                    <li><a href="?tag=227">Грузинскі рецепти</a></li>
                    <li><a href="?tag=234">Вірменські рецепти</a></li>
                </ul>
            </li>
        </ul>
    </aside>
    <?php foreach ($recipes as $rec): ?>
        <div class="col s12 m8 l6 xl4">
            <div class="card">
                <div class="card-image">
                    <img src="image/recipes/<?php echo $rec['image_url'];?>" alt="<?php echo $rec['title'];?>">
                </div>
                <div class="card-content">
                    <p class="title"><?php echo $rec['title'];?></p>
                    
                    <p>
                        <?php echo $rec['short_info'];?>
                    </p>
                </div>
                <div class="card-action">
                    <a class="eat-info-btn" href="admin-recipe?id=<?php echo $rec['id'];?>">Редагувати</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</section>
