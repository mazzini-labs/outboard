<?php

// gas balancing for rept sql -- works but no data returned
/*
SELECT gb_comments.*, gas_imbalance.*, properties.property, properties.wolfpack_status, properties.well_status, properties.operator, properties.gas_imbalance
FROM properties INNER JOIN (gb_comments INNER JOIN gas_imbalance ON gb_comments.well = gas_imbalance.well) ON (properties.property = gas_imbalance.well) AND (properties.property = gb_comments.well)
WHERE (((properties.wolfpack_status)<>"EXTINCT") AND ((properties.gas_imbalance)="Yes"));
*/

// all pending items -- works!
/*
SELECT open_items.*, open_items.pay, open_items.id, open_items.properties_name, open_items.open_comment, open_items.properties_operator, open_items.open_item_list, open_items.who_is_working_on_it, open_items.date_to_cm, open_items.deadline_date_if_applicable, open_items.deadline_date_if_applicable
FROM open_items
WHERE (((open_items.pay)="Yes"));
*/

// chris open_items -- works no changes
/*
SELECT open_items.*, open_items.who_is_working_on_it, open_items.properties_operator, open_items.date_to_cm
FROM open_items
WHERE (((open_items.who_is_working_on_it)="CM"))
ORDER BY open_items.date_to_cm;
*/

// envelope report -- not working; tried to use the concat() function but no dice
/*
SELECT operator_vendor.vendor_name, address & add2 AS Add, operator_vendor.address, operator_vendor.add2, city & "," & " " & state & " " & " " & zip AS RestAdd, operator_vendor.city, operator_vendor.state, operator_vendor.zip, operator_vendor.field15, ATTENTION AS Expr1
FROM operator_vendor
WHERE (((operator_vendor.vendor_name)=Enter vendor_name));
*/

// gb comment sorting -- works!
/*
SELECT gb_comments.gbcomment_date, gb_comments.initial, gb_comments.gb_comments, gb_comments.well
FROM gb_comments
ORDER BY gb_comments.gbcomment_date DESC;

*/

// gb filter for form -- works!
/*
SELECT gas_imbalance.*, gb_comments.*, properties.property
FROM (properties INNER JOIN gas_imbalance ON properties.property=gas_imbalance.well) INNER JOIN gb_comments ON properties.property=gb_comments.well;

*/

// gb mcf info -- works!
/*
SELECT gas_imbalance_input.wellname, sales_mcf/total_mcf_sales AS settlement_mcf, gas_imbalance_input.production_month, gas_imbalance_input.entitlement_mcf, gas_imbalance_input.sales_mcf, gas_imbalance_input.current_month_imbalance, gas_imbalance_input.cumulative_imbalance, gas_imbalance_input.gb_stment_interest_reflected, gas_imbalance_input.total_mcf_sales, gas_imbalance_input.comment_gb_info
FROM gas_imbalance_input
ORDER BY gas_imbalance_input.production_month DESC;

*/

// open_item_list for form -- works!
/*
SELECT open_items.properties_name, properties.wp_id, open_items.properties_operator, open_items.open_item_list, open_items.open_comment, open_items.pay
FROM properties RIGHT JOIN open_items ON properties.property = open_items.properties_name;

*/

// opoen item list for tc -- works!
/*
SELECT open_items.properties_name, properties.wp_id, open_items.properties_operator, open_items.open_item_list, open_items.open_comment, open_items.pay, open_items.who_is_working_on_it
FROM properties RIGHT JOIN open_items ON properties.property=open_items.properties_name
WHERE (((open_items.who_is_working_on_it)="TC"));

*/

// open_item_list report -- works!
/*
SELECT open_items.properties_name, properties.wp_id, open_items.properties_operator, open_items.open_item_list, open_items.open_comment, open_items.pay
FROM properties RIGHT JOIN open_items ON properties.property=open_items.properties_name
WHERE (((open_items.pay)="Yes"));

*/

