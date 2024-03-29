<?php
        /************************************************************************************************\
        *  Gerencia de projetos ageis                                                                   *
        *  by Rafael Raymundo da Silva (rafael2000@gmail.com)						*
        * ----------------------------------------------------------------------------------------------*
        *  This program is free software; you can redistribute it and/or modify it                      *
        *  under the terms of the GNU General Public License as published by the                        *
        *  Free Software Foundation; either version 2 of the License, or (at your                       *
        *  option) any later version.                                                                   *
	\***********************************************************************************************/

	include('inc/class.solists.inc.php');
	include('../header.inc.php');

	class uiprojects{

		var $output;
		var $listProjects;

		public function uiprojects(){
			//Novo objeto, classe solists
			
			include_once('inc/class.ldap_functions.inc.php');
			
			$list = new ldap_functions();
			
			$this->listProjects = new solists();
			$num = count($this->listProjects->db);
	
			$template = CreateObject('phpgwapi.Template',PHPGW_APP_TPL);
                        $template->set_file(Array('agileProjects' => 'projects.tpl'));
                        $template->set_block('agileProjects','body');
			if($_SESSION['phpgw_info']['expresso']['agileProjects']['projectName']){
				echo("<div align=right>Projeto executado: ");
				print_r($_SESSION['phpgw_info']['expresso']['agileProjects']['projectName']);
				echo ("</div>");
			}
	
	echo	"<div><button type=\"button\" onClick=\"javascript:projectInclude();\">[ ".lang('Include project')." ]</button><br/><br/>

	<table id=\"customers\">
		<thead>
		   <tr>
			<th>".lang('Name of Project')."</th>
			<th>".lang('Owner')."</th>
			<th>".lang('Description')."</th>
			<th>".lang('Actions')."</th>
		   </tr>
		</thead>
		<tbody>";
		for($i=0;$i<$num;$i++){
			
				
	
				$user = $list->uid2cn($this->listProjects->db[$i][1]);
				$projName = $this->listProjects->db[$i][0];
				$projId = $this->listProjects->projId[$i][0];
				$projOwner = $this->listProjects->db[$i][1];
				$descricao = $this->listProjects->db[$i][2];
				
				
				$sel='<B>';
				$unsel='</B>';
				if($_SESSION['phpgw_info']['expresso']['agileProjects']['active'] != $projId){
					$sel = '';
					$unsel = '';
				}
					
				echo	"<tr class=".$line.">
					  <td><a href=\"javascript:activeProject('".addslashes($projName)."','".$projId."', '".$_SESSION['phpgw_info']['expresso']['agileProjects']['active']."');\">".$sel.$projName.$unsel."</a></td>
		                          <td>".$sel.$user.$unsel."</td>
	        	                  <td>".$sel.$descricao.$unsel."</td>
	                	          <td>
					";
	
				
	
				if($_SESSION['phpgw_info']['expresso']['agileProjects']['active'] == $projId){
					$projActive = "<img id=\"active_project".$projId."\" onclick=\"javascript:activeProject('".addslashes($projName)."','".$projId."','".$_SESSION['phpgw_info']['expresso']['agileProjects']['active']."');\" title='Abrir' src='templates/default/images/open_now.png'/>";
				}
				else{
					$projActive = "<img id=\"active_project".$projId."\" onclick=\"javascript:activeProject('".addslashes($projName)."','".$projId."', '".$_SESSION['phpgw_info']['expresso']['agileProjects']['active']."');\" title='Abrir' src='templates/default/images/open.png'/>";
				}
				echo	$projActive."
						<img onclick=\"editProject(".$projId.",'".$projOwner."','".$_SESSION['phpgw_info']['expresso']['user']['userid']."');\" title='Editar' src='templates/default/images/edit.png'/> 
						<img onclick=\"removeProject('".addslashes($projName)."',".$projId.",'".$projOwner."','".$_SESSION['phpgw_info']['expresso']['user']['userid']."');\" title='Excluir' src='templates/default/images/delete.png'/>
					  </td>
					</tr>";
			
			if($line == "alt"){
				$line="";
			}else{
				$line="alt";
			}
		}//Fim da listagem
	echo "</tbody></table>";
		}
		
		
		
		
		
		
		
		
	}
?>
