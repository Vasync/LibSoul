<?php

namespace vasync\soul;

use vasync\soul\Data;
use pocketmine\scheduler\Task as PMTask;
use pocketmine\scheduler\TaskScheduler;
use pocketmine\plugin\PluginBase;

interface VTask {

    public function setTimeout(callable $callback, int $delay): void;

    public function setInterval(callable $callback, int $interval): void;

    public function clearTimeout(PMTask $task): void;

    public function clearInterval(PMTask $task): void;
}

final class Task implements VTask {

    public function setTimeout(callable $callback, int $delay): void {
        Data::getScheduler()->scheduleDelayedTask(new class($callback) extends PMTask {
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
        Data::getScheduler()->scheduleRepeatingTask(new class($callback) extends PMTask {
            private $callback;

            public function __construct(callable $callback) {
                $this->callback = $callback;
            }

            public function onRun(): void {
                ($this->callback)();
            }
        }, $interval);
    }

    public function clearTimeout(PMTask $task): void {
        Data::getScheduler->cancelTask($task->getTaskId());
    }

    public function clearInterval(PMTask $task): void {
        Data::getScheduler->cancelTask($task->getTaskId());
    }
}
