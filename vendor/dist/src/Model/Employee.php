<?php
    namespace Dist\Model;

    use Dist\Core_Model;
    use Dist\DB\Sql;

    class Employee extends Core_Model {
        const ERROR_MSG = "msgerror";
        const SUCCESS_MSG = "msgsuccess";

        public static function listAll() {
            $sql = new Sql;

            $results = $sql->select("SELECT * FROM tb_colaborador ORDER BY nome");

            return $results;
        }

        public function getById($idEmployee) {
            $sql = new Sql;

            $result = $sql->select("SELECT * FROM tb_colaborador WHERE id = :id", [
                ":id"=>$idEmployee
            ]);

            $this->setData($result[0]);
        }

        public function save() {
            $sql = new Sql;

            $sql->select("INSERT INTO tb_colaborador (nome, cpf, email) values (:nome, :cpf,  :email)", [
                ":nome"=>$this->getnome(),
                ":cpf"=>$this->getcpf(),
                ":email"=>$this->getemail()
            ]);  
        }

        public function update() {
            $sql = new Sql;

            $sql->select("CALL sp_employee_update(:id, :nome, :cpf, :email)", [
                ":nome"=>$this->getnome(),
                ":cpf"=>$this->getcpf(),
                ":email"=>$this->getemail(),
                ":id"=>$this->getid()
            ]);  
        }

        public function delete() {
            $sql = new Sql;

            $sql->querySql("DELETE FROM tb_colaborador WHERE id = :id", [
                ":id"=>$this->getid()
            ]);
        }

        public static function getPage($page = 1, $itemsPerPage = 8) {

            $start = ($page - 1) * $itemsPerPage;
    
            $sql = new Sql();
    
            $results = $sql->select("
                SELECT SQL_CALC_FOUND_ROWS *
                FROM tb_colaborador 
                ORDER BY nome
                LIMIT $start, $itemsPerPage;
            ");
    
            $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");
            
            return [
                'data'=>$results,
                'total'=>(int)$resultTotal[0]["nrtotal"],
                'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
            ];
    
        }
    
        public static function getPageSearch($search, $page = 1, $itemsPerPage = 8) {
    
            $start = ($page - 1) * $itemsPerPage;
    
            $sql = new Sql();
    
            $results = $sql->select("
                SELECT SQL_CALC_FOUND_ROWS *
                FROM tb_colaborador 
                WHERE nome LIKE :search
                ORDER BY nome
                LIMIT $start, $itemsPerPage;
            ", [
                ':search'=>'%'.$search.'%'
            ]);
    
            $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");
    
            return [
                'data'=>$results,
                'total'=>(int)$resultTotal[0]["nrtotal"],
                'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
            ];
    
        }

        public static function searchPage($search, $page) {
            if ($search != '') {
    
                $pagination = Employee::getPageSearch($search, $page);
        
            } else {
        
                $pagination = Employee::getPage($page);
        
            }
        
            $pages = [];
        
            for ($x = 0; $x < $pagination['pages']; $x++)
            {
        
                array_push($pages, [
                    'href'=>'/?'.http_build_query([
                        'page'=>$x+1,
                        'search'=>$search
                    ]),
                    'text'=>$x+1
                ]);
        
            }
    
            return [
                "employee"=>$pagination['data'],
                "pages"=>$pages
            ];
        }

        public static function checkEmailExists($login){
            $sql = new Sql;
            $results = $sql->select("SELECT * FROM tb_colaborador WHERE email = :email", [
                ":email" => $login
            ]);

            return (count($results) > 0);
        }

        public static function cpfValidator($cpf) {
 
            $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
             
            if (strlen($cpf) != 11) {
                return false;
            }
        
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                return false;
            }
        
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    return false;
                }
            }
            return true;
        }
        

        public static function setMsgError($msg) {
            $_SESSION[Employee::ERROR_MSG] = $msg;
        }
    
        public static function getMsgError() {
            $msg = (isset($_SESSION[Employee::ERROR_MSG])) ? $_SESSION[Employee::ERROR_MSG] : "";
            Employee::clearMsgError();
            return $msg;
        }

        public static function clearMsgError() {
            return $_SESSION[Employee::ERROR_MSG] = NULL;
        }

         // Podemos repassar ao usuário as possíveis mensagens de sucesso sem parar a execução
        public static function setMsgSuccess($msg) {
            $_SESSION[Employee::SUCCESS_MSG] = $msg;
        }

        public static function getMsgSuccess() {
            $msg = (isset($_SESSION[Employee::SUCCESS_MSG])) ? $_SESSION[Employee::SUCCESS_MSG] : "";
            Employee::clearMsgSuccess();
            return $msg;
        }

        public static function clearMsgSuccess() {
            return $_SESSION[Employee::SUCCESS_MSG] = NULL;
        }


    }
?>