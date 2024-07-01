<?php

namespace IAWP\Rows;

use IAWP\Form_Submissions\Form;
use IAWP\Illuminate_Builder;
use IAWP\Models\Geo;
use IAWP\Query;
use IAWP\WooCommerce_Order;
use IAWPSCOPED\Illuminate\Database\Query\Builder;
use IAWPSCOPED\Illuminate\Database\Query\JoinClause;
/** @internal */
class Countries extends \IAWP\Rows\Rows
{
    public function attach_filters(Builder $query) : void
    {
        $query->joinSub($this->query(\true), 'country_rows', function (JoinClause $join) {
            $join->on('country_rows.country_id', '=', 'sessions.country_id');
        });
    }
    protected function fetch_rows() : array
    {
        $rows = $this->query()->get()->all();
        return \array_map(function ($row) {
            return new Geo($row);
        }, $rows);
    }
    private function query(?bool $skip_pagination = \false) : Builder
    {
        if ($skip_pagination) {
            $this->number_of_rows = null;
        }
        $views_table = Query::get_table_name(Query::VIEWS);
        $sessions_table = Query::get_table_name(Query::SESSIONS);
        $wc_orders = Query::get_table_name(Query::WC_ORDERS);
        $countries_table = Query::get_table_name(Query::COUNTRIES);
        $woo_commerce_query = Illuminate_Builder::get_builder();
        $woo_commerce_query->select(['wc_orders.view_id AS view_id'])->selectRaw('IFNULL(COUNT(DISTINCT wc_orders.order_id), 0) AS wc_orders')->selectRaw('IFNULL(ROUND(CAST(SUM(wc_orders.total) AS DECIMAL(10, 2))), 0) AS wc_gross_sales')->selectRaw('IFNULL(ROUND(CAST(SUM(wc_orders.total_refunded) AS DECIMAL(10, 2))), 0) AS wc_refunded_amount')->selectRaw('IFNULL(SUM(wc_orders.total_refunds), 0) AS wc_refunds')->from($wc_orders, 'wc_orders')->whereIn('wc_orders.status', WooCommerce_Order::tracked_order_statuses())->whereBetween('wc_orders.created_at', $this->get_current_period_iso_range())->groupBy('wc_orders.view_id');
        $countries_query = Illuminate_Builder::get_builder();
        $countries_query->select('countries.country_id', 'countries.country_code', 'countries.country', 'countries.continent')->selectRaw('COUNT(DISTINCT views.id)  AS views')->selectRaw('COUNT(DISTINCT sessions.visitor_id)  AS visitors')->selectRaw('COUNT(DISTINCT sessions.session_id)  AS sessions')->selectRaw('ROUND(AVG( TIMESTAMPDIFF(SECOND, sessions.created_at, sessions.ended_at))) AS average_session_duration')->selectRaw('COUNT(DISTINCT IF(sessions.final_view_id IS NULL, sessions.session_id, NULL))  AS bounces')->selectRaw('IFNULL(SUM(wc.wc_orders), 0) AS wc_orders')->selectRaw('IFNULL(SUM(wc.wc_gross_sales), 0) AS wc_gross_sales')->selectRaw('IFNULL(SUM(wc.wc_refunded_amount), 0) AS wc_refunded_amount')->selectRaw('IFNULL(SUM(wc_refunds), 0) AS wc_refunds')->selectRaw('IFNULL(SUM(form_submissions.form_submissions), 0) AS form_submissions')->tap(function (Builder $query) {
            foreach (Form::get_forms() as $form) {
                $query->selectRaw("SUM(IF(form_submissions.form_id = ?, form_submissions.form_submissions, 0)) AS {$form->submissions_column()}", [$form->id()]);
            }
        })->from($views_table, 'views')->leftJoin($countries_query->raw($sessions_table . ' AS sessions'), function (JoinClause $join) {
            $join->on('views.session_id', '=', 'sessions.session_id');
        })->join($countries_query->raw($countries_table . ' AS countries'), function (JoinClause $join) {
            $join->on('sessions.country_id', '=', 'countries.country_id');
        })->leftJoinSub($woo_commerce_query, 'wc', function (JoinClause $join) {
            $join->on('wc.view_id', '=', 'views.id');
        })->leftJoinSub($this->get_form_submissions_query(), 'form_submissions', function (JoinClause $join) {
            $join->on('form_submissions.view_id', '=', 'views.id');
        })->whereBetween('views.viewed_at', $this->get_current_period_iso_range())->whereBetween('sessions.created_at', $this->get_current_period_iso_range())->when(\count($this->filters) > 0, function (Builder $query) {
            foreach ($this->filters as $filter) {
                if (!$this->is_a_calculated_column($filter->column())) {
                    $filter->apply_to_query($query);
                }
            }
        })->groupBy('countries.country_id')->having('views', '>', 0)->when(!$this->is_using_a_calculated_column(), function (Builder $query) {
            $query->when($this->sort_configuration->is_column_nullable(), function (Builder $query) {
                $query->orderByRaw("CASE WHEN {$this->sort_configuration->column()} IS NULL THEN 1 ELSE 0 END");
            })->orderBy($this->sort_configuration->column(), $this->sort_configuration->direction())->orderBy('country')->when(\is_int($this->number_of_rows), function (Builder $query) {
                $query->limit($this->number_of_rows);
            });
        });
        $previous_period_query = Illuminate_Builder::get_builder();
        $previous_period_query->select(['sessions.country_id'])->selectRaw('SUM(sessions.total_views) AS previous_period_views')->selectRaw('COUNT(DISTINCT sessions.visitor_id) AS previous_period_visitors')->from($sessions_table, 'sessions')->whereBetween('sessions.created_at', $this->get_previous_period_iso_range())->groupBy('sessions.country_id');
        $outer_query = Illuminate_Builder::get_builder();
        $outer_query->selectRaw('countries.*')->selectRaw('IF(sessions = 0, 0, views / sessions) AS views_per_session')->selectRaw('IFNULL((views - previous_period_views) / previous_period_views * 100, 0) AS views_growth')->selectRaw('IFNULL((visitors - previous_period_visitors) / previous_period_visitors * 100, 0) AS visitors_growth')->selectRaw('IFNULL(bounces / sessions * 100, 0) AS bounce_rate')->selectRaw('ROUND(CAST(wc_gross_sales - wc_refunded_amount AS DECIMAL(10, 2))) AS wc_net_sales')->selectRaw('IF(visitors = 0, 0, (wc_orders / visitors) * 100) AS wc_conversion_rate')->selectRaw('IF(visitors = 0, 0, (wc_gross_sales - wc_refunded_amount) / visitors) AS wc_earnings_per_visitor')->selectRaw('IF(wc_orders = 0, 0, ROUND(CAST(wc_gross_sales / wc_orders AS DECIMAL(10, 2)))) AS wc_average_order_volume')->selectRaw('IF(visitors = 0, 0, (form_submissions / visitors) * 100) AS form_conversion_rate')->tap(function (Builder $query) {
            foreach (Form::get_forms() as $form) {
                $query->selectRaw("IF(visitors = 0, 0, ({$form->submissions_column()} / visitors) * 100) AS {$form->conversion_rate_column()}");
            }
        })->when(\count($this->filters) > 0, function (Builder $query) {
            foreach ($this->filters as $filter) {
                if ($this->is_a_calculated_column($filter->column())) {
                    $filter->apply_to_query($query);
                }
            }
        })->fromSub($countries_query, 'countries')->leftJoinSub($previous_period_query, 'previous_period_stats', 'countries.country_id', '=', 'previous_period_stats.country_id')->when($this->is_using_a_calculated_column(), function (Builder $query) {
            $query->when($this->sort_configuration->is_column_nullable(), function (Builder $query) {
                $query->orderByRaw("CASE WHEN {$this->sort_configuration->column()} IS NULL THEN 1 ELSE 0 END");
            })->orderBy($this->sort_configuration->column(), $this->sort_configuration->direction())->orderBy('country')->when(\is_int($this->number_of_rows), function (Builder $query) {
                $query->limit($this->number_of_rows);
            });
        });
        return $outer_query;
    }
}
