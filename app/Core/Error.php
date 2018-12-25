<?php

namespace App\Core;


class Error
{
    /**
     * Registers itself as error and exception handler.
     */
    public static function register()
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            if (!($errno && error_reporting())) {
                return;
            }

            $options = array(
                'type'    => $errno,
                'message' => $errstr,
                'file'    => $errfile,
                'line'    => $errline,
                'isError' => true,
            );

            static::handle($options);
        });

        set_exception_handler(function ($e) {
            $options = array(
                'type'        => $e->getCode(),
                'message'     => $e->getMessage(),
                'file'        => $e->getFile(),
                'line'        => $e->getLine(),
                'isException' => true,
                'exception'   => $e,
            );

            static::handle($options);
        });

        register_shutdown_function(function () {
            if (!is_null($options = error_get_last())) {
                static::handle($options);
            }
        });
    }

    /**
     * Logs the error and dispatches an error controller.
     *
     * @param \Phalcon\Error\Error $error
     *
     * @return mixed
     */
    public static function handle($error)
    {
        $type    = isset($error['type']) ? $error['type'] : false;
        $message = isset($error['message']) ? $error['message'] : false;
        $file    = isset($error['file']) ? $error['file'] : false;
        $line    = isset($error['line']) ? $error['line'] : false;

        $type    = static::getErrorType($type);
        $message = "$type: {$message} in {$file} on line {$line}" . PHP_EOL;
        //logger msg
        self::logger($message);
    }

    /**
     * Maps error code to a string.
     *
     * @param int $code
     *
     * @return string
     */
    public static function getErrorType($code)
    {
        switch ($code) {
            case 0:
                return 'Uncaught exception';
            case E_ERROR:
                return 'E_ERROR';
            case E_WARNING:
                return 'E_WARNING';
            case E_PARSE:
                return 'E_PARSE';
            case E_NOTICE:
                return 'E_NOTICE';
            case E_CORE_ERROR:
                return 'E_CORE_ERROR';
            case E_CORE_WARNING:
                return 'E_CORE_WARNING';
            case E_COMPILE_ERROR:
                return 'E_COMPILE_ERROR';
            case E_COMPILE_WARNING:
                return 'E_COMPILE_WARNING';
            case E_USER_ERROR:
                return 'E_USER_ERROR';
            case E_USER_WARNING:
                return 'E_USER_WARNING';
            case E_USER_NOTICE:
                return 'E_USER_NOTICE';
            case E_STRICT:
                return 'E_STRICT';
            case E_RECOVERABLE_ERROR:
                return 'E_RECOVERABLE_ERROR';
            case E_DEPRECATED:
                return 'E_DEPRECATED';
            case E_USER_DEPRECATED:
                return 'E_USER_DEPRECATED';
        }

        return $code;
    }

    /**
     * 日志记录
     *
     * @param $data
     * @param bool $type
     * @return array
     */
    public static function logger($data, $type = false)
    {
        try {
            return Log::debug($data, 'error.log');
        } catch (\Exception $e) {
            if (defined('PRO') && !PRO) {
                echo sprintf(
                    '%s file %s line %s exception: %s',
                    date('Y-m-d H:i:s'),
                    $e->getFile(),
                    $e->getLine(),
                    $e->getMessage()
                );
            }
        }
    }
}
