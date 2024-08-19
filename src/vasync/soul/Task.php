<?php

namespace vasync\soul;

use vasync\soul\Data;
use pocketmine\scheduler\Task as PMTask;
use pocketmine\scheduler\TaskScheduler;
use pocketmine\plugin\PluginBase;

interface VTask {

    public static function setTimeout(callable $callback, int $delay): void;

    public static function setInterval(callable $callback, int $interval): void;

    public static function clearTimeout(PMTask $task): void;

    public static function clearInterval(PMTask $task): void;
}

final class Task implements VTask {

    public static function setTimeout(callable $callback, int $delay): void {
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

    public static function setInterval(callable $callback, int $interval): void {
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

    public static function clearTimeout(PMTask $task): void {
        Data::getScheduler->cancelTask($task->getTaskId());
    }

    public static function clearInterval(PMTask $task): void {
        Data::getScheduler->cancelTask($task->getTaskId());
    }
}
