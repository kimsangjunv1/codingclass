const tetrisWrap = document.querySelector(".tetris__wrap");
const playground = tetrisWrap.querySelector(".playground > ul");
const gameText = tetrisWrap.querySelector(".game__text")

// variables
let rows = 17;
let cols = 12;
let points = 0;
let duration = 500;
let downInterval;
let tempMovingItem;


// 블록 정보
const movingItem = {
    type: "Imino",
    direction: 0,      //블록 모양
    top: 0,
    left: 0
}


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
    tempMovingItem = { ...movingItem };
    for( let i=0; i<rows; i++ ){
        prependNewLine();   //블록 라인 만들기
    }
    // renderBlocks()      //블록 출력하기
    generateNewBlock()  //블록 만들기
}


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
    gameText.style.display = "flex"
    // alert("ddd")
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
            document.querySelector('.points').innerText = points
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
    },duration)

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
document.querySelector(".tetris__restart").addEventListener("click", ()=>{
    playground.innerHTML = "";
    gameText.style.display = "none"
    init();
})
init();
