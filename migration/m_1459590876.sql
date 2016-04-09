USE `swc`;
CREATE 
     OR REPLACE ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `v_all_users` AS
    select 
        `users`.`id` AS `id`,
        `users`.`name` AS `name`,
        `users`.`password` AS `password`,
        `users`.`identifier` AS `identifier`,
        `users`.`mail` AS `mail`,
        `users`.`user_type_id` AS `user_type_id`,
        `users`.`grade` AS `grade`,
        `users`.`track_id` AS `track_id`,
        `users`.`questions_id` AS `questions_id`,
        `user_type`.`type` AS `type`

    from
        (`users`
        join `user_type` ON (`users`.`user_type_id` = `user_type`.`id`))
        
    order by `users`.`id`;
