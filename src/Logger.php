<?php

class Logger {

    private static string $LOG_FILE = "./../../resources/log.log";
    public function error(string $error): void {
        $this->write($error, "ERROR");
    }

    public function info(string $info): void {
        $this->write($info, "INFO");
    }

    private function write(string $message, string $level): void {
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
}