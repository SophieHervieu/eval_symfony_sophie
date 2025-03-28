<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Task as EntityTask;
use App\Repository\TaskRepository;
use Exception;

class TaskService {

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly TaskRepository $taskRepository
    ){

    }

    public function add(EntityTask $task) {
        if($task->getTitle() !="" && $task->getContent() !="" && $task->getCreatedAt() !="" && $task->getExpiredAt() !="") {
            if($this->taskRepository->findOneBy(["title"=>$task->getTitle()])) {
                $task->setStatus('false');
                $this->em->persist($task);
                $this->em->flush();
            }
            else {
                throw new \Exception("Le compte existe déjà", 400);
            }
        }
        else {
            throw new \Exception("Les champs ne sont pas tous remplis", 400);
        }
    }

    public function getAllTasks() {
        $tasks = $this->taskRepository->findAll();
        if($tasks) {
            return $tasks;
        }
        else {
            throw new \Exception("La liste est vide", 400);
        }
    }
}