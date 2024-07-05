<?php

namespace app\config;

use Dotenv\Dotenv;

class Backup {

    private static $backupDir = __DIR__ . '/backups';
    private static $logFile = __DIR__ . '/backup_log.txt';
    private static $errorLogFile = __DIR__ . '/backup_error_log.txt';

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
            'port' =>   $_ENV['DB_PORT'],
            'socket' => $_ENV['DB_SOCKET']
        ];
    }

    private static function canRunBackup() {
        if (!file_exists(self::$logFile)) {
            return true;
        }

        $lastBackupTime = file_get_contents(self::$logFile);
        $lastBackupTimestamp = strtotime($lastBackupTime);
        $currentTimestamp = time();

        self::loadEnv();

        return ($currentTimestamp - $lastBackupTimestamp) >= $_ENV["HORAS_BACKUP"] * 60 * 60;

    }

    private static function logBackupTime() {
        file_put_contents(self::$logFile, date('Y-m-d H:i'));
    }

    private static function logError($message) {
        file_put_contents(self::$errorLogFile, date('Y-m-d H:i') . " - $message\n", FILE_APPEND);
    }

    private static function createIndexFile() {
        $indexFilePath = self::$backupDir . '/index.php';
        $indexFileContent = "<?php\n\nheader(\"location: ../../../\");";
        file_put_contents($indexFilePath, $indexFileContent);
    }

    public static function runBackup() {
        if (self::canRunBackup()) {
            self::loadEnv();
            $env = self::getEnvVariables();
            $date = date('Y-m-d__H-i');
            $backupFile = self::$backupDir . "/NS__backup_$date.sql";

            if (!is_dir(self::$backupDir)) {
                mkdir(self::$backupDir, 0755, true);
                self::createIndexFile();
            }
            

            if($env['socket'] == "C:/xampp/mysql/bin/mysqldump.exe"){
                $mysqldumpPath = 'C:/xampp/mysql/bin/mysqldump.exe';
                $command = "$mysqldumpPath --host={$env['host']} --port={$env['port']} --user={$env['user']} --password={$env['pass']} {$env['db']} > $backupFile";       

            }else{
                $mysqldumpPath = 'mysqldump';
                $command = "$mysqldumpPath --host={$env['host']} --port={$env['port']} --user={$env['user']} --password={$env['pass']} --socket={$env['socket']} {$env['db']} > $backupFile";
            }

            exec($command . ' 2>&1', $output, $returnVar);

            if ($returnVar === 0 && filesize($backupFile) > 0) {
                self::logBackupTime();
            } else {
                if (file_exists($backupFile)) {
                    unlink($backupFile);
                }
                self::logError("Backup failed. Command: $command. Output: " . implode("\n", $output));
            }
        } 
    }
}

?>
