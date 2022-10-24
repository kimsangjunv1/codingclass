<div class="login__popup">
        <div class="login__inner">
            <div class="login__header">
                <h3>LOGIN</h3>
            </div>
            <div class="login__contents">
                <form name="login" action="../login/loginSave.php" method="post">
                    <fieldset>
                        <legend>로그인 입력 폼</legend>
                        <div>
                            <label for="youEmail">이메일</label>
                            <input type="email" name="youEmail" id="youEmail" placeholder="이메일" class="input__style" required> 
                        </div>
                        <div>
                            <label for="youPass">비밀번호</label>
                            <input type="password" name="youPass" id="youPass" placeholder="비밀번호" class="input__style" required>
                        </div>
                        <button type="submit" class="input__button">로그인</button>
                    </fieldset> 
                </form>
            </div>
            <div class="login__footer">
                <div class="btn">
                    <a href="#">회원가입</a>
                    <a href="#">아이디 찾기</a>
                    <a href="#">비밀번호 찾기</a>
                </div>
                <ul class="desc"> 
                    <li>비밀번호 분실시 비밀번호 찾기를 눌러주세요.</li>
                    <li>회원가입 하신다면 귀여운 고양이를 보실 수 있을지도?</li>
                    <li>근데 가끔씩 아무말 하니까 댓글 달아주세요</li>
                </ul>
                <button type="button" class="btn-close"><span>닫기</span></button>
            </div>
        </div>
    </div>