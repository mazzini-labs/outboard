-- SOG Operated Acres
create view sog_op_al as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='AL Region') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Operated'));
create view sog_op_ar as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='AR Region') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Operated'));
create view sog_op_ca as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='CA Region') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Operated'));
create view sog_op_etx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='East Texas') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Operated'));
create view sog_op_gctx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='South Texas') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Operated'));
create view sog_op_la as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='LA Region') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Operated'));
create view sog_op_nm as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='NM Region') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Operated'));
create view sog_op_ok as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='OK Region') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Operated'));
create view sog_op_phtx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='Panhandle') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Operated'));
create view sog_op_ntx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='North Texas') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Operated'));
create view sog_op_wtx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='West Texas') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Operated'));
SELECT SUM(op_ga), SUM(op_na), SUM(nonop_ga), SUM(nonop_na)
FROM( 
SELECT pldb.gross_acres AS  op_ga, pldb.net_acres AS op_na, pldb_locations.region, pldb.owning_company, pldb.operating_status 
FROM pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
where (((pldb_locations.region)='AL Region') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Operated'))) AS oga;

(SELECT SUM(al_op_ga), SUM(al_op_na) 
FROM( 
SELECT pldb.gross_acres AS  al_op_ga, pldb.net_acres AS al_op_na, pldb_locations.region, pldb.owning_company, pldb.operating_status 
FROM pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
where (((pldb_locations.region)='AL Region') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Operated'))) AS op)
union 
(SELECT SUM(al_nonop_ga), SUM(al_nonop_na) 
FROM( 
SELECT pldb.gross_acres AS  al_nonop_ga, pldb.net_acres AS al_nonop_na, pldb_locations.region, pldb.owning_company, pldb.operating_status 
FROM pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
where (((pldb_locations.region)='AL Region') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Non-Operated'))) AS nonop)

select sog_al.region, sum(case when sog_al.operating_status='Operated' then sog_al.gross_acres end) as `Operated Gross Acres`,
        sum(case when sog_al.operating_status='Operated' then sog_al.net_acres end) as `Operated Net Acres`,
        sum(case when sog_al.operating_status='Non-Operated' then sog_al.gross_acres end) as `Non-Operated Gross Acres`,
        sum(case when sog_al.operating_status='Non-Operated' then sog_al.net_acres end) as `Non-Operated Net Acres`,
        sum(sog_al.gross_acres) as `Total Gross Acres`,
        sum(sog_al.net_acres) as `Total Net Acres`,
        (select sum(sog_al.gross_acres) from sog_al) / (select sum(ga) from sog_acres) as `Percent of Total Gross Acres`,
        (select sum(sog_al.net_acres) from sog_al) / (select sum(na) from sog_acres) as `Percent of Total Net Acres`
        from sog_acres, sog_al;

(select 
    region, 
    sum(case when operating_status='Operated' then gross_acres end) as `Operated Gross Acres`,
    sum(case when operating_status='Operated' then net_acres end) as `Operated Net Acres`,
    sum(case when operating_status='Non-Operated' then gross_acres end) as `Non-Operated Gross Acres`,
    sum(case when operating_status='Non-Operated' then net_acres end) as `Non-Operated Net Acres`,
    sum(gross_acres) as `Total Gross Acres`,
    sum(net_acres) as `Total Net Acres`,
    sum(gross_acres) / (select sum(ga) from sog_acres) as `Percent of Total Gross Acres`,
    sum(net_acres) / (select sum(na) from sog_acres) as `Percent of Total Net Acres`
from (
    select 
        pldb.id, 
        pldb.name, 
        pldb_locations.region, 
        pldb.gross_acres, 
        pldb.net_acres, 
        pldb.owning_company, 
        pldb.operating_status
    from 
        pldb_locations 
    inner join 
        pldb 
    on 
        pldb_locations.id = pldb.location_id
    where 
        (pldb_locations.region='North Texas') and (pldb.owning_company='SOG')) 
    as 
        sog_northtexas
)
union all
(select 
    region, 
    sum(case when operating_status='Operated' then gross_acres end) as `Operated Gross Acres`,
    sum(case when operating_status='Operated' then net_acres end) as `Operated Net Acres`,
    sum(case when operating_status='Non-Operated' then gross_acres end) as `Non-Operated Gross Acres`,
    sum(case when operating_status='Non-Operated' then net_acres end) as `Non-Operated Net Acres`,
    sum(gross_acres) as `Total Gross Acres`,
    sum(net_acres) as `Total Net Acres`,
    sum(gross_acres) / (select sum(ga) from sog_acres) as `Percent of Total Gross Acres`,
    sum(net_acres) / (select sum(na) from sog_acres) as `Percent of Total Net Acres`
from (
    select 
        pldb.id, 
        pldb.name, 
        pldb_locations.region, 
        pldb.gross_acres, 
        pldb.net_acres, 
        pldb.owning_company, 
        pldb.operating_status
    from 
        pldb_locations 
    inner join 
        pldb 
    on 
        pldb_locations.id = pldb.location_id
    where 
        (pldb_locations.region='East Texas') and (pldb.owning_company='SOG')) 
    as 
        sog_easttexas
)
union all 
(select 
    region, 
    sum(case when operating_status='Operated' then gross_acres end) as `Operated Gross Acres`,
    sum(case when operating_status='Operated' then net_acres end) as `Operated Net Acres`,
    sum(case when operating_status='Non-Operated' then gross_acres end) as `Non-Operated Gross Acres`,
    sum(case when operating_status='Non-Operated' then net_acres end) as `Non-Operated Net Acres`,
    sum(gross_acres) as `Total Gross Acres`,
    sum(net_acres) as `Total Net Acres`,
    sum(gross_acres) / (select sum(ga) from sog_acres) as `Percent of Total Gross Acres`,
    sum(net_acres) / (select sum(na) from sog_acres) as `Percent of Total Net Acres`
from (
    select 
        pldb.id, 
        pldb.name, 
        pldb_locations.region, 
        pldb.gross_acres, 
        pldb.net_acres, 
        pldb.owning_company, 
        pldb.operating_status
    from 
        pldb_locations 
    inner join 
        pldb 
    on 
        pldb_locations.id = pldb.location_id
    where 
        (pldb_locations.region='Gulf Coast Texas') and (pldb.owning_company='SOG')) 
    as 
        sog_gulfcoasttexas
)
union all 
(select 
    region, 
    sum(case when operating_status='Operated' then gross_acres end) as `Operated Gross Acres`,
    sum(case when operating_status='Operated' then net_acres end) as `Operated Net Acres`,
    sum(case when operating_status='Non-Operated' then gross_acres end) as `Non-Operated Gross Acres`,
    sum(case when operating_status='Non-Operated' then net_acres end) as `Non-Operated Net Acres`,
    sum(gross_acres) as `Total Gross Acres`,
    sum(net_acres) as `Total Net Acres`,
    sum(gross_acres) / (select sum(ga) from sog_acres) as `Percent of Total Gross Acres`,
    sum(net_acres) / (select sum(na) from sog_acres) as `Percent of Total Net Acres`
from (
    select 
        pldb.id, 
        pldb.name, 
        pldb_locations.region, 
        pldb.gross_acres, 
        pldb.net_acres, 
        pldb.owning_company, 
        pldb.operating_status
    from 
        pldb_locations 
    inner join 
        pldb 
    on 
        pldb_locations.id = pldb.location_id
    where 
        (pldb_locations.region='West Texas') and (pldb.owning_company='SOG')) 
    as 
        sog_westtexas
)
union all 
(select 
    region, 
    sum(case when operating_status='Operated' then gross_acres end) as `Operated Gross Acres`,
    sum(case when operating_status='Operated' then net_acres end) as `Operated Net Acres`,
    sum(case when operating_status='Non-Operated' then gross_acres end) as `Non-Operated Gross Acres`,
    sum(case when operating_status='Non-Operated' then net_acres end) as `Non-Operated Net Acres`,
    sum(gross_acres) as `Total Gross Acres`,
    sum(net_acres) as `Total Net Acres`,
    sum(gross_acres) / (select sum(ga) from sog_acres) as `Percent of Total Gross Acres`,
    sum(net_acres) / (select sum(na) from sog_acres) as `Percent of Total Net Acres`
from (
    select 
        pldb.id, 
        pldb.name, 
        pldb_locations.region, 
        pldb.gross_acres, 
        pldb.net_acres, 
        pldb.owning_company, 
        pldb.operating_status
    from 
        pldb_locations 
    inner join 
        pldb 
    on 
        pldb_locations.id = pldb.location_id
    where 
        (pldb_locations.region='Panhandle') and (pldb.owning_company='SOG')) 
    as 
        sog_panhandle
)
union all 
(select 
    region, 
    sum(case when operating_status='Operated' then gross_acres end) as `Operated Gross Acres`,
    sum(case when operating_status='Operated' then net_acres end) as `Operated Net Acres`,
    sum(case when operating_status='Non-Operated' then gross_acres end) as `Non-Operated Gross Acres`,
    sum(case when operating_status='Non-Operated' then net_acres end) as `Non-Operated Net Acres`,
    sum(gross_acres) as `Total Gross Acres`,
    sum(net_acres) as `Total Net Acres`,
    sum(gross_acres) / (select sum(ga) from sog_acres) as `Percent of Total Gross Acres`,
    sum(net_acres) / (select sum(na) from sog_acres) as `Percent of Total Net Acres`
from (
    select 
        pldb.id, 
        pldb.name, 
        pldb_locations.region, 
        pldb.gross_acres, 
        pldb.net_acres, 
        pldb.owning_company, 
        pldb.operating_status
    from 
        pldb_locations 
    inner join 
        pldb 
    on 
        pldb_locations.id = pldb.location_id
    where 
        (pldb_locations.region='AL Region') and (pldb.owning_company='SOG')) 
    as 
        sog_alabama
)
union all 
(select 
    region, 
    sum(case when operating_status='Operated' then gross_acres end) as `Operated Gross Acres`,
    sum(case when operating_status='Operated' then net_acres end) as `Operated Net Acres`,
    sum(case when operating_status='Non-Operated' then gross_acres end) as `Non-Operated Gross Acres`,
    sum(case when operating_status='Non-Operated' then net_acres end) as `Non-Operated Net Acres`,
    sum(gross_acres) as `Total Gross Acres`,
    sum(net_acres) as `Total Net Acres`,
    sum(gross_acres) / (select sum(ga) from sog_acres) as `Percent of Total Gross Acres`,
    sum(net_acres) / (select sum(na) from sog_acres) as `Percent of Total Net Acres`
from (
    select 
        pldb.id, 
        pldb.name, 
        pldb_locations.region, 
        pldb.gross_acres, 
        pldb.net_acres, 
        pldb.owning_company, 
        pldb.operating_status
    from 
        pldb_locations 
    inner join 
        pldb 
    on 
        pldb_locations.id = pldb.location_id
    where 
        (pldb_locations.region='AR Region') and (pldb.owning_company='SOG')) 
    as 
        sog_arkansas
)
union all 
(select 
    region, 
    sum(case when operating_status='Operated' then gross_acres end) as `Operated Gross Acres`,
    sum(case when operating_status='Operated' then net_acres end) as `Operated Net Acres`,
    sum(case when operating_status='Non-Operated' then gross_acres end) as `Non-Operated Gross Acres`,
    sum(case when operating_status='Non-Operated' then net_acres end) as `Non-Operated Net Acres`,
    sum(gross_acres) as `Total Gross Acres`,
    sum(net_acres) as `Total Net Acres`,
    sum(gross_acres) / (select sum(ga) from sog_acres) as `Percent of Total Gross Acres`,
    sum(net_acres) / (select sum(na) from sog_acres) as `Percent of Total Net Acres`
from (
    select 
        pldb.id, 
        pldb.name, 
        pldb_locations.region, 
        pldb.gross_acres, 
        pldb.net_acres, 
        pldb.owning_company, 
        pldb.operating_status
    from 
        pldb_locations 
    inner join 
        pldb 
    on 
        pldb_locations.id = pldb.location_id
    where 
        (pldb_locations.region='LA Region') and (pldb.owning_company='SOG')) 
    as 
        sog_louisiana
)
union all 
(select 
    region, 
    sum(case when operating_status='Operated' then gross_acres end) as `Operated Gross Acres`,
    sum(case when operating_status='Operated' then net_acres end) as `Operated Net Acres`,
    sum(case when operating_status='Non-Operated' then gross_acres end) as `Non-Operated Gross Acres`,
    sum(case when operating_status='Non-Operated' then net_acres end) as `Non-Operated Net Acres`,
    sum(gross_acres) as `Total Gross Acres`,
    sum(net_acres) as `Total Net Acres`,
    sum(gross_acres) / (select sum(ga) from sog_acres) as `Percent of Total Gross Acres`,
    sum(net_acres) / (select sum(na) from sog_acres) as `Percent of Total Net Acres`
from (
    select 
        pldb.id, 
        pldb.name, 
        pldb_locations.region, 
        pldb.gross_acres, 
        pldb.net_acres, 
        pldb.owning_company, 
        pldb.operating_status
    from 
        pldb_locations 
    inner join 
        pldb 
    on 
        pldb_locations.id = pldb.location_id
    where 
        (pldb_locations.region='NM Region') and (pldb.owning_company='SOG')) 
    as 
        sog_newmexico
)
union all 
(select 
    region, 
    sum(case when operating_status='Operated' then gross_acres end) as `Operated Gross Acres`,
    sum(case when operating_status='Operated' then net_acres end) as `Operated Net Acres`,
    sum(case when operating_status='Non-Operated' then gross_acres end) as `Non-Operated Gross Acres`,
    sum(case when operating_status='Non-Operated' then net_acres end) as `Non-Operated Net Acres`,
    sum(gross_acres) as `Total Gross Acres`,
    sum(net_acres) as `Total Net Acres`,
    sum(gross_acres) / (select sum(ga) from sog_acres) as `Percent of Total Gross Acres`,
    sum(net_acres) / (select sum(na) from sog_acres) as `Percent of Total Net Acres`
from (
    select 
        pldb.id, 
        pldb.name, 
        pldb_locations.region, 
        pldb.gross_acres, 
        pldb.net_acres, 
        pldb.owning_company, 
        pldb.operating_status
    from 
        pldb_locations 
    inner join 
        pldb 
    on 
        pldb_locations.id = pldb.location_id
    where 
        (pldb_locations.region='OK Region') and (pldb.owning_company='SOG')) 
    as 
        sog_oklahoma
)
union all 
(select 
    region, 
    ifnull(format(sum(case when operating_status='Operated' is not null then gross_acres else '0.00' end), 2), '0.00') as `Operated Gross Acres`,
    ifnull(format(sum(case when operating_status='Operated' then net_acres end), 2), '0.00') as `Operated Net Acres`,
    ifnull(format(sum(case when operating_status='Non-Operated' then gross_acres end), 2), '0.00') as `Non-Operated Gross Acres`,
    ifnull(format(sum(case when operating_status='Non-Operated' then net_acres end), 2), '0.00') as `Non-Operated Net Acres`,
    ifnull(format(sum(gross_acres), 2), '0.00') as `Total Gross Acres`,
    ifnull(format(sum(net_acres), 2), '0.00') as `Total Net Acres`,
    ifnull(format(sum(gross_acres) / (select sum(ga) from sog_acres), 2), '0.00') as `Percent of Total Gross Acres`,
    ifnull(format(sum(net_acres) / (select sum(na) from sog_acres), 2), '0.00') as `Percent of Total Net Acres`
from (
    select 
        pldb.id, 
        pldb.name, 
        pldb_locations.region as region, 
        pldb.gross_acres, 
        pldb.net_acres, 
        pldb.owning_company, 
        pldb.operating_status
    from 
        pldb_locations 
    inner join 
        pldb 
    on 
        pldb_locations.id = pldb.location_id
    where 
        ((pldb_locations.region='AL Region') and (pldb.owning_company='SOG'))
    ) 
    as 
        sog_california
);
from(
select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='AL Region') and ((pldb.owning_company)='SOG'))
) as sog_cali;

select 
    region, 
    (select ifnull(format(sum(case when operating_status='Operated' then gross_acres end) from sog_al), 2), '0.00') as `Operated Gross Acres`,
    (select ifnull(format(sum(case when operating_status='Operated' then net_acres end) from sog_al), 2), '0.00') as `Operated Net Acres`,
    (select ifnull(format(sum(case when operating_status='Non-Operated' then gross_acres end) from sog_al), 2), '0.00') as `Non-Operated Gross Acres`,
    (select ifnull(format(sum(case when operating_status='Non-Operated' then net_acres end) from sog_al), 2), '0.00') as `Non-Operated Net Acres`,
    (select ifnull(format(sum(gross_acres) from sog_al), 2), '0.00') as `Total Gross Acres`,
    (select ifnull(format(sum(net_acres) from sog_al), 2), '0.00') as `Total Net Acres`,
    (select ifnull(format(sum(gross_acres) from sog_al) / (select sum(ga) from sog_acres), 2), '0.00') as `Percent of Total Gross Acres`,
    (select ifnull(format(sum(net_acres) from sog_al) / (select sum(na) from sog_acres), 2), '0.00') as `Percent of Total Net Acres`
from 
    sog_al;
select sog_al.region, sum(case when sog_al.operating_status='Operated' then sog_al.gross_acres end) as `Operated Gross Acres`,
        sum(case when sog_al.operating_status='Operated' then sog_al.net_acres end) as `Operated Net Acres`,
        sum(case when sog_al.operating_status='Non-Operated' then sog_al.gross_acres end) as `Non-Operated Gross Acres`,
        sum(case when sog_al.operating_status='Non-Operated' then sog_al.net_acres end) as `Non-Operated Net Acres`,
        sum(sog_al.gross_acres) as `Total Gross Acres`,
        sum(sog_al.net_acres) as `Total Net Acres`,
        1g.gga / 2g.gga as `Percent of Total Gross Acres`,
        1n.gna / 2n.gna as `Percent of Total Net Acres`
        from (select sum(gross_acres) gga from sog_al) 1g, 
        (select sum(gross_acres) gga from sog_acres) 2g, 
        (select sum(net_acres) gna from sog_al) 1n, 
        (select sum(net_acres) gna from sog_acres) 2n, 
        sog_acres, 
        sog_al;
select oga, ona, noga, nona, tga, tna, ptga, ptna from (


select region, sum(case when operating_status='Operated' then gross_acres end) as oga,
        sum(case when operating_status='Operated' then net_acres end) as ona,
        sum(case when operating_status='Non-Operated' then gross_acres end) as noga,
        sum(case when operating_status='Non-Operated' then net_acres end) as nona,
        sum(gross_acres) as tga,
        sum(net_acres) as tna from sog_al) 
        ptga,
        ptna)
        from (select (gross_acres / sum(ga)) as ptga, (net_acres / sum(na)) as ptna from sog_acres, sog_al) as sa;
-- SOG Non-Operated Acres
create view sog_nonop_al as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='AL Region') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Non-Operated'));
create view sog_nonop_ar as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='AR Region') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Non-Operated'));
create view sog_nonop_ca as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='CA Region') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Non-Operated'));
create view sog_nonop_etx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='East Texas') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Non-Operated'));
create view sog_nonop_gctx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='South Texas') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Non-Operated'));
create view sog_nonop_la as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='LA Region') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Non-Operated'));
create view sog_nonop_nm as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='NM Region') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Non-Operated'));
create view sog_nonop_ok as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='OK Region') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Non-Operated'));
create view sog_nonop_ntx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='North Texas') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Non-Operated'));
create view sog_nonop_phtx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='Panhandle') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Non-Operated'));
create view sog_nonop_wtx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='West Texas') and ((pldb.owning_company)='SOG') and ((pldb.operating_status)='Non-Operated'));

