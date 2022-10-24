<?php 
     include "../connect/connect.php";

     $sql = "CREATE TABLE myMember(";
     $sql .= "myMemberID int(10) unsigned NOT NULL auto_increment,";
     $sql .= "youEmail varchar(40) NOT NULL,";
     $sql .= "youName varchar(10) NOT NULL,";
     $sql .= "youPass varchar(50) NOT NULL,";
     $sql .= "youNickName varchar(10) NOT NULL,";
     $sql .= "youPhone varchar(20) NOT NULL,";
     $sql .= "regTime int(20) NOT NULL,";
     $sql .= "PRIMARY KEY (myMemberID)";
     $sql .= ") charset=utf8;";
     
     $connect -> query($sql);
 

    // CREATE TABLE myMember (
    //     myMemberID int(10) unsigned NOT NULL auto_increment,
    //     youEmail varchar(40) NOT NULL,
    //     youName varchar(10) NOT NULL,
    //     youPass varchar(40) NOT NULL,
    //     youNickName varchar(10) NOT NULL,
    //     youPhone varchar(20) NOT NULL,
    //     regTime int(20) NOT NULL,
    //     PRIMARY KEY (myMemberID)
    // ) charset=utf8;


?>