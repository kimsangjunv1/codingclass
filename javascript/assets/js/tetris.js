const tetrisWrap = document.querySelector(".tetris__wrap");
const playground = tetrisWrap.querySelector(".playground > ul");
const gameText = tetrisWrap.querySelector(".game__text")

const searchAudioZelda = document.querySelector("#tetris_audio1");
const searchAudioTetris = document.querySelector("#tetris_audio2");
const searchAudioCorrects = document.querySelector("#tetris_success");
const searchAudioOver = document.querySelector("#tetris_gameOver");
const searchAudioSpeedUp = document.querySelector("#tetris_speedUp");

// variables
let rows = 20;
let cols = 16;
let points = 0;
let durations = 500;
let downInterval;
let tempMovingItem;
let level = 1;


// 블록 정보
const movingItem = {
    type: "Imino",
    direction: 0,      //블록 모양
    top: 0,
    left: 0
}

// 시간설정
const searchTimes = document.querySelector(".real_time");

// 난이도 표시
const searchLv = document.querySelector(".real_time em");

let timeRemaining = 0,  // 남은 시간
    timeIntervals = "",   // 시간 간격
    timing = 0;

    // 시간 설정(1초에 한번씩 줄어듦)


// 블록 좌표값
const blocks = {
    Tmino : [
        [[2,1],[0,1],[1,0],[1,1]],
        [[1,2],[0,1],[1,0],[1,1]],
        [[1,2],[0,1],[2,1],[1,1]],
        [[2,1],[1,2],[1,0],[1,1]],
    ],
    Imino : [
        [[0,0],[0,1],[0,2],[0,3]],
        [[0,0],[1,0],[2,0],[3,0]],
        [[0,0],[0,1],[0,2],[0,3]],
        [[0,0],[1,0],[2,0],[3,0]],
    ],
    Omino : [
        [[0,0],[0,1],[1,0],[1,1]],
        [[0,0],[0,1],[1,0],[1,1]],
        [[0,0],[0,1],[1,0],[1,1]],
        [[0,0],[0,1],[1,0],[1,1]],
    ],
    Zmino : [
        [[0,0],[1,0],[1,1],[2,1]],
        [[1,0],[0,1],[1,1],[0,2]],
        [[0,0],[1,0],[1,1],[2,1]],
        [[1,0],[0,1],[1,1],[0,2]],
    ],
    Smino : [
        [[1,0],[2,0],[0,1],[1,1]],
        [[0,0],[0,1],[1,1],[1,2]],
        [[1,0],[2,0],[0,1],[1,1]],
        [[0,0],[0,1],[1,1],[1,2]],
    ],
    Jmino : [
        [[0,2],[1,0],[1,1],[1,2]],
        [[0,0],[0,1],[1,1],[2,1]],
        [[0,0],[1,0],[0,1],[0,2]],
        [[0,0],[1,0],[2,0],[2,1]],
    ],
    Lmino : [
        [[0,0],[0,1],[0,2],[1,2]],
        [[0,0],[1,0],[2,0],[0,1]],
        [[0,0],[1,0],[1,1],[1,2]],
        [[0,1],[1,1],[2,0],[2,1]],
    ]
}


// 시작하기
function init(){
    
    playground.innerHTML = "";
    
    gameText.style.display = "none"
    
    points=0;
    
    document.querySelector('.points em').innerText = points;
    
    for( let i=0; i<rows; i++ ){
        prependNewLine();   //블록 라인 만들기
    }

    generateNewBlock()  //블록 만들기

    timeIntervals = setInterval(()=>{
        timing++
        searchTimes.innerText = (60-timing);
        if(timing==60){
            
            durations = 200;
            searchAudioSpeedUp.play()
            document.querySelector(".game__display").style.filter="hue-rotate(107deg)";
        } else if(timing == 120){
            level ++;
            durations = 100;
            searchAudioSpeedUp.play()
            document.querySelector(".game__display").style.filter="hue-rotate(207deg)";
        }
    },1000);
    
    timeRemaining = 0

    tempMovingItem = { ...movingItem };
}

function reduceTime(){
    timeRemaining++;
    searchTimes.innerText = displayTime();
    if(timeRemaining == 30){
        durations = 200;
        searchLv.innerText="・NORMAL"
        searchAudioSpeedUp.play()
        document.querySelector(".game__display").style.filter="hue-rotate(107deg)";
    }
    if(timeRemaining == 60){
        searchLv.innerText="・HARD"
        searchAudioSpeedUp.play()
        durations = 100;
        document.querySelector(".game__display").style.filter="hue-rotate(207deg)";
    }
}

document.querySelector(".tetris__start").addEventListener("click", ()=>{
    document.querySelector(".game__intro").style.display="none";
    init()
})


// 블록 만들기
function prependNewLine(){
    const li = document.createElement("li");
    const ul = document.createElement("ul");

    for( let j=0; j<cols; j++ ){
        const matrix = document.createElement("li");
        ul.prepend(matrix);
    }
    
    li.prepend(ul);
    playground.prepend(li);
}


