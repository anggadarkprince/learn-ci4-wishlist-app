<?php

namespace App\Libraries;

class File
{
    /**
     * Move uploaded file.
     *
     * @param $from
     * @param $to
     * @param string $base
     * @return bool
     */
    public function move($from, $to, $base = WRITEPATH)
    {
        $this->makeFolder(dirname($to));
        if (file_exists($base . $from) && is_writable($base)) {
            return rename($base . $from, $base . $to);
        }
        return false;
    }

    /**
     * Move uploaded file.
     *
     * @param $from
     * @param $to
     * @param string $base
     * @return bool
     */
    public function copy($from, $to, $base = WRITEPATH)
    {
        $this->makeFolder(dirname($to));
        if (file_exists($base . $from) && is_writable($base)) {
            return copy($base . $from, $base . $to);
        }
        return false;
    }

    /**
     * Delete given folder or file.
     *
     * @param $path
     * @param string $base
     * @return bool
     */
    public function delete($path, $base = WRITEPATH)
    {
        if (file_exists($base . $path) && is_writable($base . $path)) {
            if (is_dir($base . $path) && !empty($path)) {
                $this->deleteRecursive($base . $path);
                return true;
            } else {
                return unlink($base . $path);
            }
        }
        return false;
    }

    /**
     * Delete folder and its content recursively.
     *
     * @param $dir
     */
    private function deleteRecursive($dir)
    {
        foreach (scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) $this->deleteRecursive("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }

    /**
     * Create folder if it does not exist.
     *
     * @param $directory
     * @param string $base
     * @return bool
     */
    public function makeFolder($directory, $base = WRITEPATH)
    {
        if (!file_exists($base . $directory) && is_writable($base)) {
            return mkdir($base . $directory, 0777, true);
        }
        return false;
    }

    /**
     * Get folder size.
     *
     * @param $dir
     * @return int
     */
    public function folderSize($dir)
    {
        $size = 0;
        foreach (glob(rtrim($dir, '/') . '/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : $this->folderSize($each);
        }
        return $size;
    }

}