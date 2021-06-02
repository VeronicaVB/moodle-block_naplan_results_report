<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * The graphs continuous assessment block
 *
 * @package    block_naplan_results_report
 * @copyright 2021 Veronica Bermegui
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'NAPLAN results report';
$string['pluginname_desc'] = 'This plugin depends on DW.';
$string['naplan_results_report'] = 'NAPLAN';
$string['naplan_results_report:addinstance'] = 'Add a new NAPLAN results  report block';
$string['naplan_results_report:myaddinstance'] = 'Add a new NAPLAN results block to My Moodle page';
$string['dbtype'] = 'Database driver';
$string['dbtype_desc'] = 'ADOdb database driver name, type of the external database engine.';
$string['dbhost'] = 'Database host';
$string['dbhost_desc'] = 'Type database server IP address or host name. Use a system DSN name if using ODBC. Use a PDO DSN if using PDO.';
$string['dbname'] = 'Database name';
$string['dbuser'] = 'Database user';
$string['dbpass'] = 'Database password';
$string['dbspnaplanresult'] = 'NAPLAN Results';
$string['dbspnaplanresult_desc'] = 'Stored procedure name to retrieve NAPLAN results';
$string['profileurl'] = 'Profile URL';
$string['profileurl_desc'] = 'Moodle\'s profile URL';
$string['nodbsettings'] = 'Please configure DB settings';
$string['reportlabel'] = 'NAPLAN Results';
$string['testarea'] = 'Test Area';
$string['reportunavailable'] = 'NAPLAN results report unavailable';
$string['naplanscale'] = 'National Assessment Program -Literacy and Numeracy National Assessment Scale';
$string['naplanscales'] = 'National Assessment URL';
$string['naplanscales_desc'] = 'URL to NAPLAN scales';
$string['bcyear3'] = 'Background colour year 3';
$string['bcyear3_desc'] = 'Background colour for bar in graph representing year 3';
$string['bcyear5'] = 'Background colour year 5';
$string['bcyear5_desc'] = 'Background colour for bar in graph representing year 5';
$string['bcyear7'] = 'Background colour year 7';
$string['bcyear7_desc'] = 'Background colour for bar in graph representing year 7';
$string['bcyear9'] = 'Background colour year 9';
$string['bcyear9_desc'] = 'Background colour for bar in graph representing year 9';