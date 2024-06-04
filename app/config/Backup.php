<?php

namespace app\config;

use Dotenv\Dotenv;

class Backup {

    private static $backupDir = __DIR__ . '/backups';
    private static $logFile = __DIR__ . '/backup_log.txt';

    public static function loadEnv() {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
    }

    private static function getEnvVariables() {
        return [
            'host' =>   $_ENV["DB_HOST"],
            'db'   =>   $_ENV['DB_DATABASE'],
            'user' =>   $_ENV['DB_USER'],
            'pass' =>   $_ENV['DB_PASSWORD'],
            'port' =>   $_ENV['DB_PORT']
        ];
    }

    private static function canRunBackup() {
        if (!file_exists(self::$logFile)) {
            return true;
        }

        $lastBackupTime = file_get_contents(self::$logFile);
        $lastBackupTimestamp = strtotime($lastBackupTime);
        $currentTimestamp = time();

        return ($currentTimestamp - $lastBackupTimestamp) >= 1;
    }

    private static function logBackupTime() {
        file_put_contents(self::$logFile, date('Y-m-d H:i:s'));
    }

    public static function runBackup() {
        if (self::canRunBackup()) {
            self::loadEnv();
            $env = self::getEnvVariables();
            $date = date('Y-m-d_H-i-s');
            $backupFile = self::$backupDir . "/backup_$date.sql";

            if (!is_dir(self::$backupDir)) {
                mkdir(self::$backupDir, 0755, true);
            }

            $mysqldumpPath = 'C:/xampp/mysql/bin/mysqldump.exe';
            $command = "$mysqldumpPath --host={$env['host']} --port={$env['port']} --user={$env['user']} --password={$env['pass']} {$env['db']} > $backupFile";

            exec($command . ' 2>&1', $output, $returnVar);

            if ($returnVar === 0 && filesize($backupFile) > 0) {
                self::logBackupTime();
            } else {
                if (file_exists($backupFile)) {
                    unlink($backupFile);
                }
            }
        } 
    }
}
