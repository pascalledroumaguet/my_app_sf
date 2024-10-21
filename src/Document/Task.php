<?php 

namespace App\Document;

use DateTime;
use DateTimeImmutable;
use App\Repository\TaskRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;


#[ODM\Document(db: 'dev', collection: 'task', repositoryClass: TaskRepository::class)]
class Task
{
    #[ODM\Id]
    public string $id;

    #[ODM\Field(strategy: 'increment')]
    public int $changes = 0;

    #[ODM\Field]
    public string $title;

    #[ODM\Field]
    public string $descrition;

    public function getTitle() : string {
        return $this->title;
    }

    public function getDescrition() : string {
        return $this->descrition;
    }

}