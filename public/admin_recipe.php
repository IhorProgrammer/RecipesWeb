<link rel="stylesheet" href="recipe.css">
<form id="form_recipe" class="recipe-page" >
    <div class="row s12">
        <img class="col m5 s12 recipe-img" id="recipe_img_form" width="650" src="/image/recipes/<?=$recipe["image_url"]?>" onclick="document.getElementById('image_input').click();">
        <input type="file" id="image_input" name="image" accept=".png, .jpg, .jpeg, .webp" style="display:none;">

        <div class="col m7 s12">
            <div class="input-field col s12">
                <input name="title" id="title_input" type="text" class="validate" value="<?=$recipe["title"]?>" required>
                <label for="title_input">Назва блюда</label>
            </div>
            <div class="input-field col s12">
                <input name="short_info" id="short_info_input" type="text" class="validate" value="<?=$recipe["short_info"]?>" required>
                <label for="short_info_input">Опис:</label>
            </div>
            <div class="input-field col s12">
                <input name="servings" id="servings_input" type="text" class="validate" value="<?=$recipe["servings"]?>" required>
                <label for="servings_input">Кількість порцій:</label>
            </div>
            <div class="input-field col s12">
                <input name="preparation_time"  id="preparation_time_input" type="text" class="validate" value="<?=$recipe["preparation_time"]?>" required>
                <label for="preparation_time_input">Час приготування:</label>
            </div>

            <div class="chips chips-placeholder col s12"></div>
        </div>  
    </div>
    <div class="ingredients">
        <ul id="ingredients_list" class="collection with-header">
            <li class="collection-header row">
                <h4 class="col">Інгредієнти</h4>
                <a id="add_ingredient"class="btn-floating btn-medium waves-effect waves-light red right"><i class="material-icons">add</i></a>
            </li>
            <?php foreach ($recipe["ingredients"] as $index => $ingredient): ?>
                <li class="collection-item row">
                    <div class="input-field col s4">
                        <input id="ingredient_name_input_<?= $index ?>" type="text" class="validate" name="ingredient_name_input_<?= $index ?>" value="<?= $ingredient->name ?>" required>
                        <label for="ingredient_name_input_<?= $index ?>">назва</label>
                    </div>
                    <div class="input-field col s2">
                        <input id="ingredient_quantity_input_<?= $index ?>" type="text" class="validate" name="iingredient_quantity_input_<?= $index ?>" value="<?= $ingredient->quantity ?>" required>
                        <label for="ingredient_quantity_input_<?= $index ?>">кількість</label>
                    </div>
                    <div class="input-field col s2">
                        <input id="ingredient_unit_input_<?= $index ?>" type="text" class="validate" name="ingredient_unit_input_<?= $index ?>" value="<?= $ingredient->unit ?>" required>
                        <label for="ingredient_unit_input_<?= $index ?>">одиниця виміру</label>
                    </div>
                    <a class="btn-floating btn-medium waves-effect waves-light right"><i class="material-icons">close</i></a>
                </li>
            <?php endforeach; ?>
       </ul>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <textarea name="description" id="description_textarea" class="materialize-textarea"><?=$recipe["description"]?></textarea>
            <label for="description_textarea">Опис готування:</label>
        </div>
    </div>

    <button type="submit" class="waves-effect waves-light btn-small red">Зберегти</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.chips');
        const options = {
            placeholder: 'Enter a tag',
            secondaryPlaceholder: '+Tag',
            data: [
                <?php foreach ($recipe["tags"] as $tag): ?>
                    {tag: '<?= htmlspecialchars($tag->name) ?>'},
                <?php endforeach; ?>
            ],
        };
        const instances = M.Chips.init(elems, options);

        const buttonsRemove = document.querySelectorAll('.collection-item .btn-floating');
        buttonsRemove.forEach(el => el.addEventListener('click', (e) => {
            var liParent = e.target.closest('li');
            if (liParent) { 
                liParent.remove(); 
            }
        }));

        const addIngredientButton = document.getElementById("add_ingredient")
        let index = 1000;
        addIngredientButton.addEventListener('click', () => {
            // Створення нового елемента li
            const elem = document.createElement("li");
            elem.classList.add("collection-item", "row");

            // Поточний індекс, потрібно передати з сервера або обрахувати на клієнті
            index++; // Приклад індекса, його потрібно налаштувати правильно

            // Встановлення HTML вмісту для нового елемента
            elem.innerHTML = `
                <div class="input-field col s4">
                    <input id="ingredient_name_input_${index}" type="text" class="validate" name="ingredient_name_input_${index}" required>
                    <label for="ingredient_name_input_${index}">назва</label>
                </div>
                <div class="input-field col s2">
                    <input id="ingredient_quantity_input_${index}" type="text" class="validate" name="ingredient_quantity_input_${index}" required>
                    <label for="ingredient_quantity_input_${index}">кількість</label>
                </div>
                <div class="input-field col s2">
                    <input id="ingredient_unit_input_${index}" type="text" class="validate" name="ingredient_unit_input_${index}" required>
                    <label for="ingredient_unit_input_${index}">одиниця виміру</label>
                </div>
                <a class="btn-floating btn-medium waves-effect waves-light right"><i class="material-icons">close</i></a>
            `;

            // Додавання нового елемента в список
            const p = document.getElementById("ingredients_list");
            p.append(elem);
        });
    });
</script>

