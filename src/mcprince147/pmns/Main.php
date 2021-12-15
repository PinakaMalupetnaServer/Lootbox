<?php

namespace mcprince147\pmns;

use pocketmine\command\{Command, CommandSender, ConsoleCommandSender};
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use mcprince147\pmns\lootboxs\CommonLootbox;
//use mcprince147\pmns\lootboxs\UncommonLootbox;
//use mcprince147\pmns\lootboxs\RareLootbox;
//use mcprince147\pmns\lootboxs\MythicLootbox;

class Core extends PluginBase implements Listener
{

	/** @var Config $data */
	public $data;

	public function onEnable(): void
	{
		$this->saveResource("config.yml");
		$this->data = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		Server::getInstance()->getCommandMap()->register("commonlootbox", new CommonLootbox($this));
		//Server::getInstance()->getCommandMap()->register("uncommonlootbox", new UncommonLootbox($this));
		//Server::getInstance()->getCommandMap()->register("rarelootbox", new RareLootbox($this));
		//Server::getInstance()->getCommandMap()->register("mythiclootbox", new MythicLootbox($this));

	}

	public function onInteract(PlayerInteractEvent $event){
		$player = $event->getPlayer();
		$hand = $player->getInventory()->getItemInHand();
		if($hand->getCustomName() === "§l§aCommon Lootbox"){
			$hand->setCount($hand->getCount() - 1);
			$player->getInventory()->setItemInHand($hand);
			$event->setCancelled(true);
			#Common Rewards
			# You can copy & paste this code if you want more rewards
			$itemId1 = (int)$this->data->get("common1id");
			$itemId2 = (int)$this->data->get("common2id");
			$itemId3 = (int)$this->data->get("common3id");
			$itemId4 = (int)$this->data->get("common4id");
			$itemId5 = (int)$this->data->get("common5id");
			#count
			$count1 = (int)$this->data->get("common1amount");
			$count2 = (int)$this->data->get("common2amount");
			$count3 = (int)$this->data->get("common3amount");
			$count4 = (int)$this->data->get("common4amount");
			$count5 = (int)$this->data->get("common5amount");
			#item
            $item1 = (int)Item::get($itemId1, 0, $count1);
            $item2 = (int)Item::get($itemId2, 0, $count2);
            $item3 = (int)Item::get($itemId3, 0, $count3);
            $item4 = (int)Item::get($itemId4, 0, $count4);
            $item5 = (int)Item::get($itemId5, 0, $count5);
			#gib
			$player->getInventory()->addItem($item1);
			$player->getInventory()->addItem($item2);
			$player->getInventory()->addItem($item3);
			$player->getInventory()->addItem($item4);
			$player->getInventory()->addItem($item5);
			$player->getLevel()->broadcastLevelSoundEvent(new Vector3($player->x, $player->y, $player->z), LevelSoundEventPacket::SOUND_RAID_HORN);
			$player->sendMessage("§l§a(§e!§a) §r§eYou've just opened §l§aCommon Lootbox §r§eAnd Got Many Rewards!");
			$player->addTitle("§l§a* §eCommon Lootbox! §a*");
			$player->addSubtitle("§l§bYou Receive Good Rewards");
			}
	}
}
			