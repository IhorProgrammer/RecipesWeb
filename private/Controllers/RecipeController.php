<?php

include_once $_SERVER['DOCUMENT_ROOT']."/private/Controllers/APIController.php" ;

class RecipeController extends ApiController {	
	
	protected function do_get() {
		$db = $this->connect_db_or_exit() ;

        if (isset($_GET['id'])) {
            $id = $_GET['id']; 
        } else {
            return null;
        }

        
        $sql = "CALL GetRecipeDetails(?)";

		try {    
			$stmt = $db->prepare($sql);
			$stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		catch( PDOException $ex ) {
			http_response_code( 500 ) ;
            echo 'Error: ' . $ex->getMessage();
        } 
	    
    }

    protected function do_post() {
        
        $fileName = $this->saveImage();
        
		$db = $this->connect_db_or_exit() ;

        if (isset($_POST['id'])) {
            //оновлення
            $sql = "CALL UpdateRecipe(:recipe_id, :title, :short_info, :image_url, :servings, :preparation_time, :description, :tags, :ingredients)";
        } 
        
        $recipe_id = $_POST['id'];
        $title = $_POST["title"];
        $short_info = $_POST["short_info"];
        $image_url = $fileName;
        $servings = $_POST["servings"];
        $preparation_time = $_POST["preparation_time"];
        $description = $_POST["description"];
        $tags = $_POST["tags"];
        $ingredients = $_POST["ingredients"];

		try {    
			$stmt = $db->prepare($sql);
            
            $stmt->bindParam(':recipe_id', $recipe_id);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':short_info', $short_info);
            $stmt->bindParam(':image_url', $image_url);
            $stmt->bindParam(':servings', $servings);
            $stmt->bindParam(':preparation_time', $preparation_time);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':tags', $tags);
            $stmt->bindParam(':ingredients', $ingredients);

			$stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		catch( PDOException $ex ) {
			http_response_code( 500 ) ;
            $filePath = "public/image/recipes/" . $fileName;
            unlink( $filePath );
            echo 'Error: ' . $ex->getMessage();
        } 
        finally {

            exit;
        }
    }

    private function saveImage() {
        
        if (isset($_FILES['image']) && isset($_POST['id'])) {
            $file = $_FILES['image'];
            if ($file['error'] === UPLOAD_ERR_OK) {
                //создаем уникальное имя и сохраняем в папку
                $tmp_name = $file['tmp_name'];
                $name = basename($file['name']);
                $hashedName = hash('sha256', $name . time() . $_POST['id']);
                $hashedFileName =  $hashedName . "." . pathinfo($name, PATHINFO_EXTENSION);
                $upload_dir = 'public/image/recipes/';

                $new_filename = $upload_dir . $hashedFileName ;
                if ( !move_uploaded_file($tmp_name, $new_filename)) {                    
                    echo json_encode(['status' => 'error', 'message' => 'Failed to move the uploaded file.']);
                    exit;
                }
                return $hashedFileName;
            } 
        }
        return "";
    }
}