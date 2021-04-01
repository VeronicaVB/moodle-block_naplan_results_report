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
 * Continuous reporting block
 *
 * @package    block_naplan_results_report
 * @copyright 2021 Veronica Bermegui
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/naplan_results_report/lib.php');

class block_naplan_results_report extends block_base
{

    public function init()
    {
        $this->title = get_string('pluginname', 'block_naplan_results_report');
    }

    public function get_content()
    {
        global  $OUTPUT, $DB, $PAGE;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';
        $config = get_config('block_naplan_results_report');

        // Check DB settings are available
        if (
            empty($config->dbtype) ||
            empty($config->dbhost) ||
            empty($config->dbuser) ||
            empty($config->dbpass) ||
            empty($config->dbname) ||
            empty($config->dbspnaplanresult)
        ) {
            $notification = new \core\output\notification(
                get_string('nodbsettings', 'block_naplan_results_report'),
                \core\output\notification::NOTIFY_ERROR
            );
            $notification->set_show_closebutton(false);
            return $OUTPUT->render($notification);
        }

        try {
            if (naplan_results_report\can_view_on_profile()) {
                $profileuser = $DB->get_record('user', ['id' => $PAGE->url->get_param('id')]);
                $data = naplan_results_report\get_template_contexts($profileuser->username);
                
                $this->content->text = $OUTPUT->render_from_template('block_naplan_results_report/main', $data);
            } 
        } catch (\Throwable $th) {
        }
    }

    public function instance_allow_multiple()
    {
        return false;
    }

    public function instance_allow_config()
    {
        return false;
    }

    public function has_config()
    {
        return true;
    }

    public function hide_header()
    {
        return true;
    }
}
