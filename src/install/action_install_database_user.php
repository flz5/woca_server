<?php
include "sql_exec.php";

exeSQL("sql/insert_user.sql");
header('Location: index.php?rval=1', true, 301);
exit;