-- SDC Operated Acres
create view sdc_op_al as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='AL Region') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Operated'));
create view sdc_op_ar as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='AR Region') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Operated'));
create view sdc_op_ca as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='CA Region') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Operated'));
create view sdc_op_etx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='East Texas') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Operated'));
create view sdc_op_gctx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='South Texas') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Operated'));
create view sdc_op_la as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='LA Region') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Operated'));
create view sdc_op_nm as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='NM Region') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Operated'));
create view sdc_op_ok as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='OK Region') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Operated'));
create view sdc_op_phtx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='Panhandle') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Operated'));
create view sdc_op_ntx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='North Texas') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Operated'));
create view sdc_op_wtx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='West Texas') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Operated'));

-- SDC Non-Operated Acres
create view sdc_nonop_al as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='AL Region') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Non-Operated'));
create view sdc_nonop_ar as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='AR Region') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Non-Operated'));
create view sdc_nonop_ca as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='CA Region') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Non-Operated'));
create view sdc_nonop_etx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='East Texas') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Non-Operated'));
create view sdc_nonop_gctx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='South Texas') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Non-Operated'));
create view sdc_nonop_la as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='LA Region') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Non-Operated'));
create view sdc_nonop_nm as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='NM Region') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Non-Operated'));
create view sdc_nonop_ok as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='OK Region') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Non-Operated'));
create view sdc_nonop_ntx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='North Texas') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Non-Operated'));
create view sdc_nonop_phtx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='Panhandle') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Non-Operated'));
create view sdc_nonop_wtx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='West Texas') and ((pldb.owning_company)='SDC') and ((pldb.operating_status)='Non-Operated'));

