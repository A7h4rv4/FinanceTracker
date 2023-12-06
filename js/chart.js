/* www.youtube.com/CodeExplained */

// SELECT CHART ELEMENT
const chart = document.querySelector(".chart");

// CREATE CANVAS ELEMMENT
const canvas = document.createElement("canvas");
canvas.width = 400;
canvas.height = 400;

// APPEND CANVAS TO CHART ELEMENT
chart.appendChild(canvas);

// TO DRAW ON CANVAS, WE NEED TO GET CONTEXT OF CANVAS
const ctx = canvas.getContext("2d");

// CHANGE THE LINE WIDTH
ctx.lineWidth = 40;

// CIRCLE RADIUS
const R = 175;

function drawCircle(color, ratio, clockwise){

    ctx.strokeStyle = color;
    ctx.beginPath();
    ctx.arc( canvas.width/2, canvas.height/2, R, 0, ratio*2* Math.PI, clockwise);
    ctx.stroke();
}
function drawCircle1(color, ratio, clockwise){

    ctx.strokeStyle = color;
    ctx.beginPath();
    ctx.arc( canvas.width/2, canvas.height/2, R, Math.PI/2, ratio*2* Math.PI, clockwise);
    ctx.stroke();
}

function updateChart( income, expense){
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    let ratio = (income-expense) / (income);

    drawCircle1("#2ecc71", - ratio, true);
    drawCircle("#c0392b", 1 - ratio, false);
}