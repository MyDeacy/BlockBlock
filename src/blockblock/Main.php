<?php
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
class Main extends PluginBase implements Listener{
	
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("§6BlockBlockプラグインをご利用いただき、ありがとうございます。");
        $this->getLogger()->info("§6不具合などが生じた際は、連絡をお願いします。");
        $this->getLogger()->info("§c[License] 二次配布、改造配布は禁止です。 §b製作者gigantessbeta");
        if(!file_exists($this->getDataFolder())) {
            mkdir($this->getDataFolder(), 0744, true);
        }
        $this->data = new Config($this->getDataFolder() . "block.json", Config::JSON);
    }
    public function onCommand(CommandSender $sender, Command $command, $label, array $args){
        switch(strtolower($command->getName())){
            case "bb":
                if($sender->isOp()){
                    if(!isset($args[0])){
                        $sender->sendMessage("§b========== 使用方法 ==========");
                        $sender->sendMessage("/bb set <ブロックのid> 壊せないブロックを設定できます。");
                        $sender->sendMessage("/bb unset <ブロックのID> 壊せないブロックを解除します。");
                        $sender->sendMessage("§6※ブロックは何個でも指定できます。");
                        return false;
                    }
                    if("$args[0]" == "set"){
                        if(!isset($args[1])){
                            $sender->sendMessage("[§cBB§f]§6 ブロックIDを指定してください。");
                            return false;
                        }
                        if($this->data->exists($args[1])){
                            $sender->sendMessage("[§cBB§f]§6 既に登録されています。");
                        }else{
                            $sender->sendMessage("[§cBB§f]§6ID " . $args[1] . " を壊せなくしました。");
                            $this->data->set("$args[1]", "true");
                            $this->data->save();
                            $this->data->getAll();
                        }
                    }elseif("$args[0]" == "unset"){
                        if(!isset($args[1])){
                            $sender->sendMessage("[§cBB§f]§6 ブロックIDを指定してください。");
                            return false;
                        }
                        if($this->data->exists("$args[1]")){
                            $sender->sendMessage("[§cBB§f]§6 ID " . $args[1] . " の破壊制限を解除しました。");
                            $this->data->remove("$args[1]");
                            $this->data->save();
                        }else{
                            $sender->sendMessage("[§cBB§f]§6 このブロックは制限を掛けられていません。");
                        }
                    }else{
                        $sender->sendMessage("§b========== 使用方法 ==========");
                        $sender->sendMessage("/bb set <ブロックのid> 壊せないブロックを設定できます。");
                        $sender->sendMessage("/bb unset <ブロックのID> 壊せないブロックを解除します。");
                        $sender->sendMessage("§6※ブロックは何個でも指定できます。");
                    }
                }else{
                    $sender->sendMessage("§cあなたはOPではありません。");
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

}
