<?php

namespace App\Support;

class FileSystemHelper
{
    public static function hashDirectory(string $directory): string
    {
        if (!is_dir($directory)) {
            return false;
        }

        $hash = '';
        $dir = dir($directory);

        while (false !== ($file = $dir->read())) {
            if (!($file != '.' && $file != '..')) {
                continue;
            }

            $localHash = is_dir($directory.'/'.$file)
                ? static::hashDirectory($directory.'/'.$file)
                : md5_file($directory.'/'.$file);

            $hash = md5($localHash . $hash);
        }

        $dir->close();

        return $hash;
    }
}
