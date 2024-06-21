<link rel="stylesheet" href="recipe.css">
<div class="recipe-page">
    <div class="row s12">
        <img class="materialboxed col m5 s12 recipe-img" width="650" src="/image/recipes/<?=$recipe["image_url"]?>">
        
        <div class="col m7 s12">
            <h1 class="center recipe-title"><?=$recipe["title"]?></h1>
            <p class="short_info"><strong>Опис:</strong> <?=$recipe["short_info"]?></p>
            <p class="servings"><strong>Кількість порцій:</strong> <?=$recipe["servings"]?></p>
            <p class="preparation_time"><strong>Час приготування:</strong> <?=$recipe["preparation_time"]?>хв</p>
            <p class="tags"><strong>Теги:</strong>
                <?php foreach ($recipe["tags"] as $tag): ?>
                    <a href="/recipes?tag=<?=$tag->id?>"><?=$tag->name?></a>, 
                <?php endforeach; ?>
            </p>
            <div class="ingredients">
                <p class="ingredients-title">Інгредієнти</p>
                <ul class="ingredients_list browser-default">
                    <?php foreach ($recipe["ingredients"] as $ingredient): ?>
                        <li><?= $ingredient->name ?> - <?= $ingredient->quantity ?> <?= $ingredient->unit ?></li>
                    <?php endforeach; ?>
                </ul> 
            </div>
        </div>  
    </div>
    
    <div class="description">
        <p class="description-title">Опис готування: </p>
        <p class="card-panel">
            <?=$recipe["description"]?>
        </p>
    </div>         
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.materialboxed');
        var instances = M.Materialbox.init(elems);
    });
</script>