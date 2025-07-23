<?php
/**
 * Logger Utility
 * Handles application logging
 */

class Logger
{
    private string $logFile;
    private string $dateFormat = 'Y-m-d H:i:s';
    
    public function __construct(string $logFile = 'app.log')
    {
        $this->logFile = LOG_PATH . '/' . $logFile;
        
        // Create log file if not exists
        if (!file_exists($this->logFile)) {
            touch($this->logFile);
        }
    }
    
    /**
     * Log info message
     */
    public function info(string $message, array $context = []): void
    {
        $this->log('INFO', $message, $context);
    }
    
    /**
     * Log error message
     */
    public function error(string $message, array $context = []): void
    {
        $this->log('ERROR', $message, $context);
    }
    
    /**
     * Log warning message
     */
    public function warning(string $message, array $context = []): void
    {
        $this->log('WARNING', $message, $context);
    }
    
    /**
     * Log debug message
     */
    public function debug(string $message, array $context = []): void
    {
        if (APP_ENV === 'development') {
            $this->log('DEBUG', $message, $context);
        }
    }
    
    /**
     * Write log entry
     */
    private function log(string $level, string $message, array $context = []): void
    {
        $timestamp = date($this->dateFormat);
        $contextStr = !empty($context) ? ' ' . json_encode($context, JSON_UNESCAPED_UNICODE) : '';
        
        $logEntry = "[{$timestamp}] {$level}: {$message}{$contextStr}" . PHP_EOL;
        
        // Write to file
        file_put_contents($this->logFile, $logEntry, FILE_APPEND | LOCK_EX);
        
        // Also log to error_log in development
        if (APP_ENV === 'development') {
            error_log("[{$level}] {$message}");
        }
    }
    
    /**
     * Get recent log entries
     */
    public function getRecentLogs(int $lines = 100): array
    {
        if (!file_exists($this->logFile)) {
            return [];
        }
        
        $content = file_get_contents($this->logFile);
        $logLines = explode(PHP_EOL, trim($content));
        
        return array_slice($logLines, -$lines);
    }
    
    /**
     * Clear log file
     */
    public function clearLogs(): bool
    {
        return file_put_contents($this->logFile, '') !== false;
    }
    
    /**
     * Get log file size
     */
    public function getLogSize(): int
    {
        return file_exists($this->logFile) ? filesize($this->logFile) : 0;
    }
    
    /**
     * Rotate log file if too large
     */
    public function rotateLogs(int $maxSize = 10485760): void // 10MB default
    {
        if ($this->getLogSize() > $maxSize) {
            $backupFile = $this->logFile . '.' . date('Y-m-d-H-i-s') . '.bak';
            rename($this->logFile, $backupFile);
            touch($this->logFile);
            
            $this->info('Log file rotated', ['backup' => $backupFile]);
        }
    }
}

?>