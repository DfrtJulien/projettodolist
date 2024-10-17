<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\Task;
use App\Models\User;

class TaskController extends AbstractController
{
    public function index()
    {
        if ($_GET['id']) {
            //on met l'id de la tache dans une variable
            $idTask = $_GET['id'];
            //on instancie une nouvelle tache avec l'id de la tache
            $task = new Task($idTask, null, null, null, null, null, null, null, null, null, null);
            //on appelle la méthode pour aller chercher la tache dans la BDD on met le resulat dans la variable
            $myTask = $task->getTaskById();

            //Si la tache n'existe pas dans la base de donnée alors on redirige vers /home
            if (!$task) {
                $this->redirectToRoute('/');
            }

            $idUser = $myTask->getIdUser();

            $user = new User($idUser, null, null, null, null, null);

            $myUser = $user->getUserById();


            $dateCreation = date_create($myTask->getCreationDate());
            $dateStartDay = date_create($myTask->getStartTask());
            $dateStopDay = date_create($myTask->getStopTask());

            require_once(__DIR__ . "/../Views/task/task.view.php");
        } else {
            $this->redirectToRoute('/');
        }
    }

    public function createTask()
    {
        if (isset($_SESSION['user']) && $_SESSION['user']['idRole'] == 1) {

            if (isset($_POST['title'])) {
                $this->check('title', $_POST['title']);
                $this->check('start_task', $_POST['start_task']);
                $this->check('stop_task', $_POST['stop_task']);
                $this->check('point', $_POST['point']);

                if (empty($this->arrayError)) {
                    $title = htmlspecialchars($_POST['title']);
                    $start_task = htmlspecialchars($_POST['start_task']);
                    $stop_task = htmlspecialchars($_POST['stop_task']);
                    $point = htmlspecialchars($_POST['point']);
                    $content = htmlspecialchars($_POST['content']);
                    $creation_date = date('Y-m-d H:i:s');
                    $id_user = $_SESSION['user']['idUser'];

                    $task = new Task(null, $title, $content, $creation_date, $start_task, $stop_task, $point, $id_user, null, null, null);

                    $task->addTask();
                    $this->redirectToRoute('/');
                }
            }

            require_once(__DIR__ . '/../Views/task/createTask.view.php');
        } else {
            $this->redirectToRoute('/');
        }
    }

    public function editTask()
    {
        if ($_GET['id']) {
            //on met l'id de la tache dans une variable
            $idTask = $_GET['id'];
            //on instancie une nouvelle tache avec l'id de la tache
            $task = new Task($idTask, null, null, null, null, null, null, null, null, null, null);
            //on appelle la méthode pour aller chercher la tache dans la BDD on met le resulat dans la variable
            $myTask = $task->getTaskById();

            $dateStartDay = date_create($myTask->getStartTask());
            $dateStopDay = date_create($myTask->getStopTask());

            //Si la tache n'existe pas dans la base de donnée alors on redirige vers /home
            if (!$task) {
                $this->redirectToRoute('/');
            }

            if (isset($_POST['title'])) {
                $this->check('title', $_POST['title']);
                $this->check('start_task', $_POST['start_task']);
                $this->check('stop_task', $_POST['stop_task']);
                $this->check('point', $_POST['point']);

                if (empty($this->arrayError)) {
                    $title = htmlspecialchars($_POST['title']);
                    $start_task = htmlspecialchars($_POST['start_task']);
                    $stop_task = htmlspecialchars($_POST['stop_task']);
                    $point = htmlspecialchars($_POST['point']);
                    $content = htmlspecialchars($_POST['content']);

                    $task = new Task($idTask, $title, $content, null, $start_task, $stop_task, $point, null, null, null, null);

                    $task->updateTask();
                    $this->redirectToRoute('/');
                }
            }

            require_once(__DIR__ . '/../Views/task/editTask.view.php');
        } else {
            $this->redirectToRoute('/');
        }
    }

