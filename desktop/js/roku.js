
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

$('#bt_healthroku').on('click', function () {
    $('#md_modal').dialog({title: "{{Santé Roku}}"});
    $('#md_modal').load('index.php?v=d&plugin=roku&modal=health').dialog('open');
});

$('#bt_syncchannel').on('click', function () {
		bootbox.confirm('{{Voulez-vous lancer une synchronistation de vos chaînes }}', function (result) {
			if (result) {
        $.ajax({// fonction permettant de faire de l'ajax
            type: "POST", // methode de transmission des données au fichier php
            url: "plugins/roku/core/ajax/roku.ajax.php", // url du fichier php
            data: {
            	action: "syncchannel",
				ip : $('.eqLogicAttr[data-l1key=configuration][data-l2key=addr]').value(),
            },
            dataType: 'json',
            error: function (request, status, error) {
            	handleAjaxError(request, status, error);
            },
            success: function (data) { // si l'appel a bien fonctionné
            if (data.state != 'ok') {
            	$('#div_alert').showAlert({message: data.result, level: 'danger'});
            	return;
            }
            $('#div_alert').showAlert({message: '{{Synchronisation réussie}}', level: 'success'});
			location.reload();
        }
    });
    }
    });
    });
 $("#table_cmd").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
function addCmdToTable(_cmd) {
    if (!isset(_cmd)) {
        var _cmd = {configuration: {}};
    }
    var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
    tr += '<td>';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="id" style="display : none;">';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="name"></td>';
    tr += '<td>';
	tr += '<i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i>';
    if (is_numeric(_cmd.id)) {
        tr += '<a class="btn btn-default btn-xs pull-right cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
        tr += '<a class="btn btn-default btn-xs pull-right cmdAction expertModeVisible" data-action="configure"><i class="fa fa-cogs"></i></a> ';
    }
    tr += '</td></tr>';
    $('#table_cmd tbody').append(tr);
    $('#table_cmd tbody tr:last').setValues(_cmd, '.cmdAttr');
    jeedom.cmd.changeType($('#table_cmd tbody tr:last'), init(_cmd.subType));
}