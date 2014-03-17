<?php
/**
 * Created by PhpStorm.
 * User: Lamin Sanneh
 * Date: 3/7/14
 * Time: 11:43 AM
 */
namespace Thirdyear\Services\Interfaces;
interface VideoServiceInterface {
    public function getVideosByName($name);
    public function getVideoById($id);
    public function getRelatedVideos($id);
}