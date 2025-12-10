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
class EtatGeDependentFieldsPlugin extends MantisPlugin {

  /**
   * Information on the plugin.
   */
	public function register() {
		$this->name = "Dépendance des champs";
		$this->description = "Ce plugin permet d'effectuer des dépendances entre les champs.";

		$this->version = "1.0.0";
		$this->requires = [
			"MantisCore" => "2.3.0"
    ];

		$this->author = "Fredrik Lahode";
		$this->contact = "fredrik@lahode.ch";
		$this->url = "https://github.com/republique-et-canton-de-geneve/mantisbt-plugin-dependent-fields";
	}

  /**
   * Initiate hooks.
   * 
   * For admin page (manage_dependent_fields) and Javascript (scripts).
   */
	public function hooks() {
		return [
			'EVENT_MENU_MANAGE' => 'manage_dependent_fields',
      'EVENT_LAYOUT_PAGE_FOOTER' => 'scripts'
    ];
	}

  /**
   * Display the Javascript globally.
   */
  function scripts() {
    return '<script type="text/javascript" src="' . plugin_page( 'apply_dependent_fields.php' ) . '"></script>';
  }

  /**
   * Display the admin page with a tab.
   */
	public function manage_dependent_fields( $p_is_admin ) {
		return [
			'<a href="' . plugin_page( 'admin_dependent_fields' ) . '">Gérer les dépendances</a>'
    ];
	}

  /**
   * When activating the plugin, create the "config" table and populate with one single entry.
   */
  public function install() {
    db_query("CREATE TABLE " . plugin_table('config') . " (id serial PRIMARY KEY,config jsonb not null default '<<<>>>'::jsonb);");
    db_query("INSERT INTO " . plugin_table('config') . " (config) VALUES ('<<<>>>'::jsonb);");
    return true;
  }

  /**
   * When deactivating the plugin, delete the table containing the config.
   */
  public function uninstall() {
    db_query("DROP TABLE " . plugin_table('config') . ";");
  }

}
