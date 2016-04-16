CREATE 
     OR REPLACE ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `v_question` AS
    select 
        `questions`.*,
        `track`.`identifier` AS `track_identifier`,
        `track`.`name` AS `track_name`
    from
        (`questions`
        join `track` ON ((`questions`.`track_id` = `track`.`id`)))
    order by `questions`.`id`;