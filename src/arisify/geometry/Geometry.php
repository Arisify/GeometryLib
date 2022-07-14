<?php
/**
 * This file is part of the GeometryLib ©2022
 *
 * @author Arisify
 * @link   https://github.com/Arisify
 * @license https://opensource.org/licenses/MIT MIT License
 *
 * •.,¸,.•*`•.,¸¸,.•*¯ ╭━━━━━━━━━━━━╮
 * •.,¸,.•*¯`•.,¸,.•*¯.|:::::::/\___/\
 * •.,¸,.•*¯`•.,¸,.•* <|:::::::(｡ ●ω●｡)
 * •.,¸,.•¯•.,¸,.•╰ *  し------し---Ｊ
 *
 */
declare(strict_types=1);

namespace arisify\geometry;

use arisify\geometry\element\Bone;
use arisify\geometry\element\Description;

class Geometry{
	/** @var Bone[] */
	private array $bones;

	public const MINECRAFT_GEOMETRY = "minecraft:geometry";
	public const FORMAT_VERSION = "format_version";
	public const DESCRIPTION = "description";
	public const BONES = "bones";

	/**
	 * @param string      $format_version
	 * @param Description $description
	 * @param Bone[]      $bones Bones define the 'skeleton' of the mob: the parts that can be animated, and to which geometry and other bones are attached.
	 * @param string|null $cape
	 * @param array|null  $rawData
	 */
	public function __construct(
		protected string      $format_version,
		protected Description $description,
	    ?array                 $bones = null, // Optional
		?string               $cape = null // Optional
	){
	}

	public function getFormatVersion() : string{
		return $this->format_version;
	}

	/*
	public function toJson(int $flags = 0) : string{
		if ($this->rawData !== null) {
			$this->description->toArray($this->rawData[self::DESCRIPTION]);
			$rawBones = $this->rawData[self::BONES];
			$bones = [];
			foreach ($this->bones as $bone) {
				// TODO: AJANJ
				//$bones[] = $bone->toArray($rawBones[$bone->()] ?? []);
			}
			$this->rawData[self::BONES] = $bones;
			try {
				return json_encode($this->rawData, $flags | JSON_THROW_ON_ERROR);
			} catch (\JsonException $e) {
				echo $e->getMessage() . "\n";
				return "";
			}
		}
		$content = [self::FORMAT_VERSION => $this->format_version];
		$content[self::MINECRAFT_GEOMETRY] = $this->description->toArray();
		try {
			return json_encode($content, $flags | JSON_THROW_ON_ERROR);
		} catch (\JsonException $e) {
			echo $e->getMessage() . "\n";
			return "";
		}
	}
	*/

	/**
	 * @return Description
	 */
	public function getDescription() : Description{
		return $this->description;
	}

	public function addBone(Bone $bone) : void{
		$this->bones[$bone->getName()] = $bone;
	}

	public function getBone(string $boneName) : ?Bone{
		return $this->bones[$boneName] ?? null;
	}
}