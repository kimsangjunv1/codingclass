<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    $category = $_GET['category'];

    $categorySql = "SELECT * FROM myBlog WHERE blogDelete=0 AND blogCategory = '$category' ORDER BY myBlogID DESC LIMIT 10";
    $categoryResult = $connect -> query($categorySql);
    $categoryInfo = $categoryResult -> fetch_array(MYSQLI_ASSOC);
    $categoryCount = $categoryResult -> num_rows;
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 사이트 만들기</title>

    <?php include "../include/link.php" ?>
</head>
<body>
<div id="skip">
        <a href="#header">헤더 영역 바로가기</a>
        <a href="#main">컨텐츠 영역 바로가기</a>
        <a href="#footer">푸터 영역 바로가기</a>
    </div>
    <!-- skip -->

    <?php include "../include/header.php" ?>
    <!-- header -->

    <main id="main">
        <section id='blog' class='container'>
            <div class="blog__title">
                <h2><?=$categoryInfo['blogCategory']?>게시판</h2>
                <p><?=$categoryInfo['blogCategory']?>와(과) 관련된 글이 <?=$categoryCount?>개 있습니다.</p>
            </div>
            <div class='blog__inner'>
                <div class="blog__contents">
                    <div class="card__inner horizon">
<?php foreach($categoryResult as $blog){  ?>
        <div class="card">
            <figure>
                <img src="../assets/img/blog/<?=$blog['blogImgFile']?>" alt="vscode에 scss설치하기">
                <a href="blogView.php?blogID=<?=$blog['myBlogID']?>" class="go" title="컨텐츠 바로가기">
                </a>
                <span class="cate"><?=$blog['blogCategory']?></span>
            </figure>
            <div>
                <a href="blogView.php?blogID=<?=$blog['myBlogID']?>">
                    <h3><?=$blog['blogTitle']?></h3>
                    <p><?=$blog['blogContents']?></p>
                </a>
            </div>
        </div>
<?php } ?>
                    </div>
                </div>
                <!-- //blog__contents -->

                <div class="blog__aside">
                    <div class="blog__aside__intro">
                        <div class="img">
                            <img src="../../assets/img/card_bg_01.png" alt="나">
                        </div>
                        <div class="intro">
                            아 너무 피곤해~~~~~~~~~~~ 
                        </div>
                    </div>
                    <div class="blog__aside__cate">
                        <h3>카테고리</h3>
                        <ul>
                            <?php include "../include/category.php" ?>
                        </ul>
                    </div>
                    <div class="blog__aside__new">
                        <h3>최신글</h3>
                        <ul>
                            <?php include "../include/blogNew.php" ?>
                            <!-- <li><a href="#"><span><img src="../assets/img/icon_256.png" alt="d"></span><em>애플은 미국 캘리포니아의 아이폰, 아이패드, 애플 워치, 에어팟, 아이맥, 맥북, 맥 스튜디오와 맥 프로, 홈팟 등의 하드웨어와 iOS, iPadOS, macOS 등의 소프트웨어를 설계,</em></a></li>
                            <li><a href="#"><span></span><em>주식회사 넥슨은 대한민국에서 가장 큰 비디오 게임 회사 중 하나이다. 유명한 넥슨의 </em></a></li>
                            <li><a href="#"><span></span><em>넥슨의 온라인 비디오 게임으로는 바람의나라, 바람의나라:연, FIFA 온라인 4, 피파 모바일, 메이플스토리, 크레이지 아케이드BnB, 카트라이더, 서든어택, </em></a></li>
                            <li><a href="#"><span></span><em>넷마블는 대한민국의 온라인 게임 공급 기업이자 포털 사이트 운영사이다. 2011년
                                에 주식회사 넷마블은 포털 사이트 넷마블을 만들었다.</em></a></li> -->
                        </ul>
                    </div>
                    <div class="blog__aside__pop">
                        <h3>인기글</h3>
                        <ul>
                            <?php include "../include/blogNew.php" ?>
                        </ul>
                    </div>
                    <div class="blog__aside__comment">
                        <h3>최신 댓글</h3>
                        <ul>
                            <li><a href="#">apple</a></li>
                            <li><a href="#">apple</a></li>
                            <li><a href="#">apple</a></li>
                            <li><a href="#">apple</a></li>
                        </ul>
                    </div>
                    <!-- <div class="blog__aside__ad"></div> -->
                </div>
                <div class="blog__relation"></div>
            </div>
        </section>
    </main>
    <!-- main -->
    
    <?php include "../include/footer.php" ?>
    <!-- footer -->
</body>
</html>