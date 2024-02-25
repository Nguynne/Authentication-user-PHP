<?php

    class Book{
        private $id;
        private $title;
        private $description;
        private $author;
        private $imagefile;

        public function __construct($title, $description, $author, $imagefile){
            $this->title = $title;
            $this->description = $description;
            $this->author = $author;
            $this->imagefile = $imagefile;
        }

        private function validate(){
            //Bắt buộc phải có
            return $this->title && 
            $this->description && 
            $this->author;
        }


        //Thêm sách (C)
        public function addBook($conn){
            if($this->validate()){
                $sql = "insert into books(title, description, author, imagefile) values 
                (:title, :description, :author, :imagefile);";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
                $stmt->bindValue(':description', $this->description, PDO::PARAM_STR);
                $stmt->bindValue(':author', $this->author, PDO::PARAM_STR);
                $stmt->bindValue(':imagefile', $this->imagefile, PDO::PARAM_STR);

                return $stmt->execute();
            }else{
                return false;
            } 
        }

        // Đọc sách(R)
        public static function getAll($conn){
            try{
                $sql = "select * from books;";
                $stmt = $conn->prepare($sql);
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'Book'); //Xet 1 đổi tượng
                if($stmt->execute()){
                    $books = $stmt->fetchAll();
                    return $books;
                }
            }catch(PDOException $e){
                echo $e->getMessage();
                return null;
            }
        }

        public function getByID($conn, $id){
            try{
                $sql = "select * from books where id=:id;";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'Book'); //Trả về 1 đổi tượng
                $stmt->execute(); // Thực hiện câu lệnh sql
                $books = $stmt->fetch();
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        //Update(U)
        public function update($conn){
            if($this->validate()){
                try{
                    $sql = "update books
                            set title=:title, description=:description, author=:author
                            , imagefile=:imagefile where id=:id";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
                            $stmt->bindValue(':description', $this->description, PDO::PARAM_STR);
                            $stmt->bindValue(':author', $this->author, PDO::PARAM_STR);
                            $stmt->bindValue(':imagefile', $this->imagefile, PDO::PARAM_STR);
                            $stmt->bindValue(':id', $this->id, PDO::PARAM_STR);
                            return $stmt->execute();
                }catch(PDOException $e){
                    echo $e->getMessage();
                    return false;
                }
            }
        }

        //Delete
        public function delete($conn){

        }

        public function deleteByID($conn, $id){
            try{
                $sql = "select * from books where id=:id;";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                return $stmt->execute(); // Thực hiện câu lệnh sql
            }catch(PDOException $e){
                echo $e->getMessage();
                return false;
            }
        }

        public function updateImage($conn, $id, $imagefile){
            try{
                $sql = "update books
                set imagefile=:imagefile where id=:id";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->bindValue(':imagefile', $imagefile, $imagefile == null
                ? PDO::PARAM_NULL : PDO::PARAM_STR);
                return $stmt->execute();
            }catch(PDOException $e){
                echo $e->getMessage();
                return false;
            }         
        }

        public static function count($conn){
            try{
                $sql = "select count(id) from books";
                return $conn->query($sql)->fetchColumn();
            }catch(PDOException $e){
                echo $e->getMessage();
                return false;
            }
        }

        //Cách tính phân trang: start = (current_page - 1)*page_size; 
        public static function getPaging($conn, $limit, $offset){
            try{
                $sql = "select * from books order by title asc
                limit :limit
                offset :offset";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'Book');

                if($stmt->execute()){
                    $books = $stmt->fetchAll();
                    return $books;
                }
            }catch(PDOException $e){
                echo $e->getMessage();
                return null;
            }
        }
    }
?>