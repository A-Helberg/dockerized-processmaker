<?php
 /**
  * cliUpgrade.php
  *
  * ProcessMaker Open Source Edition
  * Copyright (C) 2011 Colosa Inc.
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
  * @author Alexandre Rosenfeld <alexandre@colosa.com>
  * @package workflow-engine-bin-tasks
  */
 
 G::LoadClass("system");
 G::LoadClass("wsTools");
 G::LoadSystem("dbMaintenance");
 G::LoadClass("cli");
 
 CLI::taskName('upgrade');
 CLI::taskDescription("Upgrade workspaces.\n\n This command should be run after ProcessMaker files are upgraded so that all workspaces are upgraded to the current version.");
 
 CLI::taskOpt("buildACV", "If the option is enabled, performs the Build Cache View.", "ACV", "buildACV");
 CLI::taskRun("run_upgrade");
 /*----------------------------------********---------------------------------*/
 CLI::taskArg('workspace');
 /*----------------------------------********---------------------------------*/
 
 /**
  * A version of rm_dir which does not exits on error.
  *
  * @param  string $filename directory or file to remove
  * @param  bool $filesOnly either to remove the containing directory as well or not
  */
 function rm_dir($filename, $filesOnly = false)
 {
     if (is_file($filename)) {
         @unlink($filename) or CLI::logging(CLI::error("Could not remove file $filename")."\n");
     } else {
         foreach (glob("$filename/*") as $f) {
             rm_dir($f);
         }
         if (!$filesOnly) {
             @rmdir($filename) or CLI::logging(CLI::error("Could not remove directory $filename")."\n");
         }
     }
 }
 
 function run_upgrade($command, $args)
 {
     CLI::logging("UPGRADE", PROCESSMAKER_PATH . "upgrade.log");
     CLI::logging("Checking files integrity...\n");
     //setting flag to true to check into sysGeneric.php
     $flag = G::isPMUnderUpdating(1);
     //start to upgrade
     $checksum = System::verifyChecksum();
     if ($checksum === false) {
         CLI::logging(CLI::error("checksum.txt not found, integrity check is not possible") . "\n");
         if (!CLI::question("Integrity check failed, do you want to continue the upgrade?")) {
             CLI::logging("Upgrade failed\n");
             $flag = G::isPMUnderUpdating(0);
             die();
         }
     } else {
         if (!empty($checksum['missing'])) {
             CLI::logging(CLI::error("The following files were not found in the installation:")."\n");
             foreach ($checksum['missing'] as $missing) {
                 CLI::logging(" $missing\n");
             }
         }
         if (!empty($checksum['diff'])) {
             CLI::logging(CLI::error("The following files have modifications:")."\n");
             foreach ($checksum['diff'] as $diff) {
                 CLI::logging(" $diff\n");
             }
         }
         if (!(empty($checksum['missing']) || empty($checksum['diff']))) {
             if (!CLI::question("Integrity check failed, do you want to continue the upgrade?")) {
                 CLI::logging("Upgrade failed\n");
                 $flag = G::isPMUnderUpdating(0);
                 die();
             }
         }
     }
     CLI::logging("Clearing cache...\n");
     if (defined('PATH_C')) {
         G::rm_dir(PATH_C);
         G::mk_dir(PATH_C, 0777);
     }
     $workspaces = get_workspaces_from_args($command);
     $count = count($workspaces);
     $first = true;
     $errors = false;
     $countWorkspace = 0;
     $buildCacheView = array_key_exists("buildACV", $args);
     foreach ($workspaces as $index => $workspace) {
         try {
             $countWorkspace++;
             CLI::logging("Upgrading workspaces ($countWorkspace/$count): " . CLI::info($workspace->name) . "\n");
             $workspace->upgrade($first, $buildCacheView, $workspace->name);
             $workspace->close();
             $first = false;
         } catch (Exception $e) {
             CLI::logging("Errors upgrading workspace " . CLI::info($workspace->name) . ": " . CLI::error($e->getMessage()) . "\n");
             $errors = true;
         }
     }
 
     // SAVE Upgrades/Patches
     $arrayPatch = glob(PATH_TRUNK . 'patch-*');
 
     if ($arrayPatch) {
         foreach ($arrayPatch as $value) {
             if (file_exists($value)) {
                 // copy content the patch
                 $names = pathinfo($value);
                 $nameFile = $names['basename'];
 
                 $contentFile = file_get_contents($value);
                 $contentFile = preg_replace("[\n|\r|\n\r]", '', $contentFile);
                 CLI::logging($contentFile . ' installed (' . $nameFile . ')', PATH_DATA . 'log/upgrades.log');
 
                 // move file of patch
                 $newFile = PATH_DATA . $nameFile;
                 G::rm_dir($newFile);
                 copy($value, $newFile);
                 G::rm_dir($value);
             }
         }
     } else {
         CLI::logging('ProcessMaker ' . System::getVersion(). ' installed', PATH_DATA . 'log/upgrades.log');
     }
 
     //Safe upgrade for JavaScript files
     CLI::logging("\nSafe upgrade for files cached by the browser\n\n");
 
     G::browserCacheFilesSetUid();
 
     //Status
     if ($errors) {
         CLI::logging("Upgrade finished but there were errors upgrading workspaces.\n");
         CLI::logging(CLI::error("Please check the log above to correct any issues.") . "\n");
     } else {
         CLI::logging("Upgrade successful\n");
     }
 
     //setting flag to false
     $flag = G::isPMUnderUpdating(0);
 }
 
 function listFiles($dir) {
     $files = array();
     $lista = glob($dir.'/*');
     foreach($lista as $valor) {
         if (is_dir($valor)) {
             $inner_files =  listFiles($valor);
             if (is_array($inner_files)) $files = array_merge($files, $inner_files);
         }
         if (is_file($valor)) {
             array_push($files, $valor);
         }
     }
     return $files;
 }
 /*----------------------------------********---------------------------------*/