<?php

namespace core;

use Throwable;

class Logger {

    private static string $LOG_FILE = "./../../resources/logs/log.log";
    private static int $MAX_FILE_SIZE = 10241024;

    public function error(mixed $error): void {
        $this->write($error, "ERROR");
    }

    public function info(mixed $info): void {
        $this->write($info, "INFO");
    }

    private function write(mixed $message, string $level): void {
        $fileSize = filesize(self::$LOG_FILE);

        if ($fileSize >= self::$MAX_FILE_SIZE) {
            $this->rotateLogs();
        }

        $fileHandle = fopen(self::$LOG_FILE, 'a');

        $log = '[' . date('Y-m-d H:i:s') . '] ['. $level . '] ' . $message . PHP_EOL;

        try {
            fwrite($fileHandle, $log);
        } catch (Throwable) {
            return;
        } finally {
            fclose($fileHandle);
        }
    }

    private function rotateLogs(): void {
        $back = self::$LOG_FILE . '.' . date('Y-m-d_H-i-s');
        rename(self::$LOG_FILE, $back);
    }
}