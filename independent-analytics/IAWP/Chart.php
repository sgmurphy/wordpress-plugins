<?php

namespace IAWP;

use IAWP\Statistics\Intervals\Intervals;
use IAWP\Statistics\Statistics;
use IAWP\Utils\Security;
/** @internal */
class Chart
{
    private $statistics;
    private $is_preview;
    public function __construct(Statistics $statistics, bool $is_preview = \false)
    {
        $this->statistics = $statistics;
        $this->is_preview = $is_preview;
    }
    public function get_html() : string
    {
        $labels = \array_map(function ($data_point) {
            return Security::json_encode($this->statistics->chart_interval()->get_label_for($data_point[0]));
        }, $this->statistics->get_statistic('views')->statistic_over_time());
        $data = [];
        foreach ($this->statistics->get_statistics() as $statistic) {
            $data[$statistic->id()] = \array_map(function ($data_point) {
                return $data_point[1];
            }, $statistic->statistic_over_time());
        }
        $options = \IAWP\Dashboard_Options::getInstance();
        $primary_statistic = $this->statistics->get_statistic($options->primary_chart_metric_id());
        $secondary_statistic = \is_string($options->secondary_chart_metric_id()) ? $this->statistics->get_statistic($options->secondary_chart_metric_id()) : null;
        return \IAWPSCOPED\iawp_blade()->run('chart', ['chart' => $this, 'intervals' => Intervals::all(), 'current_interval' => $this->statistics->chart_interval(), 'available_datasets' => $this->statistics->get_grouped_statistics(), 'primary_chart_metric_id' => $primary_statistic->id(), 'secondary_chart_metric_id' => \is_null($secondary_statistic) ? null : $secondary_statistic->id(), 'stimulus_values' => ['locale' => \get_bloginfo('language'), 'is-preview' => $this->is_preview() ? '1' : '0', 'is-using-woo-commerce' => \IAWPSCOPED\iawp_using_woocommerce() ? '1' : '0', 'primary-chart-metric-id' => $primary_statistic->id(), 'primary-chart-metric-name' => $primary_statistic->name(), 'secondary-chart-metric-id' => \is_null($secondary_statistic) ? null : $secondary_statistic->id(), 'secondary-chart-metric-name' => \is_null($secondary_statistic) ? null : $secondary_statistic->name(), 'currency-value' => \IAWPSCOPED\iawp_using_woocommerce() ? get_woocommerce_currency() : null, 'labels' => $labels, 'data' => $data]]);
    }
    public function is_preview() : bool
    {
        return $this->is_preview;
    }
    public function encode_json(array $array) : string
    {
        return Security::json_encode($array);
    }
}
