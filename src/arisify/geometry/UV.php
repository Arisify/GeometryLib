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

use pocketmine\math\Vector2;

class UV{
	/**
	 * @param Vector2|null $north Specifies the UV's for the face that stretches along the x and y axes, and faces the -z axis.
	 * @param Vector2|null $south Specifies the UV's for the face that stretches along the x and y axes, and faces the z axis
	 * @param Vector2|null $east Specifies the UV's for the face that stretches along the z and y axes, and faces the x axis
	 * @param Vector2|null $west Specifies the UV's for the face that stretches along the z and y axes, and faces the -x axis
	 * @param Vector2|null $up Specifies the UV's for the face that stretches along the x and z axes, and faces the y axis
	 * @param Vector2|null $down Specifies the UV's for the face that stretches along the x and z axes, and faces the -y axis
	 */
	public function __construct(
		public ?Vector2 $north = null,
		public ?Vector2 $south = null,
		public ?Vector2 $east = null,
		public ?Vector2 $west = null,
		public ?Vector2 $up = null,
		public ?Vector2 $down = null
	) {}

	/**
	 * @return Vector2
	 */
	public function getNorth() : Vector2{
		return $this->north ?? new Vector2(0, 0);
	}

	/**
	 * @param Vector2 $north
	 */
	public function setNorth(Vector2 $north) : void{
		$this->north = $north;
	}

	/**
	 * @return Vector2
	 */
	public function getSouth() : Vector2{
		return $this->south  ?? new Vector2(0, 0);
	}

	/**
	 * @param Vector2 $south
	 */
	public function setSouth(Vector2 $south) : void{
		$this->south = $south;
	}

	/**
	 * @return Vector2
	 */
	public function getEast() : Vector2{
		return $this->east ?? new Vector2(0, 0);
	}

	/**
	 * @param Vector2 $east
	 */
	public function setEast(Vector2 $east) : void{
		$this->east = $east;
	}

	/**
	 * @return Vector2
	 */
	public function getWest() : Vector2{
		return $this->west ?? new Vector2(0, 0);
	}

	/**
	 * @param Vector2 $west
	 */
	public function setWest(Vector2 $west) : void{
		$this->west = $west;
	}

	/**
	 * @return Vector2
	 */
	public function getUp() : Vector2{
		return $this->up ?? new Vector2(0, 0);
	}

	/**
	 * @param Vector2 $up
	 */
	public function setUp(Vector2 $up) : void{
		$this->up = $up;
	}

	/**
	 * @return Vector2
	 */
	public function getDown() : Vector2{
		return $this->down ?? new Vector2(0, 0);
	}

	/**
	 * @param Vector2 $down
	 */
	public function setDown(Vector2 $down) : void{
		$this->down = $down;
	}

	public function toArray(array &$default) : array{
		if ($this->north !== null) {
			$default["north"] = Utils::vectorToArray($this->north);
		}
		if ($this->south !== null) {
			$default["south"] = Utils::vectorToArray($this->south);
		}
		if ($this->east !== null) {
			$default["east"] = Utils::vectorToArray($this->east);
		}
		if ($this->west !== null) {
			$default["west"] = Utils::vectorToArray($this->west);
		}
		if ($this->up !== null) {
			$default["up"] = Utils::vectorToArray($this->up);
		}
		if ($this->down !== null) {
			$default["down"] = Utils::vectorToArray($this->down);
		}
		return $default;
	}
}