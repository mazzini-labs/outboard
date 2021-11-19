<?php
require_once PROJECT_ROOT_PATH . "/Model/WellsDatabase.php";

class BoardModel extends WellsDatabase
{
    // wsb datatables endpoints 
    // lTable(latesttable) - ajax/wsb.ajax.lpd.php
    public function getLatestProduction()
    {
        $sql = "SELECT
        `latest_prod_data`.`api`, 
        date_format(`latest_prod_data`.`prod_date`,'%c-%e-%Y') as prod_mo,
        `latest_prod_data`.`gas_wh_mcf`, 
        `latest_prod_data`.`oil_prod`, 
        `latest_prod_data`.`water_prod`,
        `latest_prod_data`.`sd`,
        `list`.`api`, 
        `list`.`entity_common_name`, 
        `list`.`state`, 
        `list`.`county_parish`, 
        `list`.`block`, 
        `list`.`entity_operator_code`, 
        `list`.`producing_status`, 
        `list`.`production_type`, 
        `list`.`pumper`, 
        `list`.`report_frequency`, 
        `list`.`notes`, 
        `list`.`entity_type`,
        `list`.`notes_update`,
        date_format(`list`.`update_latest_prod_date`,'%c-%e-%Y') as update_latest_prod_date,
        `list`.`lpd`,
        concat(`list`.`lpd_sd`,' ',`list`.`lpd_st`) as lpdcheck
        FROM
            latest_prod_data,
            list
        WHERE
            DATE_FORMAT(`latest_prod_data`.`prod_date`, '%y-%m-%d') = DATE_FORMAT(`list`.`lpd`, '%y-%m-%d')
            AND `latest_prod_data`.`sd` = concat(`list`.`lpd_sd`,' ',`list`.`lpd_st`)
            AND `latest_prod_data`.`api` = `list`.`api`
            AND `list`.`show` = 1   
        ORDER BY
            `list`.`api` ASC";
        return $this->select($sql);
    }

    // oTable(productiontable) - ajax/wsb.ajax.php
    // iTable(productiontable1) - ajax/wsb.ajax.php
    // pTable(printtable) - ajax/wsb.ajax.php
    public function getWells()
    {
        $sql = "SELECT
        `prod_data`.`api`, 
        `prod_data`.`days_on`, 
        date_format(`prod_data`.`prod_mo`,'%c-%e-%Y') as prod_mo,
        `prod_data`.`gas_sold`, 
        `prod_data`.`gas_wh_mcf`, 
        `prod_data`.`oil_prod`, 
        `prod_data`.`water_prod`,
        `prod_data`.`gas_line_loss`,
        `list`.`api`, 
        `list`.`entity_common_name`, 
        `list`.`state`, 
        `list`.`county_parish`, 
        `list`.`block`, 
        `list`.`entity_operator_code`, 
        `list`.`producing_status`, 
        `list`.`production_type`, 
        `list`.`pumper`, 
        `list`.`notes`, 
        `list`.`entity_type`,
        `list`.`notes_update`,
        date_format(`list`.`last_prod_date`,'%c-%e-%Y') as last_prod_date,
        concat(`list`.`de`, ' ', `list`.`ts`) as de
        FROM
            prod_data,
            list
        WHERE
            DATE_FORMAT(`prod_data`.`prod_mo`, '%y-%m') = DATE_FORMAT(`list`.`last_prod_date`, '%y-%m')
            AND `prod_data`.`api` = `list`.`api`
            AND `list`.`show` = 1   
        ORDER BY
            `list`.`api` ASC";
        return $this->select($sql);
    }
    // sTable(shutintable) - ajax/si.ajax.php
    public function getShutInWells()
    {
        $sql = "SELECT
        `list`.*,
        date_format(`list`.`notes_update`,'%b %e, %Y <br> %l:%i %p') as notes_update
        FROM
        list
        WHERE
        `list`.`producing_status` = 'Shut-In'  
        OR `list`.`producing_status` = 'Shut-in'
        OR `list`.`producing_status` = 'INACTIVE'
        OR `list`.`producing_status` = 'SI'
        ORDER BY
        `list`.`api` ASC";
    }



