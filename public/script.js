document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("search");
    if( searchInput )
        searchInput.addEventListener('change', onChangeSearchInput);

    const url = new URL(window.location.href);
    const name = url.searchParams.get("name"); 
    if ( name && searchInput) {
        searchInput.value = name;
    }
    
    const formRecipe =  document.getElementById("form_recipe");
    if( formRecipe )
        formRecipe.addEventListener('submit', recipeSubmitForm);

    const formImage =  document.getElementById("image_input");
    if( formImage )
        formImage.addEventListener('change', imageChangeInput);
});

function imageChangeInput(event) {
    const files = event.target.files;
    if (files.length > 0) {
        const image = document.getElementById("recipe_img_form");

        // Створення FileReader об'єкта для читання файлу
        const reader = new FileReader();

        // Визначення події завантаження: коли файл буде прочитано, встановити його як src для зображення
        reader.onload = function(e) {
            // Перевірка, чи відрізняється новий src від поточного
            if (e.target.result !== image.src) {
                image.src = e.target.result;
            }
        };

        // Читання файлу як Data URL
        reader.readAsDataURL(files[0]);
    } else {
        console.log("Файл не вибрано");
    }
}


function onChangeSearchInput(e) {
    const input = e.target;
    const url = new URL(window.location.href);
    url.searchParams.set("name", input.value)
    window.location.href = url.toString();  
}

function recipeSubmitForm(event) {
    event.preventDefault();
    const formData = new FormData( this ); 
    let jsonData = {"ingredients": {}};

    for (const [key, value] of Array.from(formData)) {
        let modifiedValue = "";
        if(key != "image")
            modifiedValue = value.replace(/[\"\'\`]/g, '');

        if( key.includes("ingredient") ) {
            const id = key.split('_').pop();
            if(jsonData["ingredients"][id] == null)
                jsonData["ingredients"][id] = {};

            if( key.includes("_name_") )
                jsonData["ingredients"][id].name = modifiedValue;
            else if( key.includes("_quantity_") ) 
                jsonData["ingredients"][id].quantity = modifiedValue;
            else if( key.includes("_unit_") ) 
                jsonData["ingredients"][id].unit = modifiedValue;
            
            formData.delete(key);
        }
    }

    jsonData["ingredients"] = Object.values(jsonData["ingredients"])
    formData.append("ingredients", JSON.stringify(jsonData["ingredients"]))

    const chips = Array.from(document.querySelectorAll(".chip")).map(ch => ch.textContent.replace(/close/g, '').trim());
    formData.append("tags",JSON.stringify(chips));    
    formData.append("id", new URL(window.location.href).searchParams.get("id").toString())
    console.log(formData.get("tags"));



    // Відправлення даних на сервер
    fetch('/recipe', { // змініть URL на актуальний endpoint вашого сервера
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });

}

