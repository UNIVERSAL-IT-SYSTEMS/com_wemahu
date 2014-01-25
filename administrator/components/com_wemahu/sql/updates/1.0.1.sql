ALTER TABLE `#__wm_rulesets`
	ADD `max_results_file` INT UNSIGNED NOT NULL DEFAULT '5' AFTER `filesize_max` ,
	ADD `max_results_total` INT UNSIGNED NOT NULL DEFAULT '100' AFTER `max_results_file` ;