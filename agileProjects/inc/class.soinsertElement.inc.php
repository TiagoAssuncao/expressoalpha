<?php 
        /************************************************************************************************\
        *  Gerencia de projetos ageis                                                                   *
        *  by Rafael Raymundo da Silva (rafael2000@gmail.com)  						*
        * ----------------------------------------------------------------------------------------------*
        *  This program is free software; you can redistribute it and/or modify it                      *
        *  under the terms of the GNU General Public License as published by the                        *
        *  Free Software Foundation; either version 2 of the License, or (at your                       *
        *  option) any later version.                                                                   *
        \***********************************************************************************************/
include_once('../header.inc.php');

        class soinsertElement{

                var $db;
                var $insert_projects;
		var $insert_partic;
		var $insert_admin;

                public function soinsertElement($name,$description,$particArray,$adminArray){
                        include_once('../phpgwapi/inc/class.db.inc.php');
		
			$particArray = unserialize($particArray);
			$adminArray = unserialize($adminArray);

			$numPartic = count($particArray);
                        $numAdmin = count($adminArray);

                        $this->insert_projects = $GLOBALS['phpgw']->db;
			$this->insert_partic = $GLOBALS['phpgw']->db;
			$this->insert_admin = $GLOBALS['phpgw']->db;

			//Insere o projeto guardando seu ID
                        $proj_id = $this->insert_projects->query('INSERT INTO phpgw_agile_projects(proj_name,proj_description,proj_owner) VALUES(\''.$name.'\',\''.$description.'\',\''.$_SESSION['phpgw_info']['expresso']['user']['userid'].'\') RETURNING proj_id',__LINE__,__FILE__);
			$proj_id=substr($proj_id, 7);
			
			//Insere os usuarios participantes e posteriormente os administradores
			for($i=0;$i<$numPartic;$i++){
				$this->insert_partic->query('INSERT INTO phpgw_agile_users_projects(uprojects_id_user, uprojects_id_project,uprojects_user_admin,uprojects_active) VALUES(\''.$particArray[$i].'\',\''.$proj_id.'\',FALSE,FALSE)',__LINE__,__FILE__);
			}
			for($i=0;$i<$numAdmin;$i++){
                                $this->insert_admin->query('INSERT INTO phpgw_agile_users_projects(uprojects_id_user, uprojects_id_project,uprojects_user_admin,uprojects_active) VALUES(\''.$adminArray[$i].'\',\''.$proj_id.'\',TRUE,FALSE)',__LINE__,__FILE__);
                        }
		}
	}
?>