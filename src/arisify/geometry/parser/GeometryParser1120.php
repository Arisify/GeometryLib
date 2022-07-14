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
		if (!isset($model->{"minecraft:geometry"})) {
			throw new GeometryMissingRequiredItemException("minecraft:geometry not found!");
		}

		/** @var Geometry[] $models */
		$models = [];
		foreach ($model->{"minecraft:geometry"} as $geometry) {
			$models[] = self::parseGeometry($geometry);
		}
		return $models;
	}

	/**
	 * @param string|\stdClass $geometry
	 * @return Geometry
	 * @throws JsonException
	 */
	public static function parseGeometry(string|\stdClass $geometry) : Geometry{
		if (!$geometry instanceof \stdClass) {
			$geometry = json_decode($geometry, false, 512, JSON_THROW_ON_ERROR);
		}
		if (!isset($geometry->description)) {
			throw new GeometryMissingRequiredItemException("Missing description");
		}
		return new Geometry(
			format_version: self::FORMAT_VERSION,
			description: self::parseDescription($geometry->description),
			bones: self::parseBones($geometry?->bone), //array
			cape: $geometry?->cape //string
		);
	}

	/**
	 * @param string|\stdClass $description
	 * @return Description
	 * @throws JsonException
	 */
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
			identifier: $description->identifier, //type: string
			texture_width: $description?->texture_width, //type: int (> 0), opt
			texture_height: $description?->texture_height, //type: int (> 0), opt
			visible_bounds_width: $description?->visible_bounds_width, //type: number, opt
			visible_bounds_height: $description?->visible_bounds_height, //type: number, opt
			visible_bounds_offset: Utils::arraytovector($description?->visible_bounds_offset) //type: Vector3, opt
		);
	}

	/**
	 * @param string|array|\stdClass|null $bones
	 * @return Bone[]|null
	 * @throws JsonException
	 */
	public static function parseBones(string|array|null|\stdClass $bones) : ?array{
		if ($bones === null) {
			return null;
		}
		if (!$bones instanceof \stdClass) {
			$bones = json_decode($bones, false, 512, JSON_THROW_ON_ERROR);
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
	 * @param string|\stdClass|null $cubes
	 * @return Cube[]|null
	 * @throws JsonException
	 */
	public static function parseCubes(string|\stdClass|null $cubes) : ?array{
		if ($cubes === null) {
			return null;
		}
		if (!$cubes instanceof \stdClass) {
			$cubes = json_decode($cubes, false, 512, JSON_THROW_ON_ERROR);
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
	 * @param string|\stdClass|null $uv
	 * @param bool                  $eachFace
	 * @return Vector2|UV|null
	 * @throws JsonException
	 */
	public static function parseUV(string|\stdClass|null $uv, bool $eachFace = true) : Vector2|UV|null{
		if ($uv === null) {
			return null;
		}
		if (!$uv instanceof \stdClass) {
			$uv = json_decode($uv, false, 512, JSON_THROW_ON_ERROR);
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
