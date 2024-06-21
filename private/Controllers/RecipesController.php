<?php

include_once $_SERVER['DOCUMENT_ROOT']."/private/Controllers/APIController.php" ;

class RecipesController extends ApiController {	
	
	protected function do_get() {
		$db = $this->connect_db_or_exit() ;

        $sql = '
            SELECT rs.*
            FROM recipes_short rs
        ';

        if (isset($_GET['tag'])) {
            $tags = $_GET['tag'];
            if (!empty($tags)) {
                $tagsString = $this->get_string_for_sql();
                $sql = $sql . '
                    JOIN tag_recept tr ON rs.id = tr.id_recipes
                    WHERE tr.id_tags IN (' . $tagsString . ')';
            }
        }

        if (isset($_GET['name'])) {
            $name = $_GET['name'];
            if (!empty($name)) {

                if(!empty($tags))
                    $sql .= ' AND rs.title LIKE "%' . $name . '%";' ;
                else 
                    $sql .= 'WHERE rs.title LIKE "%' . $name . '%";' ;

            }
        }
      

		try {    
			$stmt = $db->prepare($sql);
			$stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		catch( PDOException $ex ) {
			http_response_code( 500 ) ;
            echo 'Error: ' . $ex->getMessage();
        } 
	    
    }

    private function get_string_for_sql() {
        if (isset($_GET['tag'])) {
            $tags = $_GET['tag'];
            // Проверяем, передан ли хотя бы один тег
            if (!empty($tags)) {
                // Разбиваем строку тегов на массив
                $tagsArray = explode(',', $tags);
                // Подготавливаем массив для хранения безопасных значений тегов
                $safeTags = [];
                // Проходимся по каждому тегу в массиве
                foreach ($tagsArray as $tag) {
                    // Добавляем кавычки и экранируем теги для безопасности
                    $safeTags[] = "'" . $tag . "'";
                }
                // Преобразуем массив безопасных тегов обратно в строку
                $tagsString = implode(',', $safeTags);
                return $tagsString;
            }
        }        
    }
}