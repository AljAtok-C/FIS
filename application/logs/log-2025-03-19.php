<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-03-19 18:15:06 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:15:06 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:15:07 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:15:11 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:15:12 --> Query error: Table 'db_crish2.incentives_tbl' doesn't exist - Invalid query: SELECT `a`.*, `c`.*, CONCAT(b.userFirstName, " ", b.userLastName) as userFullName, CONCAT(d.userFirstName, " ", d.userLastName) as userFullNameModifier, `e`.`store_ifs_code`, `e`.`store_name`, `f`.`incentive_hurdle_qty`, `f`.`incentive_hurdle_sales_qty`, `f`.`incentive_hurdle_is_qualified`
FROM `incentives_tbl` `a`
INNER JOIN `users` `b` ON `a`.`incentive_added_by` = `b`.`userID`
INNER JOIN `status_tbl` `c` ON `a`.`incentive_status` = `c`.`status_id`
LEFT JOIN `users` `d` ON `a`.`incentive_modified_by` = `d`.`userID`
INNER JOIN `stores_tbl` `e` ON `a`.`store_id` = `e`.`store_id`
INNER JOIN `incentive_hurdles_tbl` `f` ON `a`.`incentive_id` = `f`.`incentive_id`
INNER JOIN `material_groups_tbl` `g` ON `f`.`mat_group_id` = `g`.`mat_group_id`
ORDER BY `a`.`incentive_code`
ERROR - 2025-03-19 18:15:16 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:16:56 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:17:13 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:17:18 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:17:44 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:17:48 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:19:07 --> Query error: Table 'db_crish2.themes' doesn't exist - Invalid query: SELECT *
FROM `themes`
WHERE `statusID` = 1
ORDER BY `themeName`
ERROR - 2025-03-19 18:19:07 --> Query error: Table 'db_crish2.themes' doesn't exist - Invalid query: SELECT *
FROM `themes`
WHERE `statusID` = 1
ORDER BY `themeName`
ERROR - 2025-03-19 18:19:45 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:20:21 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:21:54 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:22:01 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:22:01 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:22:30 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:22:30 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:23:52 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:25:05 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 18:25:08 --> Query error: Table 'db_crish2.incentives_tbl' doesn't exist - Invalid query: SELECT `a`.*, `c`.*, CONCAT(b.userFirstName, " ", b.userLastName) as userFullName, CONCAT(d.userFirstName, " ", d.userLastName) as userFullNameModifier, `e`.`store_ifs_code`, `e`.`store_name`, `f`.`incentive_hurdle_qty`, `f`.`incentive_hurdle_sales_qty`, `f`.`incentive_hurdle_is_qualified`
FROM `incentives_tbl` `a`
INNER JOIN `users` `b` ON `a`.`incentive_added_by` = `b`.`userID`
INNER JOIN `status_tbl` `c` ON `a`.`incentive_status` = `c`.`status_id`
LEFT JOIN `users` `d` ON `a`.`incentive_modified_by` = `d`.`userID`
INNER JOIN `stores_tbl` `e` ON `a`.`store_id` = `e`.`store_id`
INNER JOIN `incentive_hurdles_tbl` `f` ON `a`.`incentive_id` = `f`.`incentive_id`
INNER JOIN `material_groups_tbl` `g` ON `f`.`mat_group_id` = `g`.`mat_group_id`
ORDER BY `a`.`incentive_code`
ERROR - 2025-03-19 18:28:29 --> Query error: Table 'db_crish2.incentives_tbl' doesn't exist - Invalid query: SELECT `a`.*, `c`.*, CONCAT(b.userFirstName, " ", b.userLastName) as userFullName, CONCAT(d.userFirstName, " ", d.userLastName) as userFullNameModifier, `e`.`store_ifs_code`, `e`.`store_name`, `f`.`incentive_hurdle_qty`, `f`.`incentive_hurdle_sales_qty`, `f`.`incentive_hurdle_is_qualified`
FROM `incentives_tbl` `a`
INNER JOIN `users` `b` ON `a`.`incentive_added_by` = `b`.`userID`
INNER JOIN `status_tbl` `c` ON `a`.`incentive_status` = `c`.`status_id`
LEFT JOIN `users` `d` ON `a`.`incentive_modified_by` = `d`.`userID`
INNER JOIN `stores_tbl` `e` ON `a`.`store_id` = `e`.`store_id`
INNER JOIN `incentive_hurdles_tbl` `f` ON `a`.`incentive_id` = `f`.`incentive_id`
INNER JOIN `material_groups_tbl` `g` ON `f`.`mat_group_id` = `g`.`mat_group_id`
ORDER BY `a`.`incentive_code`
ERROR - 2025-03-19 19:14:56 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-03-19 19:15:21 --> Query error: Table 'db_crish2.incentives_tbl' doesn't exist - Invalid query: SELECT `a`.*, `c`.*, CONCAT(b.userFirstName, " ", b.userLastName) as userFullName, CONCAT(d.userFirstName, " ", d.userLastName) as userFullNameModifier, `e`.`store_ifs_code`, `e`.`store_name`, `f`.`incentive_hurdle_qty`, `f`.`incentive_hurdle_sales_qty`, `f`.`incentive_hurdle_is_qualified`
FROM `incentives_tbl` `a`
INNER JOIN `users` `b` ON `a`.`incentive_added_by` = `b`.`userID`
INNER JOIN `status_tbl` `c` ON `a`.`incentive_status` = `c`.`status_id`
LEFT JOIN `users` `d` ON `a`.`incentive_modified_by` = `d`.`userID`
INNER JOIN `stores_tbl` `e` ON `a`.`store_id` = `e`.`store_id`
INNER JOIN `incentive_hurdles_tbl` `f` ON `a`.`incentive_id` = `f`.`incentive_id`
INNER JOIN `material_groups_tbl` `g` ON `f`.`mat_group_id` = `g`.`mat_group_id`
ORDER BY `a`.`incentive_code`
