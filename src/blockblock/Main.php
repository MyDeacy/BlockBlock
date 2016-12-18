<?php
namespace blockblock;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;


class Main extends PluginBase implements Listener {

	public function onEnable() {   
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
	if(!file_exists($this->getDataFolder())){
	mkdir($this->getDataFolder(), 0744, true);
}
	$this->data = new Config($this->getDataFolder() . "block.enum", Config::ENUM);
}

public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
	switch (strtolower($command->getName())) {

		case "bb":
			if($sender->isOp()){
		if(!isset($args[0]))
			$sender->sendMessage("§b========== 使用方法 ==========");
			$sender->sendMessage("/bb set <ブロックのid> 壊せないブロックを設定できます。");
			$sender->sendMessage("/bb unset <ブロックのID> 壊せないブロックを解除します。");
			$sender->sendMessage("§6※ブロックは何個でも指定できます。");
			return false;

			if($args[0] = "set"){
			if(!isset($args[1]))
				$sender->sendMessage("[§cBB§f]§6ブロックIDを指定してください。");
				return false;	
					if($this->config->exists("$args[1]")){
						$sender->sendMessage("[§cBB§f]§6既に登録されています。");
			}else{
				$sender->sendMessage("[§cBB§f]§6ID ".$args[1]." を壊せなくしました。");
					$this->data->set("$args[1]", "true");
					$this->data->save();
					$this->data->getAll();
			}
		}

		
}


}
}
}