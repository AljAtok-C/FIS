<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-11-20 08:12:48 --> Severity: Notice --> Undefined variable: js_file D:\Users\Projects\fis\application\views\admin\templates.php 485
ERROR - 2025-11-20 08:12:48 --> Severity: Notice --> Undefined variable: js_file D:\Users\Projects\fis\application\views\admin\templates.php 485
ERROR - 2025-11-20 08:12:48 --> Severity: Notice --> Undefined variable: js_file D:\Users\Projects\fis\application\views\admin\templates.php 485
ERROR - 2025-11-20 08:12:54 --> Query error: Table 'db_fis.incentives_tbl' doesn't exist - Invalid query: SELECT `a`.*, `c`.*, CONCAT(b.userFirstName, " ", b.userLastName) as userFullName, CONCAT(d.userFirstName, " ", d.userLastName) as userFullNameModifier, `e`.`store_ifs_code`, `e`.`store_name`, `f`.`incentive_hurdle_qty`, `f`.`incentive_hurdle_sales_qty`, `f`.`incentive_hurdle_is_qualified`
FROM `incentives_tbl` `a`
INNER JOIN `users` `b` ON `a`.`incentive_added_by` = `b`.`userID`
INNER JOIN `status_tbl` `c` ON `a`.`incentive_status` = `c`.`status_id`
LEFT JOIN `users` `d` ON `a`.`incentive_modified_by` = `d`.`userID`
INNER JOIN `stores_tbl` `e` ON `a`.`store_id` = `e`.`store_id`
INNER JOIN `incentive_hurdles_tbl` `f` ON `a`.`incentive_id` = `f`.`incentive_id`
INNER JOIN `material_groups_tbl` `g` ON `f`.`mat_group_id` = `g`.`mat_group_id`
ORDER BY `a`.`incentive_code`
ERROR - 2025-11-20 08:13:13 --> Severity: Notice --> Undefined variable: js_file D:\Users\Projects\fis\application\views\admin\templates.php 485
ERROR - 2025-11-20 08:21:32 --> Severity: Notice --> Undefined variable: js_file D:\Users\Projects\fis\application\views\admin\templates.php 485
ERROR - 2025-11-20 08:21:32 --> Severity: Notice --> Undefined variable: js_file D:\Users\Projects\fis\application\views\admin\templates.php 485
ERROR - 2025-11-20 08:21:32 --> Severity: Notice --> Undefined variable: js_file D:\Users\Projects\fis\application\views\admin\templates.php 485
ERROR - 2025-11-20 08:21:35 --> Query error: Table 'db_fis.incentives_tbl' doesn't exist - Invalid query: SELECT `a`.*, `c`.*, CONCAT(b.userFirstName, " ", b.userLastName) as userFullName, CONCAT(d.userFirstName, " ", d.userLastName) as userFullNameModifier, `e`.`store_ifs_code`, `e`.`store_name`, `f`.`incentive_hurdle_qty`, `f`.`incentive_hurdle_sales_qty`, `f`.`incentive_hurdle_is_qualified`
FROM `incentives_tbl` `a`
INNER JOIN `users` `b` ON `a`.`incentive_added_by` = `b`.`userID`
INNER JOIN `status_tbl` `c` ON `a`.`incentive_status` = `c`.`status_id`
LEFT JOIN `users` `d` ON `a`.`incentive_modified_by` = `d`.`userID`
INNER JOIN `stores_tbl` `e` ON `a`.`store_id` = `e`.`store_id`
INNER JOIN `incentive_hurdles_tbl` `f` ON `a`.`incentive_id` = `f`.`incentive_id`
INNER JOIN `material_groups_tbl` `g` ON `f`.`mat_group_id` = `g`.`mat_group_id`
ORDER BY `a`.`incentive_code`
ERROR - 2025-11-20 08:25:47 --> Severity: Notice --> Undefined variable: js_file D:\Users\Projects\fis\application\views\admin\templates.php 485
ERROR - 2025-11-20 08:31:27 --> Severity: Notice --> Undefined variable: js_file D:\Users\Projects\fis\application\views\admin\templates.php 485
ERROR - 2025-11-20 09:18:59 --> Query error: Table 'db_fis.incentives_tbl' doesn't exist - Invalid query: SELECT `a`.*, `c`.*, CONCAT(b.userFirstName, " ", b.userLastName) as userFullName, CONCAT(d.userFirstName, " ", d.userLastName) as userFullNameModifier, `e`.`store_ifs_code`, `e`.`store_name`, `f`.`incentive_hurdle_qty`, `f`.`incentive_hurdle_sales_qty`, `f`.`incentive_hurdle_is_qualified`
FROM `incentives_tbl` `a`
INNER JOIN `users` `b` ON `a`.`incentive_added_by` = `b`.`userID`
INNER JOIN `status_tbl` `c` ON `a`.`incentive_status` = `c`.`status_id`
LEFT JOIN `users` `d` ON `a`.`incentive_modified_by` = `d`.`userID`
INNER JOIN `stores_tbl` `e` ON `a`.`store_id` = `e`.`store_id`
INNER JOIN `incentive_hurdles_tbl` `f` ON `a`.`incentive_id` = `f`.`incentive_id`
INNER JOIN `material_groups_tbl` `g` ON `f`.`mat_group_id` = `g`.`mat_group_id`
ORDER BY `a`.`incentive_code`
ERROR - 2025-11-20 17:08:46 --> Severity: Notice --> Undefined variable: js_file D:\Users\Projects\fis\application\views\admin\templates.php 485
ERROR - 2025-11-20 17:08:46 --> Severity: Notice --> Undefined variable: js_file D:\Users\Projects\fis\application\views\admin\templates.php 485
ERROR - 2025-11-20 17:08:46 --> Severity: Notice --> Undefined variable: js_file D:\Users\Projects\fis\application\views\admin\templates.php 485
