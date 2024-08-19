<?php

declare(strict_types=1);

namespace vasync\soul;

use pocketmine\scheduler\TaskScheduler;

final class Data {

    public static bool $isRegister = false;
    
    public static ?TaskScheduler $scheduler = null;

    public static function setReg(bool $reg = true): void {
        self::$isRegister = $reg;
    }
        
    public static function getReg(): bool {
        return self::$isRegister;
    }
    
    public static function setupScheduler(TaskScheduler $scheduler): void {
        self::$scheduler = $scheduler;
    }
    
    public static function getScheduler(): ?TaskScheduler {
        return self::$scheduler;
    }
}
