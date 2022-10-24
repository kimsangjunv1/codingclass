<?php 
    include "../connect/connect.php";
    include "../connect/session.php";
    include "../connect/sessionCheck.php";
?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>

    <?php include "../include/link.php" ?>
</head>
<body>
    <div id="skip">
        <a href="#header">헤더 영역 바로가기</a>
        <a href="#main">컨텐츠 영역 바로가기</a>
        <a href="#footer">푸터 영역 바로가기</a>
    </div>

    <?php include "../include/header.php" ?>
     <!-- /header -->

    <main id="main">
    <section id="board" class="container">
            <h2>게시판 영역입니다.</h2>
            <div class="board__inner">
                <div class="board__title">
                    <h3>게시판</h3>
                    <p>웹디자이너, 웹퍼블리셔, 프론트앤드 개발자를 위한 게시판입니다.</p>
                </div>
                <div class="board__search">
                    <div class="left">
                        <!-- 🐏 총 <em>1111</em>건의 게시물이 등록되어 있습니다. -->
                         <!-- 몇 개 & 몇 페이지 -->
<?php
    //  function msg($left){
    //     echo "🐏총 <em>".$left."</em>건이 검색되었습니다. :3";
    // }
    
    // $sql = "SELECT b.myBoardID, b.boardTitle, m.youName, b.regTime, b.boardView FROM myBoard b JOIN myMember m ON (b.myMemberID = m.myMemberID) ORDER BY myBoardID";
    // $result = $connect -> query($sql);

    // if($result){
    //     $count = $result -> num_rows;
    //     msg($count);
    // }


    $sql = "SELECT count(myBoardID) FROM myBoard";
    $result = $connect -> query($sql);
    $boardCount = $result -> fetch_array(MYSQLI_ASSOC);
    $boardCount = $boardCount['count(myBoardID)'];
    
    if(isset($_GET['page'])){
        $page = (int)$_GET['page'];
        } else {
            $page = 1;
        }
    echo "🐏 총 <em>{$boardCount}</em>건의 게시물이 등록되어 있습니다. :3 <br>";
    echo "🐏 현재페이지 <em>{$page}</em>페이지 입니다. :3 ";
?>
                    </div>
                    <div class="right">
                        <form action="boardSearch.php" name="boardSearch" method="get"> 
                            <fieldset>
                                <legend>게시판 검색 영역</legend>
                                <input type="search" name="searchKeyword" id="searchKeyword" placeholder="검색어를 입력하세요 :3" aria-label="search" required>
                                <select name="searchOption" id="searchOption">
                                    <option value="title">제목</option>
                                    <option value="content">내용</option>
                                    <option value="name">등록자</option>
                                </select>
                                <button type="submit" class="searchBtn">검색</button>
                                <a href="boardWrite.php" class="btn">글쓰기</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="board__table">
                    <table>
                        <colgroup>
                            <col style="width:5%">
                            <col>
                            <col style="width:10%">
                            <col style="width:10%">
                            <col style="width:7%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>제목</th>
                                <th>등록자</th>
                                <th>등록일</th>
                                <th>조회수</th>
                            </tr>
                        </thead>
                        <tbody>
<?php

    if(isset($_GET['page'])){
        $page = (int)$_GET['page'];
    } else {
        $page = 1;
    }

    $viewNum = 10;
    $viewLimit = ($viewNum * $page) - $viewNum;

    // echo $_GET['page'];

    // 501 / 20 == 26
    // 499 / 21 == 25
    // 무조건 소수점 올림 CEIL
    // 1~20 : 1page = DESC 0,   20 = ($viewNum * 1) - $viewNum
    // 21~40 : 2page = DESC 20, 20 = ($viewNum * 2) - $viewNum
    // 41~60 : 3page = DESC 40, 20 = ($viewNum * 3) - $viewNum
    // 61~80 : 4page = DESC 60, 20 = ($viewNum * 4) - $viewNum
    // 두개의 테이블 <join></join>

    $sql = "SELECT b.myBoardID, b.boardTitle, m.youName, b.regTime, b.boardView FROM myBoard b JOIN myMember m ON (b.myMemberID = m.myMemberID) ORDER BY myBoardID DESC LIMIT {$viewLimit}, {$viewNum}";
    $result = $connect -> query($sql);

    if($result){
        $count = $result -> num_rows;   
        if($count > 0){
            for($i=1; $i <= $count; $i++){
                $info = $result -> fetch_array(MYSQLI_ASSOC);
                echo "<tr>";
                echo "<td>".$info['myBoardID']."</td>";
                echo "<td><a href='boardView.php?myBoardID={$info['myBoardID']}'>".$info['boardTitle']."</a></td>";
                echo "<td>".$info['youName']."</td>";
                echo "<td>".date('Y-m-d',$info['regTime'])."</td>";
                echo "<td>".$info['boardView']."</td>";
                echo "</tr>";
            }
        }else {
            echo "<tr><td colspan = '5'>게시판이 없습니다 ;< </td></tr>";
        }
    }
    
?>
                            <!-- <tr>
                                <td>1</td>
                                <td><a href="boardView.php">게시판 제목입니다.</a></td>
                                <td>마뇽</td>
                                <td>2022-05-09</td>
                                <td>4</td>
                            </tr>-->
                        </tbody>
                    </table>
                </div>
                <div class="board__pages">
                    <ul>
<?php
    $sql = "SELECT count(myBoardID) FROM myboard";
    $result = $connect -> query($sql);

    $boardCount = $result -> fetch_array(MYSQLI_ASSOC);
    $boardCount = $boardCount['count(myBoardID)'];

    //총 페이지 갯수
    $boardCount = ceil($boardCount/$viewNum);
    
    // echo $boardCount;

    //현재 페이지를 기준으로 보여주고 싶은 갯수
    $pageCurrent = 5;
    $startPage = $page - $pageCurrent;
    $endPage = $page + $pageCurrent;

    //처음 페이지 초기화
    if($startPage < 1) $startPage = 1;

    //마지막 페이지 초기화
    if($endPage >= $boardCount ) $endPage = $boardCount;

    //이전페이지, 처음페이지
    if($page != 1){
        $prevPage = $page - 1;
        echo "<li><a href='board.php?page=1'>처음으로</a></li>";
        echo "<li><a href='board.php?page={$prevPage}'>이전</a></li>";
    }

    //페이지 넘버 표시
    for($i=$startPage; $i<=$endPage; $i++){
        $active = "";
        if($i == $page)$active = "active";

        echo "<li class='{$active}'><a href='board.php?page={$i}'>{$i}</a></li>";
    }

    //다음 페이지, 마지막페이지
    if($page != $boardCount){
        $nextPage = $page + 1;
        echo "<li><a href='board.php?page={$nextPage}'>다음</a></li>";
        echo "<li><a href='board.php?page={$boardCount}'>마지막으로</a></li>";
    }
?>
                        <!-- <li><a href="#">처음으로</a></li>
                        <li><a href="#">이전</a></li>
                        <li><a href="#" class="active">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">6</a></li>
                        <li><a href="#">7</a></li>
                        <li><a href="#">다음</a></li>
                        <li><a href="#">마지막으로</a></li> -->
                    </ul>
                </div>
            </div>
        </section>
        <!-- /board -->
    </main>
    <!-- /main -->

    <?php include "../include/footer.php" ?>
    <!-- /footer -->

</body>
</html>