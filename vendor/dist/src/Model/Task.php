<?php
    namespace Dist\Model;

    use Dist\Core_Model;
    use Dist\DB\Sql;

    class Task extends Core_Model {
        const ERROR_MSG = "msgerror";
        const SUCCESS_MSG = "msgsuccess";

        public static function listAll() {
            $sql = new Sql;

            $results = $sql->select("SELECT * FROM tb_tarefas a
            INNER JOIN tb_colaborador b
            WHERE a.responsavel = b.id
            ORDER BY prazolimite");

            return $results;
        }

        public function getById($idtask) {
            $sql = new Sql;
            $result = $sql->select("SELECT * FROM tb_tarefas a
            INNER JOIN tb_colaborador b
            ON a.responsavel = b.id
            WHERE idtarefa = :id", [
                ":id"=>$idtask
            ]);

            $this->setData($result[0]);
        }

        public function save() {
            $sql = new Sql;

            $prazo = $this->getprazolimite();

            $amanha = strtotime("+1 day");
            
            if (strtotime($prazo) < $amanha) {
                header("Location: /novatarefa");
                Task::setMsgError("A tarefa deve ter a duração de + de 24 horas de seu início");
                exit;
            } else {
            
                $sql->select("INSERT INTO tb_tarefas (descricao, prazolimite, prioridade,
                dataexecucao, responsavel)
                values (:descricao, :prazolimite, :prioridade, :dataexecucao, :responsavel)", [
                    ":descricao"=>$this->getdescricao(),
                    ":prazolimite"=>$this->getprazolimite(),
                    ":prioridade"=>$this->getprioridade(),
                    ":dataexecucao"=>$this->getdataexecucao(),
                    ":responsavel"=>$this->getresponsavel()
                ]);  
            }
        }

        public function delete() {
            $sql = new Sql;

            $sql->querySql("DELETE FROM tb_tarefas WHERE idtarefa = :idtarefa", [
                ":idtarefa"=>$this->getidtarefa()
            ]);
        }

        public static function getPage($page = 1, $itemsPerPage = 8) {

            $start = ($page - 1) * $itemsPerPage;
    
            $sql = new Sql();
    
            $results = $sql->select("
                SELECT SQL_CALC_FOUND_ROWS *
                FROM tb_tarefas a
                INNER JOIN tb_colaborador b 
                WHERE a.responsavel = b.id
                ORDER BY b.nome
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
                FROM tb_tarefas a
                INNER JOIN tb_colaborador b
                ON b.nome LIKE :search OR a.prioridade LIKE :search
                OR a.prazolimite LIKE :search
                WHERE a.responsavel = b.id
                ORDER BY b.nome
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
    
                $pagination = Task::getPageSearch($search, $page);
        
            } else {
        
                $pagination = Task::getPage($page);
        
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
                "tasks"=>$pagination['data'],
                "pages"=>$pages
            ];
        }

        public static function setMsgError($msg) {
            $_SESSION[Task::ERROR_MSG] = $msg;
        }
    
        public static function getMsgError() {
            $msg = (isset($_SESSION[Task::ERROR_MSG])) ? $_SESSION[Task::ERROR_MSG] : "";
            Task::clearMsgError();
            return $msg;
        }

        public static function clearMsgError() {
            return $_SESSION[Task::ERROR_MSG] = NULL;
        }

         // Podemos repassar ao usuário as possíveis mensagens de sucesso sem parar a execução
        public static function setMsgSuccess($msg) {
            $_SESSION[Task::SUCCESS_MSG] = $msg;
        }

        public static function getMsgSuccess() {
            $msg = (isset($_SESSION[Task::SUCCESS_MSG])) ? $_SESSION[Task::SUCCESS_MSG] : "";
            Task::clearMsgSuccess();
            return $msg;
        }

        public static function clearMsgSuccess() {
            return $_SESSION[Task::SUCCESS_MSG] = NULL;
        }


    }
