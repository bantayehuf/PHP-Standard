<?php
/**
 * Logger class to log admin actions.
 * @author Zablon Dawit <zabjd22@gmail.com>
 * @package Lib\Utils
 */
namespace Lib\Utils;

//use Lib\Config\DBController as Database;

class Logger
{    
    /**
     * Logs actions of Admin
     * @var string $context Context of actions performed.
     */
    public static function Log($context): bool
    {
        $log_file = self::GetLogFile();

        //We don't need to log into database because the system will crush to record the logs in the database for the cause of database is already crushed.
        /*$db_handler = new Database;
        $query = <<<SQL
            INSERT INTO tbl_log
            SET admin_id=? , log_dump=?
        SQL;
        $values=array(ADMIN_ID,$context);
        $logged=$db_handler->baseQuery($query, $values);*/
        
        if(self::LogToFile($log_file, $context))// 
            return true;
        return false;
    }

    public static function LogFileCreated(): bool
    {
        return file_exists(LOG_FILE_PATH);
    }

    public static function GetLogFile()
    {
        if(!self::LogFileCreated())
        {
            $log_file = fopen(LOG_FILE_PATH, 'w');
            return $log_file;
        }

        $log_file = fopen(LOG_FILE_PATH, 'a');
        return $log_file;
    }

    protected static function LogToFile($log_file, $context): bool
    {
        if(!is_writable(LOG_FILE_PATH))
            return false;
        
        $admin_id = ADMIN_ID;
        $created_date = date("D-M-Y h:m:s A", date('now'));
        fwrite($log_file, "$created_date - [admin: {$admin_id}] - {$context}" . PHP_EOL);
        fclose($log_file);
        return true;
    }
}