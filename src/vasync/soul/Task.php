<?php

namespace vasync\soul;

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
        $this->scheduler->scheduleDelayedTask(new class($callback) extends Task {
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
        $this->scheduler->scheduleRepeatingTask(new class($callback) extends Task {
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
        $this->scheduler->cancelTask($task->getTaskId());
    }

    public function clearInterval(Task $task): void {
        $this->scheduler->cancelTask($task->getTaskId());
    }
}
