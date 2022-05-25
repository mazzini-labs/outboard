<?php
# Gas Balancing for Rept
$gbfr = "SELECT gb_comments.*, gas_imbalance.*, properties.`property`, properties.`wolfpack_status`, properties.`Well Status`, properties.`operator`, properties.`gas_imbalance`
FROM properties INNER JOIN (gb_comments INNER JOIN gas_imbalance ON gb_comments.Well = gas_imbalance.WELL) ON (properties.`property` = gas_imbalance.WELL) AND (properties.`property` = gb_comments.Well)
WHERE (((properties.`wolfpack_status`)<>"EXTINCT") AND ((properties.`gas_imbalance`)=Yes));";


# All Pending Items
$allpenditems = "SELECT open_items.*, open_items.`pay`, open_items.`id`, open_items.`properties_name`, open_items.`open_comment`, open_items.`properties_operator`, open_items.`open_item_list`, open_items.`who_is_working_on_it`, open_items.`date_to_cm`, open_items.`deadline_date_if_applicable`, open_items.`deadline_date_if_applicable`
FROM open_items
WHERE (((open_items.`pay`)='Yes'))";
# CMM confirmed this is a working query in mysql
# 12/13/2021

# CGM Open Items
$coi = "SELECT open_items.*, open_items.`who_is_working_on_it`, open_items.`properties_operator`, open_items.`date_to_cm`
FROM open_items
WHERE (((open_items.`who_is_working_on_it`)='CM'))
ORDER BY open_items.`date_to_cm`;";
# TODO: Need to test


# Envelope-Report
$enrepo = "SELECT operator_vendor.`VENDOR NAME`, `address` & `add2` AS `Add`, operator_vendor.`ADDRESS`, operator_vendor.`ADD2`, `City` & "," & " " & `state` & " " & " " & `zip` AS RestAdd, operator_vendor.`CITY`, operator_vendor.`STATE`, operator_vendor.`ZIP`, operator_vendor.`Field15`, `ATTENTION` AS Expr1
FROM operator_vendor
WHERE (((operator_vendor.`VENDOR NAME`)=`Enter vendor name`));";

# GB Comment Sorting
$gbcs = "SELECT gb_comments.`gbcomment date`, gb_comments.Initial, gb_comments.GBComments, gb_comments.Well
FROM gb_comments
ORDER BY gb_comments.`gbcomment date` DESC;";

# GB Filter for Form
$gbff = "SELECT gas_imbalance.*, gb_comments.*, properties.`property`
FROM (properties INNER JOIN gas_imbalance ON properties.`property`=gas_imbalance.WELL) INNER JOIN gb_comments ON properties.`property`=gb_comments.Well;";

# GB MCF Info
$gbmi = "SELECT gas_imbalance_input.WELLNAME, `Sales Mcf`/`total Mcf Sales` AS `Settlement Mcf`, gas_imbalance_input.`Production Month`, gas_imbalance_input.`Entitlement Mcf`, gas_imbalance_input.`Sales Mcf`, gas_imbalance_input.`Current Month Imbalance`, gas_imbalance_input.`Cumulative Imbalance`, gas_imbalance_input.`GB Stment Interest Reflected`, gas_imbalance_input.`total Mcf Sales`, gas_imbalance_input.CommentGBinfo
FROM gas_imbalance_input
ORDER BY gas_imbalance_input.`Production Month` DESC;";

# Open Item List for Form
$oilff = "SELECT open_items.`Properties name`, properties.`WP ID`, open_items.`properties_operator`, open_items.`Open Item List`, open_items.`Open Comment`, open_items.`pay`
FROM properties RIGHT JOIN open_items ON properties.`property` = open_items.`Properties name`;";

# Open Item List for TC
$oiltc = "SELECT open_items.`Properties name`, properties.`WP ID`, open_items.`properties_operator`, open_items.`Open Item List`, open_items.`Open Comment`, open_items.`pay`, open_items.`who_is_working_on_it`
FROM properties RIGHT JOIN open_items ON properties.`property`=open_items.`Properties name`
WHERE (((open_items.`who_is_working_on_it`)="TC"));";

# Open Item List Report
$oilrepo = "SELECT open_items.`Properties name`, properties.`WP ID`, open_items.`properties_operator`, open_items.`Open Item List`, open_items.`Open Comment`, open_items.`pay`
FROM properties RIGHT JOIN open_items ON properties.`property`=open_items.`Properties name`
WHERE (((open_items.`pay`)=Yes));";