// 블록 출력하기
function renderBlocks(moveType = ""){
    // const ty = tempMovingItem.type;
    // const di = tempMovingItem.direction;
    // const to = tempMovingItem.top;
    // const le = tempMovingItem.left;

    const {type, direction, top, left} = tempMovingItem;
    const movingBlocks = document.querySelectorAll(".moving");

    movingBlocks.forEach((moving)=>{
        moving.classList.remove(type, "moving");
    })
    
    blocks[type][direction].some(block=>{
        const x = block[0] + left;                                 // 2 0 1 1
        const y = block[1] + top;                                  // 1 1 0 1


        const target = playground.childNodes[y] ? playground.childNodes[y].childNodes[0].childNodes[x] : null;
        const isAvailable = checkEmpty(target);

        if(isAvailable){
            target.classList.add(type,"moving")     //값이 있을때는 무빙
        } else {
            tempMovingItem = {...movingItem};       //값이 없을때는 그 전 값으로 초기화

            if(moveType === 'retry'){               //만약 movetype값이 retry라면 초를 초기화하고 showGameOverText 실행
                clearInterval(downInterval)
                document.querySelector(".final_point em").innerText = points;
                showGameoverText()
            } else {
                setTimeout(()=>{
                    // render블록에 retry를 매개변수로 보내서 함수 실행
                    // 이렇게 되면 moveType은 retry값 소유중
                    renderBlocks('retry');
                    if(moveType === "top"){
                        seizeBlock();
                    }
                },0);
            }

            return true;
        }

        // console.log({playground})
    });

    movingItem.left = left;
    movingItem.top = top;
    movingItem.direction = direction;
}

// if(movingItem.top > 0){
//     alert("dd");
// }

// 블록 감지하기
function seizeBlock(){
    const movingBlocks = document.querySelectorAll(".moving");
    movingBlocks.forEach(moving => {
        moving.classList.remove("moving");
        moving.classList.add("seized");
    })

    checkMatch();
}

// 게임오버
function showGameoverText() {
    //시간 정지
    clearInterval(timeIntervals)
    searchAudioOver.play();
    gameText.style.display = "flex"
    document.querySelector(".game__display").style.filter="hue-rotate(0deg)";
    searchTimes.innerText = 60;
    timing=0;
    durations = 500;
    searchAudioTetris.pause();
    searchAudioZelda.pause();
}

//한줄 제거하기
function checkMatch(){
    const childNodes = playground.childNodes;
    childNodes.forEach((child)=>{
        let matched = true;
        child.childNodes[0].childNodes.forEach(li => {
            if(!li.classList.contains("seized")){
                matched = false;
            }
        });
    
        if(matched){
            child.remove();
            prependNewLine();
            points++;
            searchAudioCorrects.play();
            document.querySelector('.points em').innerText = points
            // console.log(points)
        }
    })
    generateNewBlock()  //블록 만들기
}

// 새로운 블럭 만들기
function generateNewBlock(){
    clearInterval(downInterval);

    downInterval = setInterval(()=>{
        moveBlock("top", 1)
    },durations)

    const blockArray = Object.entries(blocks);
    const randomIndex = Math.floor(Math.random()*blockArray.length);

    movingItem.type = blockArray[randomIndex][0]
    movingItem.top = 0;
    movingItem.left = 6;
    movingItem.direction = 0;

    tempMovingItem = {...movingItem};
    renderBlocks();
}


// 빈칸 확인하기
function checkEmpty(target){
    if(!target || target.classList.contains("seized")){
        // alert("dd")
        return false;
    }
    return true;
}

// 블록 움직이기
function moveBlock(moveType,amount ){
    tempMovingItem[moveType] += amount
    renderBlocks(moveType);
}

// 모양 바꾸기
function changeDirection(){
    const direction = tempMovingItem.direction;
    direction === 3 ? tempMovingItem.direction=0 : tempMovingItem.direction += 1;
    renderBlocks();
}

// 빨리 내리기
function dropBlock(){
    clearInterval(downInterval);

    downInterval = setInterval(()=>{
        moveBlock("top", 1)
    },10)
}

// 이벤트
document.addEventListener("keydown", e=>{
    switch(e.keyCode){
        case 39 :
            moveBlock("left", 1);
            break;
        case 37 :
            moveBlock("left", -1);
            break;
        case 40 :
            moveBlock("top", 1);
            break;
        case 38 :
            changeDirection();
            break;
        case 32 :
            dropBlock();
            break;

        default :
            break;
    }
})

// function reset(){
//     playground.innerHTML = "";
//     gameText.style.display = "none"
//     points=0;
//     document.querySelector('.points em').innerText = points;
//     init();
// }

//노래선택
document.querySelector('.zelda').addEventListener("click",()=>{
    // alert("ddd")
    searchAudioZelda.play();
    searchAudioTetris.pause();
})
document.querySelector('.tetris').addEventListener("click",()=>{
    searchAudioTetris.play();
    searchAudioZelda.pause();
    // alert("ddd")
})

//노래선택
document.querySelector('.zelda_over').addEventListener("click",()=>{
    // alert("ddd")
    searchAudioZelda.play();
    searchAudioTetris.pause();
})
document.querySelector('.tetris_over').addEventListener("click",()=>{
    searchAudioTetris.play();
    searchAudioZelda.pause();
    // alert("ddd")
})

document.querySelector(".tetris__restart").addEventListener("click", ()=>{
    init();
})

// init();


document.querySelector(".icon6").addEventListener("click", ()=>{
    document.querySelector(".tetris__cont").style.display="block";
    gameText.style.display = "none"
    // reset()
})

document.querySelector(".tetris__header img").addEventListener("click", ()=>{
    document.querySelector(".tetris__cont").style.display="none";
    document.querySelector(".game__intro").style.display="block";
    searchAudioTetris.pause();
    searchAudioZelda.pause();
    document.querySelector(".game__display").style.filter="hue-rotate(0deg)";
    searchLv.innerText="・EASY"
    durations = 500;
    timeRemaining=0;
    clearInterval(timeIntervals);
})

// 시간 표시하기
function displayTime(){
    if(timeRemaining <= 0){
        return "0:00";
    } else {
        let minutes = Math.floor(timeRemaining / 60);
        let seconds = timeRemaining % 60;
        // 초 단위가 한자리수일 때 0 추가
        if(seconds < 10) seconds = "0" + seconds;
        return minutes + ":" + seconds;
    }
}