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
namespace zOmArRD\plugin\cmd;

use Cassandra\Custom;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\command\utils\CommandException;
use pocketmine\plugin\Plugin;
use zOmArRD\plugin\CustomMOTD;

class MotdChange extends Command implements PluginIdentifiableCommand
{
    /** @var CustomMOTD  */
    protected $plugin;

    public function __construct(CustomMOTD $customMOTD){
     $this->plugin = $customMOTD;
     $this->setPermission("custom.motd");
     parent::__construct(
         "motd",
         "Change the motd of this Server",
         "/motd <MOTD>"
     );
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender->hasPermission("custom.motd")) {
            if (count($args) === 1) {
                $motd = $args[0];

                $cfg = CustomMOTD::getCF("Config");
                $cfg->set("motd", $motd);
                $cfg->save();

                $this->plugin->getServer()->getNetwork()->setName($motd);
                $sender->sendMessage(CustomMOTD::PREFIX . " §aYou have successfully updated the Motd of the server.");
            } else {
                $sender->sendMessage(CustomMOTD::PREFIX . " §cUse: /motd <MOTD>");
            }
        } else {
            $sender->sendMessage(CustomMOTD::PREFIX . " §cYou don't have permission!");
        }
        return true;
    }

    public function getPlugin(): Plugin
    {
        // TODO: Implement getPlugin() method.
    }
}