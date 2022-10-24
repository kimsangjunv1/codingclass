<?php 
    include "../connect/connect.php";
    include "../connect/session.php";
    include "../connect/sessionCheck.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
            <h2>게시판 보기 영역입니다.</h2>
            <div class="board__inner">
                <div class="board__title">
                    <h3>게시판 보기 영역입니다.</h3>
                    <p>웹디자이너, 웹퍼블리셔, 프론트앤드 개발자를 위한 게시판입니다.</p>
                </div>
                <div class="board__view">
                    <table>
                        <colgroup>
                            <col style="width:20%">
                            <col style="width:80%">
                        </colgroup>
                        <tbody>
<?php
    $myBoardID = $_GET['myBoardID'];

    //보드뷰 + 1(업데이트)
    $sql = "UPDATE myBoard SET boardView = boardView + 1 WHERE myBoardID = {$myBoardID}";
    $connect -> query($sql);
  
    // echo $myBoardID;
    $sql = "SELECT b.boardTitle, m.youName, b.regTime, b.boardView, b.boardContents FROM myBoard b JOIN myMember m ON(m.myMemberID = b.myMemberID) WHERE b.myBoardID = {$myBoardID}";
    $result = $connect -> query($sql);


    if($result){
       $info = $result -> fetch_array(MYSQLI_ASSOC);
    //    echo "<pre>";
    //    var_dump($info);
    //    echo "</pre>";
        echo "<tr><th>제목</th><td>".$info['boardTitle']."</td></tr>";
        echo "<tr><th>등록자</th><td>".$info['youName']."</td></tr>";
        echo "<tr><th>등록일</th><td>".date('Y-m-d H:i',$info['regTime'])."</td></tr>";
        echo "<tr><th>조회수</th><td>".$info['boardView']."</td></tr>";
        echo "<tr><th>내용</th><td class='height'>".$info['boardContents']."</td></tr>";
   }

   
?>
                            <!-- <tr>
                                <th>제목</th>
                                <td>게시판 제목입니다.</td>
                            </tr>
                            <tr>
                                <th>등록자</th>
                                <td>마뇽</td>
                            </tr>
                            <tr>
                                <th>등록일</th>
                                <td>2022.05.08</td>
                            </tr>
                            <tr>
                                <th>등록일</th>
                                <td>2022.05.08</td>
                            </tr>
                            <tr>
                                <th>조회수</th>
                                <td>999</td>    
                            </tr>
                            <tr>
                                <th>내용</th>
                            <td class="height">
                            또 모르지 내 마음이 저 날씨처럼 바뀔지 날 나조차 다 알 수 없으니 <br><br>

                            그게 뭐가 중요하니 지금 네게 완전히 푹 빠졌단 게 중요한 거지 <br><br>

                            아마 꿈만 같겠지만 분명 꿈이 아니야 달리 설명할 수 없는 이건 사랑일 거야 <br>
                            방금 내가 말한 감정 감히 의심하지 마 그냥 좋다는 게 아냐 What's after 'LIKE'? <br><br>

                            You and I It's more than 'LIKE'<br>
                            L 다음 또 O 다음 난 yeah You and I<br>
                            It's more than 'LIKE' What's after 'LIKE'? What's after 'LIKE'?<br><br>

                            조심해 두 심장에 핀 새파란 이 불꽃이 저 태양보다 뜨거울 테니<br><br>

                            난 저 위로 또 아래로 내 그래프는 폭이 커 Yeah that's me<br><br>

                            두 번 세 번 피곤하게 자꾸 질문하지 마 내 장점이 뭔지 알아? 바로 솔직한 거야<br>
                            방금 내가 말한 감정 감히 의심하지 마 그냥 좋다는 게 아냐 What's after 'LIKE'?<br><br>

                            You and I It's more than 'LIKE'<br>
                            L 다음 또 O 다음 난 yeah You and I<br>
                            It's more than 'LIKE' What's after 'LIKE'? What's after 'LIKE'?<br><br>

                            What after like 내 맘에 strike 지금 느낀 짜릿함은 마치 tike<br> 
                            LO 다음에 I 그 다음에 VE 여긴 너와 내 space 아무도 막지 못해<br>
                            나를 보면 눈 깜빡할 시간 조차도 아까울 걸<br>
                            드디어 만나 반가워 LOVE 사이 놓일 I (What's after 'LIKE'?)<br><br>

                            You and I It's more than 'LIKE'<br>
                            E 앞 또 V 앞 난 yeah You and I<br>
                            It's more than 'LIKE' What's after 'LIKE'?<br><br>

                            You and I It's more than 'LIKE'<br>
                            L 다음 또 O 다음 난 yeah You and I<br>
                            It's more than 'LIKE' What's after 'LIKE'? What's after 'LIKE'?
                            </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
                <div class="board__btn">
                    <a href="boardModify.php?myBoardID=<?=$myBoardID?>">수정하기</a>
                    <a href="boardRemove.php?myBoardID=<?=$myBoardID?>" onclick="alert('정말 삭제하시겠습니까? ;3')">삭제하기</a>
                    <a href="board.php">목록보기</a>
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