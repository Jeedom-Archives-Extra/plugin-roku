<?php

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

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
if (!isConnect()) {
    include_file('desktop', '404', 'php');
    die();
}
?>
<form class="form-horizontal">
<fieldset>
<span class="col-lg-12" style="font-size:1em;color:grey" >{{Si la détection automatique ne marche pas vous pouvez toujours rajouter le roku avec son adresse IP. Il peut falloir lancer la détection 2 ou 3 fois.}}</span></br></br>
<label class="col-lg-2 control-label">{{Détecter vos Rokus}}</label>
<div class="col-lg-2">
	<a class="btn btn-warning" id="bt_scan"><i class="fa fa-check"></i> {{Scanner automatiquement}}</a>
</div>
<label class="col-lg-2 control-label">{{Nombre de Rokus }}</label>
    <span class="label label-info" style="font-size:1em;">
          <span class="configKey label label-info" data-l1key="numberroku" style="font-size : 1em;"></span>
        </span>
</fieldset> 
</form>
<script>
	$('#bt_scan').on('click', function () {
        bootbox.confirm('{{Voulez-vous lancer une auto découverte de vos Rokus }}', function (result) {
			if (result) {
        $.ajax({// fonction permettant de faire de l'ajax
            type: "POST", // methode de transmission des données au fichier php
            url: "plugins/roku/core/ajax/roku.ajax.php", // url du fichier php
            data: {
            	action: "scanroku",
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
			$('#ul_plugin .li_plugin[data-plugin_id=roku').click();
        }
    });
    }
    });
    });
</script>