    // prod_data datatables endpoints
    // oTable(productiontable) - ajax/prodajax.php
    public function getWellProduction($api)
    {
        // error_log("WSBModel: " . var_dump($this->select("SELECT * FROM `prod_data` WHERE `api` LIKE ?",["s",$api]),true));
        return $this->select("SELECT * FROM `prod_data` WHERE `api` LIKE ?",["s",$api]);
    }
    // iTable(ddrtable) - ajax/prodnotes.ajax.php
    public function getDDR($api)
    {
        $sql = "SELECT DISTINCT
        n.id,
        n.d,
        n.t,
        n.de,
        n.ts,
        n.te,
        n.deb,
        n.sd,
        n.api,
        n.cvn,
        n.cin,
        n.drn,
        n.edc,
        n.ecc,
        n.tt,
        n.dt,
        n.dc,
        n.at,
        n.ac,
        n.et,
        n.ai,
        n.ad,
        n.ec,
        n.vb,
        n.producing_status,
        date_format(`de`, '%m-%d-%Y') as dee,
        date_format(`ad`, '%m-%d-%Y') as ad,
        f.sd 
        FROM notes n
        LEFT JOIN notes_files f
        ON n.id = f.note_id 
        WHERE n.api like ? and n.t like '%d%' ORDER BY de DESC";
        return $this->select($sql,["s",$api]);
    }
    // sTable(dsrtable) - ajax/dsr.ajax.php
    public function getDSR($api)
    {
        $sql = "SELECT
        *,
        date_format(`de`, '%m-%d-%Y') as de
        FROM `notes` 
        WHERE `api` 
        LIKE %?% AND `t` like '%s%' ORDER BY de ASC";
        return $this->select($sql,["s",$api]);
    }
    // aDDRTable(ddr2015pres) - ajax/ddr.fetch.php
    public function getExcelDDR($api)
    {
        $this->select("SELECT * from `ddr_old` WHERE api LIKE ?",["s",$api]);
    }
    // vitalstable(vitalstable) - ajax/vitals.ajax.php
    public function getVitals($api)
    {
        $this->select("SELECT * from `vitals` WHERE api LIKE ? ORDER BY d DESC",["s",$api]);
    }
    // aDSRTable(dsr2015pres) - ajax/ddr.fetchold.php
    // bDDRTable(before2015detailrpt) - ajax/ddr.fetchold.php
    // bDSRTable(before2015sumrpt) - ajax/ddr.fetchold.php
    public function convertToWell($api)
    {
        return $this->select("SELECT well from `000api_list` WHERE `api` like %?%",["s",$api]);
    }
    public function getOldExcel($api,$sheet)
    {
        $well = $this->convertToWell($api);
        return $this->select("SELECT * from `$well` WHERE sheet LIKE ?",["ss",$well,$sheet]);
    } 
    // notesTable(notestable) - ajax/wellnotes.ajax.php
    // Nevermind, this isn't implemented currently
    public function getWellInfo($api)
    {
        $sql = "SELECT
        *,
        date_format(`notes_update`, '%m-%d-%Y') as ne
        FROM `prod_review_notes` WHERE `api` LIKE %?% ORDER BY ne DESC";
        return $this->select($sql,["s",$api]);
    }

    // rest of endpoints 
    // insert_latest_prod - ajax/insert.ntf.1.php
    // insert_form.ddr - ajax/insert.t.php 
    // insert_form.dsr - ajax/insert.ntf.php 
    // insert_well_form - ajax/insert.well.php -> ajax/fetchwells.php 
    // click->.edit_ddr-e - ajax/fetch.php 
    // click->.edit_ddr-a - ajax/fetch.php 
    // click->.edit_ddr-v - ajax/fetch.php 
    // click->.edit_ddr-f - ajax/fetch.php 
    // click->.edit_dsr - ajax/fetch.php
    // click->.delete_data - ajax/delete.note.php
    // click->.edit-well-info - ajax/fetchwells.php


    public function getUsers($limit)
    {
        return $this->select("SELECT * FROM list LIMIT ?", ["i", $limit]);
    }

}