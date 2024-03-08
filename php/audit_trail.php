<?php

function CreateLogEntry($action, $table, $column, $old_value, $new_value, $user_id) {
    include '../../private/conn.php';

    $sql_create_log = 'INSERT INTO tbl_audit (audit_action, audit_table, audit_column, audit_old_value, audit_current_value, audit_user_id) VALUES (:action, :table, :column, :old_value, :new_value, :user_id)';
    $sth_create_log = $conn->prepare($sql_create_log);
    $sth_create_log->bindParam(":action", $action);
    $sth_create_log->bindParam(":table", $table);
    $sth_create_log->bindParam(":column", $column);
    $sth_create_log->bindParam(":old_value", $old_value);
    $sth_create_log->bindParam(":new_value", $new_value);
    $sth_create_log->bindParam(":user_id", $user_id);
    $sth_create_log->execute();

}
//CREATION AUDITS
function Audit_UserRegister($user_id) {
    CreateLogEntry('Register', 'tbl_users', 'users_id', null, $user_id, $user_id);
}
function Audit_AdminCreate($admin_id, $new_admin_id) {
    CreateLogEntry('Admin Create', 'tbl_users', 'users_id', null, $new_admin_id, $admin_id);
}
function Audit_TagCreate($admin_id, $tag_name) {
    CreateLogEntry('Tag Create', 'tbl_tags', 'tags_id', null, $tag_name, $admin_id);
}
function Audit_LanguageCreate($admin_id, $language_name) {
    CreateLogEntry('Language Create', 'tbl_tags', 'tags_id', null, $language_name, $admin_id);
}
function Audit_EducationCreate($admin_id, $education_name) {
    CreateLogEntry('Education Create', 'tbl_tags', 'tags_id', null, $education_name, $admin_id);
}

//UPDATE AUDITS
function Audit_AdminUpdate($array) {
    include '../../private/conn.php';


    //include 'private/conn.php';
    $sql_admin_select = "SELECT users_first_name, users_preposition, users_last_name FROM tbl_users WHERE users_id = :user_id";
    $sth_admin_select = $conn->prepare($sql_admin_select);
    $sth_admin_select->bindParam(":user_id", $array['users_id']);
    $sth_admin_select->execute();
    $oldValue = $sth_admin_select->fetch();

    print_r($oldValue);
        foreach($array as $key => $value) {
            if($oldValue[$key] != $value) {
                CreateLogEntry('Admin Edit', 'tbl_users', $key, $oldValue[$key], $value, $array['users_id']);
            }
        }

}

//DELETE AUDITS