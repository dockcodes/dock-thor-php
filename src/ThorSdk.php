<?php

declare(strict_types=1);

namespace Dock\Thor;

use Dock\Thor\State\Hub;
use Dock\Thor\State\HubInterface;

final class ThorSdk
{
    /**
     * @var HubInterface|null
     */
    private static $currentHub;

    private function __construct()
    {
    }

    public static function init(): HubInterface
    {
        self::$currentHub = new Hub();

        return self::$currentHub;
    }

    public static function getCurrentHub(): HubInterface
    {
        if (null === self::$currentHub) {
            self::$currentHub = new Hub();
        }

        return self::$currentHub;
    }

    public static function setCurrentHub(HubInterface $hub): HubInterface
    {
        self::$currentHub = $hub;

        return $hub;
    }
}
