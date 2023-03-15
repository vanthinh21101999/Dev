<?php

namespace Dev\Banner\Api\Data;

interface PostInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const BANNER_ID = 'banner_id';
    const NAME = 'name';
    const IMG = 'img';
    const STATUS = 'status';
    const SHORT_DESCRIPTION = 'short_description';

    /**
     * @return int
     */
    public function getBannerId(): int;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getImg(): string;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     *
     * @return string
     */
    public function getShortDescription(): string;

    /**
     * @param int $bannerId
     * @return PostInterface
     */
    public function setBannerId(int $bannerId): PostInterface;

    /**
     * @param string $name
     * @return PostInterface
     */
    public function setName(string $name): PostInterface;

    /**
     * @param string $img
     * @return PostInterface
     */
    public function setImg(string $img): PostInterface;

    /**
     * @param string $status
     * @return PostInterface
     */
    public function setStatus(string $status): PostInterface;

    /**
     * @param string $shortDescription
     * @return PostInterface
     */
    public function setShortDescription(string $shortDescription): PostInterface;

}
