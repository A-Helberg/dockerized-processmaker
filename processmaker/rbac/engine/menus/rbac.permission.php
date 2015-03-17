<?php
/**
 * rbac.permission.php
 *  
 * ProcessMaker Open Source Edition
 * Copyright (C) 2004 - 2008 Colosa Inc.23
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * For more information, contact Colosa Inc, 2566 Le Jeune Rd., 
 * Coral Gables, FL, 33134, USA, or email info@colosa.com.
 * 
 */

global $G_TMP_MENU;

$G_TMP_MENU->AddRawOption( "rbac/permNew.html" );

switch( SYS_LANG )
{
case 'es':
  $G_TMP_MENU->Labels = array(
    "Añadir Nuevo Permiso"
  );
  break;
case 'po':
  $G_TMP_MENU->Labels = array(
    "Inserir Novo Permisio"
  );
  break;
default:
  $G_TMP_MENU->Labels = array(
    "Add New Permission"
  );
  break;
}
?>