<?php

namespace vasync\soul;

use vasync\soul\Data;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskScheduler;
use pocketmine\plugin\PluginBase;

interface VTask {

    public function setTimeout(callable $callback, int $delay): void;

    public function setInterval(callable $callback, int $interval): void;

    public function clearTimeout(Task $task): void;

    public function clearInterval(Task $task): void;
}

final class Task implements VTask {

    public function setTimeout(callable $callback, int $delay): void {
        Data::getScheduler()->scheduleDelayedTask(new class($callback) extends Task {
            private $callback;

            public function __construct(callable $callback) {
                $this->callback = $callback;
            }

            public function onRun(): void {
                ($this->callback)();
            }
        }, $delay);
    }

    public function setInterval(callable $callback, int $interval): void {
        Data::getScheduler()->scheduleRepeatingTask(new class($callback) extends Task {
            private $callback;

            public function __construct(callable $callback) {
                $this->callback = $callback;
            }

            public function onRun(): void {
                ($this->callback)();
            }
        }, $interval);
    }

    public function clearTimeout(Task $task): void {
        Data::getScheduler->cancelTask($task->getTaskId());
    }

    public function clearInterval(Task $task): void {
        Data::getScheduler->cancelTask($task->getTaskId());
    }
}
