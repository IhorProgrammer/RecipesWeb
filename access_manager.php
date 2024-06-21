<?php    
    //если путь "recipe?id=____"
    $uri = $_SERVER['REQUEST_URI'] ;
    $pos = strpos( $uri, '?' ) ;
    if( $pos > 0 ) {
        $uri = substr( $uri, 0, $pos );
    }
    else{
        $uri = substr($uri, 1);
    }
    if( str_contains($_SERVER['REQUEST_URI'], "api" ) ) {
        header ('Content-Type: application/json');
        $data = [
            "status" => "1",
            "data" => []
        ];        
        switch ($uri) {
            case '/api/recipes': case 'api/recipes': 
                    include "private/Controllers/RecipesController.php";
                    $controler_object = new RecipesController();
                    $recipes = $controler_object->serve();
                    $data["data"] = $recipes;
                break;
            case '/api/recipe':  case 'api/recipe':
                include "private/Controllers/RecipeController.php";
                $controler_object = new RecipeController();
                $recipes = $controler_object->serve();
              
                if( $recipes == null ) break;

                if( $recipes == [] ) break;
                $recipe = $recipes[0];
                $recipe["tags"] = json_decode($recipe["tags"]);
                $recipe["ingredients"] = json_decode($recipe["ingredients"]);

                $data["data"] = $recipe;
            break;
        }

        echo json_encode($data);
        exit;
    }

    if($uri != ""){
        $filename = "./public/{$uri}";
        if( is_readable( $filename ) ) { // запит uri це існуючий файл
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            unset( $content_type );
            switch ($ext) {
                case 'png':
                case 'gif':
                case 'bmp': 
                case 'webp':
                    $content_type = "image/{$ext}"; break;
                case 'jpg':
                case 'jpeg': 
                    $content_type = "image/jpeg"; break;
                case 'html':
                case 'css':
                    $content_type = "text/{$ext}"; break;
                case 'js':
                    $content_type = "text/javascript"; break;
                case 'json':
                    $content_type = "application/json"; break;
                    
            } 
            if ( isset( $content_type ) ) {
                header( "Content-Type: {$content_type}");
                if( is_readable( $filename ) ) { // запит uri це існуючий файл
                    readfile( $filename ); //передає тіло файлу до HTTP-відповіді
                }
                exit; //кінець файлу
            }
        }
    }


    
    if(!isset($page_body)) $page_body = "error.php";
    switch ($uri) {
        case '/recipes': case '/': case '': case 'recipes': 
                include "private/Controllers/RecipesController.php";
                $controler_object = new RecipesController();
                $recipes = $controler_object->serve();
                $page_body = "recipes.php";
            break;
        case 'recipe':  case '/recipe':
            include "private/Controllers/RecipeController.php";
            $controler_object = new RecipeController();
            $recipes = $controler_object->serve();
            if( $recipes == null ) break;
            $page_body = "recipe.php";

            if( $recipes == [] ) break;
            $recipe = $recipes[0];
            $recipe["tags"] = json_decode($recipe["tags"]);
            $recipe["ingredients"] = json_decode($recipe["ingredients"]);
            break;
        case 'admin':  case '/admin':
            include "private/Controllers/RecipesController.php";
            $controler_object = new RecipesController();
            $recipes = $controler_object->serve();
            $page_body = "admin.php";
            break;
            
        case 'admin-recipe': case '/admin-recipe': 
            include "private/Controllers/RecipeController.php";
            $controler_object = new RecipeController();
            $recipes = $controler_object->serve();
            if( $recipes == null ) break;
            $page_body = "admin_recipe.php";

            if( $recipes == [] ) break;
            $recipe = $recipes[0];
            $recipe["tags"] = json_decode($recipe["tags"]);
            $recipe["ingredients"] = json_decode($recipe["ingredients"]);
            break;  
    }

    include "public/_layout.php";
    http_response_code( 404 ) ;
    exit; //кінець файлу
    
