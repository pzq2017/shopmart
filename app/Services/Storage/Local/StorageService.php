<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/2
 * Time: 14:52
 */

namespace App\Services\Storage\Local;


class StorageService
{
    public function exist($file)
    {
        return \Storage::exists($file);
    }

    public function copy($fromFile, $toFile)
    {
        if ($this->exist($fromFile)) {
            $toFile = $this->getTargetFilePath($fromFile, $toFile);
            if (\Storage::copy($fromFile, $toFile)) {
                return $toFile;
            }
        }
        return false;
    }

    public function move($fromFile, $toFile)
    {
        if ($this->exist($fromFile)) {
            $toFile = $this->getTargetFilePath($fromFile, $toFile);
            if (\Storage::move($fromFile, $toFile)) {
                return $toFile;
            }
        }
        return false;
    }

    public function delete($file)
    {
        return \Storage::delete($file);
    }

    public function makeDir($dir)
    {
        if ($this->exist($dir) ==  false) {
            return \Storage::makeDirectory($dir);
        }
        return true;
    }

    private function getTargetFilePath($fromFile, $toFile)
    {
        if (isset($toFile['target_dir'])) {
            $this->makeDir($toFile['target_dir']);
            $targetFilePath =  $toFile['target_dir'] . '/' . self::getFileName($fromFile) . '.' . self::getFileExt($fromFile);
        } elseif (isset($toFile['target_path'])) {
            $this->makeDir(self::getFileDir($toFile['target_path']));
            $targetFilePath = $toFile['target_path'];
        } else {
            $this->makeDir(self::getFileDir($toFile));
            $targetFilePath = $toFile;
        }

        return $targetFilePath;
    }

    public static function getFileDir($filePath)
    {
        return pathinfo($filePath)['dirname'];
    }

    public static function getFileName($filePath)
    {
        return pathinfo($filePath)['filename'];
    }

    public static function getFileExt($filePath)
    {
        return pathinfo($filePath)['extension'];
    }
}