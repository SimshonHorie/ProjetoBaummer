<?php
require_once("vendor/autoload.php");
require_once("Utils.php");
session_start();
date_default_timezone_set('America/Sao_Paulo');
setLocale(LC_ALL, "pt_BR", "pt_BR.utf-8", "portuguese");

use Dist\Model\Employee;
use Dist\Model\Task;
use Slim\Slim;
use Dist\Page;

$app = new Slim;

$app->config("debug", true);

$app->get("/", function () {
    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

    $tasks = Task::searchPage($search, $page);

    $page = new Page();

    $page->setTpl("index", [
        "taskslist" => $tasks['tasks'],
        "search" => $search,
        "pages" => $tasks["pages"],
        "success" => Task::getMsgSuccess()
    ]);
});

$app->get("/:idtask/excluir", function ($idtask) {
    $task = new Task;
    $task->getById($idtask);
    $task->delete();
    header("Location: /");
    Task::setMsgSuccess("Tarefa excluida com sucesso");
    exit;
});

$app->get("/novatarefa", function () {
    $page = new Page;

    $page->setTpl("task-register", [
        "employeeslist" => Employee::listAll(),
        'error' => Task::getMsgError()
    ]);
});

$app->post("/novatarefa", function () {
    $task = new Task;
    if (!isset($_POST['responsavel']) || $_POST['responsavel'] === '') {

        Task::setMsgError("Deve haver um responsável por essa tarefa");
        header("Location: /novatarefa");
        exit;
    }

    if (!isset($_POST['descricao']) || $_POST['descricao'] === '') {

        Task::setMsgError("Insira uma descrição");
        header("Location: /novatarefa");
        exit;
    }

    if (!isset($_POST['prazolimite']) || $_POST['prazolimite'] === '') {

        Task::setMsgError("Insira um prazo limite");
        header("Location: /novatarefa");
        exit;
    }

    if (!isset($_POST['dataexecucao']) || $_POST['dataexecucao'] === '') {

        Task::setMsgError("insira a data em que a tarefa foi executada");
        header("Location: /novatarefa");
        exit;
    }

    $task->setData($_POST);

    $task->save();
    header("Location: /");
    Task::setMsgSuccess("Tarefa emitida com sucesso");
    exit;
});

$app->get("/areacolaboradores", function () {
    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

    $employeelist = Employee::searchPage($search, $page);

    $page = new Page;

    $page->setTpl("employee-area", [
        "employeeslist" => $employeelist['employee'],
        "search" => $search,
        "pages" => $employeelist["pages"],
        "success" => Employee::getMsgSuccess()
    ]);
});

$app->get("/areacolaboradores/novocolaborador", function () {
    $page = new Page;

    $page->setTpl("employee-register", [
        'error' => Employee::getMsgError()
    ]);
});

$app->post("/areacolaboradores/novocolaborador", function () {
    $employee = new Employee;

    $employee->setData($_POST);


    if (!isset($_POST['nome']) || $_POST['nome'] === '') {

        Employee::setMsgError("Insira um nome");
        header("Location: /areacolaboradores/novocolaborador");
        exit;
    }

    if (!isset($_POST['cpf']) || $_POST['cpf'] === '') {

        Employee::setMsgError("Insira um cpf");
        header("Location: /areacolaboradores/novocolaborador");
        exit;
    }

    if (!isset($_POST['email']) || $_POST['email'] === '') {

        Employee::setMsgError("Insira um email");
        header("Location: /areacolaboradores/novocolaborador");
        exit;
    }

    if (!Employee::cpfValidator($_POST['cpf'])) {

        Employee::setMsgError("Insira um cpf válido");
        header("Location: /areacolaboradores/novocolaborador");
        exit;
    }

    if (Employee::checkEmailExists($_POST['email'])) {
        Employee::setMsgError("Esse email já está cadastrado no banco de dados, tente outro!");
        header("Location: /areacolaboradores/novocolaborador");
        exit;
    }

    $employee->save();

    header("Location: /areacolaboradores");
    Employee::setMsgSuccess("Colaborador cadastrado com sucesso!");
    exit;
});

$app->get("/areacolaboradores/:idcolaborador/editarcolaborador", function ($idcolaborador) {
    $employee = new Employee;

    $employee->getById($idcolaborador);

    $page = new Page;

    $page->setTpl("employee-update", [
        "employee" => $employee->getValues(),
        "error" => Employee::getMsgError()
    ]);
});

$app->post("/areacolaboradores/:idcolaborador/editarcolaborador", function ($idcolaborador) {
    $employee = new Employee;

    $employee->getById($idcolaborador);

    if (!isset($_POST['nome']) || $_POST['nome'] === '') {

        Employee::setMsgError("Insira um nome");
        header("Location: /areacolaboradores/$idcolaborador/editarcolaborador");
        exit;
    }

    if (!isset($_POST['cpf']) || $_POST['cpf'] === '') {

        Employee::setMsgError("Insira um cpf");
        header("Location: /areacolaboradores/$idcolaborador/editarcolaborador");
        exit;
    }

    if (!isset($_POST['email']) || $_POST['email'] === '') {

        Employee::setMsgError("Insira um email");
        header("Location: /areacolaboradores/$idcolaborador/editarcolaborador");
        exit;
    }

    if (!Employee::cpfValidator($_POST['cpf'])) {

        Employee::setMsgError("Insira um cpf válido");
        header("Location: /areacolaboradores/$idcolaborador/editarcolaborador");
        exit;
    }

    if (Employee::checkEmailExists($_POST['email']) && $_POST['email'] !== $employee->getemail()) {
        Employee::setMsgError("Esse email já está cadastrado no banco de dados, tente outro!");
        header("Location: /areacolaboradores/$idcolaborador/editarcolaborador");
        exit;
    }

    $employee->setData($_POST);
    $employee->update();
    Employee::setMsgSuccess("Dados alterados com sucesso");
    header("Location: /areacolaboradores");
    exit;
});

$app->get("/areacolaboradores/:idcolaborador/excluir", function ($idcolaborador) {
    $employee = new Employee;

    $employee->getById($idcolaborador);

    $employee->delete();

    header("Location: /areacolaboradores");
    Employee::setMsgSuccess("Colaborador excluído com sucesso!");
    exit;
});

$app->run();