# Operator Info Link Form
$oilform = "SELECT operator_vendor.`VENDOR NAME`, operator_vendor.`ADDRESS`, operator_vendor.`ADD2`, operator_vendor.`STATE`, operator_vendor.`ZIP`, operator_vendor.`PHONE`, operator_vendor.`FAX`, operator_vendor.`pay`, operator_vendor.`1099`, operator_vendor.`COMMENTS`, operator_vendor.`WLFPK ID`, operator_vendor.`CITY`, operator_vendor.`TAX ID`
FROM operator_vendor
ORDER BY operator_vendor.`VENDOR NAME`;";

# Properties Form
$propform = "SELECT properties.`property`, properties.`SOG/SDC/GEC`, properties.Section, properties.Township, properties.Range, properties.Location, properties.County, properties.State, properties.`gas_imbalance`, properties.`wolfpack_status`, properties.`Well Status`, properties.`WP ID`, properties.`Energy ID`, properties.`ORRI only`, properties.RESEARCH, properties.ACCOUNTING, properties.propcomment, properties.`operator`, properties.`SOLD/PA EFF DATE`, properties.`JOA in Land File`, properties.ACCOUNTING, properties.`Researching What`, properties.`Preferential Right`, properties.`UPDTE Initials`, properties.`Last Updated`, properties.`gas_imbalance`, properties.`TDC list`, properties.`Interest Type`, interest_information.GWI, interest_information.NRI, interest_information.RI, interest_information.ORRI
FROM properties LEFT JOIN interest_information ON properties.`property`=interest_information.property
ORDER BY properties.`property`;";

# Properties Report 
$proprepo = "SELECT properties.`property`, properties.`SOG/SDC/GEC`, properties.Section, properties.Township, properties.Range, properties.Location, properties.County, properties.State, properties.`gas_imbalance`, properties.`wolfpack_status`, properties.`Well Status`, properties.`WP ID`, properties.`Energy ID`, properties.`ORRI only`, properties.RESEARCH, properties.ACCOUNTING, properties.propcomment, properties.`operator`, properties.`SOLD/PA EFF DATE`, properties.`JOA in Land File`, properties.ACCOUNTING, properties.`Researching What`, properties.`Preferential Right`, properties.`UPDTE Initials`, properties.`Last Updated`, properties.`gas_imbalance`, properties.`TDC list`, properties.`Interest Type`, interest_information.GWI, interest_information.NRI, interest_information.RI, interest_information.ORRI, interest_information.`Revenue Comments`, `wi-nri_information`.`VENDOR NAME`, `wi-nri_information`.`PURCHASER ID FOR SOG`, `wi-nri_information`.`PAYS OGCP?`, `wi-nri_information`.TYPE, `wi-nri_information`.NRI, `wi-nri_information`.WI, `wi-nri_information`.`OTHER INT`, `wi-nri_information`.`Netting Revenues?`
FROM (properties LEFT JOIN interest_information ON properties.`property`=interest_information.property) INNER JOIN `wi-nri_information` ON properties.`property`=`wi-nri_information`.WELLNAME
WHERE (((properties.`property`)=`Enter well name exactly as reflected above:`))
ORDER BY properties.`property`;";

# Property History
$prophistory = "SELECT property_history.`id`, property_history.Property, property_history.`Acquired From`, property_history.`Effective Date`, property_history.`Gross Acres`, property_history.`Net Acres`, property_history.`Well Data`, property_history.`Property Sheet Remarks`, property_history.DOI, property_history.`Cost of Acquision`, property_history.`WI Acquired in Sale`, property_history.`NRI Acquired in Sale`, property_history.`ORRI Acquired in Sale`, property_history.`Auction?`, property_history.`SOG/SDC`, property_history.`GB at time of sale?`, property_history.`Mcf Imbalance at sale`, property_history.`APO?`, property_history.`Part of 'Group Sale'?`
FROM property_history;";

# Status Comments
$statuscomments = "SELECT status_comments.date, status_comments.`status comment`, status_comments.intitals, status_comments.Property
FROM status_comments
ORDER BY status_comments.date DESC;";

# Tish Pending Items
$tpi = "SELECT open_items.`Properties name`, open_items.`Open Comment`, open_items.`properties_operator`, open_items.`who_is_working_on_it`
FROM open_items
WHERE (((open_items.`who_is_working_on_it`)="tc"))
ORDER BY open_items.`properties_operator`;";

# WI/NRI Information Form
$wnif = "SELECT `wi-nri_information`.`id`, `wi-nri_information`.WELLNAME, `wi-nri_information`.WFPCKID, `wi-nri_information`.`VENDOR NAME`, `wi-nri_information`.`PURCHASER ID FOR SOG`, `wi-nri_information`.`PAYS OGCP?`, `wi-nri_information`.NRI, `wi-nri_information`.WI, `wi-nri_information`.`OTHER INT`, `wi-nri_information`.`Netting Revenues?`, `wi-nri_information`.TYPE
FROM `wi-nri_information`
ORDER BY `wi-nri_information`.TYPE;";

?>