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

use pocketmine\math\Vector3;
use pocketmine\utils\SingletonTrait;

class GeometryManager{
	use SingletonTrait;

	/** @var Geometry[] */
	private array $geometry;

	public function loadGeometry(string $geometry) : bool{
		try {
			$object = json_decode($geometry, true, 512, JSON_THROW_ON_ERROR);
		} catch (\JsonException $e) {
			return false;
		}
		if (!isset($object[Geometry::MINECRAFT_GEOMETRY])) {
			return false;
		}
		$format_version = $object[Geometry::FORMAT_VERSION];
		$geometry = $object[Geometry::MINECRAFT_GEOMETRY];
		foreach ($geometry as $geo) {
			unset($object[Geometry::MINECRAFT_GEOMETRY]);
			$geometry[Geometry::MINECRAFT_GEOMETRY] = $geo;
			$description = $geo[Geometry::DESCRIPTION];
			$identifier = $description["identifier"];
			$vb_offset = $description["visible_bounds_offset"];
			$this->geometry[$identifier] = new Geometry(
				$format_version,
				new Description($identifier, $description["texture_width"], $description["texture_height"], $description["visible_bounds_width"], $description["visible_bounds_height"], new Vector3($vb_offset[0], $vb_offset[1], $vb_offset[2])),
				$geo[Geometry::BONES],
				$object
			);
		}
		return true;
	}

	public function removeGeometry(string $geometryName) : bool{
		if (isset($this->geometry[$geometryName])) {
			unset($this->geometry[$geometryName]);
			return true;
		}
		return false;
	}
}