<header id="header">
        <div class="header__inner container">
            <div class="left">
                <ul>
                    <li><a href="../main/main.php" class="star">🐳</a></li>
                </ul>
            </div>
            <h1><a href="../main/main.php">Manyong BLOG</a></h1>
            <div class="right">
                <ul>
                <?php if( isset($_SESSION['myMemberID'])){ ?>
                        <li><a href="#" class="black">🐳 <?=$_SESSION['youName']?>님 환영합니다 :3 </a></li>
                        <li><a href="../login/logout.php">로그아웃</a></li>
                <?php }else {   ?>
                        <li><a href="#" class="loginBtn">LOGIN</a></li>
                        <li><a href="../login/join.php">회원가입</a></li>
                <?php  }   ?>
                </ul>
                   
            </div>
            <nav class="nav">
                <ul>
                    <li><a href="../login/join.php">로그인</a></li>
                    <li><a href="../board/board.php">게시판</a></li>
                    <li><a href="../board/blog.php">블로그</a></li>
                    <li><a href="#">연락처</a></li>
                </ul>
            </nav>
        </div>
</header>