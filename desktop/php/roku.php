<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJS('eqType', 'roku');
$eqLogics = eqLogic::byType('roku');
?>
<div class="row row-overflow">
    <div class="col-lg-2">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un dispositif}}</a>
                <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
                <?php
                foreach ($eqLogics as $eqLogic) {
                    echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
	<div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
   <legend><i class="fa fa-cog"></i>  {{Gestion}}</legend>
   <div class="eqLogicThumbnailContainer">
    <div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
           <center>
            <i class="fa fa-plus-circle" style="font-size : 5em;color:#94ca02;"></i>
        </center>
        <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;;color:#94ca02"><center>{{Ajouter}}</center></span>
    </div>
  <div class="cursor eqLogicAction" data-action="gotoPluginConf" style="background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
    <center>
      <i class="fa fa-wrench" style="font-size : 5em;color:#767676;"></i>
    </center>
    <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676"><center>{{Configuration}}</center></span>
  </div>
  <div class="cursor" id="bt_healthroku" style="background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
    <center>
      <i class="fa fa-medkit" style="font-size : 5em;color:#767676;"></i>
    </center>
    <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676"><center>{{Santé}}</center></span>
  </div>
</div>
<legend><i class="icon maison-film50"></i>  {{Mes Rokus}}
        </legend>
        <div class="eqLogicThumbnailContainer">
         <?php
				foreach ($eqLogics as $eqLogic) {
                    echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >';
                    echo "<center>";
					$file = $eqLogic->getConfiguration('icone');
                    if (file_exists($file)) {
                        $path = $eqLogic->getConfiguration('icone');
						echo '<img src="'.$path.'" height="105" width="140" />';
                    } else {
                        $path = 'plugins/roku/doc/images/roku_icon.png';
						echo '<img src="'.$path.'" height="105" width="95" />';
                    }
                    echo "</center>";
                    echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
                    echo '</div>';
                }
                ?>
            </div>
    </div>   

    <div class="col-lg-10 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
       <a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
  <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
  <a class="btn btn-default eqLogicAction pull-right" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a>
  <a class="btn btn-default eqLogicAction pull-right" data-action="copy"><i class="fa fa-files-o"></i> {{Dupliquer}}</a>
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
    <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Equipement}}</a></li>
    <li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
  </ul>
  <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
    <div role="tabpanel" class="tab-pane active" id="eqlogictab">
      <br/>
      <div class="row">
        <div class="col-sm-6">
          <form class="form-horizontal">
            <fieldset>
              <div class="form-group">
                    <label class="col-sm-4 control-label">{{Nom du dispositif}}</label>
                    <div class="col-sm-3">
                        <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
                        <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement roku}}"/>
                    </div>
                </div>
				<div class="form-group">
					<label class="col-sm-4 control-label" >{{Objet parent}}</label>
                    <div class="col-sm-3">
                        <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
                            <option value="">{{Aucun}}</option>
                            <?php
                            foreach (object::all() as $object) {
                                echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                <label class="col-sm-4 control-label"></label>
                <div class="col-lg-6">
                  <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
                  <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
                </div>
              </div>
                <legend><i class="fa fa-wrench"></i>  {{Configuration}}</legend>
				<div class="form-group">
				<label class="col-sm-4 control-label">{{Modèle}}</label>
                    		<div class="col-sm-4">
                        	<select id="sel_item2" class="form-control eqLogicAttr" data-l1key="configuration" data-l2key="icone" onchange="document.icon_visu.src=this.value;">
								<option value="plugins/roku/doc/images/roku_icon.png">{{}}</option>
								<option value="plugins/roku/doc/images/stick.png">{{Stick}}</option>
								<option value="plugins/roku/doc/images/roku1.png">{{Roku 1}}</option>
								<option value="plugins/roku/doc/images/roku2.png">{{Roku 2}}</option>
								<option value="plugins/roku/doc/images/roku3.png">{{Roku 3}}</option>
								<option value="plugins/roku/doc/images/roku4.png">{{Roku 4}}</option>
							</select>
                    		</div>
					</div>
					<div class="form-group">
                    <label class="col-sm-4 control-label">{{Adresse IP}}</label>
                    <div class="col-sm-4">
                        <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="addr" placeholder="{{Adresse IP}}"/>
                    </div>
                </div>
					<div class="form-group">
				<label class="col-sm-4 control-label">{{Synchroniser les chaines}}</label>
					<div class="col-sm-4">
					<a class="btn btn-warning" id="bt_syncchannel"><i class="fa fa-refresh"></i> {{Synchroniser}}</a>
				</div>
                </div>
			</fieldset>
		</form>
		</div>
		 <div class="col-sm-6">
			<div class="form-group">
				<div style="text-align: center">
					<img name="icon_visu" src="" style="height : 400px;"/>
				</div>
			</div>
		</div>
		</div>
		</div>
		
        <div role="tabpanel" class="tab-pane" id="commandtab">
  <a class="btn btn-success btn-sm cmdAction pull-right" data-action="add" style="margin-top:5px;"><i class="fa fa-plus-circle"></i> {{Ajouter une commande}}</a><br/><br/>
  <table id="table_cmd" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th style="width: 700px;">{{Nom}}</th><th>{{Action}}</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        

    </div>
</div>
</div>
</div>

<?php include_file('desktop', 'roku', 'js', 'roku'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>