USE `swc`;
CREATE 
     OR REPLACE ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `v_articles` AS
    select 
        `track_aticls`.*,
        `track`.`identifier` AS `track_identifier`,
        `track`.`name` AS `track_name`,
        `track`.`objectives` AS `track_objectives`
    from
        (`track_aticls`
        join `track` ON ((`track_aticls`.`track_id` = `track`.`id`)))
    order by `track_aticls`.`id`;
