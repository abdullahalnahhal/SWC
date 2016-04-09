USE `swc`;
CREATE 
     OR REPLACE ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `v_users` AS
    select 
        `users`.*,
        `user_type`.`type` AS `type`,
		`track`.`name` AS `track_name`,
		`track`.`identifier` AS `track_identifier`,
		`track`.`objectives` AS `track_objectives`
    from
        ((`users`
        join `user_type` ON ((`users`.`user_type_id` = `user_type`.`id`)))
        join `track`ON ((`users`.`track_id` = `track`.`id`)))
    order by`users`.`id` ASC;
