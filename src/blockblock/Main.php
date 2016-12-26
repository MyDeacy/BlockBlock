Gf<?php
namespace blockblock;


use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\event\entity\EntityExplodeEvent;


class Main extends PluginBase implements Listener {

	public function onEnable() {   
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->saveDefaultConfig();
		$this->reloadConfig();
	$this->getLogger()->info($this->lang("start"));
	if(!file_exists($this->getDataFolder())){
	mkdir($this->getDataFolder(), 0744, true);
}
	$this->data = new Config($this->getDataFolder() . "block.json", Config::JSON);
}

public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
	switch (strtolower($command->getName())) {

		case "bb":
			if($sender->isOp()){
		if(!isset($args[0])){
			$sender->sendMessage($this->lang("main"));
return false;
}

			if($args[0] == "set"){
			if(!isset($args[1])){
				$sender->sendMessage($this->lang("id_error"));
return false;
}	
					if($this->data->exists($args[1])){
						$sender->sendMessage($this->lang("set_error"));
			}else{
				
				$sender->sendMessage($this->lang("set_true"));
					$this->data->set($args[1], "true");
					$this->data->save();
					$this->data->getAll();
			}
		}elseif($args[0] == "unset"){
			if(!isset($args[1])){
				$sender->sendMessage($this->lang("unset_error"));
return false;
}	
					if($this->data->exists($args[1])){
						$sender->sendMessage($this->lang("unset_true"));
						$this->data->remove($args[1]);
						$this->data->save();
			}else{
				$sender->sendMessage($this->lang("unset_error"));
			}
			}else{
				$sender->sendMessage($this->lang("main"));
			}
			}else{
			$sender->sendMessage($this->lang("dont_permission"));
				return false;
}


}
}

public function onBreak(BlockBreakEvent $event){
	$player = $event->getPlayer();
			if($player->isOp()){
return false;
}
		$id = $event->getBlock()->getID();
		if($this->data->exists("$id")){
			$event->setCancelled();
}
}
	
public function onExplode(EntityExplodeEvent $explode){
	$explode->setCancelled();
                                        
                }
 public function lang($phrase){
		$lang = $this->getConfig()->get("Use_language");
        $urlh = $this->curl_get_contents("https://raw.githubusercontent.com/PMpluginMaker-Team/BlockBlock/master/lang/{$lang}.json"); 
        $url = json_decode($urlh, true); 
        return $url["{$phrase}"];
		}
public function curl_get_contents($url){
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
  $data = curl_exec($curl);
  curl_close($curl);
  return $data;
}               
}
