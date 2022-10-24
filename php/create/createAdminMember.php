<?php 
    include "../connect/connect.php";

    $sql = "CREATE TABLE myAdminMember (";
    $sql .= "myMemberID int(10) unsigned auto_increment,";
    $sql .= "youEmail varchar(40) NOT NULL,";
    $sql .= "youNickName varchar(40) UNIQUE NULL,";
    $sql .= "youName varchar(20) NOT NULL,";
    $sql .= "youPass varchar(40) NOT NULL,";
    $sql .= "youBirth varchar(20) NOT NULL,";   
    $sql .= "youPhone varchar(20) NOT NULL,";
    $sql .= "youGender enum('남자', '여자') DEFAULT NULL,";
    $sql .= "youPhoto varchar(255) DEFAULT NULL,";
    $sql .= "youIntro varchar(255) DEFAULT NULL,";
    $sql .= "youSite varchar(255) DEFAULT NULL,";
    $sql .= "regTime int(20) NOT NULL,";
    $sql .= "PRIMARY KEY (myMemberID)";
    $sql .= ") charset=utf8";
    $connect -> query($sql);
 

    // CREATE TABLE myAdminMember(
    //     myAdminMemberID int(10) unsigned NOT NULL auto_increment,
    //     youEmail varchar(40) NOT NULL,
    //     youName varchar(10) NOT NULL,
    //     youPass varchar(40) NOT NULL,
    //     youNickName varchar(10) NOT NULL,
    //     youPhone varchar(20) NOT NULL,
    //     regTime int(20) NOT NULL,
    //     PRIMARY KEY (myAdminMemberID)
    // ) charset=utf8;
// UNIQUE -> 독립적으로 사용 가능 (중복확인)

?>