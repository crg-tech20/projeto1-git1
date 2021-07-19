<?php 
class Connection{	  
    public static function Conectar() {        
        define('servidor', 'localhost');
        define('dbname', 'db_diario1');
        define('usuario', 'postgres');
        define('password', 'rootroot1');					        
        		
        try{
            //$Connection = new PDO("mysql:host=".servidor."; dbname=".nombre_bd, usuario, password, $opciones);			
            $pdo = new PDO("pgsql:host=localhost;dbname=db_diario2;", 'postgres', 'rootroot1'); // => no windows
            //$pdo = new PDO("pgsql:dbname=db_diario; user=postgres; password= ;host=localhost;port=5432"); => no linux
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
            
            
        } catch (PDOException $e){
            echo "Erro de conexão: ". $e->getMessage()."<br>";
        }
    }
}
/*

Forma de uso nas paginas

include_once '../bd/Connection.php';
$objeto = new Connection();
$Connection = $objeto->Conectar();




*/
