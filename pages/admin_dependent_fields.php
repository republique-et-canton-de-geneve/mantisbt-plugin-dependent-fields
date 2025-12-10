<?php
/*
 * Copyright (C) 2023-2025 Republique et canton de Geneve
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *      https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
 
/**
 * Create dependant a simple dependent field solution for Etat GE
 *
 * Auteur 2022 Fredrik Lahode
 *
 */
  // Check page permissions.
  auth_reauthenticate();
  access_ensure_global_level( config_get( 'manage_custom_fields_threshold' ) );

  // Prepare HTML page.
  html_robots_noindex();
  layout_page_header( "Configuration des dépendances de champs");
  layout_page_begin(__FILE__);

  // Set the page in admin menu.
  print_manage_menu( 'admin_dependent_fields' );

  // Initialize datas.
  $error = "";
  $config = "";

  // When Save button is clicked, insert the new config in the database.
  if (isset($_POST['config'])) {
    $config = $_POST['config'];

    // Check if the file is in JSON format.
    if (!is_object(json_decode($_POST['config']))) { 
      $error = "La configuration que vous avez insérée ne correspond pas à JSON valide.";
    } else {
      // Hack replacement for brackets (mantis issue, see file /core/classes/DbQuery.class.php - line 289).
      $config = str_replace('{', '<<<', $config);
      $config = str_replace('}', '>>>', $config);

      // Replacement for quotes for saving JSON file in the database.
      $config = str_replace("'", "''", $config);

      // Update the existing entry in the database.
      db_query("UPDATE " . plugin_table( 'config' ) . " SET config = '" . $config . "'::jsonb WHERE id=1;");
    }
  }

  // If no error was found, get the single entry in the database containing the configuration.
  if (!$error) {
    $resultQuery = db_query("SELECT config FROM " . plugin_table( 'config' ) . " LIMIT 1;");
    $config = db_fetch_array($resultQuery)['config'];
  }

?>

<div class="col-md-12 col-xs-12">
  <div class="space-10"></div>

  <div class="table-container">
    <div class="widget-box widget-color-blue2">
      <div class="widget-header widget-header-small">
        <h4 class="widget-title lighter">
          <i class="ace-icon fa fa-flask"></i>
          Configuration des dépendances de champs
        </h4>
      </div>
    </div>
  </div>

  <div class="container">
  <?php if ($error) { ?>
    <div class="space-10"></div>
    <div class="alert alert-danger" role="alert">
      <?php echo $error ?>
    </div>
  <?php } ?>
  <form method="post">
    <div class="form-group">
      <div class="space-10"></div>
      <textarea class="form-control" name="config" rows="20"><?php echo ($config); ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
  </form>
  </div>

</div>

<?php
// End layout.
layout_page_end();