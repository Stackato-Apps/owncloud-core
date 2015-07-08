<?php

OCP\JSON::checkAppEnabled('files_external');
OCP\JSON::checkLoggedIn();
OCP\JSON::callCheck();

if ($_POST['isPersonal'] == 'true') {
	// Check whether the user has permissions to add personal storage backends
	if(OCP\Config::getAppValue('files_external', 'allow_user_mounting', 'yes') !== 'yes') {
		OCP\JSON::error(array('data' => array('message' => 'no permission')));
		return;
	}
	$isPersonal = true;
} else {
	OCP\JSON::checkAdminUser();
	$isPersonal = false;
}

$mountPoint = $_POST['mountPoint'];
$oldMountPoint = $_POST['oldMountPoint'];
$class = $_POST['class'];
$options = $_POST['classOptions'];
$type = $_POST['mountType'];
$applicable = $_POST['applicable'];

if ($oldMountPoint and $oldMountPoint !== $mountPoint) {
	OC_Mount_Config::removeMountPoint($oldMountPoint, $type, $applicable, $isPersonal);
}

$status = OC_Mount_Config::addMountPoint($mountPoint, $class, $options, $type, $applicable, $isPersonal);
OCP\JSON::success(array('data' => array('message' => $status)));
