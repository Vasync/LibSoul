<?php

declare(strict_types=1);

namespace vasync\soul;

use vasync\soul\Data;
use pocketmine\plugin\PluginBase;

final class Soul {

    public static function init(PluginBase $plugin) {
        if (Data::getReg() !== true) {
            Data::setReg();
            Data::setupScheduler($plugin->getScheduler());
        }
    }
}
