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

namespace arisify\geometry\format;

use arisify\geometry\element\Bone;
use arisify\geometry\element\Description;

class Geometry1120 extends Geometry{
    private Description $description;
    /** @var Bone[]|null */
    private ?array $bones; // Optional
    private ?string $cape; // Optional

    /**
     * @param Description $description
     * @param Bone[]|null $bones        Bones define the 'skeleton' of the mob: the parts that can be animated, and to which format and other bones are attached.
     * @param string|null $cape
     */
    public function __construct(Description $description, ?array $bones = null, ?string $cape = null) {
        $this->description = $description;
        $bs = [];
        foreach ($bones as $b) {
            $bs[$b->getName()] = $b;
        }
        $this->bones = $bs;
        $this->cape = $cape;
    }

    /**
     * @return Bone[]|null
     */
    public function getBones() : ?array{
        return $this->bones;
    }

    public function getBone(string $name) : ?Bone{
        return $this->bones[$name] ?? null;
    }

    /**
     * @param Bone[]|null $bones
     */
    public function setBones(?array $bones) : void{
        $this->bones = $bones;
    }

    public function addBone(Bone $bone, bool $override = false) : bool{
        if (!$override && isset($this->bones[$bone->getName()])) {
            return false;
        }
        $this->bones[$bone->getName()] = $bone;
        return true;
    }

    public function removeBone(string $name) : bool{
        if (!isset($this->bones[$name])) {
            return false;
        }
        unset($this->bones[$name]);
        return true;
    }

    /**
     * @return string|null
     */
    public function getCape() : ?string{
        return $this->cape;
    }

    /**
     * @param string|null $cape
     */
    public function setCape(?string $cape) : void{
        $this->cape = $cape;
    }

    /**
     * @return Description
     */
    public function getDescription() : Description{
        return $this->description;
    }

    /**
     * @param Description $description
     */
    public function setDescription(Description $description) : void{
        $this->description = $description;
    }

    public function getFormatVersion() : string{
        return "1.12.0";
    }

    public function toJson() : string{
        return "";
    }
}