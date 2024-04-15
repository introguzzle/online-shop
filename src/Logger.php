<?php

class Logger {

    private static string $LOG_FILE = "./../../resources/logs/log.log";
    private static int $MAX_FILE_SIZE = 10241024;

    public function error(string $error): void {
        $this->write($error, "ERROR");
    }

    public function info(string $info): void {
        $this->write($info, "INFO");
    }

    private function write(string $message, string $level): void {
        $fileSize = filesize(self::$LOG_FILE);

        if ($fileSize >= self::$MAX_FILE_SIZE) {
            $this->rotateLogs();
        }

        $fileHandle = fopen(self::$LOG_FILE, 'a');

        $log = '[' . date('Y-m-d H:i:s') . '] ['. $level . '] ' . $message . PHP_EOL;

        try {
            fwrite($fileHandle, $log);
        } catch (Throwable $t) {
            return;
        } finally {
            fclose($fileHandle);
        }
    }

    private function rotateLogs(): void {
        $next = self::$LOG_FILE . '.' . date('Y-m-d_H-i-s');
        rename(self::$LOG_FILE, $next);
    }
}