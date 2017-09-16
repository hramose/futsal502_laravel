ALTER TABLE `futsal502`.`campeonato` 
ADD COLUMN `grupos` TINYINT(4) NOT NULL AFTER `mostrar_app`;

ALTER TABLE `futsal502`.`campeonato_equipo` 
ADD COLUMN `grupo` VARCHAR(1) NOT NULL AFTER `equipo_id`;