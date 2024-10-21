<?php

namespace App\Controller;

use App\Document\Task;
use App\Repository\TaskRepository;
use App\Form\TaskType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/task", name: "app_task_")]
class TaskController extends AbstractController
{
    #[Route("", name: "list")]
    public function index(DocumentManager $dm): Response
    {
        /** @var TaskRepository $taskRepository */
        $taskRepository = $dm->getRepository(Task::class);
     
        // Add new task
        $form = $this->createForm(TaskType::class, null, ["action" => $this->generateUrl("app_task_add")]);
        
        // List tasks
        $tasks = $taskRepository->getTasks();

        return $this->render("task/index.html.twig", [
            "controller_name" => "Tasks",
            "tasks" => $tasks,
            "form" => $form,
        ]);
    }

    #[Route("/add", name: "add")]
    public function add(Request $request, DocumentManager $dm) : Response {
        // Add new task
        /** @var TaskRepository $taskRepository */
        $taskRepository = $dm->getRepository(Task::class);

        $form = $this->createForm(TaskType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $newTask = new Task();
            $newTask->title = $data["title"];
            $newTask->descrition = $data["description"];
            $taskRepository->addTask($newTask);
        }
            
        return $this->redirectToRoute("app_task_list", [], 301);
    }


    #[Route("/delete/{id}", name: "delete")]
    public function delete(string $id, DocumentManager $dm) : Response {
        /** @var TaskRepository $taskRepository */
        $taskRepository = $dm->getRepository(Task::class);
        /** @var Task $task */
        $task = $taskRepository->getTask($id);
        if (!empty($task)) {
            $taskRepository->deleteTask($task);
        }
            
        return $this->redirectToRoute("app_task_list", [], 301);
    }
}
