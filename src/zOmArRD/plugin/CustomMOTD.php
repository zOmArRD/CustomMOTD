<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: zOmArRD
 * Date: 09/12/20
 *       ___               _         ____  ____
 *  ____/ _ \ _ __ ___    / \   _ __|  _ \|  _ \
 * |_  / | | | '_ ` _ \  / _ \ | '__| |_) | | | |
 *  / /| |_| | | | | | |/ ___ \| |  |  _ <| |_| |
 * /___|\___/|_| |_| |_/_/   \_\_|  |_| \_\____/
 *
 */
namespace zOmArRD\plugin;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use zOmArRD\plugin\cmd\MotdChange;

class CustomMOTD extends PluginBase
{
    /** @var CustomMOTD|null */
    public static $instance;

    public $config;

    /** @var string  */
    public const PREFIX = "§7[§cCustomMOTD§7]";

    /**
     * Returns an instance of the plugin
     * @return CustomMOTD
     */
    public static function getInstance(): CustomMOTD
    {
        return self::$instance;
    }

    public function onLoad()
    {
        self::$instance = $this;
    }

    public function onEnable()
    {
        $motd = [
            "motd" => "§bCustomMOTD",
        ];
        $this->config = new Config($this->getDataFolder() . "Config.yml", Config::YAML, $motd);

        if (file_exists($this->getDataFolder() . "Config.yml")) {
            // TODO: NOPE BRUH
        } else {
            $this->saveResource("Config.yml");
            $this->getLogger()->info("CustomMOTD Config as been created.");
        }
        $this->initCMDR();
        $this->getLogger()->info(self::PREFIX . " §aLoaded!");
    }

    public function onDisable()
    {
        $this->getLogger()->info(self::PREFIX . " §cDisabled!");
    }

    public static function getCF(string $cfn)
    {
        return $file = new Config(CustomMOTD::getInstance()->getDataFolder() . $cfn . ".yml", Config::YAML);
    }

    private function initCMDR() : void
    {
        $this->getServer()->getCommandMap()->registerAll("CustomMOTD", [
            new MotdChange($this),
        ]);
    }
}