-- SOG Acres
create view sog_al as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='AL Region') and ((pldb.owning_company)='SOG'));
create view sog_ar as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='AR Region') and ((pldb.owning_company)='SOG'));
create view sog_ca as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='CA Region') and ((pldb.owning_company)='SOG'));
create view sog_etx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='East Texas') and ((pldb.owning_company)='SOG'));
create view sog_gctx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='South Texas') and ((pldb.owning_company)='SOG'));
create view sog_la as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='LA Region') and ((pldb.owning_company)='SOG'));
create view sog_nm as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='NM Region') and ((pldb.owning_company)='SOG'));
create view sog_ok as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='OK Region') and ((pldb.owning_company)='SOG'));
create view sog_phtx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='Panhandle') and ((pldb.owning_company)='SOG'));
create view sog_ntx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='North Texas') and ((pldb.owning_company)='SOG'));
create view sog_wtx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='West Texas') and ((pldb.owning_company)='SOG'));
create view sog_acres as select pldb.id, pldb.name as n, pldb_locations.region as r, pldb.gross_acres as ga, pldb.net_acres as na, pldb.owning_company as oc, pldb.operating_status as os
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where ((pldb.owning_company)='SOG');

-- SDC Acres
create view sdc_al as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='AL Region') and ((pldb.owning_company)='SDC'));
create view sdc_ar as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='AR Region') and ((pldb.owning_company)='SDC'));
create view sdc_ca as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='CA Region') and ((pldb.owning_company)='SDC'));
create view sdc_etx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='East Texas') and ((pldb.owning_company)='SDC'));
create view sdc_gctx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='South Texas') and ((pldb.owning_company)='SDC'));
create view sdc_la as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='LA Region') and ((pldb.owning_company)='SDC'));
create view sdc_nm as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='NM Region') and ((pldb.owning_company)='SDC'));
create view sdc_ok as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='OK Region') and ((pldb.owning_company)='SDC'));
create view sdc_phtx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='Panhandle') and ((pldb.owning_company)='SDC'));
create view sdc_ntx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='North Texas') and ((pldb.owning_company)='SDC'));
create view sdc_wtx as select pldb.id, pldb.name, pldb_locations.region, pldb.gross_acres, pldb.net_acres, pldb.owning_company, pldb.operating_status
    from pldb_locations inner join pldb on pldb_locations.id = pldb.location_id
    where (((pldb_locations.region)='West Texas') and ((pldb.owning_company)='SDC'));





