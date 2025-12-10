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
  // Header for Javascript file.
  header( "Content-Type: text/javascript" );

  // Get the single entry in the database containing the configuration.
  $resultQuery = db_query("SELECT config FROM " . plugin_table( 'config' ) . " LIMIT 1;");
  $config = db_fetch_array($resultQuery)['config'];

  // Add the configuation to a javascript constant.
  echo "const depFields = " . $config . ";";
?>

// Get all field to manage.
let foundFields = null;
let saveDestFields = {};
let saveDestSelected = {};

// Check if page is report bug form.
if (document.getElementById('report_bug_form')) {

  // Get all field to manage.
  foundFields = Object.keys(depFields).filter(f => document.getElementById(f));
  
  // Loop on each fields.
  foundFields.map(f => {
    if (depFields[f] && depFields[f].length > 0) {
      
      // Save all initial options of each destination fields.
      depFields[f].map(fi => {
        if (fi.dest && saveDestFields[fi.dest] === undefined) {
          saveDestFields[fi.dest] = {};
          for(let option of document.getElementById(fi.dest)) {
            saveDestFields[fi.dest][option.value] = option.text;
            if (option.selected) {
              saveDestSelected[fi.dest] = option.value;
            }
          }
        }
      });

      // Make the first filter.
      const selectedField = document.getElementById(f);
      updateDependentField(f, document.getElementById(f).value);

      // Action filter when a change has been made.
      selectedField.addEventListener("change", (e) => updateDependentFields(f));
    }
  });
}

// Update all fields.
function updateDependentFields(level) {
  let updateFields = false;
  const foundFields = Object.keys(depFields).filter(f => document.getElementById(f));
  foundFields.map(f => {
    // Update all fields only from the specified level (all above fields will be ignored).
    if (f === level) {
      updateFields = true;
    }
    if (depFields[f] && depFields[f].length > 0 && updateFields) {
      const selectedField = document.getElementById(f);
      updateDependentField(f, document.getElementById(f).value);
    }
  });
}

// Filter each fields.
function updateDependentField(index, selectedValue) {
  const foundValues = depFields[index].filter(d => d.source == selectedValue);
  if (foundValues.length > 0) {
    const destField = document.getElementById(foundValues[0].dest);
    if (destField) {

      // Remove all options in select.
      destField.innerHTML = '';

      // Add each option for the select.
      for (const [value, text] of Object.entries(saveDestFields[foundValues[0].dest])) {
        if (foundValues[0].values.includes(value)) {
          const option = document.createElement("option");
          option.value = value;
          option.text = text;
          if (value == saveDestSelected[foundValues[0].dest]) {
            option.selected = 'selected';
          }
          destField.add(option);
        }
      }
    }
  }
}
