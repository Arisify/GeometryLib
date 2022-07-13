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

namespace arisify\geometry\parser;

use arisify\geometry\exception\GeometryInvalidFormatVersionException;
use arisify\geometry\exception\GeometryMissingFormatVersionException;
use arisify\geometry\exception\GeometryMissingRequiredItemException;
use arisify\geometry\Utils;
use JsonException;
use arisify\geometry\Geometry;
use arisify\geometry\element\Bone;
use arisify\geometry\element\Cube;
use arisify\geometry\element\Description;
use arisify\geometry\element\UV;
use function json_decode;
use pocketmine\math\Vector2;

class GeometryParser1120 implements GeometryParser{
	public const FORMAT_VERSION = "1.12.0";

	/**
	 * @param string|\stdClass $model
	 * @return Geometry[]
	 * @throws JsonException
	 */
	public static function parseModel(string|\stdClass $model) : array{
		if (!$model instanceof \stdClass) {
			$model = json_decode($model, false, 512, JSON_THROW_ON_ERROR);
		}
		if (!isset($model->format_version) || in_array($model->format_version, Utils::FORMAT_VERSION_LIST, true)) {
			throw new GeometryMissingFormatVersionException("Format version not found!");
		}

		/** @var Geometry[] $models */
		$models = [];
		foreach ($model->{"minecraft:geometry"} as $geometry) {
			$models[] = self::parseGeometry($geometry, $model->format_version);
		}
		return $models;
	}

	public static function parseGeometry(string|\stdClass $geometry, string $format_version) : Geometry{
		if (!$geometry instanceof \stdClass) {
			$geometry = json_decode($geometry, false, 512, JSON_THROW_ON_ERROR);
		}
		return new Geometry(
			$format_version,
			self::parseDescription($geometry->description),
		);
	}

	public static function parseDescription(string|\stdClass $description) : Description{
		if (!$description instanceof \stdClass) {
			$description = json_decode($description, false, 512, JSON_THROW_ON_ERROR);
		}
		if (!isset($description->identifier)) {
			throw new GeometryMissingRequiredItemException("Missing identifier");
		}
		// TODO: A json parser that validate the format
		// ?-> weird but does shorter than "$var ?? null" lol
		return new Description(
			$description->identifier, //type: string
			$description?->texture_width, //type: int (> 0), opt
			$description?->texture_height, //type: int (> 0), opt
			$description?->visible_bounds_width, //type: number, opt
			$description?->visible_bounds_height, //type: number, opt
			Utils::arraytovector($description?->visible_bounds_offset) //type: Vector3, opt
		);
	}

	/**
	 * @param string|\stdClass $bones
	 * @return Bone[]|null
	 */
	public static function parseBones(string|\stdClass $bones) : ?array{
		// TODO: Implement parseBones() method.
		return null;
	}

	/**
	 * @param string|\stdClass $cubes
	 * @return Cube[]|null
	 */
	public static function parseCubes(string|\stdClass $cubes) : ?array{
		// TODO: Implement parseCubes() method.
		return null;
	}

	public static function parseUV(string|\stdClass $uv, bool $eachFace = true) : Vector2|UV|null{
		// TODO: Implement parseUV() method.
		return null;
	}

	public static function checkFormatVersion(string $version) : bool{
		return $version === self::FORMAT_VERSION;
	}

	public static function parseLocators(string $version) : array{
		return [];
	}
}
