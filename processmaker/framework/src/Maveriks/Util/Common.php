<?php
namespace Maveriks\Util;

class Common
{
    /**
     * Recursive version of glob php standard function
     *
     * @author Erik Amaru Ortiz <erik@colosa.com, aortiz.erik@gmail.com>
     * @param string $pattern pattern for native glob function
     * @param int|string $flags any valid flag for glob function
     * @param bool $onlyFiles to filter return array with only matched files, or all matched results
     * @return array array containing the recursive glob results
     *
     * Example:
     *
     *   Common::rglob("/example/path/*");
     *
     * it will returns:
     *
     *   Array
     *   (
     *       [0] => /example/path/README.txt
     *       [1] => /example/path/composer.json
     *       [4] => /example/path/one/one_text.txt
     *       [6] => /example/path/two/two_text.txt
     *       [7] => /example/path/two/two_one/two_one_text.txt
     *       [8] => /example/path/two/two_one/build.json
     *   )
     *
     * Example 2:
     *
     *   Common::rglob("/example/path/*.json");
     *
     * It will returns:
     *
     *   Array
     *   (
     *       [0] => /example/path/composer.json
     *       [1] => /example/path/two/two_one/build.json
     *   )
     */
    public static function rglob($pattern, $flags = 0, $onlyFiles = false)
    {
        $singlePattern = basename($pattern);

        if (strpos($singlePattern, "*") !== false) {
            $path = rtrim(str_replace($singlePattern, "", $pattern), DIRECTORY_SEPARATOR);
        } else {
            $singlePattern = "";
            $path = $pattern;
        }

        $files = glob("$path/$singlePattern", $flags);
        $dirs = glob("$path/*", GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);

        foreach ($dirs as $dir) {
            $files = array_merge($files, self::rglob("$dir/$singlePattern", $flags));
        }

        if ($onlyFiles) {
            $files = array_filter($files, function($v) { return is_dir($v) ? false : true;});
        }

        return $files;
    }

    /**
     * Returns the last version given a pattern of file name
     *
     * @param string $pattern a valid pattern for glob(...) native function
     * @param int $flag php flags for glob(...) native function
     * @return int|string
     *
     * Example:
     * - Given the following files inside a directory:
     *       /example/path/myApplication-v1.tar
     *       /example/path/myApplication-v2.tar
     *       /example/path/myApplication-v3.tar
     *       /example/path/myApplication-v5.tar
     *       /example/path/myApplication-v7.tar
     *
     * $lastVer = ProcessMaker\Util\Common::getLastVersion("/example/path/myApplication-*.tar");
     *
     * It will returns: 7
     */
    public static function getLastVersion($pattern, $flag = 0)
    {
        $files = glob($pattern, $flag);
        $maxVersion = 0;

        $pattern = str_replace("*", '([0-9\.]+)', basename($pattern));

        foreach ($files as $file) {
            $filename = basename($file);

            if (preg_match('/'.$pattern.'/', $filename, $match)) {

                if ($maxVersion < $match[1]) {
                    $maxVersion = $match[1];
                }
            }
        }

        return $maxVersion;
    }

    public static function parseIniFile($filename)
    {
        $data = @parse_ini_file($filename, true);
        $result = array();

        if ($data === false) {
            throw new \Exception("Error parsing ini file: $filename");
        }

        foreach ($data as $key => $value) {
            if (strpos($key, ':') !== false) {
                list($key, $subSection) = explode(':', $key);
                $result[trim($key)][trim($subSection)] = $value;
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    public static function mk_dir($strPath, $rights = 0777)
    {
        $folder_path = array($strPath);
        $oldumask = umask(0);
        while (!@is_dir(dirname(end($folder_path)))
            && dirname(end($folder_path)) != '/'
            && dirname(end($folder_path)) != '.'
            && dirname(end($folder_path)) != ''
        ) {
            array_push($folder_path, dirname(end($folder_path)));
        }

        while ($parent_folder_path = array_pop($folder_path)) {
            if (! @is_dir($parent_folder_path)) {
                if (! @mkdir($parent_folder_path, $rights)) {
                    umask($oldumask);
                }
            }
        }
    }
}