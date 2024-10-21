<?php

namespace App\Repository;

use App\Document\Task;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\UnitOfWork;

class TaskRepository extends DocumentRepository
{
    public function __construct(DocumentManager $dm, UnitOfWork $uow, ClassMetadata $classMetadata)
    {
        // The constructor arguments are inherited from DocumentRepository
        parent::__construct($dm, $uow, $classMetadata);
    }

    /**
     * @return Task[]
     */
    public function getTasks() : array {
        // Finds all tasks.
        return $this->findAll();
    }

    /**
     * @return Task | null
     */
    public function getTask(string $id) : ?Task {
        // Finds task by id.
        $tasks = $this->findBy(["id" => $id]);
        if (empty($tasks)) return null;
        return $tasks[0];
    }

    /**
     * @return void
     */
    public function deleteTask(Task $task) : void {
        // detelet task.
        $this->dm->remove($task);
        $this->dm->flush();
    }

    /**
     * @return void
     */
    public function addTask(Task $task) : void {
        $this->dm->persist($task);
        $this->dm->flush();
    }
}