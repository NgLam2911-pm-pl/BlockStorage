<?php

namespace LamPocketVN\BlockStorage;

use pocketmine\plugin\PluginBase;
use pocketmine\{Player, Server};
use pocketmine\utils\Config;
use pocketmine\block\Block;
use pocketmine\level\Level;

class BlockStorage extends PluginBase
{
	public $data;
	private static $instance = null;
	
	public static function getInstance()
	{
		return self::$instance;
	}
	
	public function getData()
	{
		return $this->data;
	}
	public function saveData()
	{
		$this->config->setAll($this->data);
		$this->config->save();
	}
	public function onLoad()
	{
		self::$instance = $this;
	}
	public function onEnable()
	{
		@mkdir($this->getDataFolder());
		$this->saveResource("data.yml");
		$this->config = new Config($this->getDataFolder() . "data.yml", Config::YAML);
		$this->data = $this->config->getAll();
	}
	public function onDisable()
	{
		$this->saveData();
	}
	public function setBlockData(Block $block, $sdata)
	{
		$x = $block->getX();
		$y = $block->getY();
		$z = $block->getZ();
		$pos = $x.'-'.$y.'-'.$z;
		$level = $block->getLevel()->getName();
		$this->data[$level][$pos]['data'] = $sdata;
	}
	public function getBlockData(Block $block)
	{
		$x = $block->getX();
		$y = $block->getY();
		$z = $block->getZ();
		$pos = $x.'-'.$y.'-'.$z;
		$level = $block->getLevel()->getName();
		if (!isset($this->getData()[$level][$pos]['data']))
		{
			return "";
		}
		return $this->getData()[$level][$pos]['data'];
	}
	public function IsHasData(Block $block): bool
	{
		if ($this->getBlockData($block) === "")
		{
			return false;
		}
		else 
		{
			return true;
		}
	}
}