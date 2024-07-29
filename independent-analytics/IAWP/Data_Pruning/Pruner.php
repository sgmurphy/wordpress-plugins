<?php

namespace IAWP\Data_Pruning;

use IAWP\Illuminate_Builder;
use IAWP\Query;
/** @internal */
class Pruner
{
    private $cutoff_date;
    private function __construct()
    {
        $this->cutoff_date = (new \IAWP\Data_Pruning\Pruning_Scheduler())->get_pruning_cutoff_as_datetime();
    }
    private function run()
    {
        if (\is_null($this->cutoff_date)) {
            return;
        }
        $db = Illuminate_Builder::get_connection();
        $db->transaction(function () {
            $sessions_table = Query::get_table_name(Query::SESSIONS);
            Illuminate_Builder::get_builder()->from($sessions_table)->where('created_at', '<', $this->cutoff_date->format('Y-m-d\\TH:i:s'))->delete();
            // Delete orphaned views
            $views_table = Query::get_table_name(Query::VIEWS);
            $this->delete_session_orphans($views_table, 'session_id');
            // Delete orphaned form submissions
            $form_submissions_table = Query::get_table_name(Query::FORM_SUBMISSIONS);
            $this->delete_session_orphans($form_submissions_table, 'session_id');
            // Delete orphaned WooCommerce orders
            $wc_orders_table = Query::get_table_name(Query::WC_ORDERS);
            $this->delete_view_orphans($wc_orders_table, 'view_id', 'id');
            // Delete orphaned visitors
            $visitors_table = Query::get_table_name(Query::VISITORS);
            $this->delete_session_orphans($visitors_table, 'visitor_id');
            // Delete orphaned resources
            $resources_table = Query::get_table_name(Query::RESOURCES);
            $this->delete_view_orphans($resources_table, 'id', 'resource_id');
            // Delete orphaned referrers
            $referrers_table = Query::get_table_name(Query::REFERRERS);
            $this->delete_session_orphans($referrers_table, 'id', 'referrer_id');
            // Delete orphaned forms
            $forms_table = Query::get_table_name(Query::FORMS);
            Illuminate_Builder::get_builder()->from($forms_table, 'orphans')->leftJoin("{$form_submissions_table} AS form_submissions", "orphans.form_id", '=', "form_submissions.form_id")->whereNull('form_submissions.form_id')->delete();
            // Delete orphaned device browsers
            $device_browsers_table = Query::get_table_name(Query::DEVICE_BROWSERS);
            $this->delete_session_orphans($device_browsers_table, 'device_browser_id');
            // Delete orphaned device oss
            $device_oss_table = Query::get_table_name(Query::DEVICE_OSS);
            $this->delete_session_orphans($device_oss_table, 'device_os_id');
            // Delete orphaned device types
            $device_types_table = Query::get_table_name(Query::DEVICE_TYPES);
            $this->delete_session_orphans($device_types_table, 'device_type_id');
            // Don't touch cities or countries for now
            // This would be a very different custom query as cities reference countries
            // Delete orphaned campaigns
            $campaigns_table = Query::get_table_name(Query::CAMPAIGNS);
            $this->delete_session_orphans($campaigns_table, 'campaign_id');
        });
    }
    private function delete_session_orphans(string $table, string $column, ?string $sessions_column = null) : int
    {
        $sessions_table = Query::get_table_name(Query::SESSIONS);
        $sessions_column = $sessions_column ?? $column;
        return Illuminate_Builder::get_builder()->from($table, 'orphans')->leftJoin("{$sessions_table} AS sessions", "orphans.{$column}", '=', "sessions.{$sessions_column}")->whereNull('sessions.session_id')->delete();
    }
    private function delete_view_orphans(string $table, string $column, ?string $views_column = null) : int
    {
        $views_table = Query::get_table_name(Query::VIEWS);
        $views_column = $views_column ?? $column;
        return Illuminate_Builder::get_builder()->from($table, 'orphans')->leftJoin("{$views_table} AS views", "orphans.{$column}", '=', "views.{$views_column}")->whereNull('views.id')->delete();
    }
    public static function register_hook()
    {
        \add_action('iawp_prune', function () {
            self::prune();
        });
    }
    public static function prune()
    {
        $pruner = new self();
        $pruner->run();
    }
}
