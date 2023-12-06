const balance = document.getElementById("balance");
const money_plus = document.getElementById("money-plus");
const money_minus = document.getElementById("money-minus");
const list = document.getElementById("list");
const form = document.getElementById("form");
const text = document.getElementById("text");
const amount = document.getElementById("amount");
const selectMonth = document.getElementById("months");
const submitBtn = document.getElementById("sub");
const displayMonth = document.getElementById("selected-month");
var length = 0;
var month;
var tatalf = 0, incf = 0, expf = 0;
let tatal = 0;
let inc = 0;
let exp = 0;

let transactions = [];

submitBtn.addEventListener("click", () => {
  month = selectMonth.options[selectMonth.selectedIndex].text;
  updateValues(month);
});

function addTransaction(e) {
  e.preventDefault();
  if (text.value.trim() === '' || amount.value.trim() === '') {
    alert('please add text and amount')
  } else {
    var t_id = generateID();
    const transaction = {
      id: t_id,
      text: text.value,
      amount: +amount.value
    }

    transactions.push(transaction);

    updateValuesagain();

    var txt = text.value;
    var amt = amount.value;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_tra.php');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = () => {
      if (xhr.status === 200) {
        console.log('transaction stored successfully');
      } else {
        console.error('Error storing transaction');
      }
    };
    const data = { t_id, txt, amt, month };
    xhr.send(JSON.stringify(data));

    addTransactionDOM(transaction, month);
    text.value = '';
    amount.value = '';
  }
}

function generateID() {
  return Math.floor(Math.random() * 1000000000);
}

function addTransactionDOM(transaction) {
  const sign = transaction.amount < 0 ? "-" : "+";
  const item = document.createElement("li");

  item.classList.add(
    transaction.amount < 0 ? "minus" : "plus"
  );

  item.innerHTML = `
    ${transaction.text} <span>${sign}${Math.abs(
    transaction.amount
  )}</span>
    <button class="debn" onclick="removeTransaction(${transaction.id})">x</button>`;
  list.appendChild(item);
}




function updateValues(month) {
  const xhr = new XMLHttpRequest();
  xhr.open('GET', `get_data.php?month=${month}`, true);
  xhr.onload = function () {
    if (this.status === 200) {
      const data = JSON.parse(this.responseText);
      const { income, expense } = data;
      const balanceValue = income - expense;

      // Update UI with received data
      tatal = balanceValue;
      tatalf = balanceValue.toFixed(2);
      inc = income;
      incf = income.toFixed(2);
      exp = expense
      expf = expense.toFixed(2);

      updateChart(inc, exp);

      balance.innerText = `$${tatalf}`;
      money_plus.innerText = `$${incf}`;
      money_minus.innerText = `$${expf}`;
    }
  }
  xhr.send();
}


function updateValuesagain() {

  for (let i = transactions.length - 1; i >= 0; i--) {
    const transaction = transactions[i];
    const amount = transaction.amount;

    if (i === transactions.length - 1) {
      if (amount >= 0) {
        inc += amount;
      } else {
        exp += Math.abs(amount);
      }
    } else {
      break;
    }
  }

  tatal = inc - exp;

  balance.innerText = `$${tatal.toFixed(2)}`;
  money_plus.innerText = `$${inc.toFixed(2)}`;
  money_minus.innerText = `$${exp.toFixed(2)}`;

  updateChart(inc, exp);

  if (tatal < 0) {
    alert("Expenses are Overbudget");
  }

  // send inc and exp data to server using AJAX
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'update_data.php');
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.onload = () => {
    if (xhr.status === 200) {
      console.log('Data stored successfully');
    } else {
      console.error('Error storing data');
    }
  };
  const data = { inc, exp, month };
  xhr.send(JSON.stringify(data));
}

function removeTransaction(id) {
  const newTransactions = transactions.filter(transaction => transaction.id !== id);
  transactions = newTransactions;
  Init();
}

function Init() {
  list.innerHTML = "";
  transactions.forEach(addTransactionDOM);
  updateValuesagain();
}

form.addEventListener('submit', addTransaction);