    public function deleteTask()
    {
        if (isset($_POST['id'])) {
            $idTask = htmlspecialchars($_POST['id']);
            $task = new Task($idTask, null, null, null, null, null, null, null, null, null, null);
            $task->deleteTask();
            $this->redirectToRoute('/');
        }
    }

    public function deleteTaskAndTodo()
    {
        if (isset($_POST['id'])) {
            $idTask = htmlspecialchars($_POST['id']);
            $task = new Task($idTask, null, null, null, null, null, null, null, null, null, null);
            $task->deleteTodo();
            $task->deleteTask();
            $this->redirectToRoute('/');
        }
    }

    public function addKidTask()
    {
        if ($_GET['id']) {
            //on met l'id de la tache dans une variable
            $idTask = $_GET['id'];
            //on instancie une nouvelle tache avec l'id de la tache
            $task = new Task($idTask, null, null, null, null, null, null, null, null, null, null);
            //on appelle la méthode pour aller chercher la tache dans la BDD on met le resulat dans la variable
            $myTask = $task->getTaskById();

            $user = new User(null, null, null, null, null, null);
            $myKids = $user->getKids();

            if (!$myTask) {
                $this->redirectToRoute('/');
            }

            if (isset($_POST['kid'])) {
                $idKid = htmlspecialchars($_POST['kid']);
                $status = htmlspecialchars($_POST['status']);

                $this->checkFormat('kid', $idKid);
                $this->checkFormat('status', $status);

                if (empty($this->arrayError)) {
                    $task = new Task($idTask, null, null, null, null, null, null, null, $status, null, $idKid);
                    $task->addTodo();
                    $this->redirectToRoute('/');
                }
            }

            require_once(__DIR__ . "/../Views/task/addKidTask.view.php");
        } else {
            $this->redirectToRoute('/');
        }
    }

    public function updateTodoTask()
    {
        if ($_GET['id']) {
            //on met l'id de la tache dans une variable
            $idTask = $_GET['id'];
            //on instancie une nouvelle tache avec l'id de la tache
            $task = new Task($idTask, null, null, null, null, null, null, null, null, null, null);
            //on appelle la méthode pour aller chercher la tache dans la BDD on met le resulat dans la variable
            $myTask = $task->getTaskById();

            $user = new User(null, null, null, null, null, null);
            $myKids = $user->getKids();

            if (!$myTask) {
                $this->redirectToRoute('/');
            }

            if (isset($_POST['kid'])) {

                $idKid = htmlspecialchars($_POST['kid']);
                $status = htmlspecialchars($_POST['status']);

                $this->checkFormat('kid', $idKid);
                $this->checkFormat('status', $status);

                if (empty($this->arrayError)) {
                    $task = new Task($idTask, null, null, null, null, null, null, null, $status, null, $idKid);
                    $task->addTodo();
                    $task->updateTodo();
                    $this->redirectToRoute('/');
                }
            }

            require_once(__DIR__ . "/../Views/task/addKidTask.view.php");
        } else {
            $this->redirectToRoute('/');
        }
    }

    public function showMyTasks()
    {
        if (isset($_GET['id'])) {
            $idKid = $_GET['id'];
            $task = new Task(null, null, null, null, null, null, null, null, null, null, $idKid);
            $resultTask = $task->getMyTasks();

            require_once(__DIR__ . '/../Views/task/myTasks.view.php');
        }
    }

    public function endTask()
    {
        if (isset($_GET['idTask']) && isset($_GET['idUser']) && isset($_GET['point'])) {
            $idTask = $_GET['idTask'];
            $idUser = $_GET['idUser'];
            $point = intval($_GET['point']);

            $task = new Task($idTask, null, null, null, null, null, $point, null, null, null, $idUser);
            $user = new User($idUser, null, null, null, null, null);
            $myUserScore = $user->getScore();
            if ($myUserScore) {
                $task->addPointNotNull();
                $task->deleteTodo();
                $task->deleteTask();

                $this->redirectToRoute('/');
            } else {
                $task->addPoint();
                $task->deleteTodo();
                $task->deleteTask();
                $this->redirectToRoute('/');
            }
        }
    }
}
