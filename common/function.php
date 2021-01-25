<?PHP
function connectDB(){
    $param = 'mysql:dbname=personalbranding;host=localhost';
    try{
        $pdo = new PDO($param, 'root', 'root');
        return $pdo;
    } catch (PDOException $e) { 
        echo $e->getMessage();
        exit();
    }
}
?>