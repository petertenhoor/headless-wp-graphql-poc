<?php

namespace PTH;

/**
 * Class Log
 *
 * @package PTH
 */
class Log
{
    const FORMAT_PRINT_R = 'print_r';
    const FORMAT_VAR_DUMP = 'var_dump';
    const FORMAT_EXPORT = 'export';

    /**
     * Get last debug trace line
     *
     * @return string
     */
    public static function getLastDebugTraceLine()
    {
        $trace = '';
        $backTrace = (array)debug_backtrace();
        $lastDebugTrace = isset($backTrace[1]) ? $backTrace[1] : null;
        if ($lastDebugTrace) {
            $file = $lastDebugTrace['file'];
            $line = $lastDebugTrace['line'];
            $trace = sprintf(__('Called from line %1$d of file %2$s', 'pth'), $line, $file);
        }
        return $trace;
    }

    /**
     * Print log data in /wp-content/debug.log when constant `WP_DEBUG_LOG` and `WP_DEBUG` are set
     *
     * @param mixed $data
     * @param string $export_type
     */
    public static function log($data, $export_type = 'var_dump')
    {
        if (WP_DEBUG_LOG === true && WP_DEBUG === true) {
            if (is_string($data)) {
                error_log($data);
            } else {
                ob_start();
                switch ($export_type) {
                    case Log::FORMAT_EXPORT:
                        var_export($data);
                        break;
                    case Log::FORMAT_VAR_DUMP:
                        var_dump($data);
                        break;
                    case Log::FORMAT_PRINT_R:
                    default:
                        print_r($data);
                        break;
                }
                $data = ob_get_clean();
                error_log($data);
            }
        }
    }
}