// operator info link-form -- works!
/*
SELECT operator_vendor.vendor_name, operator_vendor.address, operator_vendor.add2, operator_vendor.state, operator_vendor.zip, operator_vendor.PHONE, operator_vendor.FAX, operator_vendor.pay, operator_vendor.1099, operator_vendor.comments, operator_vendor.wlfpk_id, operator_vendor.city, operator_vendor.tax_id
FROM operator_vendor
ORDER BY operator_vendor.vendor_name;

*/

// properties-form -- works!
/*
SELECT properties.property, properties.`sog-sdc-gec`, properties.section, properties.township, properties.range, properties.location, properties.county, properties.state, properties.gas_imbalance, properties.wolfpack_status, properties.well_status, properties.wp_id, properties.energy_id, properties.orri_only, properties.research, properties.accounting, properties.propcomment, properties.operator, properties.`sold-pa_eff_date`, properties.joa_in_land_file, properties.accounting, properties.researching_what, properties.preferential_right, properties.updte_initials, properties.last_updated, properties.gas_imbalance, properties.tdc_list, properties.interest_type, interest_information.gwi, interest_information.nri, interest_information.ri, interest_information.orri
FROM properties LEFT JOIN interest_information ON properties.property=interest_information.property
ORDER BY properties.property;

*/

// properties-report -- works! requires an input
/*
SELECT properties.property, properties.`sog-sdc-gec`, properties.section, properties.township, properties.range, properties.location, properties.county, properties.state, properties.gas_imbalance, properties.wolfpack_status, properties.well_status, properties.wp_id, properties.energy_id, properties.orri_only, properties.research, properties.accounting, properties.propcomment, properties.operator, properties.`sold-pa_eff_date`, properties.joa_in_land_file, properties.accounting, properties.researching_what, properties.preferential_right, properties.updte_initials, properties.last_updated, properties.gas_imbalance, properties.tdc_list, properties.interest_type, interest_information.gwi, interest_information.nri, interest_information.ri, interest_information.orri, interest_information.revenue_comments, `wi-nri_information`.vendor_name, `wi-nri_information`.purchaser_id_for_sog, `wi-nri_information`.pays_ogcp, `wi-nri_information`.type, `wi-nri_information`.nri, `wi-nri_information`.wi, `wi-nri_information`.other_int, `wi-nri_information`.netting_revenues
FROM (properties LEFT JOIN interest_information ON properties.property=interest_information.property) INNER JOIN `wi-nri_information` ON properties.property=`wi-nri_information`.wellname
WHERE (((properties.property)="$property"))
ORDER BY properties.property;

*/

// property_history -- works!
/*
SELECT property_history.id, property_history.property, property_history.acquired_from, property_history.effective_date, property_history.gross_acres, property_history.net_acres, property_history.well_data, property_history.property_sheet_remarks, property_history.doi, property_history.cost_of_acquision, property_history.wi_acquired_in_sale, property_history.nri_acquired_in_sale, property_history.orri_acquired_in_sale, property_history.auction, property_history.sog_sdc, property_history.gb_at_time_of_sale, property_history.mcf_imbalance_at_sale, property_history.apo, property_history.part_of_group_sale
FROM property_history;

*/

// status comments-form -- works!
/*
SELECT status_comments.date, status_comments.status_comment, status_comments.intitals, status_comments.property
FROM status_comments
ORDER BY status_comments.date DESC;

*/

// tish pending items -- works!
/*
SELECT open_items.properties_name, open_items.open_comment, open_items.properties_operator, open_items.who_is_working_on_it
FROM open_items
WHERE (((open_items.who_is_working_on_it)="tc"))
ORDER BY open_items.properties_operator;

*/

// wi/nri information-form -- works!
/*
SELECT `wi-nri_information`.id, `wi-nri_information`.wellname, `wi-nri_information`.wfpckid, `wi-nri_information`.vendor_name, `wi-nri_information`.purchaser_id_for_sog, `wi-nri_information`.pays_ogcp, `wi-nri_information`.nri, `wi-nri_information`.wi, `wi-nri_information`.other_int, `wi-nri_information`.netting_revenues, `wi-nri_information`.type
FROM `wi-nri_information`
ORDER BY `wi-nri_information`.type;

*/

