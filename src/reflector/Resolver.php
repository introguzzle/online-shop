<?php

namespace reflector;

class Resolver {

    private static string $namespace = "reflector";
    private static string $this = "Resolver";

    public static function getPath(string $class, bool $extension = true): string {
        $inverse = function(string $class): string {
            return str_replace("\\", DIRECTORY_SEPARATOR, $class);
        };

        $dn = function(string $class, string $path): string {
            return str_contains($class, self::class) ||
            str_contains($class, self::$this)
                ? $path
                : str_replace(self::$namespace . "/", "", $path);
        };

        return $dn($class,
            __DIR__
            . '/'
            . $inverse($class)
            . ($extension ? ".php" : "")
        );
    }

    public static function getAllClasses(): array {
        $files = self::recursiveScanDirectory(self::getRelativeDir());

        $files = array_map(function(string $file): string {
            return self::getPath($file, false);
        }, $files);

        return array_filter($files, function($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'php';
        });
    }

    private static function getRelativeDir(): string {
        return str_replace("/reflector", "", __DIR__);
    }

    public static function recursiveScanDirectory(string $dir): array {
        $result = [];

        foreach(scandir($dir) as $filename) {
            if ($filename[0] === '.') continue;

            $filePath = $dir . DIRECTORY_SEPARATOR . $filename;

            if (is_dir($filePath) && !self::contains($filePath, ["public", "view"])) {
                foreach (self::recursiveScanDirectory($filePath) as $childFilename) {
                    $result[] = $filename . DIRECTORY_SEPARATOR . $childFilename;
                }
            } else {
                $result[] = $filename;
            }
        }

        return $result;
    }

    private static function contains(string $source, array $target): bool {
        foreach ($target as $item) {
            if (str_contains($source, $item))
                return true;
        }

        return false;
    }
}