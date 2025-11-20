<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-01-03 17:05:05 --> Severity: Warning --> mysqli::query(): MySQL server has gone away D:\base-temp\system\database\drivers\mysqli\mysqli_driver.php 307
ERROR - 2025-01-03 17:05:05 --> Severity: Warning --> mysqli::query(): Error reading result set's header D:\base-temp\system\database\drivers\mysqli\mysqli_driver.php 307
ERROR - 2025-01-03 17:05:05 --> Query error: MySQL server has gone away - Invalid query: SELECT *
FROM `users` `a`
JOIN `userkey` `b` ON `a`.`userID` = `b`.`userID` and `b`.`statusID` = 1 and (`a`.`userEmail` = "akatok@bountyagro.com.ph" or `a`.`employeeNo` = "akatok@bountyagro.com.ph")
JOIN `key` `c` ON `b`.`keyID` = `c`.`keyID`
JOIN `businesscenter` `d` ON `c`.`bcID` = `d`.`bcID`
JOIN `businessunit` `e` ON `c`.`buID` = `e`.`buID`
JOIN `usertype` `g` ON `a`.`userTypeID` = `g`.`userTypeID`
JOIN `themes` `h` ON `a`.`themeID` = `h`.`themeID`
JOIN `usertheme` `f` ON `a`.`userID` = `f`.`userID`
ORDER BY `b`.`current` DESC, `b`.`keyID`
ERROR - 2025-01-03 17:05:09 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): No connection could be made because the target machine actively refused it.
 D:\base-temp\system\database\drivers\mysqli\mysqli_driver.php 203
ERROR - 2025-01-03 17:05:09 --> Unable to connect to the database
ERROR - 2025-01-03 17:08:19 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-01-03 17:08:19 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-01-03 17:08:19 --> Severity: Notice --> Undefined variable: js_file D:\base-temp\application\views\admin\templates.php 485
ERROR - 2025-01-03 17:13:06 --> Query error: Table 'db_crish2.incentives_tbl' doesn't exist - Invalid query: SELECT `a`.*, `c`.*, CONCAT(b.userFirstName, " ", b.userLastName) as userFullName, CONCAT(d.userFirstName, " ", d.userLastName) as userFullNameModifier, `e`.`store_ifs_code`, `e`.`store_name`, `f`.`incentive_hurdle_qty`, `f`.`incentive_hurdle_sales_qty`, `f`.`incentive_hurdle_is_qualified`
FROM `incentives_tbl` `a`
INNER JOIN `users` `b` ON `a`.`incentive_added_by` = `b`.`userID`
INNER JOIN `status_tbl` `c` ON `a`.`incentive_status` = `c`.`status_id`
LEFT JOIN `users` `d` ON `a`.`incentive_modified_by` = `d`.`userID`
INNER JOIN `stores_tbl` `e` ON `a`.`store_id` = `e`.`store_id`
INNER JOIN `incentive_hurdles_tbl` `f` ON `a`.`incentive_id` = `f`.`incentive_id`
INNER JOIN `material_groups_tbl` `g` ON `f`.`mat_group_id` = `g`.`mat_group_id`
ORDER BY `a`.`incentive_code`
ERROR - 2025-01-03 17:13:20 --> Query error: Table 'db_crish2.incentives_tbl' doesn't exist - Invalid query: SELECT `a`.*, `c`.*, CONCAT(b.userFirstName, " ", b.userLastName) as userFullName, CONCAT(d.userFirstName, " ", d.userLastName) as userFullNameModifier, `e`.`store_ifs_code`, `e`.`store_name`, `f`.`incentive_hurdle_qty`, `f`.`incentive_hurdle_sales_qty`, `f`.`incentive_hurdle_is_qualified`
FROM `incentives_tbl` `a`
INNER JOIN `users` `b` ON `a`.`incentive_added_by` = `b`.`userID`
INNER JOIN `status_tbl` `c` ON `a`.`incentive_status` = `c`.`status_id`
LEFT JOIN `users` `d` ON `a`.`incentive_modified_by` = `d`.`userID`
INNER JOIN `stores_tbl` `e` ON `a`.`store_id` = `e`.`store_id`
INNER JOIN `incentive_hurdles_tbl` `f` ON `a`.`incentive_id` = `f`.`incentive_id`
INNER JOIN `material_groups_tbl` `g` ON `f`.`mat_group_id` = `g`.`mat_group_id`
ORDER BY `a`.`incentive_code`
