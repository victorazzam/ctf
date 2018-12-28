const GRID = document.querySelector('.box-grid');
const MORE = document.querySelector('#more');
const LESS = document.querySelector('#less');
var count = 1;

function addItem() {
  let el = document.createElement("li");
  count++;
  el.append('flag{' + Math.floor(100000 + Math.random() * 900000).toString() + '}');
  GRID.append(el);
}

function removeItem() {
  let list = GRID.querySelectorAll('li');
  list[list.length - 1].remove();
  count--;
}

MORE.addEventListener('click', addItem, false);
LESS.addEventListener('click', removeItem, false);