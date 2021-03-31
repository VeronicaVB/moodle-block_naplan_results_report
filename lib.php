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
 *  NAPLAN report block
 *
 * @package    block_naplan_results_report
 * @copyright 2021 Veronica Bermegui
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace naplan_results_report;

/**
 * Returns the context for the template
 * @return string
 */

function get_template_contexts($username)
{

    $results = get_naplan_results($username);

    $years = [];
    $areasdetails = [];

    foreach ($results as $result) {

        $years['year'][] = $result->testleveldescription;
        $r = new \stdClass();
        $r->value = $result->testresultdescription;
        $areasdetails[$result->testareadescription]['result'][] = $r;
    }


    $years = array_unique($years['year']);
    $yearlabels = [];

    foreach ($years as $year) {
        $y = new \stdClass();
        $y->year = $year;
        $yearlabels['label'][] = $y;
    }

    foreach ($areasdetails as $area => $results) {
        $summary = new \stdClass();
        $summary->area = $area;
        $summary->results = $results;

        $summaries['summaries'][] = $summary;
    }


    $data = ['years' => $yearlabels, 'testarea' => $summaries, 'hasdata' => !empty($summaries)];
   
    return $data;
}


/**
 * Call to the SP 
 */
function get_naplan_results($username)
{

    try {

        $config = get_config('block_naplan_results_report');

        // Last parameter (external = true) means we are not connecting to a Moodle database.
        $externalDB = \moodle_database::get_driver_instance($config->dbtype, 'native', true);

        // Connect to external DB
        $externalDB->connect($config->dbhost, $config->dbuser, $config->dbpass, $config->dbname, '');

        $sql = 'EXEC ' . $config->dbspnaplanresult . ' :id';

        $params = array(
            'id' => $username,
        );

        $naplanresults = $externalDB->get_records_sql($sql, $params);

        return $naplanresults;

    } catch (\Exception $ex) {
        throw $ex;
    }
}


// Parent view of own child's activity functionality
function can_view_on_profile()
{
    global $DB, $USER, $PAGE;

    $config = get_config('block_naplan_results_report');
    if ($PAGE->url->get_path() ==  $config->profileurl) {
        // Admin is allowed.
        $profileuser = $DB->get_record('user', ['id' => $PAGE->url->get_param('id')]);

        if (is_siteadmin($USER) && $profileuser->username != $USER->username) {
            return true;
        }

        // Students are allowed to see timetables in their own profiles.
        if ($profileuser->username == $USER->username && !is_siteadmin($USER)) {
            return true;
        }

        // Parents are allowed to view timetables in their mentee profiles.
        $mentorrole = $DB->get_record('role', array('shortname' => 'parent'));

        if ($mentorrole) {

            $sql = "SELECT ra.*, r.name, r.shortname
                FROM {role_assignments} ra
                INNER JOIN {role} r ON ra.roleid = r.id
                INNER JOIN {user} u ON ra.userid = u.id
                WHERE ra.userid = ?
                AND ra.roleid = ?
                AND ra.contextid IN (SELECT c.id
                    FROM {context} c
                    WHERE c.contextlevel = ?
                    AND c.instanceid = ?)";
            $params = array(
                $USER->id, //Where current user
                $mentorrole->id, // is a mentor
                CONTEXT_USER,
                $profileuser->id, // of the prfile user
            );
            $mentor = $DB->get_records_sql($sql, $params);
            if (!empty($mentor)) {
                return true;
            }
        }
    }

    return false;
}
