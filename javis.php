<?php
/**
 * Plugin main file.
 *
 * @copyright 2021 BIG 5 Concepts GmbH
 * @license   https://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @link      https://javis.de
 *
 * @wordpress-plugin
 * Plugin Name: Javis
 * Plugin URI:  https://javis.de
 * Description: Mit diesem Plugin können Veranstaltungen der Seminar- und Veranstaltungsverwaltung Javis in WordPress angezeigt werden.
 * Version:     1.2.0
 * Author:      JOHN IT GmbH
 * Author URI:  https://john-it.com
 * License:     Proprietary
 * Text Domain: javis
 */

namespace b5c\Javis;

define('JAVIS_PLUGIN_PATH', dirname(__FILE__));

spl_autoload_register(__NAMESPACE__ . '\\javis_autoload');
function javis_autoload($cls)
{
    $cls = ltrim($cls, '\\');
    if (strpos($cls, __NAMESPACE__) !== 0)
        return;

    $cls = str_replace(__NAMESPACE__, '', $cls);

    $path = JAVIS_PLUGIN_PATH .
        str_replace('\\', DIRECTORY_SEPARATOR, $cls) . '.php';

    require_once($path);
}

function javis_get_sorting_function($key, $order)
{
    $sorting = array(
        'appointment' => function (\b5c\Javis\Model\JAVIS_Seminar $a, \b5c\Javis\Model\JAVIS_Seminar $b) use ($order) {
            $aAppointment = $a->getAppointments()[0] ?? null;
            $bAppointment = $b->getAppointments()[0] ?? null;
            if ($aAppointment === null || !$bAppointment === null)
                return 0;

            $aDate = new \DateTime();
            if (isset($aAppointment) && $aAppointment != null) {
                $aDate = $aAppointment->getStart();
            }

            $bDate = new \DateTime();
            if (isset($bAppointment) && $bAppointment != null) {
                $bDate = $bAppointment->getStart();
            }

            if ($aDate == $bDate) {
                return 0;
            }

            if($order == 'desc') {
                return ($aDate < $bDate) ? 1 : -1;
            }
            return ($aDate < $bDate) ? -1 : 1;
        },
        'number' => function (\b5c\Javis\Model\JAVIS_Seminar $a, \b5c\Javis\Model\JAVIS_Seminar $b) use ($order) {
            if ($a->getNumber() == $b->getNumber()) {
                return 0;
            }
            if($order == 'desc') {
                return ($a->getNumber() < $b->getNumber()) ? 1 : -1;
            }
            return ($a->getNumber() < $b->getNumber()) ? -1 : 1;
        }
    );

    if (!isset($sorting[$key])) {
        return function ($a, $b) {
            return 0;
        };
    }

    return $sorting[$key];
}

function javis_func($attr)
{
    $param = shortcode_atts(array(
        'instance' => '',
        'tag' => '',
        'sort' => 'appointment',
        'order' => 'asc',
    ), $attr);

    $tag = $param['tag'];

    if (empty($param['instance'])) {
        return 'Keine Javis-Instanz angegeben.';
    }

    try {
        $client = new \b5c\Javis\JAVIS_Client($param['instance']);
        $seminars = $client->getSeminars(function (\b5c\Javis\Model\JAVIS_Seminar $seminar) use ($tag) {
            $tags = $seminar->getTags();
            // nur Seminare mit Tag
            if (!empty($tag) && ($tags === null || !in_array($tag, $tags))) {
                return false;
            }


            $firstDate = $seminar->getAppointments()[0] ?? null;

            // nur zukünftige Termine
            if (isset($firstDate) && $firstDate->getStart() < new \DateTime) {
                return false;
            }

            return true;
        }, javis_get_sorting_function($param['sort'], $param['order']));

        $columnAmount = 5; // Wird gebraucht für eine korrekte Darstellung der "Keine Seminare verfügbar" Nachricht.
        $table = <<<TABLE
<div class="javis table-1">
<table width="100%">
<thead><tr>
<th align="left">Nr.</th>
<th align="left">Termin</th>
<th align="left">Ort</th>
<th align="left">Titel</th>
<th align="left">Info/Preise</th>
</tr></thead>
<tbody>
TABLE;

        foreach ($seminars as $seminar) {
            /**
             * @var \b5c\Javis\Model\JAVIS_Seminar $seminar
             * @var \b5c\Javis\Model\JAVIS_Appointment $firstDate
             */
            $firstDate = $seminar->getAppointments()[0] ?? null;
            $resources = $seminar->getResources();

            $preis = $seminar->getPrice();

            $table .= '<tr>';
            $table .= '<td>' . $seminar->getNumber() . '</td>';
            if ($firstDate instanceof \b5c\Javis\Model\JAVIS_Appointment
                && $firstDate->getStart() instanceof \DateTime
                && $firstDate->getEnd() instanceof \DateTime
            ) {
                $table .= '<td>'
                    . $firstDate->getStart()->format('d.m.Y') . '<br>'
                    . $firstDate->getStart()->format('H:i') . ' bis ' . $firstDate->getEnd()->format('H:i')
                    . '</td>';
            } else {
                $table .= '<td></td>';
            }
            $table .= '<td>' . $seminar->getLocation() . '</td>';
            $table .= '<td>' . $seminar->getTitle() . '</td>';
            if ($seminar->getPlaces()->getAvailable() == 0) {
                $table .= '<td><i>Ausgebucht</i></td>';
            } else {
                $table .= '<td>' . $preis . ' inkl. MwSt.<br><a target="_blank" href="' . $resources['overview'] . '">Weiter</a></td>';
            }
            $table .= '</tr>';
        }

        if (count($seminars) == 0) {
            $table .= '<tr><td colspan="' . $columnAmount . '" align="center"><i>Keine Seminare verfügbar.</i></td></tr>';
        }

        $table .= '</tbody></table></div>';

        return $table;
    } catch (\Exception $e) {
        return "Javis-Daten konnten nicht geladen werden.";
    }
}

add_shortcode('javis', __NAMESPACE__ . '\\javis_func');
