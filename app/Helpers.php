<?php

namespace App;

class Helpers
{
    public static function redirectTo($path) {
        header("Location: {$path}");
        exit;
    }

    public static function const($path = null) {
        if($path) {
            $config = $GLOBALS['config'];
            $path = explode('.', $path); //'mysql something no foo bar'
            foreach($path as $item) {
                if(isset($config[$item])) {
                    $config = $config[$item];
                }
            }
            return $config;
        }
        return false;
    }

    public static function getUserImage($image)
    {
        $imgDir = self::const('url.img');
        if (!$image || !file_exists($imgDir . $image)) {
            return self::const('url.path') . $imgDir . 'noavatar.png';
        }
        return self::const('url.path') . $imgDir . $image;
    }

    public static function getUserSocialLink ($link, $type)
    {
        $socialLinks = self::const('socialLinks');
        return $link ? $socialLinks[$type] . $link : '#';
    }

    public static function getUserStatus($allStatuses, $statusID)
    {
        foreach ($allStatuses as $status) {
            if ($status['id'] == $statusID) {
                return $status['interpretation'];
            }
        }
    }

    public static function uploadImage($image, $dir)
    {
        $newFileExt = pathinfo($image['name'], PATHINFO_EXTENSION);
        $newFileName = 'avatar_' . md5($image['name'] . time()) . '.' . $newFileExt;
        $destPath = $dir . $newFileName;
        if (move_uploaded_file($image['tmp_name'], $destPath)) {
            return $newFileName;
        }
    }

    public static function deleteImage($image, $dir)
    {
        $file = $dir . $image;
        if (is_file($file)) {
            return unlink($file);
        }
        return false;
    }
}