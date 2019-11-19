<?php
require_once '../core/init.php';

$db = DB::getInstance();
$imagename = Input::get("imagename");
$username = Input::get("username");
$imageid = Input::get("id");
$path = "../includes/usergallery/" . $imagename;
unlink($path);
$db->delete('likes', array('imageid', '=', $imageid));
$db->delete('comments', array('imageid', '=', $imageid));
$db->delete('images', array('imagename', '=', $imagename));
Session::flash('profile',' Image Deleted!');
Redirect::to('../includes/profile.php?start=0&user='.$username);