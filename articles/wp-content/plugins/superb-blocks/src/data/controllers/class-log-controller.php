<?php

namespace SuperbAddons\Data\Controllers;

defined('ABSPATH') || exit();

use Exception;

class LogController
{
    const LOG_OPTION_KEY = 'superbaddons_errorlogs';
    const LOG_MAX_ENTRIES = 50;

    const CRON_SHARE_ERROR_LOGS = 'superbaddons_share_error_logs';
    const SHARE_ENDPOINT = 'addons-status/logs/share';
    const FEEDBACK_ENDPOINT = 'addons-status/feedback/share';

    public static function GetLogs()
    {
        return get_option(self::LOG_OPTION_KEY, false);
    }

    public static function HandleException($exception)
    {
        try {
            $settings = OptionController::GetSettings();
            if (!$settings[SettingsOptionKey::LOGS_ENABLED]) {
                return;
            }

            $exception_stack = array();
            $trace = $exception->getTrace();
            $code = $exception->getCode();
            $message = $exception->getMessage();
            $minimum_amount = 2;
            $current_trace = 1;
            $should_break_next = false;
            foreach ($trace as $trace_item) {
                $trace_class = $trace_item['class'] ?? 'Unknown Class';
                // Remove ABSPATH from trace to anonymize and prevent including server path
                $trace_item_string = sprintf("%s (%s): %s -> %s", str_replace(rtrim(ABSPATH, '/\\'), '', $trace_item['file'] ?? 'Unknown File'), $trace_item['line'] ?? '??', $trace_class, $trace_item['function'] ?? 'Unknown Function');

                array_push($exception_stack, $trace_item_string);
                if ($should_break_next) {
                    // Limit the number of traces to add to the stack
                    break;
                }
                if ($current_trace >= $minimum_amount && false === strpos($trace_class, "superb-blocks")) {
                    // Break after adding the next trace
                    $should_break_next = true;
                }
                $current_trace++;
            }
            $exception_stack = implode("\n\n", $exception_stack);

            if ($code > 0) {
                $message .= sprintf(" (Code: %d)", $code);
            }

            LogController::AddLog($message, $exception_stack);
        } catch (Exception $ex) {
            // do nothing if error log somehow fails
        }
    }

    private static function AddLog($title, $stack)
    {
        try {
            $logs = self::GetLogs();
            if (!$logs) {
                $logs = array();
            }

            $log_count = count($logs);
            // add new log entry
            if ($log_count >= self::LOG_MAX_ENTRIES) {
                // slice to only allow max number of log entries
                $logs = array_slice($logs, 1, self::LOG_MAX_ENTRIES);
            }

            if ($log_count >= 1 && isset($logs[$log_count - 1]['stack']) && $logs[$log_count - 1]['stack'] === $stack) {
                // Don't add duplicate log entries
                return;
            }

            array_push($logs, array(
                "time" => time(),
                "shared" => false,
                "version" => sanitize_text_field(SUPERBADDONS_VERSION),
                "title" => sanitize_text_field($title),
                "stack" => sanitize_textarea_field($stack)
            ));

            update_option(self::LOG_OPTION_KEY, $logs, false);
        } catch (Exception $e) {
            // do nothing if error log somehow fails
        }
    }

    public static function ClearLogs()
    {
        if (!self::GetLogs()) {
            return true;
        }

        return delete_option(self::LOG_OPTION_KEY);
    }

    public static function AddCronAction()
    {
        add_action(self::CRON_SHARE_ERROR_LOGS, array(self::class, 'ShareErrorLogsCronEvent'));
    }

    public static function MaybeSubscribeCron()
    {
        if (!wp_next_scheduled(self::CRON_SHARE_ERROR_LOGS)) {
            wp_schedule_event(time(), 'daily', self::CRON_SHARE_ERROR_LOGS);
        }
    }

    public static function ShareErrorLogsCronEvent()
    {
        try {
            $settings = OptionController::GetSettings();
            if (!$settings[SettingsOptionKey::LOG_SHARE_ENABLED]) {
                return;
            }

            $logs = self::GetLogs();
            if (!$logs) {
                return;
            }

            $logs_to_share = array();
            foreach ($logs as $log) {
                if (!$log['shared']) {
                    array_push($logs_to_share, $log);
                }
            }

            if (count($logs_to_share) === 0) {
                return;
            }

            $response = DomainShiftController::RemotePost(
                self::SHARE_ENDPOINT,
                array(
                    'headers' => array('Content-Type' => 'application/json'),
                    'method' => 'POST',
                    'body' => json_encode(
                        array(
                            'action' => 'share_error_logs',
                            'logs' => $logs_to_share
                        )
                    )
                )
            );
            $status = wp_remote_retrieve_response_code($response);
            if (!is_array($response) || is_wp_error($response) || $status !== 200) {
                throw new Exception(sprintf(__("Error logs could not be shared. Status %d.", "superb-blocks"), $status));
            }

            foreach ($logs as &$log) {
                $log['shared'] = true;
            }

            update_option(self::LOG_OPTION_KEY, $logs, false);
        } catch (Exception $ex) {
            self::HandleException($ex);
        }
    }

    public static function SendFeedback($message)
    {
        if (strlen($message) > 1000) {
            $message = substr($message, 0, 1000) . "...";
        }
        $response = DomainShiftController::RemotePost(
            self::FEEDBACK_ENDPOINT,
            array(
                'headers' => array('Content-Type' => 'application/json'),
                'method' => 'POST',
                'body' => json_encode(
                    array(
                        'action' => 'share_feedback',
                        'feedback' => array(
                            'message' => sanitize_text_field($message),
                            "time" => time(),
                            "premium" => KeyController::HasValidPremiumKey(),
                            "version" => sanitize_text_field(SUPERBADDONS_VERSION),
                        )
                    )
                )
            )
        );
        $status = wp_remote_retrieve_response_code($response);
        if (!is_array($response) || is_wp_error($response) || $status !== 200) {
            throw new Exception(sprintf(__("Feedback could not be shared. Status %d.", "superb-blocks"), $status));
        }
    }

    public static function MaybeUnsubscribeCron()
    {
        $timestamp = wp_next_scheduled(self::CRON_SHARE_ERROR_LOGS);
        if ($timestamp) {
            wp_unschedule_event($timestamp, self::CRON_SHARE_ERROR_LOGS);
        }
    }
}
