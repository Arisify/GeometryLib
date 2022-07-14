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

use arisify\geometry\Geometry;
use arisify\geometry\Utils;
use arisify\geometry\element\Bone;
use arisify\geometry\element\Cube;
use arisify\geometry\element\Description;
use arisify\geometry\element\UV;
use arisify\geometry\exception\GeometryMissingFormatVersionException;
use arisify\geometry\exception\GeometryMissingRequiredItemException;

use arisify\jsonhelper\JsonHelper;
use arisify\jsonhelper\JsonObject;

use pocketmine\math\Vector2;

class GeometryParser1120 implements GeometryParser{
	public const FORMAT_VERSION = "1.12.0";

	/**
	 * @param JsonObject $model
	 * @return Geometry[]
	 */
	public static function parseModel(JsonObject $model) : array{
		if ($model->getProperty("format_version") === null) {
			throw new GeometryMissingFormatVersionException("Format version not found!");
		}
		$geometries = JsonHelper::getAsObject($model, "minecraft:geometry");
		if ($geometries === null) {
			throw new GeometryMissingRequiredItemException("minecraft:geometry not found!");
		}

		/** @var Geometry[] $models */
		$models = [];
		foreach ($geometries as $geometry) {
			$models[] = self::parseGeometry(new JsonObject($geometry, ["description"]));
		}
		return $models;
	}

	/**
	 * @param JsonObject $geometry
	 * @return Geometry
	 */
	public static function parseGeometry(JsonObject $geometry) : Geometry{
		$description = JsonHelper::getAsObject($geometry, "description");
		$bones = JsonHelper::getAsArray($geometry, "bones");
		$cape = JsonHelper::getAsString($geometry, "cape");
		if ($description === null) {
			throw new GeometryMissingRequiredItemException("Missing description");
		}
		$description = self::parseDescription(new JsonObject($description, ["identifier"]));
		if ($bones !== null) {
			$bb = [];
			foreach ($bones as $bone) {
				$b = self::parseBone(new JsonObject($bone, ["name"]));
				if ($b !== null) {
					$bb[$b->getName()] = $b;
				}
			}
			$bones = $bb;
		}

		return new Geometry(
			format_version: self::FORMAT_VERSION,
			description: $description,
			bones: $bones,
			cape: $cape
		);
	}

	/**
	 * @param JsonObject $description
	 * @return Description
	 */
	public static function parseDescription(JsonObject $description) : Description{
		$identifier = JsonHelper::getAsString($description, $description);
		if ($identifier === null) {
			throw new GeometryMissingRequiredItemException("Missing identifier");
		}
		// TODO: A json parser that validate the format
		// ?-> weird but does shorter than "$var ?? null" lol
		return new Description(
			identifier: $identifier, //type: string
			texture_width: $description?->texture_width, //type: int (> 0), opt
			texture_height: $description?->texture_height, //type: int (> 0), opt
			visible_bounds_width: $description?->visible_bounds_width, //type: number, opt
			visible_bounds_height: $description?->visible_bounds_height, //type: number, opt
			visible_bounds_offset: Utils::arraytovector($description?->visible_bounds_offset) //type: Vector3, opt
		);
	}

	/**
	 * @param JsonObject|null $bones
	 * @return Bone|null
	 */
	public static function parseBone(?JsonObject $bones) : ?Bone{
		if ($bones === null) {
			return null;
		}
		$bone_data = [];
		foreach ($bones as $bone) {
			if (!isset($bone->name)) {
				throw new GeometryMissingRequiredItemException("Missing bone name");
			}
			$bone_data[] = new Bone(
				name: $bone->name,
				cubes: $bone?->cubes,
				rotation: Utils::arraytovector($bone?->rotation),
				pivot: Utils::arraytovector($bone?->pivot),
				locators: $bone?->locators,
				parent: $bone?->parent,
				mirror: $bone?->mirror,
				reset: $bone?->reset,
				debug: $bone?->debug,
				bind_pose_rotation: Utils::arraytovector($bone?->bind_pose_rotation),
				inflate: $bone?->inflate,
				neverRender: $bone?->neverRender,
				render_group_id: $bone?->render_group_id,
				poly_mesh: $bone?->poly_mesh,
				texture_meshes: $bone?->texture_meshes
			);
		}
		return empty($bone_data) ? null : $bone_data;
	}

	/**
	 * @param JsonObject|null $cubes
	 * @return Cube[]|null
	 */
	public static function parseCube(?JsonObject $cubes) : ?array{
		if ($cubes === null) {
			return null;
		}
		$cube_data = [];
		foreach ($cubes as $cube) {
			$cube_data[] = new Cube(
				origin: Utils::arraytovector($cube->origin),
				size: Utils::arraytovector($cube->size),
				rotation: Utils::arraytovector($cube->rotation),
				pivot: Utils::arraytovector($cube->pivot),
				inflate: $cube->inflat,
				mirror: $cube->mirror,
				uv: self::parseUV($cube->uv),
			);
		}
		return $cube_data;
	}

	/**
	 * @param JsonObject|null $uv
	 * @param bool            $eachFace
	 * @return Vector2|UV|null
	 */
	public static function parseUV(?JsonObject $uv, bool $eachFace = true) : Vector2|UV|null{
		if ($uv === null) {
			return null;
		}
		return null;
	}

	public static function checkFormatVersion(string $version) : bool{
		return $version === self::FORMAT_VERSION;
	}

	public static function parseLocators(string|\stdClass $locators) : array{
		return [];
	}

	public static function parsePolyMesh(string|\stdClass $poly_mesh) : array{
		return  [];
	}

	public static function parseTextureMeshes(string|\stdClass $texture_meshes) : array{
		return  [];
	}
}
