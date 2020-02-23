<?php

namespace LamPocketVN\BlockStorage;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;

class EventListener implements Listener
{
	private $plugin;
	
	public function __construct (BlockStorage $plugin)
	{
		$this->plugin = $plugin;
	}
	
	public function getPlugin()
	{
		return $this->plugin;
	}
	
	public function onBreak (BlockBreakEvent $event)
	{
		$block = $event->getBlock();
		if ($this->getPlugin()->IsHasData($block) == true)
		{
			$this->getPlugin()->setBlockData($block, null);
		}
	}
}