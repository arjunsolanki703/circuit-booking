const Tablesort = require ('tablesort');

$(document).ready(function() {
  const tables = document.getElementsByClassName('table-sortable');

  for (let i=0; i < tables.length; i++) {
    const sortable = new Tablesort(tables[i]);
  }
});