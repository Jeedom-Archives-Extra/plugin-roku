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

/* * ***************************Includes**********************************/
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class roku extends eqLogic {
	/***************************Attributs*******************************/
	public static $_widgetPossibility = array('custom' => true);
	
	public static function scanroku() {
		log::remove('roku_update');
		$cmd = '/usr/bin/python ' .dirname(__FILE__) . '/../../3rdparty/discover.py';
		log::add('roku','debug','Scan lancé avec : ' .$cmd);
		$discovered=trim(shell_exec($cmd));
		$result=explode(';',$discovered);
		foreach ($result as $rokuip) {
			if ($rokuip == '') {
				continue;
			}
			$eqLogic = roku::byLogicalId($rokuip, 'roku');
			if (!is_object($eqLogic)) {
				$eqLogic = new self();
				$eqLogic->setLogicalId($rokuip);
				$eqLogic->setName('Roku '.$rokuip);
				$eqLogic->setEqType_name('roku');
				$eqLogic->setIsVisible(1);
				$eqLogic->setIsEnable(1);
				$eqLogic->setConfiguration('addr',$rokuip);
				$eqLogic->setCategory('multimedia', 1);
				$eqLogic->save();
			}
		}
		$number=count(eqLogic::byType('roku'));
		config::save('numberroku', $number, 'roku');
	}

	public function syncchannel($ip) {
		$roku = roku::byLogicalId($ip, 'roku');
		$cmd = '/usr/bin/python ' .dirname(__FILE__) . '/../../3rdparty/discoverapps.py ' . $ip;
		log::add('roku','debug','Synchro des chaînes lancée avec : ' .$cmd);
		$discoveredapps=shell_exec($cmd);
		log::add('roku','debug',$discoveredapps);
		$listapps = explode(';',$discoveredapps);
		$listid = [];
		foreach ($listapps as $appduet){
			$appname = explode('||', $appduet)[0];
			$appid = explode('||', $appduet)[1];
			array_push($listid, $appid);
			$channel = $roku->getCmd(null, $appid);
			if (!is_object($channel)) {
				log::add('roku','info','La chaîne ' . $appname . ' a été ajoutée');
				$channel = new rokucmd();
				$channel->setLogicalId($appid);
				$channel->setIsVisible(1);
				$channel->setName(__($appname, __FILE__));
			}
			$channel->setType('action');
			$channel->setSubType('other');
			$channel->setEqLogic_id($roku->getId());
			$channel->save();
		}
		foreach ($roku->getCmd('action') as $cmd) {
			$logical = $cmd->getLogicalId();
			if (strpos($logical,'channel') !== false && !in_array($logical,$listid)){
				log::add('roku','info','La chaîne ' . $cmd->getName() . ' a été supprimée');
				$cmd->remove();
			}
		}
	}
	
	public function postRemove () {
		$number=count(eqLogic::byType('roku'));
		config::save('numberroku', $number, 'roku');
	}
	
	public function preSave() {
		$this->setLogicalId($this->getConfiguration('addr'));
	}
	public function postSave() {
		$back = $this->getCmd(null, 'back');
		if (!is_object($back)) {
			$back = new rokucmd();
			$back->setLogicalId('back');
			$back->setIsVisible(1);
			$back->setName(__('Retour', __FILE__));
		}
		$back->setType('action');
		$back->setSubType('other');
		$back->setEqLogic_id($this->getId());
		$back->save();
		
		$backspace = $this->getCmd(null, 'backspace');
		if (!is_object($backspace)) {
			$backspace = new rokucmd();
			$backspace->setLogicalId('backspace');
			$backspace->setIsVisible(1);
			$backspace->setName(__('backspace', __FILE__));
		}
		$backspace->setType('action');
		$backspace->setSubType('other');
		$backspace->setEqLogic_id($this->getId());
		$backspace->save();
		
		$down = $this->getCmd(null, 'down');
		if (!is_object($down)) {
			$down = new rokucmd();
			$down->setLogicalId('down');
			$down->setIsVisible(1);
			$down->setName(__('Bas', __FILE__));
		}
		$down->setType('action');
		$down->setSubType('other');
		$down->setEqLogic_id($this->getId());
		$down->save();
		
		$enter = $this->getCmd(null, 'enter');
		if (!is_object($enter)) {
			$enter = new rokucmd();
			$enter->setLogicalId('enter');
			$enter->setIsVisible(1);
			$enter->setName(__('Enter', __FILE__));
		}
		$enter->setType('action');
		$enter->setSubType('other');
		$enter->setEqLogic_id($this->getId());
		$enter->save();
		
		$forward = $this->getCmd(null, 'forward');
		if (!is_object($forward)) {
			$forward = new rokucmd();
			$forward->setLogicalId('forward');
			$forward->setIsVisible(1);
			$forward->setName(__('Avance rapide', __FILE__));
		}
		$forward->setType('action');
		$forward->setSubType('other');
		$forward->setEqLogic_id($this->getId());
		$forward->save();
		
		$home = $this->getCmd(null, 'home');
		if (!is_object($home)) {
			$home = new rokucmd();
			$home->setLogicalId('home');
			$home->setIsVisible(1);
			$home->setName(__('Accueil', __FILE__));
		}
		$home->setType('action');
		$home->setSubType('other');
		$home->setEqLogic_id($this->getId());
		$home->save();
		
		$info = $this->getCmd(null, 'info');
		if (!is_object($info)) {
			$info = new rokucmd();
			$info->setLogicalId('info');
			$info->setIsVisible(1);
			$info->setName(__('Info', __FILE__));
		}
		$info->setType('action');
		$info->setSubType('other');
		$info->setEqLogic_id($this->getId());
		$info->save();
		
		$left = $this->getCmd(null, 'left');
		if (!is_object($left)) {
			$left = new rokucmd();
			$left->setLogicalId('left');
			$left->setIsVisible(1);
			$left->setName(__('Gauche', __FILE__));
		}
		$left->setType('action');
		$left->setSubType('other');
		$left->setEqLogic_id($this->getId());
		$left->save();
		
		$play = $this->getCmd(null, 'play');
		if (!is_object($play)) {
			$play = new rokucmd();
			$play->setLogicalId('play');
			$play->setIsVisible(1);
			$play->setName(__('Lecture', __FILE__));
		}
		$play->setType('action');
		$play->setSubType('other');
		$play->setEqLogic_id($this->getId());
		$play->save();
		
		$replay = $this->getCmd(null, 'replay');
		if (!is_object($replay)) {
			$replay = new rokucmd();
			$replay->setLogicalId('replay');
			$replay->setIsVisible(1);
			$replay->setName(__('Replay', __FILE__));
		}
		$replay->setType('action');
		$replay->setSubType('other');
		$replay->setEqLogic_id($this->getId());
		$replay->save();
		
		$reverse = $this->getCmd(null, 'reverse');
		if (!is_object($reverse)) {
			$reverse = new rokucmd();
			$reverse->setLogicalId('reverse');
			$reverse->setIsVisible(1);
			$reverse->setName(__('Retour Rapide', __FILE__));
		}
		$reverse->setType('action');
		$reverse->setSubType('other');
		$reverse->setEqLogic_id($this->getId());
		$reverse->save();
		
		$right = $this->getCmd(null, 'right');
		if (!is_object($right)) {
			$right = new rokucmd();
			$right->setLogicalId('right');
			$right->setIsVisible(1);
			$right->setName(__('Droite', __FILE__));
		}
		$right->setType('action');
		$right->setSubType('other');
		$right->setEqLogic_id($this->getId());
		$right->save();
		
		$search = $this->getCmd(null, 'search');
		if (!is_object($search)) {
			$search = new rokucmd();
			$search->setLogicalId('search');
			$search->setIsVisible(1);
			$search->setName(__('Recherche', __FILE__));
		}
		$search->setType('action');
		$search->setSubType('other');
		$search->setEqLogic_id($this->getId());
		$search->save();
		
		$select = $this->getCmd(null, 'select');
		if (!is_object($select)) {
			$select = new rokucmd();
			$select->setLogicalId('select');
			$select->setIsVisible(1);
			$select->setName(__('OK', __FILE__));
		}
		$select->setType('action');
		$select->setSubType('other');
		$select->setEqLogic_id($this->getId());
		$select->save();
		
		$up = $this->getCmd(null, 'up');
		if (!is_object($up)) {
			$up = new rokucmd();
			$up->setLogicalId('up');
			$up->setIsVisible(1);
			$up->setName(__('Haut', __FILE__));
		}
		$up->setType('action');
		$up->setSubType('other');
		$up->setEqLogic_id($this->getId());
		$up->save();
		
		$volumedown = $this->getCmd(null, 'volumedown');
		if (!is_object($volumedown)) {
			$volumedown = new rokucmd();
			$volumedown->setLogicalId('volumedown');
			$volumedown->setIsVisible(1);
			$volumedown->setName(__('Volume bas', __FILE__));
		}
		$volumedown->setType('action');
		$volumedown->setSubType('other');
		$volumedown->setEqLogic_id($this->getId());
		$volumedown->save();
		
		$volumeup = $this->getCmd(null, 'volumeup');
		if (!is_object($volumeup)) {
			$volumeup = new rokucmd();
			$volumeup->setLogicalId('volumeup');
			$volumeup->setIsVisible(1);
			$volumeup->setName(__('Volume haut', __FILE__));
		}
		$volumeup->setType('action');
		$volumeup->setSubType('other');
		$volumeup->setEqLogic_id($this->getId());
		$volumeup->save();
		
		$volumemute = $this->getCmd(null, 'volumemute');
		if (!is_object($volumemute)) {
			$volumemute = new rokucmd();
			$volumemute->setLogicalId('volumemute');
			$volumemute->setIsVisible(1);
			$volumemute->setName(__('Muet', __FILE__));
		}
		$volumemute->setType('action');
		$volumemute->setSubType('other');
		$volumemute->setEqLogic_id($this->getId());
		$volumemute->save();
		
		$literal = $this->getCmd(null, 'literal');
		if (!is_object($literal)) {
			$literal = new rokucmd();
			$literal->setLogicalId('literal');
			$literal->setIsVisible(1);
			$literal->setName(__('Texte', __FILE__));
		}
		$literal->setType('action');
		$literal->setSubType('message');
        $literal->setDisplay('title_disable', 1);
        $literal->setDisplay('message_placeholder', __('Texte', __FILE__));
		$literal->setEqLogic_id($this->getId());
		$literal->save();
		
		$number=count(eqLogic::byType('roku'));
		config::save('numberroku', $number, 'roku');
	}
	
	public function toHtml($_version = 'dashboard') {
		$replace = $this->preToHtml($_version);
 		if (!is_array($replace)) {
 			return $replace;
  		}
		$version = jeedom::versionAlias($_version);
		if ($this->getDisplay('hideOn' . $version) == 1) {
			return '';
		}
		$channel = '';
		foreach ($this->getCmd('action') as $cmd) {
			$logical = $cmd->getLogicalId();
			if (strpos($logical, 'channel') !== false) {
				$channel .= '<img class="cmd noRefresh tooltips" data-cmd_id="' . $cmd->getId() . '" src="plugins/roku/tmp/' . substr($logical,7) . '.png" title="' . $cmd->getname() . '" height="50px" style = "margin-top : 5px;cursor:pointer" />';
			} else {
				$replace['#cmd_' . $cmd->getLogicalId() . '_id#'] = $cmd->getId();
			}
		}
		$replace['#channels#'] = $channel;
		
		if (($_version == 'dview' || $_version == 'mview') && $this->getDisplay('doNotShowNameOnView') == 1) {
			$replace['#name#'] = '';
			$replace['#object_name#'] = (is_object($object)) ? $object->getName() : '';
		}
		if (($_version == 'mobile' || $_version == 'dashboard') && $this->getDisplay('doNotShowNameOnDashboard') == 1) {
			$replace['#name#'] = '<br/>';
			$replace['#object_name#'] = (is_object($object)) ? $object->getName() : '';
		}
		
		$parameters = $this->getDisplay('parameters');
		if (is_array($parameters)) {
			foreach ($parameters as $key => $value) {
				$replace['#' . $key . '#'] = $value;
			}
		}
		
		$html = template_replace($replace, getTemplate('core', $version, 'eqLogic', 'roku'));
		cache::set('widgetHtml' . $version . $this->getId(), $html, 0);
		return $html;
    }
}

class rokuCmd extends cmd {
	/***************************Attributs*******************************/


	/*************************Methode static****************************/

	/***********************Methode d'instance**************************/

	public function execute($_options = null) {
		if ($this->getType() == '') {
			return '';
		}
		$roku = $this->getEqLogic();
		$cmd = '/usr/bin/python ' .dirname(__FILE__) . '/../../3rdparty/command.py ';
		$action= $this->getLogicalId();
		$ip = $roku->getLogicalId();
		$commande = $action;
		if ($action == 'literal') {
			$texte = $_options['message'];
			$commande = 'literal "' . $texte . '"';
		} elseif (substr($action,0,7) == 'channel') {
			$channelid = substr($action,7);
			$commande = 'channel ' .$channelid;
		}
		log::add('roku','debug','Execution de la commande suivante : ' . $cmd . $ip . ' ' . $commande);
		$result=shell_exec($cmd . $ip . ' ' . $commande);
	}

	/************************Getteur Setteur****************************/
}
?>