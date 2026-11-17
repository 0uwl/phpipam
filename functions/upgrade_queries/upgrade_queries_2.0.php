<?php

//
// Version 2.0 queries
//
$upgrade_queries['2.0.48'] = [];
$upgrade_queries['2.0.48'][] = '-- Version update';
$upgrade_queries['2.0.48'][] = "UPDATE `settings` set `version` = '2.0';";

$upgrade_queries['2.0.49'][] = '-- Optionally keep subnet and IP address database IDs across delete / re-add';
$upgrade_queries['2.0.49'][] = "ALTER TABLE `settings` ADD `reuseDeletedIds` TINYINT(1)  NOT NULL  DEFAULT '0'  AFTER `passkeys`;";
$upgrade_queries['2.0.49'][] = 'CREATE TABLE `ipaddresses_released` (
  `subnetId` INT(11) UNSIGNED NOT NULL,
  `ip_addr` varchar(100) NOT NULL,
  `id` int(11) NOT NULL,
  `released` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`subnetId`,`ip_addr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
$upgrade_queries['2.0.49'][] = 'CREATE TABLE `subnets_released` (
  `sectionId` INT(11) UNSIGNED NOT NULL,
  `vrfId` INT(11) UNSIGNED NOT NULL DEFAULT 0,
  `subnet` VARCHAR(255) NOT NULL,
  `mask` VARCHAR(3) NOT NULL,
  `id` int(11) NOT NULL,
  `released` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sectionId`,`vrfId`,`subnet`,`mask`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
$upgrade_queries['2.0.49'][] = '-- Database version bump';
$upgrade_queries['2.0.49'][] = "UPDATE `settings` SET `dbversion` = '49';";
