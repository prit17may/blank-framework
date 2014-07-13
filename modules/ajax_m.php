<?php

set_time_limit(0);
if (isset($_GET['action'])) {
	extract($_GET);
} elseif (isset($_POST['action'])) {
	extract($_POST);
}    
