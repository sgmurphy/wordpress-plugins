<?php

namespace IAWP\Tables;

use IAWP\Filter_Lists\Device_Browser_Filter_List;
use IAWP\Filter_Lists\Device_OS_Filter_List;
use IAWP\Filter_Lists\Device_Type_Filter_List;
use IAWP\Rows\Device_Browsers;
use IAWP\Rows\Device_OSS;
use IAWP\Rows\Device_Types;
use IAWP\Statistics\Device_Browser_Statistics;
use IAWP\Statistics\Device_OS_Statistics;
use IAWP\Statistics\Device_Type_Statistics;
use IAWP\Tables\Columns\Column;
use IAWP\Tables\Groups\Group;
use IAWP\Tables\Groups\Groups;
/** @internal */
class Table_Devices extends \IAWP\Tables\Table
{
    protected function table_name() : string
    {
        return 'devices';
    }
    protected function groups() : Groups
    {
        $groups = [];
        $groups[] = new Group('device_type', \__('Device Type', 'independent-analytics'), Device_Types::class, Device_Type_Statistics::class);
        $groups[] = new Group('os', \__('OS', 'independent-analytics'), Device_OSS::class, Device_OS_Statistics::class);
        $groups[] = new Group('browser', \__('Browser', 'independent-analytics'), Device_Browsers::class, Device_Browser_Statistics::class);
        return new Groups($groups);
    }
    protected function local_columns() : array
    {
        $columns = [new Column(['id' => 'device_type', 'name' => \__('Type', 'independent-analytics'), 'visible' => \true, 'type' => 'select', 'options' => Device_Type_Filter_List::options(), 'database_column' => 'device_types.device_type_id', 'unavailable_for' => ['browser', 'os']]), new Column(['id' => 'os', 'name' => \__('Operating System', 'independent-analytics'), 'visible' => \true, 'type' => 'select', 'options' => Device_OS_Filter_List::options(), 'database_column' => 'device_oss.device_os_id', 'unavailable_for' => ['device_type', 'browser']]), new Column(['id' => 'browser', 'name' => \__('Browser', 'independent-analytics'), 'visible' => \true, 'type' => 'select', 'options' => Device_Browser_Filter_List::options(), 'database_column' => 'device_browsers.device_browser_id', 'unavailable_for' => ['device_type', 'os']]), new Column(['id' => 'visitors', 'name' => \__('Visitors', 'independent-analytics'), 'visible' => \true, 'type' => 'int']), new Column(['id' => 'views', 'name' => \__('Views', 'independent-analytics'), 'visible' => \true, 'type' => 'int']), new Column(['id' => 'sessions', 'name' => \__('Sessions', 'independent-analytics'), 'type' => 'int']), new Column(['id' => 'average_session_duration', 'name' => \__('Session Duration', 'independent-analytics'), 'visible' => \true, 'type' => 'int', 'filter_placeholder' => 'Seconds']), new Column(['id' => 'views_per_session', 'name' => \__('Views Per Session', 'independent-analytics'), 'type' => 'int']), new Column(['id' => 'bounce_rate', 'name' => \__('Bounce Rate', 'independent-analytics'), 'visible' => \true, 'type' => 'int']), new Column(['id' => 'visitors_growth', 'name' => \__('Visitors Growth', 'independent-analytics'), 'type' => 'int', 'exportable' => \false]), new Column(['id' => 'views_growth', 'name' => \__('Views Growth', 'independent-analytics'), 'type' => 'int', 'exportable' => \false])];
        return \array_merge($columns, $this->get_woocommerce_columns(), $this->get_form_columns());
    }
}
